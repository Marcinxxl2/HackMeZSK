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
    <script>
        document.addEventListener("DOMContentLoaded", function() { 
            document.getElementById("pass").value = 'gf80tfp0';
        });       
    </script>
    
</head>
<body>
    <div id="formDiv">
        Pole do odczytania: <input type="password" id="pass"><br><br>
        <form action="check.php" method="POST">
            Podaj hasło: <input type="text" name="pass">
            <input type="submit">
        </form>
        <?php echoSessionAlert('levelAlert'); ?>
    </div>
</body>
</html>