<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/beforeHeadA.php'; ?>

    <title>Rejestracja</title>

<?php /* </HEAD> */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/afterHeadA.php'; ?>

<div id="content">
    <div id="formDiv">
        <form id="formForm">
            Podaj login:
            <input type="text" name="login">
            Podaj hasło:
            <input type="password" name="pass">
        </form>
    </div>
</div>

<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/afterContent.php'; 
?>