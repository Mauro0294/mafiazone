<html>
<head>
<title>MafiaZone | Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel='stylesheet' href='index.css'>
<script src="https://kit.fontawesome.com/44d0f25a2a.js" crossorigin="anonymous"></script>
<link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <ul class='ul'>
        <li><i class="fa-solid fa-bars icon" id='display' onclick="openMenu()"></i><i class="fa-solid fa-xmark icon" id='display2' onclick='closeMenu()'></i><a href='index.php' class='logo'>MafiaZone</a></li>
        <div class='hide'>
            <li><a href="index.php" id="first">Home</a></li>
            <li><a href="login.php">Game</a></li>
            <li><a href="#">Info</a></li>
        </div>
        <li><a href='login.php' class='login'><button>Login</button></a></li>
    </ul>
    <ul class='dropdown'>
    <li><a href="index.php" id="first">Home</a></li>
        <li><a href='login.php'>Game</a></li>
        <li><a href='#'>Info</a></li>
    </ul>
    <div class='container'>
        <div class='register'>
            <h1>MafiaZone: Enter the zone</h1><br />
            <div class='center'><a href='registreer.php'><button>Create account.</button></a></div>
        </div>
    </div>
    <script src='menu.js'></script>
</body>
</html>