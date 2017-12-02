<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsNotLoggedA.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HackMeZSK - zadanie <?php echo basename(__DIR__); ?></title>
    <link rel="stylesheet" href="../../../includes/css/levels.css">
</head>
<body>
    <div id="formDiv">
        <form action="check.php" method="POST" id="form">
            Podaj hasło: <input type="text" name="pass" maxlength="8">
            <button type="button" id="button">Prześlij</button>
        </form>
        <div id="alertLevel"><?php echoSessionAlert('levelAlert'); ?></div>
    </div>
    <script src="js/validate.js"></script>
</body>
</html>