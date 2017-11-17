<?php
require './database_interface.php';
/**
 * Description of database
 *
 * @author Bastiaan
 */
class database implements database_interface {
    private $connection;
    private $error = 0;
    private $check_username;
    private $check_email;
    private $insert_account;
    
    function __construct() {
        $this->connection = new mysqli(
            self::SERVERNAME,
            self::USERNAME,
            self::PASSWORD,
            self::DATABASE
        );
        if ($this->connection->connect_error) {
            die('Connect Error: ' . $this->connection->connect_error);
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function getError() {
        return $this->error;
    }
    
    function __destruct() {
        $this->connection->close();
    }
    
    function login($username, $password) {
        $this->connection = new database();
        $username = $this->connection->real_escape($username);
        $password_hash = $this->connection->real_escape(password_hash($password, PASSWORD_BCRYPT));
        $select_user = "SELECT username, password FROM ".self::TABLE." WHERE username='$username' AND password='$password_hash'";
        $result = $this->connection->query($select_user);

        if ($result == null) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function register($username, $password, $email) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $this->create_register_queries($username, $password_hash, $email);
        $usernames = $this->connection->query($this->check_username);
        $emails = $this->connection->query($this->check_username);
        
        if (mysqli_num_rows($usernames) > 0) {
            $this->error = self::USERNAME_ERROR;
            return;
        }
        if (mysqli_num_rows($emails) > 0) {
            $this->error = self::EMAIL_ERROR;
            return;
        }
        
        $return_value = $this->connection->query($this->insert_account);
        if ($return_value) {
            return;
        } else {
            $this->error = self::INSERT_ERROR;
            return;
        }
    }
    
    function create_register_queries($username, $password_hash, $email) {
        $username = $this->connection->escape_string($username);
        $email = $this->connection->escape_string($email);
        $password_hash = $this->connection->escape_string($password_hash);
        $this->check_username = "SELECT * FROM ".self::TABLE." WHERE username='$username';";
        $this->check_email = "SELECT * FROM ".self::TABLE." WHERE email='$email';";
        $this->insert_account = "INSERT INTO ".self::TABLE." (date, username, password, email) VALUES (CURRENT_TIMESTAMP,'$username', '$password_hash', '$email');";
    }
}