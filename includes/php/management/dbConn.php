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

            if (!$this->mysqliConn = new mysqli($this->serverAddress, $this->userName, $this->userPass, $this->dbName)) {
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

        //Funkcja dodaje w bezpieczny sposób użytkownika do bazy
        //Nie zwraca żadnej wartości
        public function addUserToDatabase ($username, $password_hash, $email, $firstname, $lastname) { 

            if ($stmt = $this->mysqliConn->prepare('INSERT INTO users VALUES (default, ?, ?, ?, ?, ?, default)')) {
                $stmt->bind_param('sssss', $username, $password_hash, $email, $firstname, $lastname);
                $stmt->execute();
                $stmt->close();
            } else {
                throw new Exception('Wystąpił błąd przy dodawaniu użytkownika do bazy');
            }
            
        }

        public function areLoginCredentialsValid () {
            //TODO
        }

        public function customQuery () {
            //TODO
        }

        public function closeConnection () {
            $this->mysqliConn->close();
        }

        public function __destruct () {
            $this->mysqliConn->close();
        }
    }

?>