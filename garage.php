<?php
include "notLoggedIn.php";

$username = $_SESSION['username'];

$globalstmt = $pdo->prepare("SELECT id from users where gebruikersnaam = :username");
$globalstmt->execute(['username' => $username]);
$globalrow = $globalstmt->fetch();
$globalid = $globalrow['id'];

$stmt = $pdo->prepare("SELECT auto_id FROM garage WHERE user_id = :globalid");
$stmt->execute(['globalid' => $globalid]);
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
    <form method='post'>
    ";
    foreach ($rows as $row) {
        $autos = $row['auto_id'];
        $stmt = $pdo->prepare("SELECT * FROM autos WHERE id = :autos");
        $stmt->execute(['autos' => $autos]);
        $row = $stmt->fetch();
        echo "
        <tr>
        <td>" . $row['model'] . "</td>
        <td>€" . number_format($row['waarde'], 0, ',', '.') . "</td>
        </tr>";
    }
    echo "
    <tr>
    <td><input type='submit' name='sell' value='Alles verkopen' /></td>
    </tr>
    </form>
    </table>";
}

if (isset($_POST['sell'])) {
    $stmt = $pdo->prepare("SELECT * FROM garage WHERE user_id = :globalid");
    $stmt->execute(['globalid' => $globalid]);
    $rows = $stmt->fetchAll();
    foreach ($rows as $row) {
        $autos = $row['auto_id'];
        $stmt = $pdo->prepare("SELECT * FROM autos WHERE id = :autos");
        $stmt->execute(['autos' => $autos]);
        $row = $stmt->fetch();
        $waarde = $row['waarde'];
        $stmt = $pdo->prepare("UPDATE users SET cashgeld = cashgeld + :waarde WHERE gebruikersnaam = :username");
        $stmt->execute([
            'waarde' => $waarde,
            'username' => $username
        ]);
        $stmt = $pdo->prepare("DELETE FROM garage WHERE auto_id = :autos");
        $stmt->execute(['autos' => $autos]);
        echo "Je hebt alle auto's verkocht voor €" . number_format($waarde, 0, ',', '.') . " euro.";
        echo "<script> document.querySelector('table').style.display = 'none'; </script>";
        header("Refresh: 5");
    }
}
?>