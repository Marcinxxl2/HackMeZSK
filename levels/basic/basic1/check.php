<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsNotLoggedA.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsAddSolution.php'; 

    if (isset($_POST['pass']) && $_POST['pass'] === '81jads9d') {
        addSolution(basename(__DIR__));
    } else {
        $_SESSION['levelAlert'] = '<div id="alertLevel">Niepoprawne hasło</div>';
        header('Location: ./');
    }

?>