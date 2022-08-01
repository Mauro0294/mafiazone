<html>
    <head><link rel='stylesheet' href='topbar.css'></head>
</html>

<?php
$stmt = $pdo->prepare('SELECT cashgeld FROM users WHERE gebruikersnaam = :username');
$stmt->execute(['username' => $username]);
$cashfetch = $stmt->fetch();
$cashgeld = number_format($cashfetch['cashgeld'], 0, ',', '.');

$stmt = $pdo->prepare('SELECT bankgeld FROM users WHERE gebruikersnaam = :username');
$stmt->execute(['username' => $username]);
$bankfetch = $stmt->fetch();
$bankgeld = number_format($bankfetch['bankgeld'], 0, ',', '.');

echo 
"<div class='topbar'><p>Cash: €$cashgeld <span>Bank: €$bankgeld</span></p></div>"
?>