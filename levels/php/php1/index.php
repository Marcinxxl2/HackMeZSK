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
        <form action="login.php" method="POST">
            Podaj login: <input type="text" name="login"><br><br>
            Podaj hasło: <input type="password" name="pass"><br><br>
            <input type="submit" value="Zaloguj">
        </form>
        <?php echoSessionAlert('levelAlert'); ?>
    </div>
</body>
</html>