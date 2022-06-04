<?php
include "verbinding.php";
session_start();
if (empty($_SESSION["username"])) {
    header('Location: login.php');
}
$query = "SELECT * FROM `users` WHERE `gebruikersnaam`=:gebruikersnaam";
$stmt = $pdo->prepare($query);
$stmt->execute(array(
    ':gebruikersnaam' => $_SESSION["username"]
));
$rows = $stmt->fetchAll();
foreach ($rows as $row) {
    if ($row['banned'] == 'true') {
        echo "<script>window.location.href = 'banned/banned.html'</script>";
    }
}
?>