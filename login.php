<?php
include "verbinding.php";
session_start();
?>

<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title></title>
</head>
<body>
    <img class="banner" src="images/banner.png"/>
        <ul>
            <div>
            <li><a href='index.php' class='a'>Home</a></li>
            <li><a href='#' class='a'>Inloggen</a></li>
            <li><a href='contact.php' class='a'>Contact</a></li>
            </div>
            <div>
            <li class="border-button"><a href='registreer.php' class='current'>Aanmelden</a></li>
            </div>
        </ul>
    <section class="form">
        <form method="POST">
            <label for='gebruikersnaam'>Gebruikersnaam</label><br />
            <input type="text" name='gebruikersnaam' placeholder="Gebruikersnaam"/><br />
            <label for='gebruikersnaam'>Wachtwoord</label><br />
            <input type="password" name='wachtwoord' placeholder="Wachtwoord"/><br />
            <input type="submit" name='submit' class='border-button' value='Inloggen'/>
        </form>
    </section>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $gebruikersnaam = trim($_POST['gebruikersnaam']);
    $wachtwoord = trim($_POST['wachtwoord']);
    if ($gebruikersnaam != "" && $wachtwoord != "") {
        $query = "SELECT * FROM `users` WHERE `gebruikersnaam`=:gebruikersnaam AND `wachtwoord`=:wachtwoord";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam('gebruikersnaam', $gebruikersnaam, PDO::PARAM_STR);
        $stmt->bindParam('wachtwoord', $wachtwoord, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($count == 1 && !empty($row)) {
            echo "<script type='text/javascript'>alert('Je bent succesvol ingelogd!');</script>";
            $username = $row['gebruikersnaam'];
            $_SESSION['username'] = $username;
            header('Location: status.php');
        } else {
            echo "<script type='text/javascript'>alert('Verkeerd gebruikersnaam en/of wachtwoord!');</script>";
        }
    }
}
?>