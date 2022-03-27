<?php
include "verbinding.php";

?>
<!-- Algemente statistieken -->
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
    <td><?php echo $sum_cash ?></td>
    </tr>
    <tr>
    <td>Totaal bank</td>
    <?php
    $stmt = $pdo->prepare("SELECT SUM(bankgeld) as sum_bank FROM users");
    $stmt->execute();
    $rows = $stmt->fetch();
    $sum_bank = $rows['sum_bank']
    ?>
    <td><?php echo $sum_bank ?></td>
    </tr>
    <tr>
    <td>Totaal geld</td>
    <td><?php echo $sum_cash + $sum_bank?></td>
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
    </table>
    </body>
</html>