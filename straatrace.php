<?php
include "notLoggedIn.php";
error_reporting(0);
$username = $_SESSION['username'];
?>

<html>
    <head>
        <link rel="stylesheet" href="straatrace.css">
    </head>
    <body>
        <?php include "sidebar.php" ?>
        <div class="wrapper">
        <?php include "topbar.php" ?>
        <div class='content'>
        <h2>Straatrace</h2>
        <div class="contentwrapper">
            <form method='POST'><table>
                <tr>
                <th>Speler</th>
                <th>Inzet</th>
                <th>#</th>
</tr>
<?php
$stmt = $pdo->prepare("SELECT * from straatraces");
$stmt->execute();
$rows = $stmt->fetchAll();
foreach ($rows as $row) {
?>
<tr>
    <td><?php echo $row['speler'] ?></td>
    <td><?php echo $row['inzet'] ?></td>
    <td><button type='submit' name='submit' value='<?php $row['speler'] ?>'><i class='fa-solid fa-car' style='color: red;'></i></button></td>
</tr>
<?php
if (isset($_POST['submit'])) {
    $random = rand(1, 2);
    $inzet = $row['inzet'] * 2;
    $stmt = $pdo->prepare("DELETE FROM straatraces where speler = :speler");
    $stmt->execute([':speler' => $row['speler']]);
    if ($random == 1) {
        $stmt = $pdo->prepare("UPDATE users SET cashgeld = cashgeld + :inzet WHERE gebruikersnaam = :username");
        $stmt->execute([':inzet' => $row['inzet'], ':username' => $username]);
        echo "<script>alert('Je hebt gewonnen!')</script>";
        header("Refresh:0");
    }
    if ($random == 2) {
        $stmt = $pdo->prepare("UPDATE users SET cashgeld = cashgeld - :inzet WHERE gebruikersnaam = :username");
        $stmt->execute([':inzet' => $row['inzet'], ':username' => $username]);
        echo "<script>alert('Je hebt verloren!')</script>";

        $stmt = $pdo->prepare("UPDATE users SET cashgeld = cashgeld + :inzet WHERE gebruikersnaam = :username");
        $stmt->execute([':inzet' => $inzet, ':username' => $row['speler']]);
        header("Refresh:0");
    }
}
}
?>
</table>
</form>
        </div>
        <p style='text-align: center;'><a href='straatrace_nieuw.php'>Klik hier om je in te schrijven!</a></p>
    </body>
</html>

<?php
?>