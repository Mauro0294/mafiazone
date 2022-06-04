<?php
include "../admin_check.php";
include '../verbinding.php';
?>

<html>
    <head>
        <title>MafiaZone - Auto Beheer</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class='box'>
            <img src='car.png'>
            <h2>Auto Toevoegen</h2>
            <form method="POST">
                <label for='model'>Model</label>
                <input type="text" name="model" placeholder="Voer het model in">
                <label for='img_url'>Image url</label>
                <input type="text" name="img_url" placeholder="Voer de img url in">
                <label for='waarde'>Waarde</label>
                <input type="text" name="waarde" placeholder="Voer de waarde in">
                <input type='submit' name='submit' value='Toevoegen'>
            </form>
        </div>
    </body
</html>

<?php
$model = $_POST['model'];
$img_url = $_POST['img_url'];
$waarde = $_POST['waarde'];
$submit = $_POST['submit'];

if (isset($submit)) {
    $stmt = $pdo->prepare("INSERT INTO autos (model, img_url, waarde) VALUES (:model, :img_url, :waarde)");
    $stmt->execute(['model' => $model, 'img_url' => $img_url, 'waarde' => $waarde]);
}
?>