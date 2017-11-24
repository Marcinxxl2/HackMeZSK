</head>
<body>
    <div id="container">
        <div id="head">
            <div id="logoDiv"><a href="/HackMeZSK"><img src="/HackMeZSK/includes/img/logo.png" alt="logo"></a></div>
            <?php
                if (isset($_SESSION['userData'])) {
                    echo '<a href="/HackMeZSK/technical/logout.php"><div class="headButton niceButton">Wyloguj</div></a>';
                    echo '<a href="/HackMeZSK/account"><div class="headButton niceButton">Twoje konto</div></a>';
                } else {
                    echo '<a href="/HackMeZSK/registration"><div class="headButton niceButton">Zarejestruj się</div></a>';
                    echo '<a href="/HackMeZSK/login"><div class="headButton niceButton">Zaloguj się</div></a>';
                }
            ?>
        </div>
        <div id="leftSide">
            <p>Kategorie</p>
            <div class="niceButton">HTML</div>
            <div class="niceButton">JavaScript</div>
            <div class="niceButton">PHP</div>
            <div class="niceButton">SQL</div>
        </div>