<?php
include "verbinding.php";
session_start();
?>

<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link
      href="https://fonts.googleapis.com/css?family=Montserrat"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MafiaZone | Login</title>
    </title>
</head>
<body>
<ul>
  <li><a href="index.php" id="first">Home</a></li>
  <li><a href="login.php" class="active" >Inloggen</a></li>
  <li><a href="registreer.php">Registreren</a></li>
</ul>
<div class="container">
    <div class="box">
        <img src="/images/avatar.png" />
        <h2>Inloggen</h2>
        <form method='POST'>
            <label for="username">Gebruikersnaam</label>
            <input
            type="text"
            placeholder="Voer je gebruikersnaam in"
            name="gebruikersnaam"
            />
            <label for="password">Wachtwoord</label>
            <input
            type="password"
            placeholder="Voer je wachtwoord in"
            name="wachtwoord"
            />
            <input type="submit" name='submit' value="Login" />
            <span><a href="#">Wachtwoord vergeten?</a></span>
            <span><a href="registreer.php">Nog geen account?</a></span>
        </form>
    </div>
</div>
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
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            if ($count == 1 && !empty($row)) {
                if ($row['banned'] == 'true') {
                    echo "<script>window.location.href = 'banned/banned.html'</script>";
                } else {
                    $username = $row['gebruikersnaam'];
                    $_SESSION['username'] = $username;
                    echo "<script>window.location.href = 'status.php'</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert('Verkeerd gebruikersnaam en/of wachtwoord!');</script>";
            }
        }
    }
}
?>