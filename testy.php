<?php
    session_start();
    require 'includes/php/dbConn.php';
    echo '<pre>';
    echo print_r($_SESSION['userSolutions']);
    echo '</pre>';
?>