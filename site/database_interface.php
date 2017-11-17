<?php

/**
 *
 * @author Bastiaan
 */
interface database_interface {
    const SERVERNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "gamblesitedata";
    const TABLE = "users";
    const PORT = "3306";
    const USERNAME_ERROR = 1;
    const EMAIL_ERROR = 2;
    const INSERT_ERROR = 3;
}
