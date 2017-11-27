<?php
    session_start();
    echo '<pre>';
    echo print_r($_SESSION['userSolutions']);
    echo '</pre>';
    echo $_SESSION['userSolutions']['numOfPoints'];
?>