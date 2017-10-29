<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/beforeHeadA.php'; ?>

    <title>Logowanie</title>
    <link rel="stylesheet" type="text/css" href="/HackMeZSK/includes/css/login.css">
    <script src="../includes/js/login.js"></script>

<?php /* </HEAD> */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/afterHeadA.php'; ?>

<div id="content">
    <form action="login.php" method="POST" id="loginForm">
        <div><label>Podaj login: <input type="text" name="login"></label></div>
        <div><label>Podaj hasło: <input type="password" name="pass"></label></div>
        <button type="button">Zaloguj</button>
        <span id="alert"></span>
    </form>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/afterContent.php'; ?>