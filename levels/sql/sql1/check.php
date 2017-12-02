<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsNotLoggedA.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsAddSolution.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/config/levelsConfig/level1-4_dbConfig.php'; 

    if (isset($_POST['login']) && isset($_POST['pass'])) {


        $login = $_POST['login'];
        $pass = $_POST['pass'];

        $levelConn = new mysqli($dbAddr, $dbUser, $dbUserPass, $dbName);

        $result = $levelConn->query("SELECT user_id FROM users WHERE login = '$login' AND pass = '$pass'");
        $levelConn->close();

        if ($result->num_rows > 0) {
            addSolution(basename(__DIR__));
        } else {
            $_SESSION['levelAlert'] = '<div id="alertLevel">Nieporawny login lub hasło</div>';
            header('Location: ./');
        }
    } else {
        header('Location: ./');
    }

?>
