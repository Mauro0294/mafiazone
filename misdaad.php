<?php
include "notLoggedIn.php";

error_reporting(0);

$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT id FROM users WHERE gebruikersnaam = '$username'");
$stmt->execute();
$row = $stmt->fetch();

$userid = $row['id'];

$stmt2 = $pdo->prepare("SELECT * FROM misdaad_timers WHERE user_id = '$userid'");
$stmt2->execute();
$row2 = $stmt2->fetch();

$date = $row2['date'];
$currenttime = time();

$verschil = $currenttime - $date;
$wachttijd = 90;

if ($verschil <= $wachttijd) {
    echo "Je kan nog geen misdaad plegen!<br />";
    echo "Je moet nog " . ($wachttijd - $verschil) . " seconden wachten!";
    } else {
    echo "<p class='possible'>Je kan een misdaad plegen!</p>";
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
    $removestmt = $pdo->prepare("DELETE FROM misdaad_timers WHERE user_id = '$id'");
    $removestmt->execute();
    $stmt = $pdo->prepare("INSERT INTO misdaad_timers (user_id, date) VALUES ('$id', '$timepressed')");
    $stmt->execute();
    $randomnumber = rand(1, 3);
    $cashgeld = rand(25000, 50000);
    $cashgeld = number_format($cashgeld, 0, ',', '.');
    if ($randomnumber == 1) { 
        $stmt = $pdo->prepare("UPDATE users SET cashgeld = cashgeld + $cashgeld WHERE gebruikersnaam = '$username'");
        $stmt->execute();
        $options = array('Je hebt een winkel overvallen!', 'Je hebt scooters gestolen!', 'Je hebt een paar elektrische fietsen gestolen!', 'Je hebt juwelen gestolen!', 'Je hebt een kunstwerk gestolen!', 'Je hebt een pinautomaat ge-ramkraakt!');
        $x = rand(0, 5);
        echo "" . $options[$x] . "<br /> Je hebt $cashgeld euro hiermee verdiend!\n";
        echo "
        <script>
            document.querySelector('form').style.display = 'none';
            document.querySelector('.possible').style.display = 'none';
        </script>
        ";
        header("Refresh: 5");
    } else {
        echo "
        <script>
            document.querySelector('form').style.display = 'none';
            document.querySelector('.possible').style.display = 'none';
        </script>
        ";
        echo "De misdaad is gefaald, probeer het later opnieuw!";
        header("Refresh: 5");
    }
}
?>