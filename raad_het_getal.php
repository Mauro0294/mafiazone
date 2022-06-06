<?php
include "notLoggedIn.php";

$username = $_SESSION['username'];
?>

<html>
    <head>
        <title>MafiaZone | Raad het getal</title>
        <link rel="stylesheet" href="raad_het_getal.css" />
        <link
      href="https://fonts.googleapis.com/css?family=Montserrat"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <body>
        <div class='container'>
        <div class='wrapper'>
        <h2>Raad het getal</h2>
        <p>Welkom bij raad het getal. Hieronder krijg je de keuze om een getal te kiezen tussen 1 en 10. Als je het getal goed weet te raden, krijg je je inzet 10x terug, raad je het niet goed, verlies je je volledige inzet. Veel speelplezier!</p>
        <form method="post">
            <label for='getal'>Hoeveel geld wil je inzetten?</label>
            <input type='number' min='1' name='inzet'>
            <label for="getallen">Kies een getal</label>
            <select name="getallen">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
            <input type='submit' name='submit' value='Speel'>
        </form>
        <p>Huidige cashgeld: <span class='saldo'></span></p>
        <p class='no_money'>Je hebt niet genoeg geld om in te zetten</p>
        <p class='winwrapper'>Je hebt het getal goed geraden! Je hebt 10x je inzet gewonnen!</p>
        <p class='losswrapper'>Je hebt het getal niet goed geraden! Je hebt je inzet verloren!</p>
        <a href='status.php'>Ga terug naar het overzicht</a>
        </div>
        </div>
    </body>
</html>

<?php
$random_number = rand(1, 10);
$submit = $_POST['submit'];
$getal = $_POST['getallen'];
$inzet = $_POST['inzet'];

$stmt = $pdo->prepare("SELECT cashgeld FROM users WHERE gebruikersnaam = :username");
$stmt->execute(['username' => $username]);
$saldofetch = $stmt->fetch();
$saldo = $saldofetch['cashgeld'];
echo "<script>document.querySelector('.saldo').innerText = $saldo</script>";

if (isset($submit)) {
    if ($inzet > $saldo) {
        echo "<script>document.querySelector('.no_money').style.display = 'block'</script>";
    } else {
        if ($getal == $random_number) {
            $saldo = $saldo + ($inzet * 10);
            $stmt = $pdo->prepare("UPDATE users SET cashgeld = :saldo WHERE gebruikersnaam = :username");
            $stmt->execute([
                'saldo' => $saldo,
                'username' => $username
            ]);
            echo "<script>document.querySelector('.winwrapper').style.display = 'block'</script>";
        } else {
            $saldo = $saldo - $inzet;
            $stmt = $pdo->prepare("UPDATE users SET cashgeld = :saldo WHERE gebruikersnaam = :username");
            $stmt->execute([
                'saldo' => $saldo,
                'username' => $username
            ]);
            echo "<script>document.querySelector('.losswrapper').style.display = 'block'</script>";
        }
    }
}
?>