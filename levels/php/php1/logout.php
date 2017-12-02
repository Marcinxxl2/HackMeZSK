<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsNotLoggedA.php';
    
    if (isset($_COOKIE['login'])) {
        setcookie("login", "", time() - 3600);
        header('Location: ./');
    } else {
        header('Location: ./');
    }

?>