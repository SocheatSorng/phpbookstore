<?php

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        try {
            $string = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
            $this->conn = new PDO($string, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if(self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function read($query)
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            return false;
        }
    }

    public function write($query)
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }
}