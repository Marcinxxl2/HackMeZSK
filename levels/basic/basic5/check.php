<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsNotLoggedA.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsAddSolution.php'; 

    if (isset($_POST['pass']) && $_POST['pass'] === 'b7ttgh9o') {
        addSolution(basename(__DIR__));
    } else {
        $_SESSION['levelAlert'] = 'Niepoprawne hasło';
        header('Location: ./');
    }

?>