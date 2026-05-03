<?php
// app/core/Database.php

class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = ""; // Your XAMPP password, usually empty
    private $dbname = "book_review_db"; // The database we created
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // This method allows other parts of our code to get the connection
    public function getConnection() {
        return $this->conn;
    }
}