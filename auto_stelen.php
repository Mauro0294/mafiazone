<?php
include "notLoggedIn.php";

error_reporting(0);

$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT id FROM users WHERE gebruikersnaam = '$username'");
$stmt->execute();
$row = $stmt->fetch();

$userid = $row['id'];

$stmt2 = $pdo->prepare("SELECT * FROM autostelen_timers WHERE user_id = '$userid'");
$stmt2->execute();
$row2 = $stmt2->fetch();

$date = $row2['date'];
$currenttime = time();

$verschil = $currenttime - $date;
$wachttijd = 300;

function echoDifference() {
    echo "Je moet nog " . ($wachttijd - $verschil) . " seconden wachten!";
}

if ($verschil <= $wachttijd) {
    echo "Je kan geen auto stelen!<br />";
    echo "Je moet nog " . ($wachttijd - $verschil) . " seconden wachten!";
    } else {
    echo "<p class='possible'>Je kan een auto stelen!</p>";
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
    $removestmt = $pdo->prepare("DELETE FROM autostelen_timers WHERE user_id = '$id'");
    $removestmt->execute();
    $stmt = $pdo->prepare("INSERT INTO autostelen_timers (user_id, date) VALUES ('$id', '$timepressed')");
    $stmt->execute();
    $successrate = rand(1, 5);
    if ($successrate == 1) {
        echo "
        <script>
        document.querySelector('.possible').style.display = 'none';
        </script>";
        $auto = rand(1,2);
        $stmt = $pdo->prepare("INSERT INTO garage (user_id, auto_id) VALUES ('$id', '$auto')");
        $stmt->execute();
        
        $stmt = $pdo->prepare("SELECT * FROM autos WHERE id = '$auto'");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            echo "Je hebt een " . $model = $row['model'] . " gestolen, met een waarde van €" . number_format($row['waarde'], 0, ',', '.') . " euro!<br />";
            echo "<img src='" . $row['img_url'] . "'width='500px'>";
        }
        echo "
        <script>
            document.querySelector('form').style.display = 'none';
        </script>
        ";
        header("Refresh: 5");
    } else {
        echo "Je hebt geen auto kunnen stelen, probeer het later opnieuw!";
        echo "
        <script>
            document.querySelector('form').style.display = 'none';
        </script>
        ";
        header("Refresh: 5");
    }
}

