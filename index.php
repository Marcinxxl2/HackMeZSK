<?php require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; ?>

<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/beforeHeadA.php'; ?>

    <title>HackMeZSK</title>
    <script src="/HackMeZSK/includes/js/hideAlertBox.js"></script>
    <style>
        #content p, #content h1 {
            color: #c5c6c7;
            text-align: center;
        }
    </style>

<?php /* </HEAD> */ require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterHeadA.php'; ?>

<div id="content">
    <?php echoSessionAlert('mainAlert'); ?>
    <h1>Witaj na HackMeZSK</h1>
    <p>Po lewej stronie znajdują się linki do zadań</p>
    <p>Aby je rozwiązywać musisz być zalogowany</p>
    <p>Za każdę rozwiązane zadanie otrzymujesz punkty</p>
    <p>W niektórych zadaniach znajdują się podpowiedzi, ukryte w źródle strony HTML</p>
    <p>Powodzenia!</p>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterContent.php'; ?>