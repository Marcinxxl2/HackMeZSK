<?php

    //Wyświetla tekst z sesji i usuwa
    function echoSessionAlert($key) {
        if (isset($_SESSION[$key])) {
            echo $_SESSION[$key];
            unset($_SESSION[$key]);
        }
    }
?>