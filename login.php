<?php
include "verbinding.php";
session_start();
?>
<html>
    <head>
        <link href="tailwind.css" rel="stylesheet">
        <link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">
        <style>
            body {
                background-color: rgb(255, 255, 255);
                font-weight: bold;
                font-style: italic;
                font-family: 'Roboto Mono', monospace;
                background-repeat: no-repeat;
                background-size: cover;
                margin: 0px;
                padding: 0px;
                cursor: default;
                background-image: url("images/original.gif");
            }

            * {
                font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Ubuntu, "Helvetica Neue", sans-serif;
            }

            input {
                background-color: #2C2C2C;
            }
        </style>
    </head>
    <body class=''>
        <div class='float-right lg:w-2/5 sm:w-full h-full bg-black lg:mt-0 sm:pt-96 lg:pt-0 text-white block text-center' data-aos="fade-left" data-aos-duration="500">
            <div class='flex justify-center'>
                <img src='images/logo.png' class='lg:w-10 sm:w-32 mt-20'>
            </div>
            <h1 class='lg:text-3xl sm:text-7xl lg:mt-16 sm:mt-12 mb-14'>INLOGGEN BIJ BITR.</h1>
            <form method='post'>
                <h1 class='mb-4 lg:text-lg sm:text-3xl'>GEBRUIKERSNAAM.</h1>
                <input type='text' name='gebruikersnaam' class='sm:w-1/2 mb-20 lg:py-4 lg:pr-20 lg:text-lg sm:text-2xl sm:py-6 sm:pr-32 outline-none pl-2 rounded-lg' placeholder='Gebruikersnaam' maxlength='25' required>
                <h1 class='mb-4 lg:text-lg sm:text-3xl'>WACHTWOORD.</h1>
                <input name='wachtwoord' class='sm:w-1/2 lg:mb-8 sm:mb-20 py-4 pr-20 pl-2 lg:text-lg sm:text-2xl outline-none rounded-lg' placeholder='Wachtwoord' type='password' required><br>
                <button name='login' class='bg-blue-500 sm:text-2xl lg:text-base rounded-full lg:py-3 sm:py-5 font-bold lg:px-14 sm:px-24 hover:bg-blue-600 duration-500'>INLOGGEN.</button>
            </form>
        
        <h1 class='lg:text-xs sm:text-2xl lg:mt-10 sm:mt-20 mb-20'>NOG GEEN ACCOUNT?<a href='registreer.php' class='text-blue-500 hover:text-blue-600 duration-500'> REGISTREER NU!</a></h1>
        <h1 id='h1'>VERKEERD WACHTWOORD OF GEBRUIKERSNAAM.</h1>
        <img src='images/original.gif' class='lg:hidden sm:block w-full h-1/2 mr-10'>
        </div>
        <script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>
        <script src='data-aos.js'></script>
    </body>

<?php
if (isset($_POST['login'])) {
    $gebruikersnaam = trim($_POST['gebruikersnaam']);
    $wachtwoord = trim($_POST['wachtwoord']);
    if ($gebruikersnaam != "" && $wachtwoord != "") {
        $query = "SELECT * FROM `users` WHERE `gebruikersnaam`=:gebruikersnaam AND `wachtwoord`=:wachtwoord";
        $stmt = $connect->prepare($query);
        $stmt->bindParam('gebruikersnaam', $gebruikersnaam, PDO::PARAM_STR);
        $stmt->bindParam('wachtwoord', $wachtwoord, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($count == 1 && !empty($row)) {
            echo "<script type='text/javascript'>alert('Je bent succesvol ingelogd!');</script>";
            $id = $row['id'];
            $_SESSION['userID'] = $id;
            header('Location: index.php');
        } else {
            echo "
            <div class='float-right lg:mt-96'>
            <h1 class='text-white ml-28 lg:mt-80 z-1 absolute'>VERKEERD GEBRUIKERSNAAM OF WACHTWOORD!</h1>
            </div>";
        }
    }
}
?>

</html>