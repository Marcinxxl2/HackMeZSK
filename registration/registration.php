<?php
    session_start();
    require '../includes/php/management/dbConn.php'; //Tutaj zanjduje się moja klasa do połączeń z bazą danych, aby kod był bardziej czytelny

    try {
        $conn = new DatabaseConnection();
        $conn->addUserToDatabase('asda22ssd322d', 'asddas2222233sd', 'afas232d2s2ssda', 'df3d22ss2d2f3sd', 's22d23d2sfsd2f');
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }

    
?>