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
    <tr>
    <td>Belcredits</td>
    <td> " . $row['belcredits'] . " </td>
    </tr>
    <tr>
    <td>Moorden</td>
    <td> " . $row['moorden'] . " </td>
    </tr>
    </table>
    ";
}
?>