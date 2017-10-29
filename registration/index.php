<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/beforeHeadA.php'; ?>

    <title>Rejestracja</title>
    <link rel="stylesheet" type="text/css" href="/HackMeZSK/includes/css/regis.css">
    <script src="../includes/js/regis.js"></script>

<?php /* </HEAD> */ require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/afterHeadA.php'; ?>

<div id="content">
    <form action="regis.php" method="POST" id="regisForm">
        <div id="inputLoginDiv">
            Login:<br>
            <input type="text" name="login" maxlength="45">
        </div>
        <div id="inputEmailDiv">
            Email:<br>
            <input type="text" name="email" maxlength="45">
        </div>
    </form>
</div>

<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/afterContent.php'; 
?>