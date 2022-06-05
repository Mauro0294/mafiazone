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
            <input type='number' min='1' name='geld'>
            <label for="keuze">Maak een keuze</label>
            <div class='keuzes'>
            <input type='submit' name='kop' value='Kop'>
            <input type='submit' name='munt' value='Munt'>
            </div>
        </form>
        <p>Huidige cashgeld: <span class='saldo'></span></p>
        <p class='no_money'>Je hebt niet genoeg geld om in te zetten</p>
        <p class='winwrapper'>Je hebt gewonnen! Je hebt <span class='win'></span> euro verdiend</p>
        <p class='losswrapper'>Je hebt verloren! Je hebt <span class='loss'></span> euro verloren</p>
        <a href='status.php'>Ga terug naar het overzicht</a>
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
echo "<script>document.querySelector('.saldo').innerText = $saldo</script>";

if (isset($keuze_kop)) {
    $keuze = 'kop';
    if ($geld > $saldo) {
        echo "<script>document.querySelector('.no_money').style.display = 'block'</script>";
    } else {
        if ($keuze == $kant) {
            $saldo += $geld;
            $stmt = $pdo->prepare("UPDATE users SET cashgeld = :cashgeld WHERE gebruikersnaam = :username");
            $stmt->execute(['cashgeld' => $saldo, 'username' => $username]);
            echo "<script>document.querySelector('.win').innerText = $geld</script>";
            echo "<script>document.querySelector('.winwrapper').style.display = 'block'</script>";
        } else {
            $saldo -= $geld;
            $stmt = $pdo->prepare("UPDATE users SET cashgeld = :cashgeld WHERE gebruikersnaam = :username");
            $stmt->execute(['cashgeld' => $saldo, 'username' => $username]);
            echo "<script>document.querySelector('.loss').innerText = $geld</script>";
            echo "<script>document.querySelector('.losswrapper').style.display = 'block'</script>";
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
            echo "<script>document.querySelector('.win').innerText = $geld</script>";
            echo "<script>document.querySelector('.winwrapper').style.display = 'block'</script>";
        } else {
            $saldo -= $geld;
            $stmt = $pdo->prepare("UPDATE users SET cashgeld = :cashgeld WHERE gebruikersnaam = :username");
            $stmt->execute(['cashgeld' => $saldo, 'username' => $username]);
            echo "<script>document.querySelector('.loss').innerText = $geld</script>";
            echo "<script>document.querySelector('.losswrapper').style.display = 'block'</script>";
        }
    }
}
?>