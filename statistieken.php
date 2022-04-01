<?php
include "notLoggedIn.php";

?>
<!-- Algemene statistieken -->
<html>
    <body>
    <table>
    <tr>
    <th colspan='2'>Algemene statistieken</th>
    </tr>
    <tr>
    <td>Totaal leden</td>
    <?php 
    $stmt = $pdo->prepare("SELECT MAX(id) AS max_id FROM users");
    $stmt->execute();
    $rows = $stmt->fetch();
    $max_id = $rows['max_id'];
    ?>
    <td><?php echo $max_id?></td>
    </tr>
    <tr>
    <td>Totaal contant</td>
    <?php
    $stmt = $pdo->prepare("SELECT SUM(cashgeld) as sum_cash FROM users");
    $stmt->execute();
    $rows = $stmt->fetch();
    $sum_cash = $rows['sum_cash']
    ?>
    <td><?php echo "€" . number_format($sum_cash, 0, ',', '.') ?></td>
    </tr>
    <tr>
    <td>Totaal bank</td>
    <?php
    $stmt = $pdo->prepare("SELECT SUM(bankgeld) as sum_bank FROM users");
    $stmt->execute();
    $rows = $stmt->fetch();
    $sum_bank = $rows['sum_bank']
    ?>
    <td><?php echo "€" . number_format($sum_bank, 0, ',', '.') ?></td>
    </tr>
    <tr>
    <td>Totaal geld</td>
    <td><?php echo "€" . number_format($sum_cash + $sum_bank, 0, ',', '.') ?></td>
    </tr>
    <tr>
    <td>Totaal kogels</td>
    <?php
    $stmt = $pdo->prepare("SELECT SUM(kogels) as sum_kogels FROM users");
    $stmt->execute();
    $rows = $stmt->fetch();
    $sum_kogels = $rows['sum_kogels']
    ?>
    <td><?php echo $sum_kogels ?></td>
    </tr>
    <tr>
    <td>Totaal power</td>
    <?php
    $stmt = $pdo->prepare("SELECT SUM(power) as sum_power FROM users");
    $stmt->execute();
    $rows = $stmt->fetch();
    $sum_power = $rows['sum_power']
    ?>
    <td><?php echo number_format($sum_power, 0, ',', '.') ?></td>
    </tr>
    <tr>
    <td>Totaal moorden</td>
    <?php
    $stmt = $pdo->prepare("SELECT SUM(moorden) as sum_moorden FROM users");
    $stmt->execute();
    $rows = $stmt->fetch();
    $sum_moorden = $rows['sum_moorden']
    ?>
    <td><?php echo number_format($sum_moorden, 0, ',', '.') ?></td>
    </tr>
    <tr>
</tr>
    </table>
    <table>
    <tr>
    <th colspan='2'>Meeste power</th>
    </tr>
    <?php
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY power DESC LIMIT 10");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    foreach($rows as $row) {
        echo "<tr>";
        echo "<td>" . $row['gebruikersnaam'] . "</td>";
        echo "<td>" . number_format($row['power'], 0, ',', '.') . "</td>";
        echo "</tr>";
    }
    ?>
    <tr>
    <th colspan='2'>Rijkste spelers</th>
    </tr>
    <?php
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY bankgeld DESC LIMIT 10");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    foreach($rows as $row) {
        $geld = $row['cashgeld'] + $row['bankgeld'];
        echo "<tr>";
        echo "<td>" . $row['gebruikersnaam'] . "</td>";
        echo "<td>" . number_format($geld, 0, ',', '.') . "</td>";
        echo "</tr>";
    }
    ?>


    <tr>
    <th colspan='2'>Meeste kogels</th>
    </tr>
    <?php
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY kogels DESC LIMIT 10");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    foreach($rows as $row) {
        echo "<tr>";
        echo "<td>" . $row['gebruikersnaam'] . "</td>";
        echo "<td>" . number_format($row['kogels'], 0, ',', '.') . "</td>";
        echo "</tr>";
    }
    ?>
    <tr>
    <th colspan='2'>Meeste moorden</th>
    </tr>
    <?php
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY moorden DESC LIMIT 10");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    foreach($rows as $row) {
        echo "<tr>";
        echo "<td>" . $row['gebruikersnaam'] . "</td>";
        echo "<td>" . number_format($row['moorden'], 0, ',', '.') . "</td>";
        echo "</tr>";
    }
    ?>
    </table>
    </body>
</html>
<!-- Einde algemene statistieken -->
<?php

?>