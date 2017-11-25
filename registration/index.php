<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; ?>

<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/beforeHeadA.php'; ?>

    <title>Rejestracja</title>
    <link rel="stylesheet" type="text/css" href="/HackMeZSK/includes/css/regis.css">
    <script src="../includes/js/regis.js"></script>
    <script src="../includes/js/hideAlertBox.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

<?php /* </HEAD> */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterHeadA.php'; ?>

<div id="content">
    <?php echoSessionAlert('passRemindChangeAlert'); ?>
    <form action="registration.php" method="POST" id="regisForm">
        <div class="regisSide">
            <div>
                <div class="regisLegend">Podaj login: *</div>
                <input type="text" name="login" maxlength="45" tabindex='1'>
                <div id="alertLogin" class="regisAlert"><?php echoSessionAlert('usernameAlreadyExists'); ?></div>
            </div>
            <div>
                <div class="regisLegend">Podaj imię:</div>
                <input type="text" name="firstname" maxlength="45" tabindex='3'>
                <div id="alertFirstname" class="regisAlert"></div>
            </div>
            <div>
                <div class="regisLegend">Podaj hasło: *</div>
                <input type="password" name="password1" maxlength="45" tabindex='5'>
                <div id="passwordMeter" hidden>
                    <div id="meterLength" class='badText'>Minimum 8 znaków</div>
                    <div id="meterLetter" class='badText'>Litera</div>
                    <div id="meterDigit" class='badText'>Cyfra</div>
                    <div id="meterSpecial" class='badText'>Znak specjalny</div>
                </div>
                <div id="alertPassword1" class="regisAlert"></div>
            </div>
            <div id="regisRegulations">
                <label for="regulationsCheckbox">Zaakceptuj</label> <a href="../includes/docs/regulamin_strony" target="_blank" id="regulationsLink">regulamin</a>: <input type="checkbox" name="regulations" value="accepted" id="regulationsCheckbox" autocomplete="off">
                <div id="alertRegulations"></div>
            </div>
            <div class="g-recaptcha" data-sitekey="6LdkzzYUAAAAAIPRNJZ7BmEmjQ7Ku0Ny4_9pTxgu"></div>
            <div id="alertCaptcha"></div>
            <button type="button" class="niceButton">Zarejestruj</button>
            <p>* Pola obowiązkowe</p>
        </div>
        <div class="regisSide">
            <div>
                <div class="regisLegend">Podaj E-mail: *</div>
                <input type="text" name="email" maxlpth="45" tabindex='2'>
                <div id="alertEmail" class="regisAlert"><?php echoSessionAlert('emailAlreadyExists'); ?></div>
            </div>
            <div>
                <div class="regisLegend">Podaj nazwisko:</div>
                <input type="text" name="lastname" maxlength="45" tabindex='4'>
                <div id="alertLastname" class="regisAlert"></div>
            </div>
            <div>
                <div class="regisLegend">Powtórz hasło: *</div>
                <input type="password" name="password2" maxlength="45" tabindex='6' disabled>
                <div id="alertPassword2" class="regisAlert"></div>
            </div>
        </div>
    </form>
</div>

<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterContent.php'; 
?>