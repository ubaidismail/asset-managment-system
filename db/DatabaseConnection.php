<?php

class DatabaseConnection {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $db = 'ams_db';
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db);

        if ($this->conn->connect_errno) {
            die("DB connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

// $db = 'ams_db';
// $host = 'localhost';
// $user = 'root';
// $password = '';


// $conn = new mysqli ($host, $user, $password, $db);

// if($conn-> connect_errno){
//     echo "Failed to connect to DB: " . $conn -> connect_error;
//     exit();
// }