<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/usefulFunctions.php'; ?>

<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/beforeHeadA.php'; ?>

    <title>HackMeZSK</title>
    <script src="/HackMeZSK/includes/js/hideAlertBox.js"></script>

<?php /* </HEAD> */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterHeadA.php'; ?>

<div id="content">
    <?php 
        echoSessionAlert('mainAlert');
    ?>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterContent.php'; ?>