<?php
include "verbinding.php";

error_reporting(0);

$stmt = $pdo->prepare("SELECT * from users WHERE naam = 'Mauro'");
$stmt->execute();
$rows = $stmt->fetchAll();

foreach ($rows as $row) {
    echo "Power: " . number_format($row['power'], 0, ',', '.') . "";
    echo "<br />";
    echo "Bankgeld: " . number_format($row['bankgeld'], 0, ',', '.') . "";
}
?>

<table width="650px">
    <form method='POST'>
        <tr>
            <th>#</th>
            <th>Optie</th>
            <th>Credits</th>
        </tr>
        <tr>
            <td><input type='radio' name='keuze' value='power1' /></td>
            <td>500.000 power</td>
            <td>Kost 100 credits</td>
        </tr>
        <tr>
            <td><input type='radio' name='keuze' value='power2' /></td>
            <td>1.500.000 power</td>
            <td>Kost 300 credits</td>
        </tr>
        <tr>
            <td><input type='radio' name='keuze' value='bank1' /></td>
            <td>20.000.000 bankgeld</td>
            <td>Kost 50 credits</td>
        </tr>
        <tr>
            <td><input type='radio' name='keuze' value='bank2' /></td>
            <td>50.000.000 bankgeld</td>
            <td>Kost 125 credits</td>
        </tr>
            <td colspan='2'><b>Huidige credits:</b>
            <?php
            $stmt = $pdo->prepare("SELECT credits from users WHERE naam = 'Mauro'");
            $stmt->execute();
            $row = $stmt->fetch();
            echo number_format($row['credits'], 0, ',', '.');
            ?>
            </td>
            <td>
                Aantal<input type='number' name="aantal"/><input type='submit' name='submit' value='Schaf het product aan' />
            </td>
    </form>
</table>

<?php
$stmt = $pdo->prepare("SELECT * from users WHERE naam = 'Mauro'");
$stmt->execute();
$rows = $stmt->fetchAll();
foreach ($rows as $row) {
    $power = $row['power'];
    $bank = $row['bankgeld'];
    $credits = $row['credits'];
    $submit = $_POST['submit'];
    if (isset($submit)) {
        $keuze = $_POST['keuze'];
        $aantal = $_POST['aantal'];
        switch ($keuze) {
            case "power1":
                if ($credits >= 100 * $aantal) {
                    $power += 500000 * $aantal;
                    $credits -= 100 * $aantal;
                    $stmt1 = $pdo->prepare("UPDATE users SET power = " . $power . " WHERE naam = 'Mauro'");
                    $stmt2 = $pdo->prepare("UPDATE users SET credits = " . $credits . " WHERE naam = 'Mauro'");
                    $stmt1->execute();
                    $stmt2->execute();
                    header("Refresh: 0");
                    return;
                } else {
                    echo "Niet genoeg credits!";
                    return;
                }
            case "power2":
                if ($credits >= 300 * $aantal) {
                    $power += 1500000 * $aantal;
                    $credits -= 300 * $aantal;
                    $stmt1 = $pdo->prepare("UPDATE users SET power = " . $power . " WHERE naam = 'Mauro'");
                    $stmt2 = $pdo->prepare("UPDATE users SET credits = " . $credits . " WHERE naam = 'Mauro'");
                    $stmt1->execute();
                    $stmt2->execute();
                    header("Refresh: 0");
                    return;
                } else {
                    echo "Niet genoeg credits!";
                    return;
                }
            case "bank1":
                if ($credits >= 50 * $aantal) {
                    $bank += 20000000 * $aantal;
                    $credits -= 50 * $aantal;
                    $stmt1 = $pdo->prepare("UPDATE users SET bankgeld = " . $bank . " WHERE naam = 'Mauro'");
                    $stmt2 = $pdo->prepare("UPDATE users SET credits = " . $credits . " WHERE naam = 'Mauro'");
                    $stmt1->execute();
                    $stmt2->execute();
                    header("Refresh: 0");
                    return;
                } else {
                    echo "Niet genoeg credits!";
                    return;
                }
            case "bank2":
                if ($credits >= 125 * $aantal) {
                    $bank += 50000000 * $aantal;
                    $credits -= 125 * $aantal;
                    $stmt1 = $pdo->prepare("UPDATE users SET bankgeld = " . $bank . " WHERE naam = 'Mauro'");
                    $stmt2 = $pdo->prepare("UPDATE users SET credits = " . $credits . " WHERE naam = 'Mauro'");
                    $stmt1->execute();
                    $stmt2->execute();
                    header("Refresh: 0");
                    return;
                } else {
                    echo "Niet genoeg credits!";
                    return;
                }
            default:
                return;
        }
    }
}
?>