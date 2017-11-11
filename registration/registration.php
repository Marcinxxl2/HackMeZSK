<?php
    session_start();
    require '../includes/php/management/dbConn.php';

    $conn = new DatabaseConnection('write');
    echo $conn->currentConnectionType();
    $conn->switchConnectionType('read');
    echo $conn->currentConnectionType();
    echo $conn->whetherUsernameAlreadyExists('test');
?>