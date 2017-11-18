<?php

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: index.php');
        exit();
    }
    
    session_start();
    
    $login = $_POST['login'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $regulations = $_POST['regulations'];

    function captchaVerify () {
        $secretKey = '6LdkzzYUAAAAAKRrwDRi5--ZqAO1RZlir7JMZ4lN';
        $test = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']));
        return $test->success; 
    }

    if (
        preg_match('/^\w{2,45}$/', $login) &&
        preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email) &&
        preg_match('/^[\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ]{2,45}$/', $firstname) &&
        preg_match('/^[\wąężćńółĄĆĘŁŃÓŚŹŻ]{2,32}(\-[\wąężćńółĄĆĘŁŃÓŚŹŻ]{2,32}$)?$/', $lastname) &&
        preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,45}$/', $password1) &&
        preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,45}$/', $password2) && 
        ($password1 === $password2) &&
        ($regulations == 'accepted') && 
        (captchaVerify() == true)
    ) {
        require '../includes/php/management/dbConn.php'; //Tutaj zanjduje się moja klasa do połączeń z bazą danych, aby kod był bardziej czytelny
        
        $conn = new DatabaseConnection();

        $somethingTaken = false;

        if ($conn->whetherUsernameAlreadyExists($login)) {
            $_SESSION['usernameAlreadyExists'] = 'Login jest już zajęty';
            $somethingTaken = true;
        }

        if ($conn->whetherEmailAlreadyExists($email)) {
            $_SESSION['emailAlreadyExists'] = 'E-mail jest już zajęty';
            $somethingTaken = true;
        }

        if ($somethingTaken) {
            header('Location: index.php');
            exit();
        }

        $conn->addUserToDatabase($login, $password1, $email, $firstname, $lastname);
            $_SESSION['userAdded'] = 'Zarejestrowano, możesz teraz aktywować swoje konto i się zalogować';
            header('Location: ../index.php');

    } else {
        $_SESSION['regAlert'] = 'Dane wysłane na serwer nie przeszyły weryfikacji';
        header('Location: index.php');
    }
?>