<?php
    if (!isset($_GET['uid'])) {
        header('Location: ../index.php');
        exit();
    }

    session_start();
    
    require '../includes/php/dbConn.php';
    require '../includes/php/echoFunctions.php';

    $conn = new DatabaseConnection;

    $conn->reSendActivationCode($_GET['uid']);
    $conn->closeConnection();

    $_SESSION['mainAlert'] = echoAlertBox('good', 'Link aktywacyjny został wysłany ponownie');
    header('Location: ../');
?>