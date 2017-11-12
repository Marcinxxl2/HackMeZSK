<?php
    require 'includes/php/management/dbConn.php';

    try {

        $conn = new DatabaseConnection();

        echo '<pre>';
        print_r($conn->getUserData($conn->areLoginCredentialsValid('test1', 'pyssa123')));
        echo '</pre>';

        $result = $conn->customQuery('SELECT username FROM users');
        $row1 = $result->fetch_assoc();
        echo $row1['username'], '<br>';
        $row2 = $result->fetch_assoc();
        echo $row2['username'], '<br>';

    }
    catch (Exception $e) {
        echo $e->getMessage();
    }
?>