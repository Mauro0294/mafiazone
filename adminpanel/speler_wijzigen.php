<?php
include "../admin_check.php";
?>

<html>
    <head>
        <title>MafiaZone - Speler Wijzigen</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class='container'>
            <div class='boxwrapper'>
                <div class='playerbox'>
                    <img src='avatar.png'>
                    <h2>Speler opzoeken</h2>
                    <form method="POST">
                        <label for='model'>Gebruikersnaam</label>
                        <input type="text" name="username" placeholder="Voer een gebruikersnaam in">
                        <input type='submit' name='submit' value='Opzoeken'>
                    </form>
                </div>
                    <?php
                        $username = $_POST['username'];
                        $submit = $_POST['submit'];

                        if (isset($submit)) {
                            $stmt = $pdo->prepare("SELECT * from users WHERE gebruikersnaam = :username");
                            $stmt->execute([
                                'username' => $username
                            ]);
                            $rows = $stmt->fetchAll();
                            foreach ($rows as $row) {
                                echo "
                                <div class='box2'>
                                <h2>Speler gegevens</h2>
                                <table>
                                <form method='post'>
                                <tr>
                                <th>Gebruikersnaam</th>
                                <td>" . $row['gebruikersnaam'] . "</td>
                                </tr>
                                <tr>
                                <th>Cashgeld</th>
                                <td><input type='number' name='cashgeld' value='" . $row['cashgeld'] . "'></td>
                                </tr>
                                <tr>
                                <th>Bankgeld</th>
                                <td><input type='number' name='bankgeld' value='" . $row['bankgeld'] . "'></td>
                                </tr>
                                <tr>
                                <th>Power</th>
                                <td><input type='number' name='power' value='" . $row['power'] . "'></td>
                                </tr>
                                <tr>
                                <th>Kogels</th>
                                <td><input type='number' name='kogels' value='" . $row['kogels'] . "'></td>
                                </tr>
                                <tr>
                                <th>Credits</th>
                                <td><input type='number' name='credits' value='" . $row['credits'] . "'></td>
                                </tr>
                                <tr>
                                <td colspan='2'><input type='submit' name='submitchanges' value='Wijzigen'></td>
                                </tr>
                                </form>
                                </table>
                                </div>
                                ";
                            }
                        }
                        ?>
            </div>
        </div>
    </body
</html>

<?php
$cashgeld = $_POST['cashgeld'];
$bankgeld = $_POST['bankgeld'];
$power = $_POST['power'];
$kogels = $_POST['kogels'];
$credits = $_POST['credits'];
$submitchanges = $_POST['submitchanges'];

if (isset($submitchanges)) {
    $stmt = $pdo->prepare("UPDATE users SET cashgeld = :cashgeld, bankgeld = :bankgeld, power = :power, kogels = :kogels, credits = :credits WHERE gebruikersnaam = :username");
    $stmt->execute([
        'cashgeld' => $cashgeld,
        'bankgeld' => $bankgeld,
        'power' => $power,
        'kogels' => $kogels,
        'credits' => $credits,
        'username' => $_SESSION['username']
    ]);
}
?>