<?php
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        header('Location: ../index.php');
        exit();
    }

    session_start();
    require '../includes/php/dbConn.php';

    $conn = new DatabaseConnection;
    $alertText = $conn->activateAccount($_GET['uid'], $_GET['a']);
    $conn->closeConnection();

    $_SESSION['activationAlert'] = '<div class="alertBox"><div class="alertBoxText">'.$alertText.'</div><div class="closeSymbol">&#10006;</div></div>';
    header('Location: ../index.php');
?>