<?php

include "notLoggedIn.php";
include "chatbox.php";

$username = $_SESSION['username'];

$stmt = $pdo->prepare("SELECT gezondheid FROM users WHERE gebruikersnaam = :username");
$stmt->execute([
    'username' => $username
]);
$row = $stmt->fetch();
$gezondheid = $row['gezondheid'];
if ($gezondheid <= 0) {
    echo "Je bent dood gemaakt.<br />";
    echo "<p'>Druk hier om je gezondheid terug te krijgen!</p>";
    echo "<form method='post'>
    <input type='submit' name='submit' value='Krijg gezondheid terug'>
    </form>";
    echo "
    <script>
        document.querySelector('#all').style.display = 'none';
    </script>
    ";
    $submit = $_POST['submit'];
    if (isset($submit)) {
        $stmt = $pdo->prepare("UPDATE users SET gezondheid = 100 WHERE gebruikersnaam = :username");
        $stmt->execute([
            'username' => $username
        ]);
        header('Refresh: 0');
    }
    return;
}

$stmt = $pdo->prepare("SELECT * from users WHERE gebruikersnaam = :username");
$stmt->execute([
    'username' => $username
]);	
$rows = $stmt->fetchAll();

// Overzicht
echo "<div id='all'>";
foreach ($rows as $row) {
    echo "Ingelogd als " . $row['gebruikersnaam'] . "\n";
    echo "Cash: €" . number_format($row['cashgeld'], 0, ',', '.') . "\n";
    echo "Bank: €" . number_format($row['bankgeld'], 0, ',', '.') . "\n";
    echo "
    <table width='200px'>
    <tr>
    <th colspan='2'>Persoonlijke informatie</th>
    </tr>
    <tr>
    <td>Naam</td>
    <td> " . $row['gebruikersnaam'] . " </td>
    </tr>
    <tr>
    <td>Kogels</td>
    <td> " . number_format($row['kogels'], 0, ',', '.') . " </td>
    </tr>
    <tr>
    <td>Power</td>
    <td> " . number_format($row['power'], 0, ',', '.') . " </td>
    </tr>
    <tr>
    <td>Credits</td>
    <td> " . number_format($row['credits'], 0, ',', '.') . " </td>
    </tr>
    <tr>
    <td>Moorden</td>
    <td> " . number_format($row['moorden'], 0, ',', '.') . " </td>
    </tr>
    <tr>
    <td>Gezondheid</td>
    <td> " . number_format($row['gezondheid'], 0, ',', '.') . "%</td>
    </tr>
    </table>
    <a href='logout.php'>Uitloggen</a>
    <h2>Links</h2>
    <div>
    <a href='winkel.php'>Winkel</a>
    <a href='creditshop.php'>Creditshop</a>
    <a href='kogelfabriek.php'>Kogelfabriek</a>
    <a href='murder.php'>Moord</a>
    <a href='attack.php'>Attack</a>
    <a href='garage.php'>Garage</a>
    <a href='misdaad.php'>Misdaad</a>
    <a href='auto_stelen.php'>Auto stelen</a>
    <a href='statistieken.php'>Statistieken</a>
    <a href='bank.php'>Bank</a>
    <a href='sporthal.php'>Sporthal</a>
    <a href='ziekenhuis.php'>Ziekenhuis</a>
    <a href='kop_of_munt.php'>Kop of munt</a>
    ";
    $stmt = $pdo->prepare("SELECT admin FROM users WHERE gebruikersnaam = :gebruikersnaam");
    $stmt->execute(['gebruikersnaam' => $_SESSION['username']]);
    $fetch = $stmt->fetch();
    if ($fetch['admin'] == 'true') {
        echo "<a href='adminpanel/index.php' style='color: red; margin-top: 20px'>Admin Paneel</a>";
    };
    echo "
    </div>
    ";
    miniChat();
    echo "
    </div>
    <style>
    div {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    </style>
    ";
}
?>