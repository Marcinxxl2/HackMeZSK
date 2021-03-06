<?php

    class DatabaseConnection {

        private $serverAddress;
        private $dbName;
        private $userName;
        private $userPass;
        protected $mysqliConn;

        //******************************************POŁĄCZENIE******************************************

        //Konstruktor, przypisuje odpowienie wartości do zmiennych i tworzy połączenie z bazą danych
        //Nie zwraca żadnej wartości
        public function __construct () { 

            require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/config/dbConfig.php';

            $this->serverAddress = $serverAddress;
            $this->dbName = $site_dbName;
            $this->userName = $site_operationsUserName;
            $this->userPass = $site_operationsUserPass; 

            if ($this->mysqliConn = new mysqli($this->serverAddress, $this->userName, $this->userPass, $this->dbName)) {
                $this->mysqliConn->set_charset('utf8');
            } else {
                throw new Exception('Błąd połączenia z bazą danych');
            }
        }
                
        //******************************************ZAPYTANIA******************************************

        //Funkcja sprawdza czy istnieje juz podany login w bazie
        //Zwraca true jeśli istnieje, false jeśli nie istnieje
        public function whetherUsernameExists ($username) {

            if ($stmt = $this->mysqliConn->prepare('SELECT username FROM users WHERE username = ?')) {

                $stmt->bind_param('s', $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
    
                if ($result->num_rows == 0) {
                    return false;
                } else {
                    return true;
                }

            } else {
                throw new Exception('Błąd zapytania do bazy');
            }

        }

        //Funkcja sprawdza czy istnieje juz podany Email w bazie
        //Zwraca true jeśli istnieje, false jeśli nie istnieje
        public function whetherEmailExists ($email) {

            if ($stmt = $this->mysqliConn->prepare('SELECT email FROM users WHERE email = ?')) {

                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
    
                if ($result->num_rows == 0) {
                    return false;
                } else {
                    return true;
                }

            } else {
                throw new Exception('Błąd zapytania do bazy');
            }

        }

        //Funkcja dodaje w bezpieczny sposób użytkownika do bazy
        //Zostaje dodany wiersz do tabeli users i do tabeli confirmations w celu późniejszej aktywacji konta
        //Link aktywacyjny jest tworzony z połączonego stringa aktalnego czasu, podanego emailu i nazwy uzytkownika i jest zamieniany na hash md5
        //Link aktywacyjny zostaje wysłany na podany email 
        //Zwraca user_id jeśli dodanie się udało
        public function addUserToDatabase ($username, $password, $email, $firstname, $lastname) { 

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt = $this->mysqliConn->prepare('INSERT INTO users VALUES (default, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP(), default)')) {
                $stmt->bind_param('sssss', $username, $passwordHash, $email, $firstname, $lastname);
                $stmt->execute();
                $stmt->close();

                $userId = $this->mysqliConn->insert_id; //mysqliConn->insert_id zwraca id ostatnio dodanego wiersza
                $activationCode = md5($username.$email.time());

                if ($stmt = $this->mysqliConn->prepare('INSERT INTO confirmations VALUES (default, ?, ?, CURRENT_TIMESTAMP(), 0)')) {
                    $stmt->bind_param('ss', $userId, $activationCode);
                    $stmt->execute();
                    $stmt->close();

                    $activationLink = '127.0.0.1/HackMeZSK/technical/activation.php?&a='.$activationCode; //W wersji produkcyjnej trzeba zmienić ten link
                    $headerFields = array(
                        "From: hackmezsk@gmail.com",
                        "MIME-Version: 1.0",
                        "Content-type: text/html; charset=utf-8",
                        "Content-Transfer-Encoding: 8bit"
                    );
                    /* 
                    Aby wysyłanie maili zadziałało trzeba ustawić:
                    W php.ini:
                        SMTP=smtp.gmail.com
                        smtp_port=587
                        sendmail_from = hackmezsk@gmail.com
                        sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
                    W sendmail.ini:
                        smtp_server=smtp.gmail.com
                        smtp_port=587
                        auth_username=hackmezsk@gmail.com
                        auth_password=j"$a%^E5Db8R6L\D
                        force_sender=hackmezsk@gmail.com
                    */

                    mail($email, 'Aktywacja konta', 'Link aktywacyjny: '.$activationLink.' <br> Jeśli nie aktywujesz swojego konta w przeciągu 30 dni, zostanie one usunięte i będziesz musiał zarejstrować je na nowo.', implode("\r\n", $headerFields));
                    
                    return $userId;

                } else {
                    throw new Exception('Wystąpił błąd przy dodawaniu wpisu do aktywacji konta');
                }

            } else {
                throw new Exception('Wystąpił błąd przy dodawaniu użytkownika do bazy');
            }

        }

        //Funkcja wysyła ponownie kod aktywacyjny
        //Zwraca true jeśli się udało, false jeśli się nie udało
        public function reSendActivationCode ($uid) {

            if ($stmt = $this->mysqliConn->prepare('SELECT users.email, confirmations.con_key FROM users INNER JOIN confirmations on users.user_id = confirmations.user_id WHERE users.user_id = ? AND confirmations.con_type = 0')) {
                $stmt->bind_param('i', $uid);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();

                    $activationLink = '127.0.0.1/HackMeZSK/technical/activation.php?&a='.$row['con_key'];
                    $headerFields = array(
                        "From: hackmezsk@gmail.com",
                        "MIME-Version: 1.0",
                        "Content-type: text/html; charset=utf-8",
                        "Content-Transfer-Encoding: 8bit"
                    );
                    mail($row['email'], 'Ponownie wysłany link aktywacyjny', 'Link aktywacyjny: '.$activationLink, implode("\r\n", $headerFields));
                    
                    return true;
                } else {
                    return false;
                }
            } else {
                throw new Exception('Wystąpił błąd przy ponownym wysyłaniu kodu aktywacyjnego');
            }

        }

        //Funkcja wysyła link do zmiany hasła
        //Zwraca true jeśli znaleziono użytkownika o podanym E-mailu, false jeśli nie znaleziono
        public function sendPasswordResetCode ($email) {
            if ($stmt = $this->mysqliConn->prepare('SELECT user_id, username FROM users WHERE email = ?')) {
                
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows == 1) {
                    
                    $row = $result->fetch_assoc();
                    $userId = $row['user_id'];
                    $username = $row['username'];
                    
                    //Jeśli kod już istnieje, zostanie on zastępiony nowym, więc trzeba najpierw usunąć stary
                    //Mogę użyć mniej bezpiecznej formy, bo user_id jest pobierany z bazy
                    if (!$this->mysqliConn->query("DELETE FROM confirmations WHERE user_id = $userId AND con_type = 1")) {
                        throw new Exception('Błąd przy generowaniu kodu do zmiany hasła');
                    }

                    $passwordChangeCode = md5($username.$email.time());

                    if ($stmt = $this->mysqliConn->prepare('INSERT INTO confirmations VALUES (default, ?, ?, CURRENT_TIMESTAMP(), 1)')) {
                        $stmt->bind_param('ss', $userId, $passwordChangeCode);
                        $stmt->execute();
                        $stmt->close();

                        $passwordChangeLink = '127.0.0.1/HackMeZSK/technical/passRemindChange/index.php?&c='.$passwordChangeCode;
                        $headerFields = array(
                            "From: hackmezsk@gmail.com",
                            "MIME-Version: 1.0",
                            "Content-type: text/html; charset=utf-8",
                            "Content-Transfer-Encoding: 8bit"
                        );

                        mail($email, 'Reset hasła', 'Link do zmiany hasła: '.$passwordChangeLink, implode("\r\n", $headerFields));
                        return true;

                    } else {
                        throw new Exception('Błąd przy generowaniu kodu do zmiany hasła');
                    }
                }
                return false;

            } else {
                throw new Exception('Błąd zapytania do bazy');
            }
        }

        //Fukcja aktywuje konto
        //Zwraca true jeśli aktywacja się powiodła, false jeśli się nie powiodła
        public function activateAccount ($a) {

            if ($stmt = $this->mysqliConn->prepare('SELECT confirmation_id, user_id FROM confirmations WHERE con_key = ? AND con_type = 0')) {
                $stmt->bind_param('s', $a);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    
                    $cid = $row['confirmation_id'];
                    $uid = $row['user_id'];

                    if (
                        $this->mysqliConn->query("DELETE FROM confirmations WHERE confirmation_id = $cid") &&
                        $this->mysqliConn->query("UPDATE users SET user_status = 1 WHERE user_id = $uid")
                    ) {
                        return true;
                    } else {
                        throw new Exception('Wystąpił błąd w czasie aktywacji konta');
                    }
                } else {
                    return false;
                }
            } else {
                throw new Exception('Wystąpił błąd w czasie aktywacji konta');
            }

        }

        //Fukcja zmienia hasło poprzez opcje przypomnienia hasła
        //Zwraca true jeśli zmiana się powiodła, false jeśli się nie powiodła
        public function remindPasswordChange ($c, $newPassword) {
            
            if ($stmt = $this->mysqliConn->prepare('SELECT confirmation_id, user_id FROM confirmations WHERE con_key = ? AND con_type = 1')) {
                $stmt->bind_param('s', $c);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    
                    $cid = $row['confirmation_id'];
                    $uid = $row['user_id'];
                    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                    if (
                        $this->mysqliConn->query("DELETE FROM confirmations WHERE confirmation_id = $cid") &&
                        $stmt = $this->mysqliConn->prepare('UPDATE users SET password_hash = ? WHERE user_id = ?')
                    ) {
                        $stmt->bind_param('si', $passwordHash, $uid);
                        $stmt->execute();
                        return true;
                        
                    } else {
                        throw new Exception('Wystąpił błąd w czasie aktywacji konta');
                    }
                } else {
                    return false;
                }
            } else {
                throw new Exception('Wystąpił błąd w czasie aktywacji konta');
            }

        }

        //Funkcja sprawdza czy login i hasło się zgadzają
        //Zwraca user_id jeśli się zgadzają, false jeśli się nie zgadzają
        public function areLoginCredentialsValid ($username, $password) {
            
            if ($stmt = $this->mysqliConn->prepare('SELECT user_id, password_hash FROM users WHERE username = ?')) {
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows == 1) {

                    $row = $result->fetch_assoc();
                    $passwordHash = $row['password_hash'];
                    $userId = $row['user_id'];

                    if (password_verify($password, $passwordHash)) {
                        return $userId;
                    } else {
                        return false;
                    }
                }
                       
            } else {
                throw new Exception('Błąd zapytania do bazy');
            } 

        }

        //Funkcja pobiera dane użytkownika
        //Zwraca tablice z danymi jeśli znaleziono użytkownika, false jeśli nie znaleziono 
        public function getUserData ($userId) {
            if ($stmt = $this->mysqliConn->prepare('SELECT user_id, username, email, firstname, lastname, creation_date, user_status FROM users WHERE user_id = ?')) {
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows > 0) { 
                    return $result->fetch_assoc();
                } else {
                    return false;
                }

            } else {
                throw new Exception('Błąd zapytania do bazy');
            }

        }

        //Funkcja pobiera rozwiązania zadań użytkownika
        //Zwraca tablice z rozwiązaniami, tablica jest pusta jeśli użytkownik jeszcze nic nie rozwiązał
        //W tablicy znajduje się także indeks "numOfPoints" z ilością punktów użytkownika
        //users_solutions i ranking_full są widokami
        public function getUserSolutions ($userId) {
            if ($stmt = $this->mysqliConn->prepare('SELECT level_name FROM users_solutions WHERE user_id = ?')) {
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                $arrayForReturn = array();
                if ($result->num_rows > 0) { 
                    while ($row = $result->fetch_array(MYSQLI_NUM)) {
                        array_push($arrayForReturn, $row[0]);
                    }
                    if ($stmt = $this->mysqliConn->prepare('SELECT num_of_points FROM ranking_full WHERE user_id = ?')) {
                        $stmt->bind_param('i', $userId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $stmt->close();

                        $row = $result->fetch_assoc();
                        $arrayForReturn['numOfPoints'] = $row['num_of_points'];

                    } else {
                        throw new Exception('Błąd przy pobieraniu rozwiązań');
                    }
                } else {
                    $arrayForReturn['numOfPoints'] = 0;
                }

                return $arrayForReturn;

            } else {
                throw new Exception('Błąd przy pobieraniu rozwiązań');
            }

        }

        //Fukcja dodaje rozwiązanie użtykownika do tabeli solutions
        //Zwraca true jeśli się udało dodać wiersz
        public function updateUserSolutions ($userId, $levelName) {

            if ($stmt = $this->mysqliConn->prepare('INSERT INTO solutions VALUES (DEFAULT, ?, (SELECT level_id FROM levels WHERE level_name = ?), CURRENT_TIMESTAMP())')) {
                $stmt->bind_param('is', $userId, $levelName);
                $stmt->execute();
                $stmt->close();

                return true;
            } else {
                throw new Exception('Błąd przy dodawaniu wiersza do bazy');
            } 
        }

        //Funkcja wykonuje podane zapytanie SQL
        //Zwraca obiekt wynikowy
        public function customQuery ($sql) {
            return $this->mysqliConn->query($sql);
        }

        public function closeConnection () {
            $this->mysqliConn->close();
        }

        //Destruktor, zakmnię połączenie z bazą danych, jeśli nie zostało ono zamknięte wcześniej
        public function __destruct () {
            if (is_resource($this->mysqliConn)) {
                $this->mysqliConn->close();
            }
        }
    }

?>