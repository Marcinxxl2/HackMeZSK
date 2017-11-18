<?php
    require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/config/dbConfig.php';

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

            $this->serverAddress = $GLOBALS['serverAddress'];
            $this->dbName = $GLOBALS['site_dbName']; 
            $this->userName = $GLOBALS['site_operationsUserName']; 
            $this->userPass = $GLOBALS['site_operationsUserPass']; 

            if ($this->mysqliConn = new mysqli($this->serverAddress, $this->userName, $this->userPass, $this->dbName)) {
                $this->mysqliConn->set_charset('utf8');
            } else {
                throw new Exception('Błąd połączenia z bazą danych');
            }
        }
                
        //******************************************ZAPYTANIA******************************************

        //Funkcja sprawdza czy istnieje juz podany login w bazie
        //Zwraca true jeśli istnieje, false jeśli nie istnieje
        public function whetherUsernameAlreadyExists ($username) {
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
        public function whetherEmailAlreadyExists ($email) {
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
        //Nic nie zwraca
        public function addUserToDatabase ($username, $password, $email, $firstname, $lastname) { 

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt = $this->mysqliConn->prepare('INSERT INTO users VALUES (default, ?, ?, ?, ?, ?, CURRENT_DATE(), default)')) {
                $stmt->bind_param('sssss', $username, $passwordHash, $email, $firstname, $lastname);
                $stmt->execute();
                $stmt->close();

                $userId = $this->mysqliConn->insert_id; //mysqliConn->insert_id zwraca id ostatnio dodanego wiersza
                $activationCode = md5($username.$email.time());

                if ($stmt = $this->mysqliConn->prepare('INSERT INTO confirmations VALUES (default, ?, ?, CURRENT_DATE(), 0)')) {
                    $stmt->bind_param('ss', $userId, $activationCode);
                    $stmt->execute();
                    $stmt->close();

                    $activationLink = '127.0.0.1/HackMeZSK/activation/activation.php?uid='.$userId.'&a='.$activationCode; //W wersji produkcyjnej trzeba zmienić ten link

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

                    mail($email, 'Aktywacja konta', 'Link aktywacyjny: '.$activationLink.' <br> Jeśli nie aktywujesz swojego konta w przeciągu 30 dni, zostanie one usunięte i będziesz musiał zarejstrować je na nowo.', 'Content-Type: text/html; charset=UTF-8');

                } else {
                    throw new Exception('Wystąpił błąd przy dodawaniu wpisu do aktywacji konta');
                }

            } else {
                throw new Exception('Wystąpił błąd przy dodawaniu użytkownika do bazy');
            }
        }

        //Funkcja sprawdza czy login i hasło się zgadzają
        //Zwraca user_id jeśli się zgadzają, false jeśli się nie zgadzają
        public function areLoginCredentialsValid ($username, $password) {
            
            if ( $stmt = $this->mysqliConn->prepare('SELECT user_id, password_hash FROM users WHERE username = ?')) {
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows > 0) {

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
        //Zwraca tablice z jeśli znaleziono rozwiązania, false jeśli nie znaleziono
        //users_solutions jest widokiem
        public function getUserSolutions ($userId) {
            if ($stmt = $this->mysqliConn->prepare('SELECT level_name FROM users_solutions WHERE user_id = ?')) {
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows > 0) { 
                    $varForReturn = array();
                    while ($row = $result->fetch_array(MYSQLI_NUM)) {
                        array_push($varForReturn, $row[0]);
                    }
                    return $varForReturn;
                } else {
                    return false;
                }

            } else {
                throw new Exception('Błąd zapytania do bazy');
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

        public function __destruct () {
            $this->mysqliConn->close();
        }
    }

?>