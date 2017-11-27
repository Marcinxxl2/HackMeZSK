</head>
<body>
    <div id="container">
        <div id="head">
            <div id="logoDiv"><a href="/HackMeZSK"><img src="/HackMeZSK/includes/img/logo.png" alt="logo"></a></div>
            <?php
                if (isset($_SESSION['userData'])) {
                    echo '<a href="/HackMeZSK/technical/logout.php"><div class="headButton niceButton" id="logoutButton">Wyloguj</div></a>';
                    echo '<a href="/HackMeZSK/account"><div class="headButton niceButton" id="accountButton">Twoje konto</div></a>';
                } else {
                    echo '<a href="/HackMeZSK/registration"><div class="headButton niceButton" id="regisButton">Zarejestruj się</div></a>';
                    echo '<a href="/HackMeZSK/login"><div class="headButton niceButton" id="loginButton">Zaloguj się</div></a>';
                }
            ?>
        </div>
        <div id="leftSide">
            <p>Kategorie</p>
            <a href="/HackMeZSK/levels/html/"><div class="niceButton" id="HTMLLevelsLink">HTML</div></a>
            <a href="/HackMeZSK/levels/js/"><div class="niceButton" id="JSLevelsLink">JavaScript</div></a>
            <a href="/HackMeZSK/levels/php/"><div class="niceButton" id="PHPLevelsLink">PHP</div></a>
            <a href="/HackMeZSK/levels/sql/"><div class="niceButton" id="SQLLevelsLink">SQL</div></a>
        </div>