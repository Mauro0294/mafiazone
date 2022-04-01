<?php

include "notLoggedIn.php";

error_reporting(0);

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
    <tr>
    <td>Credits</td>
    <td> " . number_format($row['credits'], 0, ',', '.') . " </td>
    </tr>
    <tr>
    <td>Moorden</td>
    <td> " . number_format($row['moorden'], 0, ',', '.') . " </td>
    </tr>
    </table>
    <a href='logout.php'>Uitloggen</a>
    ";
}
?>