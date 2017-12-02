<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsNotLoggedA.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsAddSolution.php'; 

    if (!isset($_COOKIE['login'])) {
        echo 'test';
        header ('Location: ./');
        exit();
    }
    if ($_COOKIE['login'] === 'admin') {
        addSolution(basename(__DIR__));
        setcookie("login", "", time() - 3600);
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HackMeZSK - zadanie <?php echo basename(__DIR__); ?></title>
    <link rel="stylesheet" href="../../../includes/css/levels.css">
    <style> 
        p {
            color: #c5c6c7;
        }
    </style>
</head>
<body>
    <?php
        echo '<p>Witaj '.$_COOKIE['login'].'</p>';
        echo '<p><a href="logout.php">Wyloguj się</a></p>';
    ?>
</body>
</html>