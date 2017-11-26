<?php require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; ?>

<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/beforeHeadA.php'; ?>

    <title>HackMeZSK</title>
    <script src="/HackMeZSK/includes/js/hideAlertBox.js"></script>

<?php /* </HEAD> */ require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterHeadA.php'; ?>

<div id="content">
    <?php 
        echoSessionAlert('mainAlert');
    ?>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterContent.php'; ?>