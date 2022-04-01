<?php
include "notLoggedIn.php";

error_reporting(0);

$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT id FROM users WHERE gebruikersnaam = '$username'");
$stmt->execute();
$row = $stmt->fetch();

$userid = $row['id'];

$stmt2 = $pdo->prepare("SELECT * FROM timers WHERE user_id = '$userid'");
$stmt2->execute();
$row2 = $stmt2->fetch();

$date = $row2['date'];
$currenttime = time();

$verschil = $currenttime - $date;

function echoDifference() {
    echo "Je moet nog " . (5 - $verschil) . " seconden wachten!";
}

if ($verschil <= 5) {
    echo "Je kan geen misdaad plegen!<br />";
    echo "Je moet nog " . (5 - $verschil) . " seconden wachten!";
    } else {
    echo "Je kan een misdaad plegen!";
    echo "
    <html>
    <form method='POST'>
        <input type='submit' name='submit' value='Probeer!'/>
    </form>
</html>
";
}
?>

<?php
$stmt = $pdo->prepare("SELECT id FROM users where gebruikersnaam = '$username'");
$stmt->execute();
$row = $stmt->fetch();

$id = $row['id'];

$submit = $_POST['submit'];
if (isset($submit)) {
    $timepressed = time();
    $removestmt = $pdo->prepare("DELETE FROM timers WHERE user_id = '$id'");
    $removestmt->execute();
    $stmt = $pdo->prepare("INSERT INTO timers (user_id, date) VALUES ('$id', '$timepressed')");
    $stmt->execute();
    $randomnumber = rand(1, 3);
    $cashgeld = rand(25000, 50000);
    if ($randomnumber == 1) { 
        $stmt = $pdo->prepare("UPDATE users SET cashgeld = cashgeld + $cashgeld WHERE gebruikersnaam = '$username'");
        $stmt->execute();
        $options = array('Je hebt een winkel overvallen!', 'Je hebt een scooter gestolen!', 'Je hebt een auto gestolen!', 'Je hebt juwelen gestolen!', 'Je hebt een kunstwerk gestolen!', 'Je hebt een pinautomaat ge-ramkraakt!');
        $x = rand(0, 5);
        echo "" . $options[$x] . " Je hebt $cashgeld euro hiermee verdiend!\n";
        echo "Je hebt succesvol een misdaad gepleegd!";
        header("Refresh: 5");
    } else {
        header("Refresh: 3");
        echo "De misdaad is gefaald, probeer het later opnieuw!";
    }
}
?>