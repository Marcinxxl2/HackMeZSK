<?php
    if (!isset($_GET['a'])) {
        header('Location: ../index.php');
        exit();
    }

    session_start();
    
    require_once '../includes/php/dbConn.php'; //Tutaj zanjduje się moja klasa do połączeń z bazą danych, aby kod był bardziej czytelny
    require_once '../includes/php/echoFunctions.php'; //Tutaj znajduje się funkcja wyświetlająca okienko z informacją

    try {
        $conn = new DatabaseConnection;

        if ($conn->activateAccount($_GET['a'])) {

            $_SESSION['mainAlert'] = echoAlertBox('good', 'Konto zostało aktywowane, możesz się teraz zalogować');

        } else {

            $_SESSION['mainAlert'] = echoAlertBox('bad', '
                Konto nie zostało aktywowane, możliwe przyczyny:
                <ul>
                    <li>Konto zostało już aktywowane</li>
                    <li>Konto zostało usunięte</li>
                    <li>Klucz aktywacyjny jest błędny</li>
                </ul>
            ');

        }
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }

    $conn->closeConnection();
    header('Location: ../index.php');
?>