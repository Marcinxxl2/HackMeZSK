<?php
    session_start();

    if (!isset($_SESSION['passwordChangeCode'])) {
        header('Location: ../../index.php');
    }

    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if (
        preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,45}$/', $password1) &&
        preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,45}$/', $password2) && 
        $password1 === $password2
    ) {
        require_once '../../includes/php/dbConn.php';
        require_once '../../includes/php/echoFunctions.php';
        try {
            
            $conn = new DatabaseConnection();
            
            if ($conn->remindPasswordChange($_SESSION['passwordChangeCode'], $password1)) {
                $_SESSION['mainAlert'] = echoAlertBox('good', 'Hasło zostało zmienione, możesz się teraz zalogować');
                header('Location: ../../index.php');
            } else {
                $_SESSION['mainAlert'] = echoAlertBox('bad', 'Kod do zmiany hasła jest nieprawidłowy');
                header('Location: ../../index.php');
            }
        
            $conn->closeConnection();
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        
    } else {
        $_SESSION['regAlert'] = echoAlertBox('bad', 'Dane wysłane na serwer nie przeszły weryfikacji');
        header('Location: index.php');
    }

?>