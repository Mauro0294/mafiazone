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
            <li><a href='login.php' class='a'>Inloggen</a></li>
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
            <label for='gebruikersnaam'>Email</label><br />
            <input type="email" name='email' placeholder="Email"/><br />
            <label for='gebruikersnaam'>Wachtwoord</label><br />
            <input type="password" name='wachtwoord' placeholder="Wachtwoord"/><br />
            <input type="submit" name='submit' class='border-button' value='Aanmelden'/>
        </form>
    </section>
</body>
</html>

<?php
  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $user = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];
    $sql = "SELECT COUNT(gebruikersnaam) AS num FROM users WHERE gebruikersnaam = :gebruikersnaam";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':gebruikersnaam', $user);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql1 = "SELECT COUNT(email) AS num FROM users WHERE email = :email";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindValue(':email', $email);
    $stmt1->execute();
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    $cashgeld = 0;
    $bankgeld = 0;

    if ($row['num'] > 0) {
      echo '<script>alert("Gebruikersnaam bestaat al!")</script>';
    } elseif ($row1['num'] > 0) {
      echo '<script>alert("Email bestaat al!")</script>';
    } else {
      $sql = "INSERT INTO `users` (`gebruikersnaam`, `email`, `wachtwoord`, `cashgeld`, `bankgeld`, `power`, `kogels`, `credits`, `moorden`) 
    VALUES (:gebruikersnaam, :email, :wachtwoord, :cashgeld, :bankgeld, :power, :kogels, :credits, :moorden) ";
      $sql_run = $pdo->prepare($sql);
      $result = $sql_run->execute(array(
        ":gebruikersnaam" => $user,
        ":email" => $email, ":wachtwoord" => $wachtwoord,
        ":cashgeld" => 0, ":bankgeld" => 0,
        ":power" => 0, ":kogels" => 0,
        ":credits" => 0, ":moorden" => 0,
      ));
      header("Location: login.php");
    }
  }
?>