<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/beforeHeadA.php'; ?>

    <title>Rejestracja</title>
    <link rel="stylesheet" type="text/css" href="/HackMeZSK/includes/css/regis.css">
    <script src="../includes/js/regis.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

<?php /* </HEAD> */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/afterHeadA.php'; ?>

<div id="content">
    <form action="regis.php" method="POST" id="regisForm">
        <div class="regisSide">
            <div>
                <div class="regisLegend">Podaj login: *</div>
                <input type="text" name="login" maxlength="45">
                <div id="alertLogin" class="regisAlert"></div>
            </div>
            <div>
                <div class="regisLegend">Podaj imię:</div>
                <input type="text" name="firstname" maxlength="45">
                <div id="alertFirstname" class="regisAlert"></div>
            </div>
            <div>
                <div class="regisLegend">Podaj hasło: *</div>
                <input type="password" name="password1" maxlength="45">
                <div id="alertPassword1" class="regisAlert"></div>
            </div>
            <div id="regisRegulations">
                <label for="regulationsCheckbox">Zaakceptuj</label> <a href="../includes/docs/regulamin_strony" target="_blank" id="regulationsLink">regulamin</a>: <input type="checkbox" name="regulations" id="regulationsCheckbox">
                <div id="alertRegulations" class="regisAlert"></div>
            </div>
            <div class="g-recaptcha" data-sitekey="6LchbRQUAAAAAKNfB7TwFroRDo4JZa3plUU_pmZG"></div>
            <button type="button" class="niceButton">Zarejestruj</button>
            <p>* Pola obowiązkowe</p>
        </div>
        <div class="regisSide">
            <div>
                <div class="regisLegend">Podaj E-mail: *</div>
                <input type="text" name="email" maxlength="45">
                <div id="alertEmail" class="regisAlert"></div>
            </div>
            <div>
                <div class="regisLegend">Podaj nazwisko:</div>
                <input type="text" name="lastname" maxlength="45">
                <div id="alertLastname" class="regisAlert"></div>
            </div>
            <div>
                <div class="regisLegend">Powtórz hasło: *</div>
                <input type="password" name="password2" maxlength="45">
                <div id="alertPassword2" class="regisAlert"></div>
            </div>
        </div>
    </form>
</div>

<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/afterContent.php'; 
?>