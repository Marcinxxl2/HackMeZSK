<?php
    session_start();
    require '../includes/php/management/dbConn.php'; //Tutaj zanjduje się moja klasa do połączeń z bazą danych, aby kod był bardziej czytelny

    try {
        $conn = new DatabaseConnection();
        $conn->addUserToDatabase('asda22ssd22d', 'asddas222223sd', 'afas22d2s2ssda', 'dfd22ss2d2f3sd', 's22d2d2sfsd2f');
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }

    
?>