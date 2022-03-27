<?php
include "verbinding.php";

error_reporting(0);

$stmt = $pdo->prepare("SELECT * from users WHERE naam = 'Mauro'");
$stmt->execute();
$rows = $stmt->fetchAll();

// Overzicht
foreach ($rows as $row) {
    echo "Ingelogd als " . $row['naam'] . "\n";
    echo "Cash: €" . $row['cashgeld'] . "\n";
    echo "Bank: €" . $row['bankgeld'] . "\n";
    echo "
    <table>
    <tr>
    <th colspan='2'>Persoonlijke informatie</th>
    </tr>
    <tr>
    <td>Naam</td>
    <td> " . $row['naam'] . " </td>
    </tr>
    <tr>
    <td>Rank</td>
    <td> " . $row['rank'] . " </td>
    </tr>
    <tr>
    <td>Kogels</td>
    <td> " . $row['kogels'] . " </td>
    </tr>
    <tr>
    <td>Power</td>
    <td> " . $row['power'] . " </td>
    </tr>
    </table>
    ";
}

// Power kopen
$prijs = 2650;
$power = 100;
echo "
<br />
    <form method='POST'>
    <label>" . $power . " power kopen voor " . $prijs ." cash</label><br />
    <label>Aantal</label>
    <input type='number' name='amount'/>
    <input type='submit' value='Koop' name='power' />
    </form>
";

$koop = $_POST['power'];

// Power kopen logica
foreach ($rows as $row) {
    if (isset($koop)) {
        $cash = $row['cashgeld'];
        $amount = $_POST['amount'];
        $spelerpower = $row['power'];
        if ($cash >= $prijs) {
            if ($amount >= 1) {
                // Declare variables

                echo "Gekocht!";
                $cash -= $prijs * $amount;
                $spelerpower += $power * $amount;
                $stmt1 = $pdo->prepare("UPDATE users SET cashgeld = $cash WHERE naam = 'Mauro'");
                $stmt2 = $pdo->prepare("UPDATE users SET power = $spelerpower WHERE naam = 'Mauro'");
                $stmt1->execute();
                $stmt2->execute();
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