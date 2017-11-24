<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; ?>
<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/beforeHeadA.php'; ?>

    <title>Logowanie</title>
    <link rel="stylesheet" type="text/css" href="/HackMeZSK/includes/css/passRemindChange.css">
    <script src="../includes/js/passRemindChange.js"></script>

<?php /* </HEAD> */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterHeadA.php'; ?>

<div id="content">
    <form action="send.php" method="POST" id="passRemindChangeForm">
        <div><label>Podaj nowe hasło: <input type="text" name="pass1" maxlength="45"></label></div>
        <div id="alertPass1" class="passRemindChangeAlert"></div>
        <div><label>Powtórz nowe hasło: <input type="text" name="pass2" maxlength="45"></label></div>
        <div id="alertPass2" class="passRemindChangeAlert"></div>
        <button type="button" class="niceButton">Zmień hasło</button>
    </form>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterContent.php'; ?>