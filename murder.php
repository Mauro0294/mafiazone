<?php
include "notLoggedIn.php";

error_reporting(0);

$username = $_SESSION['username'];
?>

<html>
    <form method='POST'>
        <table>
            <tr>
                <th colspan='2'>Moord</th>
            </tr>
            <tr>
                <td>Slachtoffer</td>
                <td><input type='text' name='victim'/></td>
            </tr>
            <tr>
                <td>Kogels</td>
                <td><input type='number' name='bullets' /></td>
            </tr>
            <tr>
                <td><input type='submit' name='submit' value='Vermoord persoon'></td>
            </tr>
        </table>
    </form>
    <p>Let op, je hebt 100 kogels per 1% gezondheid nodig om iemand te vermoorden!</p>
</html>

<?php
$submit = $_POST['submit'];
$victim = $_POST['victim'];
$bullets = $_POST['bullets'];
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
            if ($gezondheid <= 0) {
                echo "Deze persoon is al dood!";
            } else {
                $gezondheid = $gezondheid - ($bullets * 0.01);
                if ($gezondheid > 0) {
                    echo "Niet genoeg kogels om het slachtoffer te vermoorden!";
                } else {
                    $stmt = $pdo->prepare("UPDATE users SET gezondheid = '$gezondheid' WHERE gebruikersnaam = '$victim'");
                    $stmt->execute();
                    if ($gezondheid <= 0) {
                        $stmt = $pdo->prepare("SELECT kogels FROM users WHERE gebruikersnaam = '$username'");
                        $stmt->execute();
                        $row = $stmt->fetch();
                        $kogels = $row['kogels'];
                        if ($bullets > $kogels) {
                            echo "Je hebt niet genoeg kogels om deze persoon te vermoorden!";
                        } else {
                            $kogels -= $bullets;
                            $stmt = $pdo->prepare("UPDATE users SET kogels = '$kogels' WHERE gebruikersnaam = '$username'");
                            $stmt->execute();
                    
                            $stmt = $pdo->prepare("UPDATE users SET gezondheid = '0' WHERE gebruikersnaam = '$victim'");
                            $stmt->execute();
                            
                            $stmt = $pdo->prepare("SELECT cashgeld, bankgeld FROM users WHERE gebruikersnaam = '$victim'");
                            $stmt->execute();
                            $row = $stmt->fetch();
                            $cashgeld = $row['cashgeld'];
                            $bankgeld = $row['bankgeld'];
                            $geld = $cashgeld + $bankgeld;
    
                            $stmt = $pdo->prepare("SELECT cashgeld FROM users WHERE gebruikersnaam = '$username'");
                            $stmt->execute();
                            $row = $stmt->fetch();
                            $cashgeld = $row['cashgeld'];
                            $cashgeld += $geld;
                            $stmt = $pdo->prepare("UPDATE users SET cashgeld = '$cashgeld' WHERE gebruikersnaam = '$username'");
                            $stmt->execute();
                            echo "De slachtoffer is dood!";
                            echo "<br />";
                            echo "Je hebt al het geld van " . $victim . " gekregen, dit is €" . number_format($geld, 0, ',', '.') . "!";
    
                            $stmt = $pdo->prepare("UPDATE users SET cashgeld = '0', bankgeld = '0' WHERE gebruikersnaam = '$victim'");
                            $stmt->execute();
                            
                            $stmt = $pdo->prepare("SELECT moorden FROM users WHERE gebruikersnaam = '$username'");
                            $stmt->execute();
                            $row = $stmt->fetch();
                            $moorden = $row['moorden'];
                            $moorden += 1;
                            $stmt = $pdo->prepare("UPDATE users SET moorden = '$moorden' WHERE gebruikersnaam = '$username'");
                            $stmt->execute();
                        }
            }
                }
        }
        }
    }
}

?>