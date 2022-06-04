<?php
include "notLoggedIn.php";

$username = $_SESSION['username'];

$stmt = $pdo->prepare("SELECT * from users WHERE gebruikersnaam = :username");
$stmt->execute(
    ['username' => $username]);
$rows = $stmt->fetchAll();

// Overzicht
foreach ($rows as $row) {
    echo "Ingelogd als " . $row['gebruikersnaam'] . "\n";
    echo "Cash: €" . number_format($row['cashgeld'], 0, ',', '.') . "\n";
    echo "Bank: €" . number_format($row['bankgeld'], 0, ',', '.') . "\n";

echo "
    <form method='POST'>
        <label>Storten</label>
        <input type='radio' checked name='keuze' value='storten' />
        <br />
        <label>Opnemen</label>
        <input type='radio' name='keuze' value='opnemen'/>
        <br />
        <input type='number' value='" . $row['cashgeld'] . "' name='bedrag' />
        <br />
        <input type='submit' value='Voer transactie uit' name='submit' />
    </form>
";
}

$keuze = $_POST['keuze'];
$submit = $_POST['submit'];
$bedrag = $_POST['bedrag'];

if (isset($submit)) {
    $bedrag = $_POST['bedrag'];
    if ($bedrag > 0) {
        foreach ($rows as $row) {
            switch ($keuze) {
                case "storten":
                    $cash = $row['cashgeld'];
                    $bank = $row['bankgeld'];
                    if ($bedrag <= $cash) {
                        $cash -= $bedrag;
                        $bank += $bedrag;
                        $stmt1 = $pdo->prepare("UPDATE users SET cashgeld = " . $cash . " WHERE gebruikersnaam = :username");
                        $stmt2 = $pdo->prepare("UPDATE users SET bankgeld = " . $bank . " WHERE gebruikersnaam = :username");
                        $stmt1->execute(['username' => $username]) && $stmt2->execute(['username' => $username]);
                        header("Refresh: 0"); 
                    }
                    return;
                case "opnemen":
                    $cash = $row['cashgeld'];
                    $bank = $row['bankgeld'];
                    if ($bedrag <= $bank) {
                        $cash += $bedrag;
                        $bank -= $bedrag;
                        $stmt1 = $pdo->prepare("UPDATE users SET cashgeld = " . $cash . " WHERE gebruikersnaam = :username");
                        $stmt2 = $pdo->prepare("UPDATE users SET bankgeld = " . $bank . " WHERE gebruikersnaam = :username");
                        $stmt1->execute(['username' => $username]) && $stmt2->execute(['username' => $username]);
                        header("Refresh: 0");
                    }
                    return;
                default:
                    return;
            }
        }
    } else {
        echo "Voer een geldig bedrag in";
    }
}
?>