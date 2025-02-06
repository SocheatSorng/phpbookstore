<?php
class Database {
    private $conn;
    
    public function __construct() {
        try {
            $string = "mysql:host=localhost;dbname=bookstore_db";
            $this->conn = new PDO($string, "user", "User@123");
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    
    public function read($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function write($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($params);
        } catch(PDOException $e) {
            return false;
        }
    }
}