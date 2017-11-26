<?php
    if (!isset($_GET['uid'])) {
        header('Location: ../index.php');
        exit();
    }

    session_start();
    
    require_once '../includes/php/dbConn.php';
    require_once '../includes/php/echoFunctions.php';
    try {
        $conn = new DatabaseConnection;

        $conn->reSendActivationCode($_GET['uid']);
        $conn->closeConnection();
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }

    $_SESSION['mainAlert'] = echoAlertBox('good', 'Link aktywacyjny został wysłany ponownie');
    header('Location: ../');
?>