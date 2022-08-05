<?php
include "notLoggedIn.php";
?>

<html>
    <head>
        <link rel="stylesheet" href="koffers.css">
        <script src="https://kit.fontawesome.com/44d0f25a2a.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include "sidebar.php" ?>
        <div class="wrapper">
        <?php include "topbar.php" ?>
        <div class='content'>
        <h2>Koffers</h2>
        <div class="contentwrapper">
        <p>Koffers vind je tijdens het spelen van MafiaZone. Ze bevatten cash, kogels en credits! Je ontvangt een bericht wanneer je een koffer gevonden hebt.<br /><br /> Klik op een koffer, om hem te openen, je ziet meteen, wat erin zit.<br /> <br />
        Je hebt momenteel <?php $stmt = $pdo->prepare("SELECT koffers FROM users WHERE gebruikersnaam = :username");
    $stmt->execute(['username' => $username]);
    $kofferfetch = $stmt->fetch();
    $koffer = $kofferfetch['koffers'];
    if ($koffer == 0) {
        echo "geen";
    } else {
    echo $koffer;
    }?> <?php if ($koffer == 1) {
        echo "koffer";
    } else {
        echo "koffers";
    }; ?>
        <div>
        <form method="POST">
            <?php
            for ($i = 0; $i < $koffer; $i++) {
                    echo "<button type='submit' name='submit' style='margin-right: 10px; margin-bottom: 10px;'>
                    <i id='koffer_icon' class='fa fa-briefcase' aria-hidden='true'></i>
                    </button>";
                }
             ?>
        </form>
        </div>
            </div>
        </div>
            </div>
    </body>
</html>

<?php
if (isset($_POST['submit'])) {
    if ($koffer < 1) return;
    $stmt = $pdo->prepare("UPDATE users SET koffers = koffers - 1 WHERE gebruikersnaam = :username");
    $stmt->execute(['username' => $username]);

    $keuze = rand(0, 2);
    switch ($keuze) {
        case 0:
            $randommoney = rand(100000, 250000);
            header("Refresh: 3");
            $stmt = $pdo->prepare("UPDATE users SET cashgeld = cashgeld + :randommoney WHERE gebruikersnaam = :username");
            $stmt->execute(['randommoney' => $randommoney, 'username' => $username]);
            echo "<script>alert('Je hebt €$randommoney gevonden in de koffer!');</script>";
            break;
        case 1:
            $randomcredits = rand(5, 15);
            header("Refresh: 3");
            $stmt = $pdo->prepare("UPDATE users SET credits = credits + :randomcredits WHERE gebruikersnaam = :username");
            $stmt->execute(['randomcredits' => $randomcredits, 'username' => $username]);
            echo "<script>alert('Je hebt $randomcredits credits gevonden in de koffer!');</script>";
            break;
        case 2:
            $randombullets = rand(25, 75);
            $randommoney = rand(100000, 250000);
            $stmt = $pdo->prepare("UPDATE users SET kogels = kogels + :randombullets WHERE gebruikersnaam = :username");
            $stmt->execute(['randombullets' => $randombullets, 'username' => $username]);

            $stmt = $pdo->prepare("UPDATE users SET cashgeld = cashgeld + :randommoney WHERE gebruikersnaam = :username");
            $stmt->execute(['randommoney' => $randommoney, 'username' => $username]);
            echo "<script>alert('Je hebt €$randommoney en $randombullets kogels gevonden in de koffer!');</script>";
            break;
    }
}
?>