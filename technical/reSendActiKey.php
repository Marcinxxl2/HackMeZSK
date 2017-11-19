<?php
    if (!isset($_GET['uid'])) {
        header('Location: ../index.php');
        exit();
    }

    session_start();
    
    require '../includes/php/dbConn.php';

    $conn = new DatabaseConnection;

    $conn->reSendActivationCode($_GET['uid']);
    
    $conn->closeConnection();
?>