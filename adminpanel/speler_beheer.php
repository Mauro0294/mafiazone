<?php
include "../admin_check.php";
?>

<html>
    <head>
        <title>MafiaZone - Speler Beheer</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
                                if ($row['banned'] == 'true') {
                                    $banstatus = "Unbannen";
                                } else {
                                    $banstatus = "Bannen";
                                }
                                echo "
                                <div class='box2'>
                                <h2>Speler gegevens</h2>
                                <table>
                                <form method='post'>
                                <tr>
                                <th>Gebruikersnaam</th>
                                <td><input type='text' style='margin: 0;' readonly name='gebruikersnaam' value='" . $row['gebruikersnaam'] . "'></td>
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
                                <td><input type='submit' name='submitchanges' value='Wijzigen'></td>
                                <td><input type='submit' class='button' style='background: darkred;' name='banplayer' value='" . $banstatus . "'></td>
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
$username = $_POST['gebruikersnaam'];
$submitchanges = $_POST['submitchanges'];

if (isset($submitchanges)) {
    $stmt = $pdo->prepare("UPDATE users SET cashgeld = :cashgeld, bankgeld = :bankgeld, power = :power, kogels = :kogels, credits = :credits WHERE gebruikersnaam = :username");
    $stmt->execute([
        'cashgeld' => $cashgeld,
        'bankgeld' => $bankgeld,
        'power' => $power,
        'kogels' => $kogels,
        'credits' => $credits,
        'username' => $username
    ]);
}

$banplayer = $_POST['banplayer'];

if (isset($banplayer)) {
    $stmt = $pdo->prepare("SELECT banned from users WHERE gebruikersnaam = :username");
                            $stmt->execute([
                                'username' => $username
                            ]);
                            $row = $stmt->fetch();
    if ($row['banned'] == 'true') {
        $stmt = $pdo->prepare("UPDATE users SET banned = 'false' WHERE gebruikersnaam = :username");
        $stmt->execute([
            'username' => $username
        ]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET banned = 'true' WHERE gebruikersnaam = :username");
        $stmt->execute([
            'username' => $username
        ]);
    }
}
?>