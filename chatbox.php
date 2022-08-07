<?php
function miniChat() {
    include "notLoggedIn.php";
    $username = $_SESSION['username'];

    echo "
    <table id='table' width=300px;>";
    $datapdo2 = "SELECT * FROM messages ORDER BY id DESC LIMIT 10";
    $stmtpdo2 = $pdo->prepare($datapdo2);
    $stmtpdo2->execute();
    $rowpdo2 = $stmtpdo2->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rowpdo2 as $berichten) {
        echo "<tr>";
        echo "<th>" . $berichten['afzender'] . "</th>";
        echo "<td>" . $berichten['bericht'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "
    <form method='post'>
    <input type='text' name='bericht'>
    <input type='submit' name='submit'>
    </form>";
    
    if (isset($_POST['submit'])) {
        $bericht = $_POST['bericht'];
    
        $sql = "INSERT INTO messages (afzender, bericht) 
        VALUES ('$username', '$bericht')";
        $pdo->prepare($sql);
        $pdo->exec($sql);
        header("Refresh: 0");
    }
}
?>