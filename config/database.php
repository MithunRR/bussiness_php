<?php

class Database {
    private $host = '127.0.0.1';
    private $user = 'root';
    private $password = 'mithuN';
    private $database = 'admin';
    private $port = 3306;
    private $conn;

    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
