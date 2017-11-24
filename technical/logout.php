<?php
    session_start();

    if (isset($_SESSION['userData'])) {
        require '../includes/php/echoFunctions.php';
        session_destroy();
        session_start();
        $_SESSION['mainAlert'] = echoAlertBox('good', 'Wylogowano');
    }

    header('Location: ../');
?>