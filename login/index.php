<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; ?>
<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/beforeHeadA.php'; ?>

    <title>Logowanie</title>
    <link rel="stylesheet" type="text/css" href="/HackMeZSK/includes/css/login.css">
    <script src="../includes/js/login.js"></script>

<?php /* </HEAD> */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterHeadA.php'; ?>

<div id="content">
    <form action="login.php" method="POST" id="loginForm">
        <div><label>Podaj login: <input type="text" name="login" maxlength="45"></label></div>
        <div><label>Podaj hasło: <input type="password" name="pass" maxlength="45"></label></div>
        <button type="button" class="niceButton">Zaloguj</button>
        <span id="alert"><?php echoSessionAlert('loginError'); ?></span>
    </form>
    <a href="../technical/passRemind/" id="passRemind" class="textLink">Nie pamiętasz hasła?</a>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterContent.php'; ?>