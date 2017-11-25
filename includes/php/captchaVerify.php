<?php
    function captchaVerify () {
        $secretKey = '6LdkzzYUAAAAAKRrwDRi5--ZqAO1RZlir7JMZ4lN';
        $test = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']));
        return $test->success; 
    }
?>