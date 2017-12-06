        <div id="rightSide">
            <?php
                if (isset($_SESSION['userData'])) {
                    echo '<div id="userPoints">Twoja liczba punktów: <span>'.$_SESSION['userSolutions']['numOfPoints'].'</span></div>';
                }
                require_once $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/dbConn.php';
                try {
                    $conn = new DatabaseConnection();

                    if ($result = $conn->customQuery('SELECT * FROM ranking')) {
                        $i = 1;
                        echo '<table>';
                        echo '<caption>Ranking TOP 10</caption>';
                        echo '<tr><th>#</th><th>Nazwa użytkownika</th><th>Punkty</th></tr>';
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr><td>'.$i.'.</td><td>'.$row['user'].'</td><td>'.$row['num_of_points'].'</td></tr>';
                            $i++;
                        }
                        echo '</table>';
                    } else {
                        echo "Błąd połączenia z bazą";
                    }
                    
                    $conn->closeConnection();
                } 
                catch (Exception $e) {
                    echo $e->getMessage();
                }
            ?>
        </div>
        <div id="footer">
                Marcin Tajsner &copy; <?php echo date('Y') ?>
        </div>
    </div>
</body>
</html>












