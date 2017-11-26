<?php    
    session_start();
    if (!isset($_SESSION['userData'])) {
        $_SESSION['mainAlert'] = echoAlertBox('bad', 'Zaloguj się aby rozwiązywać zadania');
        header('Location: /HackMeZSK/');
        exit();
    }
?>