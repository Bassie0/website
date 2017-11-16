<?php

require './database.php';

class login {
    
    private $connection;
    private $username;
    private $password;
    private $table;
                function __construct($username, $password) {
        $this->connection = new database();
        $this->username = $username;
        $this->password = $password;
        $this->printError();
        $this->table = login_interface::TABLE;
    }
    
    function login() {
        $select_user = "SELECT username, password FROM "
                .$this->table.
                "WHERE username=".$this->username.
                "AND password=".$this->password;
        $result = $this->connection->getConnection()->query($select_user);
        if ($result->num_rows == 0) {
            
        }
    }
    
    function check_username() {
        
    }
    
    function check_password() {
        
    }
    
    function printError() {
        echo $this->connection->getError();
    }
}