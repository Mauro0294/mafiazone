<?php
include "notLoggedIn.php";
$username = $_SESSION['username'];
?>

<html>
    <head><link rel='stylesheet' href='murder.css'></head>
    <body>
    <?php include "sidebar.php" ?>
        <div class="wrapper">
        <?php include "topbar.php" ?>
        <div class='content'>
        <h2>Moord</h2>
        <div class="contentwrapper">
        <form method='POST'>
            <label>Slachtoffer</label><br />
            <input type='text' name='victim'/><br />
            <label>Kogels</label><br />
            <input type='number' name='bullets' /><br />
            <input type='submit' name='submit' value='Vermoord persoon'>
        </form>
        <p>Let op, je hebt 100 kogels per 1% gezondheid nodig om iemand te vermoorden!</p>
</div>
</div>
</div>
    </body>
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
                    $stmt = $pdo->prepare("SELECT kogels FROM users WHERE gebruikersnaam = '$username'");
                    $stmt->execute();
                    $row = $stmt->fetch();
                    $kogels = $row['kogels'];
                    if ($bullets > $kogels) {
                        echo "Je hebt niet genoeg kogels om deze persoon te vermoorden!";
                    } else {
                        $stmt = $pdo->prepare("UPDATE users SET gezondheid = '$gezondheid' WHERE gebruikersnaam = '$victim'");
                        $stmt->execute();
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
                        echo "Het slachtoffer is dood!";
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

?>