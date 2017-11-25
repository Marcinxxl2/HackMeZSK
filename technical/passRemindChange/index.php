<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; ?>
<?php
    if (!isset($_GET['c'])) {
        header('Location: ../../index.php');
    }
?>
<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/beforeHeadA.php'; ?>

    <title>Logowanie</title>
    <link rel="stylesheet" type="text/css" href="/HackMeZSK/includes/css/passRemindChange.css">
    <script src="../../includes/js/passRemindChange.js"></script>

<?php /* </HEAD> */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterHeadA.php'; ?>

<div id="content">
    <form action="change.php" method="POST" id="passRemindChangeForm">
        <div><label>Podaj nowe hasło: <input type="password" name="password1" maxlength="45"></label></div>
        <div id="passwordMeter" hidden>
            <div id="meterLength" class='badText'>Minimum 8 znaków</div>
            <div id="meterLetter" class='badText'>Litera</div>
            <div id="meterDigit" class='badText'>Cyfra</div>
            <div id="meterSpecial" class='badText'>Znak specjalny</div>
        </div>
        <div id="alertPassword1" class="passRemindChangeAlert"></div>
        <div><label>Powtórz nowe hasło: <input type="password" name="password2" maxlength="45" disabled="disabled"></label></div>
        <div id="alertPassword2" class="passRemindChangeAlert"></div>
        <button type="button" class="niceButton">Zmień hasło</button>
    </form>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterContent.php'; ?>
<?php
    $_SESSION['passwordChangeCode'] = $_GET['c'];
?>