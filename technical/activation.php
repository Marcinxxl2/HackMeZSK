<?php
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        header('Location: ../index.php');
        exit();
    }

    session_start();
    
    require '../includes/php/dbConn.php';

    $conn = new DatabaseConnection;

    if ($conn->activateAccount($_GET['a'])) {
        $_SESSION['activationAlert'] = '<div class="alertBox"><div class="alertBoxText"><span style="color: #5cb85c">Konto zostało aktywowane, możesz się teraz zalogować</span></div><div class="closeSymbol">&#10006;</div></div>';
    } else {

        $_SESSION['activationAlert'] = <<<'TEXT'
        <div class="alertBox">
            <div class="alertBoxText">
                <span style="color: #dc3545">
                    Konto nie zostało aktywowane, możliwe przyczyny:
                    <ul>
                        <li>Konto zostało już aktywowane</li>
                        <li>Konto zostało usunięte</li>
                        <li>Klucz aktywacyjny jest błędny</li>
                    </ul>
                </span>
            </div>
            <div class="closeSymbol">
                &#10006;
            </div>
        </div>
TEXT;

    }

    $conn->closeConnection();
    header('Location: ../index.php');
?>