<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; ?>
<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/beforeHeadA.php'; ?>

    <title>Logowanie</title>
    <link rel="stylesheet" type="text/css" href="/HackMeZSK/includes/css/passRemind.css">
    <script src="../../includes/js/passRemind.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

<?php /* </HEAD> */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterHeadA.php'; ?>

<div id="content">
    <?php echoSessionAlert('passRemindAlert'); ?>
    <form action="send.php" method="POST" id="passRemindForm">
        Link do zmiany hasła zostanie wysłany na podany poniżej E-mail
        <div><label>Podaj E-mail: <input type="text" name="email" maxlength="45"></label></div>
        <div id="alertEmail" class="passRemindAlert"><?php echoSessionAlert('emailError'); ?></div>
        <div class="g-recaptcha" data-sitekey="6LdkzzYUAAAAAIPRNJZ7BmEmjQ7Ku0Ny4_9pTxgu"></div>
        <div id="alertCaptcha" class="passRemindAlert"></div>
        <button type="button" class="niceButton">Wyślij link</button>
    </form>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterContent.php'; ?>