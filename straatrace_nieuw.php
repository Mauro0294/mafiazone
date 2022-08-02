<?php
include "notLoggedIn.php";
?>

<html>
    <head>
        <link rel="stylesheet" href="straatrace_nieuw.css">
        <script src="https://kit.fontawesome.com/44d0f25a2a.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include "sidebar.php" ?>
        <div class="wrapper">
        <?php include "topbar.php" ?>
        <div class='content'>
        <h2>Straatrace</h2>
        <div class="contentwrapper">
            <p>Hieronder kan je je inschrijven voor een straatrace.<br /> Vul een geldbedrag in om in te zetten, klik op inschrijven en wacht tot iemand de race accepteert.</p>
            <form method='POST'>
                <label>Spelersnaam</label><br />
                <input type='text' value='<?php echo $_SESSION['username'] ?>' readonly><br />
                <label>Inzet</label><br />
                <input type='number' min="1" name='inzet' required><br />
                <input type='submit' value='Inschrijven' name='submit'>
            </form>
        </div>
    </body>
</html>

<?php
if (isset($_POST['submit'])) {
    $stmt = $pdo->prepare("SELECT * from straatraces where speler = :speler");
    $stmt->execute([':speler' => $_SESSION['username']]);
    $rows = $stmt->fetchAll();
    $stmt = $pdo->prepare("SELECT cashgeld from users where gebruikersnaam = :username");
    $stmt->execute([':username' => $_SESSION['username']]);
    $row = $stmt->fetch();
    if ($row['cashgeld'] < $_POST['inzet']) {
        echo "<script>alert('Je hebt niet genoeg geld om in te zetten!')</script>";
        return;
    }
    if (count($rows) > 0) {
        echo "<script>alert('Je bent al ingeschreven!')</script>";
        return;
    }
    $stmt = $pdo->prepare("SELECT * FROM straatraces WHERE speler = :username");
    $stmt->execute([
        'username' => $_SESSION['username']
    ]);
    $speler = $_SESSION['username'];
    $inzet = $_POST['inzet'];
    $query = "INSERT INTO straatraces (speler, inzet) VALUES (:speler, :inzet)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(["speler" => $speler, "inzet" => $inzet]);

    $stmt = $pdo->prepare("UPDATE users SET cashgeld = cashgeld - :inzet WHERE gebruikersnaam = :username");
    $stmt->execute([':inzet' => $inzet, ':username' => $_SESSION['username']]);
    header("Location: straatrace.php");
}
?>