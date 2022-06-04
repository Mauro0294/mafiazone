<?php
include "notLoggedIn.php";



$username = $_SESSION['username'];
?>

<html>
    <h2>Ziekenhuis</h2>
    <form method='POST'>
        <p>Koop <input type='number' name='units'/> eenheden bloed</p>
        <input type='submit' name='submit' value='Koop eenheden'/>
    </form>
</html>

<?php
$submit = $_POST['submit'];
$units = $_POST['units'];
$cost = $units * 25;

if (isset($submit)) {
    $stmt = $pdo->prepare("SELECT cashgeld FROM users WHERE gebruikersnaam = '$username'");
    $stmt->execute();
    $row = $stmt->fetch();
    $cash = $row['cashgeld'];
    if ($cash < $cost) {
        echo "Je hebt niet genoeg geld om dit te kopen!";
    } else {

        $cash -= $cost;
        $stmt = $pdo->prepare("UPDATE users SET cashgeld = '$cash' WHERE gebruikersnaam = '$username'");
        $stmt->execute();

        $stmt = $pdo->prepare("SELECT gezondheid FROM users WHERE gebruikersnaam = '$username'");
        $stmt->execute();
        $row = $stmt->fetch();
        $gezondheid = $row['gezondheid'];
        $gezondheid += $units;

        if ($gezondheid > 100) {
            $gezondheid = 100;
            $stmt = $pdo->prepare("UPDATE users SET gezondheid = '$gezondheid' WHERE gebruikersnaam = '$username'");
            $stmt->execute();
            echo "Je hebt het maximum aantal gezondheid bereikt!";
        } else {
            $stmt = $pdo->prepare("UPDATE users SET gezondheid = '$gezondheid' WHERE gebruikersnaam = '$username'");
            $stmt->execute();
            echo "Je hebt " . $units . " eenheden bloed gekocht!";
        }
    }
}
?>