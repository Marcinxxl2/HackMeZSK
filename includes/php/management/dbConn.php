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
        //Nie zwraca żadnej wartości
        public function addUserToDatabase ($username, $password_hash, $email, $firstname, $lastname) { 

            if ($stmt = $this->mysqliConn->prepare('INSERT INTO users VALUES (default, ?, ?, ?, ?, ?, default)')) {
                $stmt->bind_param('sssss', $username, $password_hash, $email, $firstname, $lastname);
                $stmt->execute();
                $stmt->close();

                $userId = $this->mysqliConn->insert_id; //mysqliConn->insert_id zwraca id ostatnio dodanego wiersza
                $activationCode = md5($username.$email.time());
                $date = date('Y-m-d');

                if ($stmt = $this->mysqliConn->prepare('INSERT INTO confirmations VALUES (default, ?, ?, ?, 0)')) {
                    $stmt->bind_param('sss', $userId, $activationCode, $date);
                    $stmt->execute();
                    $stmt->close();

                    $activationLink = '127.0.0.1/HackMeZSK/activation/activation.php?uid='.$userId.'&a='.$activationCode;

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

                    mail($email, 'Aktywacja konta', 'Link aktywacyjny: '.$activationLink.' <br> Jeśli nie aktywujesz swojego konta w przeciągu 7 dni, zostanie one usunięte i będziesz musiał zarejstrować je na nowo.', 'Content-Type: text/html; charset=UTF-8');

                } else {
                    throw new Exception('Wystąpił błąd przy dodawaniu wpisu do aktywacji konta');
                }



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