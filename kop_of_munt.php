<?php
include "notLoggedIn.php";

$username = $_SESSION['username'];
?>

<html>
    <head>
        <title>MafiaZone | Kop of munt</title>
        <link rel="stylesheet" href="kop_of_munt.css" />
        <link
      href="https://fonts.googleapis.com/css?family=Montserrat"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <body>
        <div class='container'>
        <div class='wrapper'>
        <h2>Kop of munt</h2>
        <p>Welkom bij kop of munt. Hieronder krijg je de keuze om kop of munt te kiezen, als je op de knop drukt zal de computer een van deze twee opties kiezen, als je het goed hebt, verdubbel je je inzet, als je het fout hebt, verlies je al je inzet. Veel speelplezier!</p>
        <form method="post">
            <label for='getal'>Hoeveel geld wil je inzetten?</label>
            <input type='number' name='geld'>
            <label for="keuze">Kop of munt?</label>
            <div class='keuzes'>
            <input type='submit' name='kop' value='Kop'>
            <input type='submit' name='munt' value='Munt'>
            </div>
        </form>
        <p class='no_money'>Je hebt niet genoeg geld om in te zetten</p>
        </div>
        </div>
    </body>
</html>

<?php
$random_number = rand(1, 2);
if ($random_number == 1) {
    $kant = 'kop';
} else {
    $kant = 'munt';
}

$geld = $_POST['geld'];
$keuze_kop = $_POST['kop'];
$$keuze_munt = $_POST['munt'];

$stmt = $pdo->prepare("SELECT cashgeld FROM users WHERE gebruikersnaam = :username");
$stmt->execute(['username' => $username]);
$saldofetch = $stmt->fetch();
$saldo = $saldofetch['cashgeld'];

if (isset($keuze_kop)) {
    $keuze = 'kop';
    echo "Je huidige saldo is: $saldo";
    if ($geld > $saldo) {
        echo "<script>document.querySelector('.no_money').style.display = 'block'</script>";
    } else {
        if ($keuze == $kant) {
            $saldo += $geld;
            $stmt = $pdo->prepare("UPDATE users SET cashgeld = :cashgeld WHERE gebruikersnaam = :username");
            $stmt->execute(['cashgeld' => $saldo, 'username' => $username]);
            echo '<p>Je hebt gewonnen! Je hebt ' . $geld . ' euro verdiend</p>';
        } else {
            $saldo -= $geld;
            $stmt = $pdo->prepare("UPDATE users SET cashgeld = :cashgeld WHERE gebruikersnaam = :username");
            $stmt->execute(['cashgeld' => $saldo, 'username' => $username]);
            echo '<p>Je hebt verloren! Je hebt ' . $geld . ' euro verloren</p>';
        }
    }
}

if (isset($keuze_zwart)) {
    $keuze = 'zwart';
    if ($geld > $saldo) {
        echo "<script>document.querySelector('.no_money').style.display = 'block'</script>";
    } else {
        if ($keuze == $kant) {
            $saldo += $geld;
            $stmt = $pdo->prepare("UPDATE users SET cashgeld = :cashgeld WHERE gebruikersnaam = :username");
            $stmt->execute(['cashgeld' => $saldo, 'username' => $username]);
            echo '<p>Je hebt gewonnen! Je hebt ' . $geld . ' euro verdiend</p>';
        } else {
            $saldo -= $geld;
            $stmt = $pdo->prepare("UPDATE users SET cashgeld = :cashgeld WHERE gebruikersnaam = :username");
            $stmt->execute(['cashgeld' => $saldo, 'username' => $username]);
            echo '<p>Je hebt verloren! Je hebt ' . $geld . ' euro verloren</p>';
        }
    }
}
?>