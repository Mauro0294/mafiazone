<?php
include "notLoggedIn.php";

error_reporting(0);

$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT id FROM users WHERE gebruikersnaam = '$username'");
$stmt->execute();
$row = $stmt->fetch();
?>

<html>
    <form>
        <table>
            <tr>
                <th colspan='2'>
</tr>
<tr>
<td></td>
<td></td>
        <input type="submit" name="submit" value="Probeer!"/>
</table>
    </form>
</html>