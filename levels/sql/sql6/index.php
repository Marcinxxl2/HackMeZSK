<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsNotLoggedA.php'; 
    require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HackMeZSK - zadanie <?php echo basename(__DIR__); ?></title>
    <link rel="stylesheet" href="../../../includes/css/levels.css">
    <style>
        #formDiv input[type=number] {
            width: 70px;
        }
    </style>
</head>
<body>
    <div id="formDiv">
        <form action="check.php" method="POST">
            Podaj login: <input type="text" name="login"><br><br>
            Podaj hasło: <input type="password" name="pass"><br><br>
            Podaj kod dostępu: <input type="number" name="accessCode" min="0000" max="9999"><br><br>
            <input type="submit" value="Zaloguj">
        </form>
        <?php echoSessionAlert('levelAlert'); ?>
    </div>
<!--

$login = $levelConn->real_escape_string(htmlentities($_POST['login']));
$pass = $levelConn->real_escape_string(htmlentities($_POST['pass']));
$accessCode = $levelConn->real_escape_string(htmlentities($_POST['accessCode']));

$result = $levelConn->query("SELECT hash FROM users WHERE login = '$login' AND access_code = $accessCode");

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($pass, $row['hash'])) {
        addSolution('sql6');
    }
}

-->
</body>
</html>