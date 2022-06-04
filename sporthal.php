<?php
include "notLoggedIn.php";



$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT id FROM users WHERE gebruikersnaam = '$username'");
$stmt->execute();
$row = $stmt->fetch();

$id = $row['id'];

$stmt2 = $pdo->prepare("SELECT date FROM sporthal_timers WHERE user_id = '$id'");
$stmt2->execute();
$row2 = $stmt2->fetch();

$date = $row2['date'];

$currenttime = time();

$verschil = $currenttime - $date;

$wachttijdstmt = $pdo->prepare("SELECT * FROM cooldowns WHERE event = 'sporthal'");
$wachttijdstmt->execute();
$wachttijdfetch = $wachttijdstmt->fetch();
$wachttijd = $wachttijdfetch['time'];

if ($verschil <= $wachttijd) {
    echo "
    <script>
    document.querySelector('form').style.display = 'none';
    </script>";
    echo "Je kan nog niet sporten, je moet nog " . ($wachttijd - $verschil) . " seconden wachten!";
} else {
    echo "
    <h2>Sporthal</h2>
    <form method='POST'>
        <input type='radio' name='keuze' value='basketbal'/>
        <label>Basketbal</label>
        <br />
        <input type='radio' name='keuze' value='rugby'/>
        <label>Rugby</label>
        <br />
        <input type='radio' name='keuze' value='voetbal'/>
        <label>Voetbal</label>
        <br />
        <input type='radio' name='keuze' value='tennis'/>
        <label>Tennis</label>
        <br />
        <br />
        <input type='submit' value='Start met sporten' name='submit' />
    </form>
    ";
}
?>

<?php
$submit = $_POST['submit'];
$keuze = $_POST['keuze'];

if (isset($submit)) {
        $timepressed = time();
        $removestmt = $pdo->prepare("DELETE FROM sporthal_timers WHERE user_id = '$id'");
        $removestmt->execute();
        $stmt = $pdo->prepare("INSERT INTO sporthal_timers (user_id, date) VALUES ('$id', '$timepressed')");
        $stmt->execute();
        switch ($keuze) {
            case "basketbal":
                $stmt = $pdo->prepare("SELECT power from users WHERE gebruikersnaam = '$username'");
                $stmt->execute();
                $row = $stmt->fetch();
                $power = $row['power'];
                $random = rand(500, 2000);
                $power += $random;
                $stmt = $pdo->prepare("UPDATE users SET power = " . $power . " WHERE gebruikersnaam = '$username'");
                $stmt->execute();
                echo "Je hebt gebasketbal gespeeld, je kreeg hiervoor " . number_format($random, 0, ',', '.') . " power, je power is nu " . number_format($power, 0, ',', '.') . ".";
                echo "
                <script>
                    document.querySelector('form').style.display = 'none';
                </script>
                ";
                header("Refresh: 5");
                return;
            case "rugby":
                $stmt = $pdo->prepare("SELECT power from users WHERE gebruikersnaam = '$username'");
                $stmt->execute();
                $row = $stmt->fetch();
                $power = $row['power'];
                $random = rand(500, 2000);
                $power += $random;
                $stmt = $pdo->prepare("UPDATE users SET power = " . $power . " WHERE gebruikersnaam = '$username'");
                $stmt->execute();
                echo "Je hebt rugby gespeeld, je kreeg hiervoor " . number_format($random, 0, ',', '.') . " power, je power is nu " . number_format($power, 0, ',', '.') . ".";
                echo "
                <script>
                    document.querySelector('form').style.display = 'none';
                </script>
                ";
                header("Refresh: 5");
                return;
            case "voetbal":
                $stmt = $pdo->prepare("SELECT power from users WHERE gebruikersnaam = '$username'");
                $stmt->execute();
                $row = $stmt->fetch();
                $power = $row['power'];
                $random = rand(500, 2000);
                $power += $random;
                $stmt = $pdo->prepare("UPDATE users SET power = " . $power . " WHERE gebruikersnaam = '$username'");
                $stmt->execute();
                echo "Je hebt voetbal gespeeld, je kreeg hiervoor " . number_format($random, 0, ',', '.') . " power, je power is nu " . number_format($power, 0, ',', '.') . ".";
                echo "
                <script>
                    document.querySelector('form').style.display = 'none';
                </script>
                ";
                header("Refresh: 5");
                return;
            case "tennis":
                $stmt = $pdo->prepare("SELECT power from users WHERE gebruikersnaam = '$username'");
                $stmt->execute();
                $row = $stmt->fetch();
                $power = $row['power'];
                $random = rand(500, 2000);
                $power += $random;
                $stmt = $pdo->prepare("UPDATE users SET power = " . $power . " WHERE gebruikersnaam = '$username'");
                $stmt->execute();
                echo "Je hebt tennis gespeeld, je kreeg hiervoor " . number_format($random, 0, ',', '.') . " power, je power is nu " . number_format($power, 0, ',', '.') . ".";
                echo "
                <script>
                    document.querySelector('form').style.display = 'none';
                </script>
                ";
                header("Refresh: 5");
                return;
            default:
                return;
    }
}
?>