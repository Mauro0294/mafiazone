<html>
    <head>
        <link rel='stylesheet' href='sidebar.css'>
    <script src="https://kit.fontawesome.com/44d0f25a2a.js" crossorigin="anonymous"></script>
</head>
</html>

<?php
include "notLoggedIn.php";

$username = $_SESSION['username'];
echo 
"
<div class='sidebar'>
        <div class='username'>$username</div>
        <ul>
                <h3>Criminaliteit</h3>
                <li><a href='misdaad.php'><i id='icon' class='fa-solid fa-bomb'></i>Misdaad plegen</a></li>
                <li><a href='auto_stelen.php'><i id='icon' class='fa-solid fa-car-burst'></i>Auto stelen</a></li>
                <li><a href='attack.php'><i id='icon' class='fa-solid fa-person-rifle'></i>Aanvallen</a></li>
                <li><a href='murder.php'><i id='icon' class='fa-solid fa-skull'></i>Moord</a></li>
                <h3>Omgeving</h3>
                <li><a href='bank.php'><i id='icon' class='fa-solid fa-building-columns'></i>Bank</a></li>
                <li><a href='winkel.php'><i id='icon' class='fa-solid fa-cart-shopping'></i></i>Winkel</a></li>
                <li><a href='straatrace.php'><i id='icon' class='fa-solid fa-car'></i>Straatrace</a></li>
                <li><a href='ziekenhuis.php'><i id='icon' class='fa-solid fa-hospital'></i>Ziekenhuis</a></li>
                <li><a href='kogelfabriek.php'><i id='icon' class='fa-solid fa-gun'></i>Kogelfabriek</a></li>
                <li><a href='sporthal.php'><i id='icon' class='fa-solid fa-football'></i>Sporthal</a></li>
                <li><a href='garage.php'><i id='icon' class='fa-solid fa-warehouse'></i>Garage</a></li>
                <h3>Casino</h3>
                <li><a href='hoger_of_lager.php'><i id='icon' class='fa-solid fa-up-down'></i>Hoger of lager</a></li>
                <li><a href='kop_of_munt.php'><i id='icon' class='fa-solid fa-coins'></i>Kop of munt</a></li>
                <h3>Overige</h3>
                <li><a href='creditshop.php'><i id='icon' class='fa fa-shop' aria-hidden='true'></i>Creditshop</a></li>
                <li><a href='koffers.php'><i id='icon' class='fa fa-briefcase' aria-hidden='true'></i>Koffers</a></li>
                <li><a href='logout.php'><i id='icon' class='fa fa-sign-out' aria-hidden='true'></i>Uitloggen</a></li>
            </ul>
        </div>
";
?>