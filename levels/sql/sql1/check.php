<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsNotLoggedA.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsAddSolution.php'; 

    if (isset($_POST['login']) && isset($_POST['pass'])) {

        $levelConn = new mysqli('localhost', 'hackmezsk_levels_sql1_user', '4ibSZbiMOLH8tH6M', 'hackmezsk_levels_sql1');

        $login = $_POST['login'];
        $pass = $_POST['pass'];

        $result = $levelConn->query("SELECT user_id FROM users WHERE login = '$login' AND pass = '$pass'");

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
