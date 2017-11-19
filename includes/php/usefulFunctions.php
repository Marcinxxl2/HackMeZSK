<?php

    //Wyświetla tekst z sesji i usuwa
    function echoSessionAlert($key) {
        if (isset($_SESSION[$key])) {
            echo $_SESSION[$key];
            unset($_SESSION[$key]);
        }
    }

    //Wyświetla okienko z komunikatem, które da się ukryć
    function echoAlertBox($type, $text) {
        if ($type == 'good') {
            $color = '#5cb85c';
        } else if ($type == 'bad') {
            $color = '#dc3545';
        }
        return '
            <div class="alertBox">
                <div class="alertBoxText">
                    <span style="color: '.$color.'">'.$text.'
                    </span>
                </div>
                <div class="closeSymbol">
                        &#10006;
                </div>
            </div>
        ';
    }
?>