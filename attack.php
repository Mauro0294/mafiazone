<?php
include "notLoggedIn.php";

$username = $_SESSION['username'];
?>

<html>
    <form method='POST'>
        <table>
            <tr>
                <th colspan='2'>Aanvallen</th>
            </tr>
            <tr>
                <td>Slachtoffer</td>
                <td><input type='text' name='victim'/></td>
            </tr>
            <tr>
                <td><input type='submit' name='submit' value='Val persoon aan'></td>
            </tr>
        </table>
    </form>
    <p>Let op, om iemand aan te vallen heb je minimaal 1 kogel nodig.</p>
</html>

<?php
$submit = $_POST['submit'];
$victim = $_POST['victim'];
if (isset($submit)) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE gebruikersnaam = '$victim'");
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row['id'] == null) {
        echo "Deze persoon bestaat niet!";
    } else {
        if ($victim == $username) {
            echo "Je kan jezelf niet vermoorden!";
        } else {
            $stmt = $pdo->prepare("SELECT gezondheid FROM users WHERE gebruikersnaam = '$victim'");
            $stmt->execute();
            $row = $stmt->fetch();
            $gezondheid = $row['gezondheid'];
            if ($gezondheid > 25) {
                $stmt = $pdo->prepare("SELECT power FROM users WHERE gebruikersnaam = '$username'");
                $stmt->execute();
                $row = $stmt->fetch();
                $power = $row['power'];
                $stmt = $pdo->prepare("SELECT power FROM users WHERE gebruikersnaam = '$victim'");
                $stmt->execute();
                $row = $stmt->fetch();
                $victimPower = $row['power'];
                if ($power > $victimPower) {
                    $stmt = $pdo->prepare("SELECT kogels FROM users WHERE gebruikersnaam = '$username'");
                    $stmt->execute();
                    $row = $stmt->fetch();
                    $kogels = $row['kogels'];
                    if ($kogels >= 1) {
                        $kogels -= 1;
                        $stmt = $pdo->prepare("UPDATE users SET kogels = '$kogels' WHERE gebruikersnaam = '$username'");
                        $stmt->execute();
                        $stmt = $pdo->prepare("SELECT gezondheid FROM users WHERE gebruikersnaam = '$victim'");
                        $stmt->execute();
                        $row = $stmt->fetch();
                        $gezondheid = $row['gezondheid'];
                        $gezondheid -= 1;
                        $stmt = $pdo->prepare("UPDATE users SET gezondheid = '$gezondheid' WHERE gebruikersnaam = '$victim'");
                        $stmt->execute();
                        
                        $stmt = $pdo->prepare("SELECT cashgeld FROM users WHERE gebruikersnaam = '$username'");
                        $stmt->execute();
                        $row = $stmt->fetch();
                        $cash = $row['cashgeld'];
                        
                        $stmt = $pdo->prepare("SELECT cashgeld FROM users WHERE gebruikersnaam = '$victim'");
                        $stmt->execute();
                        $row = $stmt->fetch();
                        $cash2 = $row['cashgeld'];

                        $moneyplus = $cash2 / 4;
                        $cash += $moneyplus;
                        $stmt = $pdo->prepare("UPDATE users SET cashgeld = '$cash' WHERE gebruikersnaam = '$username'");
                        $stmt->execute();

                        $cashvictim = $cash2 * 0.75;
                        $stmt = $pdo->prepare("UPDATE users SET cashgeld = '$cashvictim' WHERE gebruikersnaam = '$victim'");
                        $stmt->execute();


                        echo "Je hebt de persoon aangevallen, hiermee heb je €" . number_format($moneyplus, 0, ',', '.') . " euro verdiend.";
                    } else {
                        echo "Niet genoeg kogels om deze persoon aan te vallen!";
                    }
                } else {
                    echo "Je hebt niet genoeg power om deze persoon aan te vallen.<br /><a href='winkel.php'>Ga naar de winkel voor meer power!</a>";
                }
            } else {
                echo "Het slachtoffer heeft te weinig gezondheid om aangevallen te kunnen worden!";
            }
        }
    }
}
?>