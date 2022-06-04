<?php
include "notLoggedIn.php";



$username = $_SESSION['username'];
$kogelprijs = 2500;
?>

<html>
    <h2>Kogel Fabriek</h2>
    <form method='POST'>
        <table width='250px'>
            <tr>
                <td>Beschikbare kogels</td>
                <td>Oneindig</td>
            </tr>
            <tr>
                <td>Maximale aantal kogels</td>
                <td>
                    <?php 
                    $stmt = $pdo->prepare("SELECT cashgeld FROM users WHERE gebruikersnaam = '$username'");
                    $stmt->execute();
                    $row = $stmt->fetch();
                    $cash = $row['cashgeld'];
                    $kogels = floor($cash / $kogelprijs);
                    echo number_format($kogels, 0, ',', '.');
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Kogelprijs
                </td>
                <td>€<?php echo number_format($kogelprijs, 0, ',', '.'); ?> per kogel</td>
            </tr>
        </table>
        Koop <input type='number' name='amount'/>  kogels<br />
        <input type='submit' name='submit' value='Koop kogels'/>
    </form>
</html>

<?php
$submit = $_POST['submit'];
$amount = $_POST['amount'];
if (isset($submit)) {
    $stmt = $pdo->prepare("SELECT cashgeld FROM users WHERE gebruikersnaam = '$username'");
    $stmt->execute();
    $row = $stmt->fetch();
    $cash = $row['cashgeld'];
    $cost = $amount * $kogelprijs;
    if ($cash < $cost) {
        echo "Je hebt niet genoeg geld om zoveel kogels te kopen!";
    } else {
        $cash -= $cost;
        $stmt = $pdo->prepare("UPDATE users SET cashgeld = '$cash' WHERE gebruikersnaam = '$username'");
        $stmt->execute();

        $stmt = $pdo->prepare("SELECT kogels FROM users WHERE gebruikersnaam = '$username'");
        $stmt->execute();
        $row = $stmt->fetch();
        $kogels = $row['kogels'];
        $kogels += $amount;

        $stmt = $pdo->prepare("UPDATE users SET kogels = '$kogels' WHERE gebruikersnaam = '$username'");
        $stmt->execute();
        echo "Je hebt " . $amount . " kogels gekocht!";
    }
}
?>