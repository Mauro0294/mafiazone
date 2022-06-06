<?php
include "notLoggedIn.php";

$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT id FROM users WHERE gebruikersnaam = :username");
$stmt->execute([
    'username' => $username
]);
$row = $stmt->fetch();

$userid = $row['id'];

$stmt2 = $pdo->prepare("SELECT * FROM misdaad_timers WHERE user_id = :userid");
$stmt2->execute([
    'userid' => $userid
]);
$row2 = $stmt2->fetch();

$date = $row2['date'];
$currenttime = time();

$verschil = $currenttime - $date;

$wachttijdstmt = $pdo->prepare("SELECT * FROM cooldowns WHERE event = 'misdaad'");
$wachttijdstmt->execute();
$wachttijdfetch = $wachttijdstmt->fetch();
$wachttijd = $wachttijdfetch['time'];

$wait_time = $wachttijd - $verschil;

if ($verschil <= $wachttijd) {
    echo "Je kan nog geen misdaad plegen!<br />";
    echo "<span>Je moet nog <span class='time'>" . $wait_time . "</span> seconden wachten!</span>";
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
echo "
<script>
let time = document.querySelector('.time').innerText;

setInterval(function(){
    document.querySelector('.time').innerText = time;
     time--;
     if (time < 0) {
         window.location.href = 'misdaad.php';
     }
   }, 1000)
</script>";
$stmt = $pdo->prepare("SELECT id FROM users where gebruikersnaam = :username");
$stmt->execute([
    'username' => $username
]);
$row = $stmt->fetch();

$id = $row['id'];

$submit = $_POST['submit'];
if (isset($submit)) {
    $timepressed = time();
    $removestmt = $pdo->prepare("DELETE FROM misdaad_timers WHERE user_id = :id");
    $removestmt->execute([
        'id' => $id
    ]);
    $stmt = $pdo->prepare("INSERT INTO misdaad_timers (user_id, date) VALUES (:id, :timepressed)");
    $stmt->execute([
        'id' => $id,
        'timepressed' => $timepressed
    ]);
    $randomnumber = rand(1, 3);
    $cashgeld = rand(25000, 50000);
    if ($randomnumber == 1) { 
        $stmt = $pdo->prepare("UPDATE users SET cashgeld = cashgeld + :cashgeld WHERE gebruikersnaam = :username");
        $stmt->execute([
            'cashgeld' => $cashgeld,
            'username' => $username
        ]);
        $options = array('Je hebt een winkel overvallen!', 'Je hebt scooters gestolen!', 'Je hebt een paar elektrische fietsen gestolen!', 'Je hebt juwelen gestolen!', 'Je hebt een kunstwerk gestolen!', 'Je hebt een pinautomaat ge-ramkraakt!');
        $x = rand(0, count($options));
        $cashgeld = number_format($cashgeld, 0, ',', '.');
        echo "" . $options[$x] . "<br /> Je hebt $cashgeld euro hiermee verdiend!\n";
        echo "
        <script>
            document.querySelector('form').style.display = 'none';
            document.querySelector('.possible').style.display = 'none';
        </script>
        ";
        echo "<script> setTimeout(function() { window.location = 'misdaad.php'; }, 5000);</script>";
    } else {
        echo "
        <script>
            document.querySelector('form').style.display = 'none';
            document.querySelector('.possible').style.display = 'none';
        </script>
        ";
        echo "De misdaad is gefaald, probeer het later opnieuw!";
        echo "<script> setTimeout(function() { window.location = 'misdaad.php'; }, 5000);</script>";
    }
}
?>