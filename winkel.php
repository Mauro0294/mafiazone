<?php
include "notLoggedIn.php";



$username = $_SESSION['username'];

$stmt = $pdo->prepare("SELECT * from users WHERE gebruikersnaam = '$username'");
$stmt->execute();
$rows = $stmt->fetchAll();

// Overzicht
foreach ($rows as $row) {
    echo "Ingelogd als " . $row['gebruikersnaam'] . "\n";
    echo "Cash: €" . number_format($row['cashgeld'], 0, ',', '.') . "\n";
    echo "Bank: €" . number_format($row['bankgeld'], 0, ',', '.') . "\n";
    echo "
    <table>
    <tr>
    <th colspan='2'>Persoonlijke informatie</th>
    </tr>
    <tr>
    <td>Naam</td>
    <td> " . $row['gebruikersnaam'] . " </td>
    </tr>
    <tr>
    <td>Kogels</td>
    <td> " . number_format($row['kogels'], 0, ',', '.') . " </td>
    </tr>
    <tr>
    <td>Power</td>
    <td> " . number_format($row['power'], 0, ',', '.') . " </td>
    </tr>
    </table>
    ";
}

// Power kopen
$prijs = 2650;
$power = 100;
?>
<html>
<body>
<br />
    <form method='POST'>
    <label><?php echo $power ?> power kopen voor <?php echo $prijs?> cash</label><br />
    <label>Aantal</label>
    <input type='number' name='amount'/>
    <input type='submit' value='Koop' name='power' />
    </form>
";
</body>
</html>

<?php
$koop = $_POST['power'];

// Power kopen logica
foreach ($rows as $row) {
    if (isset($koop)) {
        $cash = $row['cashgeld'];
        $amount = $_POST['amount'];
        $spelerpower = $row['power'];
        if ($cash >= $prijs * $amount) {
            if ($amount >= 1) {
                echo "Gekocht!";
                $cash -= $prijs * $amount;
                $spelerpower += $power * $amount;
                $stmt1 = $pdo->prepare("UPDATE users SET cashgeld = $cash WHERE gebruikersnaam = :username");
                $stmt2 = $pdo->prepare("UPDATE users SET power = $spelerpower WHERE gebruikersnaam = :username");
                $stmt1->execute(['username' => $username]);
                $stmt2->execute(['username' => $username]);
                header("Refresh: 0");
            } else {
                echo "Voer een getal in boven de 0";
            }
        } else {
            echo "Niet genoeg contant geld!";
        }
    }
}
?>