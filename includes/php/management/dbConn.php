<?php
    require $_SERVER['DOCUMENT_ROOT'].'/HackMeZSK/config/dbConfig.php';

    class DatabaseConnection {

        protected $connType;
        protected $serverAddress;
        protected $dbName;
        protected $userName;
        protected $userPass;
        protected $mysqliConn;

        //******************************************POŁĄCZENIA******************************************

        //Konstruktor, przypisuje odpowienie wartości do zmiennych i tworzy połączenie z bazą danych przy pomocy użytkownika który ma uprawnienia WRITE (INSERT, UPDATE, DELETE), lub przy pomocy takiego co ma uprawnienia READ (SELECT). Wymyśliłem coś takiego dla większego bezpieczeństwa przed ewentualnymi atakiami SQL Injection
        //Nie zwraca żadnej wartości
        public function __construct ($connType) { 

            $this->serverAddress = $GLOBALS['serverAddress'];
            $this->dbName = $GLOBALS['site_dbName']; 

            if ($connType == 'write') {
                $this->userName = $GLOBALS['site_writeUserName'];
                $this->userPass = $GLOBALS['site_writeUserPassword'];
                $this->connType = 'write';
            } else if ($connType == 'read') {
                $this->userName = $GLOBALS['site_readUserName'];
                $this->userPass = $GLOBALS['site_readUserPassword'];
                $this->connType = 'read';
            } else {
                throw new Exception('Niepoprawny typ połączenia');
            }

            $this->mysqliConn = new mysqli($this->serverAddress, $this->userName, $this->userPass, $this->dbName);
        }

        //Funkcja ta zmienia typ połączenia na inny
        //Nie zwraca żadnej wartości
        public function switchConnectionType ($connType) { 

            $this->mysqliConn->close();

            if ($connType == 'write') {
                $this->userName = $GLOBALS['site_writeUserName'];
                $this->userPass = $GLOBALS['site_writeUserPassword'];
                $this->connType = 'write';
            } else if ($connType == 'read') {
                $this->userName = $GLOBALS['site_readUserName'];
                $this->userPass = $GLOBALS['site_readUserPassword'];
                $this->connType = 'read';
            } else {
                throw new Exception('Niepoprawny typ połączenia');
            }

            $this->mysqliConn = new mysqli($this->serverAddress, $this->userName, $this->userPass, $this->dbName);
        }

        //Funkcja która po prostu zwraca aktualny typ połączenia
        public function currentConnectionType () {
            return $this->connType;
        }
                
        //******************************************ZAPYTANIA******************************************

        //Funkcja sprawdza czy istnieje juz podany login w bazie
        //Zwraca true jeśli istnieje, false jeśli nie istnieje
        //Typ READ
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
        //Typ WRITE
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