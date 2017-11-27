<?php
    session_start();
    if (!isset($_SESSION['userData'])) {
        header('Location: /HackMeZSK/');
        exit();
    }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; ?>

<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/beforeHeadA.php'; ?>

    <title>HackMeZSK</title>
    <link rel="stylesheet" href="../includes/css/account.css">
    <style>
        #rz {
            background-color: #66fcf1;
            color: #0b0c10;
        }
    </style>
    <script src="/HackMeZSK/includes/js/hideAlertBox.js"></script>

<?php /* </HEAD> */ require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterHeadA.php'; ?>

<div id="content">
    <div id="accountMenu">
        <div class="niceButton" id="rz">Rozwiązane zadania</div>
        <div class="niceButton" id="do">Dane osobowe</div>
        <div class="niceButton" id="zh">Zmień hasło</div>
        <div class="niceButton" id="ze">Zmień E-mail</div>
    </div>
    <div id="accountContent">
        <?php
            if (count($_SESSION['userSolutions']) > 1) {
                array_pop($_SESSION['userSolutions']);
                $INArray = implode(',', $_SESSION['userSolutions']);
            } else {
                echo '<p>Nie rozwiązałeś jeszcze żadnego zadania</p>';
            }
        ?>
    </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterContent.php'; ?>