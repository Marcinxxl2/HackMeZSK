<?php require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/echoFunctions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/levelsNotLoggedA.php'; ?>
<?php /* PODAJ DODATKI DO HEAD PO TEJ LINI */ require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/beforeHeadA.php'; ?>

    <title>HackMeZSK</title>
    <link rel="stylesheet" href="../../includes/css/levelsTable.css">
    <script src="/HackMeZSK/includes/js/hideAlertBox.js"></script>
    <style>
        #PHPLevelsLink {
            background-color: #66fcf1;
            color: #0b0c10;
        }
    </style>
<?php /* </HEAD> */ require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterHeadA.php'; ?>

<div id="content">
    <?php
        require_once '../../includes/php/dbConn.php';
        try {

            $conn = new DatabaseConnection();
            if ($result = $conn->customQuery('SELECT levels.level_id, levels.level_name, levels.description, levels.points, levels.link FROM levels INNER JOIN categories on levels.category_id = categories.category_id WHERE categories.name = "PHP"')) {

                $i = 1;
                echo '<table id="levelsTable">';
                echo '<tr><th>#</th><th>Nazwa</th><th>Opis</th><th>Punkty</th><th>Odnośnik</th><th>Wykonane?</th></tr>';
                while ($row = $result->fetch_assoc()) {

                    echo '
                        <tr>
                            <td>'.$i.'.</td>
                            <td>'.$row['level_name'].'</td>
                            <td>'.$row['description'].'</td>
                            <td>'.$row['points'].'</td>
                            <td id="levelsTableLinkToLevel"><a href="'.$row['link'].'" class="niceLink">Link</a></td>';
                            if (in_array($row['level_id'], $_SESSION['userSolutions'])) {
                                echo '<td id="levelsTableDoneSymbol">&#x2714;</td>';
                            } else {
                                echo '<td id="levelsTableNotDoneSymbol">&#x2718;</td>';
                            } echo '
                        </tr>
                    ';    
                    $i++;
                }
                echo '</table>';

            } else {
                throw new Exception("Błąd przy pobieraniu tabeli z zadaniami z bazy danych");
            }
            $conn->closeConnection();

        } 
        catch (Exception $e) {
            echo $e->getMessage();
        }


    ?>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/htmlphp/afterContent.php'; ?>