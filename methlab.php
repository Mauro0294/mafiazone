<?php
    include "notLoggedIn.php";

    $username = $_SESSION['username'];
    $stmt = $pdo->prepare("SELECT id FROM users WHERE gebruikersnaam = :username");
    $stmt->execute(['username' => $username]);
    $useridfetch = $stmt->fetch();
    $userid = $useridfetch['id'];
    http_response_code(404);
?>

<html>
    <head>
        <title>MafiaZone | Meth Lab</title>
        <link rel="stylesheet" href="methlab.css">
        <link
      href="https://fonts.googleapis.com/css?family=Montserrat"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <body>
        <div class='container'>
            <div class='content'>
                <h2>Meth Lab</h2>
                <br />
                <?php
                $stmt = $pdo->prepare('SELECT * from methlabs WHERE user_id = :userid');
                $stmt->execute(['userid' => $userid]);
                $methlabfetch = $stmt->fetch();
                $rowcount = $stmt->rowCount();
                if ($rowcount == 0) {
                    echo "<p>
                    Ah eindelijk <?php echo $username ?>, daar ben je dan!
                    Hier kan je je eigen meth lab kopen en als je hem hebt gekocht, meth produceren en voor geld verkopen!
                </p>";
                    echo "<p>Koop een meth lab voor €2.500.000</p>";
                    echo "<form method='post'>
                    <input type='submit' name='buy' value='Koop meth lab'>
                    </form>";
                    $buy = $_POST['buy'];
                    $stmt = $pdo->prepare("SELECT cashgeld FROM users WHERE gebruikersnaam = :username");
                    $stmt->execute(['username' => $username]);
                    $saldofetch = $stmt->fetch();
                    $saldo = $saldofetch['cashgeld'];
                    $prijs = 2500000;
                    if (isset($buy)) {
                        if ($saldo < $prijs) {
                            echo "<p>Je hebt niet genoeg geld om een meth lab te kopen</p>";
                        } else {
                            $stmt = $pdo->prepare('INSERT INTO methlabs (user_id) VALUES (:userid)');
                            $stmt->execute(['userid' => $userid]);
                            $stmt = $pdo->prepare('UPDATE users SET cashgeld = cashgeld - :prijs WHERE id = :userid');
                            $stmt->execute(['prijs' => $prijs, 'userid' => $userid]);
                            echo "<p>Je hebt een meth lab gekocht!</p>";
                        }
                    }
                } else {
                    echo "<h3>Start het produceren van meth</h3>
                    <p>Het produceren zal 12 uur duren, daarna is de productie klaar en zorgen de werkers in het lab dat het verkocht kan worden, het enigste wat je hoeft te doen, is na 12 uur terugkomen en het te verkopen.</p>
                    <form method='post'>
                    <input type='submit' name='produce' value='Start meth productie'>
                    </form>";
                    $produce = $_POST['produce'];
                    if (isset($produce)) {
                        $stmt = $pdo->prepare('SELECT * from methlab_timers WHERE user_id = :userid');
                        $stmt->execute(['userid' => $userid]);
                        $methlabfetch = $stmt->fetch();
                        $rowcount = $stmt->rowCount();
                        if ($rowcount == 0) {
                            $stmt = $pdo->prepare('INSERT INTO methlab_timers (user_id ,time) VALUES (:userid, :time);');
                            $stmt->execute(['userid' => $userid, 'time' => time()]);
                            echo "<p>Je bent gestart met het produceren van meth!</p>";
                        } else {
                            $stmt = $pdo->prepare("SELECT * FROM methlab_timers WHERE user_id = :userid");
                            $stmt->execute([
                                'userid' => $userid
                            ]);
                            $row = $stmt->fetch();
                            $date = $row['time'];

                            $currenttime = time();

                            $verschil = $currenttime - $date;

                            $wachttijdstmt = $pdo->prepare("SELECT * FROM cooldowns WHERE event = 'methlab'");
                            $wachttijdstmt->execute();
                            $wachttijdfetch = $wachttijdstmt->fetch();
                            $wachttijd = $wachttijdfetch['time'];

                            $wait_time = $wachttijd - $verschil;
                            echo "<p>Je moet nog $wait_time seconden wachten voordat de meth klaar is met produceren!</p>";
                            if ($wait_time < 0) {
                                echo "<h3>Je meth is klaar, druk hieronder om de meth te verkopen!</h3>";
                                echo 
                                "
                                <form method='post'>
                                <input type='submit' name='sell' value='Verkopen'>
                                </form>
                                ";
                                $sell = $_POST['sell'];
                                if (isset($sell)) {
                                    $verkoopprijs = 100000;
                                    $stmt = $pdo->prepare('DELETE FROM methlab_timers WHERE user_id = :userid');
                                    $stmt->execute(['userid' => $userid]);
                                    $stmt = $pdo->prepare('UPDATE users SET cashgeld = cashgeld + :verkoopprijs WHERE id = :userid');
                                    $stmt->execute(['verkoopprijs' => $verkoopprijs, 'userid' => $userid]);
                                    echo "<p>Je hebt je meth verkocht voor $verkoopprijs</p>";
                                }
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>