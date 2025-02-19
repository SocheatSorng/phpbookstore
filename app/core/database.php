<?php
class Database {
    private $conn;
    
    public function __construct() {
        try {
            $string = "mysql:host=localhost;dbname=bookstore_db";
            $this->conn = new PDO($string, "user", "User@1234");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    
    public function query($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            error_log("Database query error: " . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
    
    public function read($query, $params = []) {
        $stmt = $this->query($query, $params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function write($query, $params = []) {
        $stmt = $this->query($query, $params);
        return $stmt->rowCount();
    }
}