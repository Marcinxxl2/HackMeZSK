<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsNotLoggedA.php'; 

    if (isset($_POST['login']) && isset($_POST['pass'])) {
        if ($_POST['login'] === 'testowe' && $_POST['pass'] === 'pass123') {
            setcookie('login', 'testowe', (time() + 86400), './');
            header('Location: loged.php');
        } else {
            $_SESSION['levelAlert'] = '<div id="alertLevel">Nieporawny login lub hasło</div>';
            header('Location: ./');
        }
    } else {
        header('Location: ./');
    }
?>