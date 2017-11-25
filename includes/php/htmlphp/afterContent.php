        <div id="rightSide">
            <?php
                require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/includes/php/dbConn.php';
                try {
                    $conn = new DatabaseConnection();

                    if ($result = $conn->customQuery('SELECT * FROM ranking')) {
                        $i = 1;
                        echo '<table>';
                        echo '<tr><th>#</th><th>Nazwa użytkownika</th><th>Punkty</th></tr>';
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr><td>'.$i.'</td><td>'.$row['user'].'</td><td>'.$row['num_of_points'].'</td></tr>';
                            $i++;
                        }
                        echo '</table>';
                    } else {
                        echo "Błąd połączenia z bazą";
                    }
                } 
                catch (Exception $e) {
                    echo $e->getMessage();
                }
            ?>
        </div>
        <div id="footer">
                Marcin Tajser &copy; <?php echo date('Y') ?>
        </div>
    </div>
</body>
</html>












