<?php
include "notLoggedIn.php";

$query = "SELECT * FROM `users` WHERE `gebruikersnaam`=:gebruikersnaam";
$stmt = $pdo->prepare($query);
$stmt->execute(array(
    ':gebruikersnaam' => $_SESSION["username"]
));
$rows = $stmt->fetchAll();
foreach ($rows as $row) {
    if ($row['admin'] === 'false') {
        echo "<script>window.location.href = 'status.php'</script>";
    }
}
?>