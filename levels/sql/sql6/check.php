<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsNotLoggedA.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsAddSolution.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/config/levelsConfig/level6_dbConfig.php';  

    if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['accessCode'])) {

        $levelConn = new mysqli($dbAddr, $dbUser, $dbUserPass, $dbName);

        $login = $levelConn->real_escape_string(htmlentities($_POST['login']));
        $pass = $levelConn->real_escape_string(htmlentities($_POST['pass']));
        $accessCode = $levelConn->real_escape_string(htmlentities($_POST['accessCode']));

        $result = $levelConn->query("SELECT hash FROM users WHERE login = '$login' AND access_code = $accessCode");
        $levelConn->close();

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            if (password_verify($pass, $row['hash'])) {
                addSolution(basename(__DIR__));
            } else {
                $_SESSION['levelAlert'] = '<div id="alertLevel">Nieporawny login, hasło lub kod dostępu</div>';
                header('Location: ./');
            }
        } else {
            $_SESSION['levelAlert'] = '<div id="alertLevel">Nieporawny login, hasło lub kod dostępu</div>';
            header('Location: ./');
        }

    } else {
        header('Location: ./');
    }

?>
