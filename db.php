<?php
include_once('config.php');

class DB {
    private $conn;

    function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function executeQuery($query) {
        return $this->conn->query($query);
    }
}
?>
