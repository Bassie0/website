<?php
require './login_interface.php';
/**
 * Description of database
 *
 * @author Bastiaan
 */
class database {
    private $connection;
    private $error;
    private $socket;
            
    function __construct() {
        $this->connection = new mysqli(
            login_interface::SERVERNAME,
            login_interface::SERVERNAME,
            login_interface::PASSWORD
        );
        $this->error = $this->connection->connect_error;
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

}