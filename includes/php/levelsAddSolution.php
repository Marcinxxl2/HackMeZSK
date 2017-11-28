<?php

    //Dodatkowe usprawnienie aby skórcić kod dodawania wyniku do bazy
    function addSolution ($levelName) {

        require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php';

        try {

            if (!in_array($levelName, $_SESSION['userSolutions'], true)) {

                $uid = $_SESSION['userData']['user_id'];

                require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/dbConn.php';
                $conn = new DatabaseConnection();
                $conn->updateUserSolutions($uid, 'basic1');
                $_SESSION['userSolutions'] = $conn->getUserSolutions($uid);
                $conn->closeConnection();

            }

            $_SESSION['levelsAlert'] = echoAlertBox('good', 'Wykonano zadanie: '.$levelName);
            header('Location: ../');
            
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
?>