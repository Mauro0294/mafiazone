<?php
include "notLoggedIn.php";



$username = $_SESSION['username'];
$kogelprijs = 2500;
?>

<html>
    <head>
        <link rel="stylesheet" href="kogelfabriek.css">
    </head>
<?php include "sidebar.php" ?>
        <div class="wrapper">
        <?php include "topbar.php" ?>
        <div class='content'>
    <h2>Kogel Fabriek</h2>
    <div class="contentwrapper">
        <p>Om iemand te vermoorden of aan te vallen heb je kogels nodig, deze kan je hier kopen.<br />Momenteel zijn er oneindig kogels in voorraad</p>
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
                    $stmt = $pdo->prepare("SELECT cashgeld FROM users WHERE gebruikersnaam = :username");
                    $stmt->execute([
                        'username' => $username
                    ]);
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
        <p>Aantal kogels om te kopen<br/> <input type='number' name='amount'/></p><br />
        <input type='submit' name='submit' value='Koop kogels'/>
    </form>
</html>

<?php
$submit = $_POST['submit'];
$amount = $_POST['amount'];
if (isset($submit)) {
    $stmt = $pdo->prepare("SELECT cashgeld FROM users WHERE gebruikersnaam = :username");
    $stmt->execute([
        'username' => $username
    ]);
    $row = $stmt->fetch();
    $cash = $row['cashgeld'];
    $cost = $amount * $kogelprijs;
    if ($cash < $cost) {
        echo "<p>Je hebt niet genoeg geld om zoveel kogels te kopen!</p>";
    } else {
        $cash -= $cost;
        $stmt = $pdo->prepare("UPDATE users SET cashgeld = '$cash' WHERE gebruikersnaam = :username");
        $stmt->execute([
            'username' => $username
        ]);

        $stmt = $pdo->prepare("SELECT kogels FROM users WHERE gebruikersnaam = :username");
        $stmt->execute([
            'username' => $username
        ]);
        $row = $stmt->fetch();
        $kogels = $row['kogels'];
        $kogels += $amount;

        $stmt = $pdo->prepare("UPDATE users SET kogels = '$kogels' WHERE gebruikersnaam = :username");
        $stmt->execute([
            'username' => $username
        ]);
        echo "<p>Je hebt " . $amount . " kogels gekocht!</p>";
    }
}
?>