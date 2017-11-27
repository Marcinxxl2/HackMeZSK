<?php
    session_start();
    if (!isset($_SESSION['userData'])) {
        header('Location: /HackMeZSK/');
        exit();
    }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; ?>

<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/beforeHeadA.php'; ?>

    <title>HackMeZSK</title>
    <link rel="stylesheet" href="../includes/css/account.css">
    <link rel="stylesheet" href=../includes/css/levelsDoneTable.css>
    <style>
        #rz {
            background-color: #66fcf1;
            color: #0b0c10;
        }
    </style>
    <script src="/HackMeZSK/includes/js/hideAlertBox.js"></script>

<?php /* </HEAD> */ require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterHeadA.php'; ?>

<div id="content">
    <div id="accountMenu">
        <div class="niceButton" id="rz">Rozwiązane zadania</div>
        <div class="niceButton" id="do">Dane osobowe</div>
        <div class="niceButton" id="zh">Zmień hasło</div>
        <div class="niceButton" id="ze">Zmień E-mail</div>
    </div>
    <div id="accountContent">
        <?php

            try {
                require_once '../includes/php/dbConn.php';
                $conn = new DatabaseConnection();

                if ($result = $conn->customQuery('SELECT category_name, level_name, solution_date, points FROM users_solutions_full WHERE user_id = '.$_SESSION['userData']['user_id'])) {

                    if ($result->num_rows > 0) {
                        
                        echo '<table id="levelsDoneTable">';
                        echo '<tr><th>Kategoria</th><th>Nazwa</th><th>Data wykonania</th><th>Punkty</th></tr>';

                        while ($row = $result->fetch_assoc()) {
                            echo '
                                <tr>
                                    <td>'.$row['category_name'].'</td>
                                    <td>'.$row['level_name'].'</td>
                                    <td>'.$row['solution_date'].'</td>
                                    <td>'.$row['points'].'</td>
                                </tr>
                            ';
                        }
                        echo '<tr><td colspan="3">Łącznie punktów: </td><td>'.$_SESSION['userSolutions']['numOfPoints'].'</td></tr>';

                        echo '</table>';

                    } else {
                        echo '<p>Nie rozwiązałeś jeszcze żadnego zadania</p>';
                    }
                    
                } else {
                    throw new Exception('Błąd zapytania do bazy danych');
                }
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }

        ?>
    </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterContent.php'; ?>