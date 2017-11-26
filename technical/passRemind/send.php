<?php

    session_start();

    if (!isset($_POST['email'])) {
        header('Location: ../../');
        exit();
    }

    require_once '../../includes/php/captchaVerify.php';
    $email = $_POST['email'];


    if (preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email) && captchaVerify()) {

        require_once '../../includes/php/dbConn.php';
        require_once '../../includes/php/echoFunctions.php';

        try {

            $conn = new DatabaseConnection();
            if ($conn->sendPasswordResetCode($email)) {

                $_SESSION['mainAlert'] = echoAlertBox('good', 'Wysłano link do zmiany hasła na podany E-mail');
                header('Location: ../../index.php');

            } else {

                $_SESSION['emailError'] = 'Nie znaleziono takiego E-maila';
                header('Location: index.php');
                
            }
            $conn->closeConnection();
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }

    } else {
        $_SESSION['passRemindAlert'] = echoAlertBox('bad', 'Dane wysłane na serwer nie przeszły weryfikacji');
        header('Location: index.php');
    }

?>