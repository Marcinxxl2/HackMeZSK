<?php

    session_start();
    
    if (isset($_SESSION['userData'])) {
        header('Location: ../');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: index.php');
        exit();
    }

    $login = $_POST['login'];
    $pass = $_POST['pass'];

    if (
        preg_match('/^\w{2,45}$/', $login) &&
        preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,45}$/', $pass)
    ) {
        require_once '../includes/php/dbConn.php';
        try {
            $conn = new DatabaseConnection();

            if ($uid = $conn->areLoginCredentialsValid($login, $pass)) {

                require_once '../includes/php/echoFunctions.php';

                $_SESSION['userData'] = $conn->getUserData($uid);

                if ($_SESSION['userData']['user_status'] == 1) {
                    
                    $_SESSION['userSolutions'] = $conn->getUserSolutions($uid);
                    
                    $_SESSION['mainAlert'] = echoAlertBox('good', 'Zalogowano');
                    header('Location: ../');

                } else {

                    unset($_SESSION['userData']);
                    $_SESSION['mainAlert'] = echoAlertBox('bad', 'Konto nie zostało aktywowane, jeśli nie dostałeś E-maila aktywacyjnego, możesz wysłać go ponownie klikając w ten link:&nbsp;<a href="technical/reSendActiKey.php?uid='.$uid.'" class="textLink">Link</a>');
                    header('Location: ../');

                }

            } else {
                $_SESSION['loginError'] = 'Niepoprawne dane logowania';
                header('Location: /');
            }

            $conn->closeConnection();
        } 
        catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        $_SESSION['loginError'] = 'Niepoprawne dane logowania';
        header('Location: /');
    }

?>