<?php
    require 'includes/php/management/dbConn.php';

    try {

        $conn = new DatabaseConnection();

        echo '<pre>';
        print_r($conn->getUserSolutions($conn->areLoginCredentialsValid('test1', 'pyssa123')));
        echo '</pre>';


    }
    catch (Exception $e) {
        echo $e->getMessage();
    }
?>