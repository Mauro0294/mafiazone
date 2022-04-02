<?php
include "notLoggedIn.php";

$username = $_SESSION['username'];

$globalstmt = $pdo->prepare("SELECT id from users where gebruikersnaam = '$username'");
$globalstmt->execute();
$globalrow = $globalstmt->fetch();
$globalid = $globalrow['id'];

$stmt = $pdo->prepare("SELECT auto_id FROM garage WHERE user_id = '$globalid'");
$stmt->execute();
$rows = $stmt->fetchAll();
if (count($rows) == 0) {
echo "Je hebt nog geen auto's in je garage.<br /><a href='auto_stelen.php'>Druk hier om een auto te proberen stelen!</a>";
} else {
    echo "<table width='300px''>
    <tr>
        <th>Garage</th>
    </tr>
    <tr>
        <td><b>Model</b></td>
        <td><b>Waarde</b></td>
    </tr>
    ";
    foreach ($rows as $row) {
        $autos = $row['auto_id'];
        $stmt = $pdo->prepare("SELECT * FROM autos WHERE id = '$autos'");
        $stmt->execute();
        $row = $stmt->fetch();
        echo "
        <tr>
        <td>" . $row['model'] . "</td>
        <td>€" . number_format($row['waarde'], 0, ',', '.') . "</td>
        </tr>";
    }
    echo "</table>";
}
?>
