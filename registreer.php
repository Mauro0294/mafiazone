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
    <title>MafiaZone | Registreer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <script src="https://kit.fontawesome.com/44d0f25a2a.js" crossorigin="anonymous"></script>
</head>
<body>
<ul class='ul'>
        <li><i class="fa-solid fa-bars icon" id='display' onclick="openMenu()"></i><i class="fa-solid fa-xmark icon" id='display2' onclick='closeMenu()'></i><a href='index.php' class='logo'>MafiaZone</a></li>
        <div class='hide'>
            <li><a href="index.php" id="first">Home</a></li>
            <li><a href="login.php">Game</a></li>
            <li><a href="#">Info</a></li>
        </div>
        <li><a href='login.php' class='login'><button>Login</button></a></li>
    </ul>
    <ul class='dropdown'>
    <li><a href="index.php" id="first">Home</a></li>
        <li><a href='login.php'>Game</a></li>
        <li><a href='#'>Info</a></li>
    </ul>
<div class="container">
    <div class="box">
        <img src="/images/avatar.png" />
        <h2>Registreren</h2>
        <form method='POST'>
            <label for="username">Gebruikersnaam</label>
            <input
            type="text"
            placeholder="Voer je gebruikersnaam in"
            name="gebruikersnaam"
            required
            />
            <label for="email">Email</label>
            <input
            type="email"
            placeholder="Voer je e-mail in"
            name="email"
            required
            />
            <label for="password">Wachtwoord</label>
            <input
            type="password"
            placeholder="Voer je wachtwoord in"
            name="wachtwoord"
            required
            />
            <input type="submit" name='submit' value="Registreren" />
            <span><a href="login.php">Heb je al een account?</a></span>
        </form>
    </div>
</div>
<script src='menu.js'></script>	
</body>
</html>

<?php
  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $user = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];
    $sql = "SELECT COUNT(gebruikersnaam) AS num FROM users WHERE gebruikersnaam = :gebruikersnaam";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':gebruikersnaam' => $user
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql1 = "SELECT COUNT(email) AS num FROM users WHERE email = :email";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute(array(
      ':email' => $email
    ));
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    $cashgeld = 0;
    $bankgeld = 0;

    if ($row['num'] > 0) {
      echo '<script>alert("Gebruikersnaam bestaat al!")</script>';
    } elseif ($row1['num'] > 0) {
      echo '<script>alert("Email bestaat al!")</script>';
    } else {
      $sql = "INSERT INTO `users` (`gebruikersnaam`, `email`, `wachtwoord`, `cashgeld`, `bankgeld`, `power`, `kogels`, `credits`, `moorden`, `gezondheid`, `banned`, `admin`) 
    VALUES (:gebruikersnaam, :email, :wachtwoord, :cashgeld, :bankgeld, :power, :kogels, :credits, :moorden, :gezondheid, :banned, :admin) ";
      $sql_run = $pdo->prepare($sql);
      $result = $sql_run->execute(array(
        ":gebruikersnaam" => $user,
        ":email" => $email, ":wachtwoord" => $wachtwoord,
        ":cashgeld" => 0, ":bankgeld" => 0,
        ":power" => 0, ":kogels" => 0,
        ":credits" => 0, ":moorden" => 0,
        ":gezondheid" => 100,
        ":banned" => 'false',
        ":admin" => 'false',
      ));
    echo "<script>window.location.href = 'login.php'</script>";
    }
  }
?>