<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpbookstore/admin/database.php';

class BookModel 
{
    private $db;
    private $conn;

    function __construct()
    {
        try {
            $this->db = new Database();
            $this->conn = $this->db->getConnection();
        } catch(Exception $e) {
            error_log("BookModel constructor error: " . $e->getMessage());
            throw $e;
        }
    }

    public function getBestSellingBooks($limit = 6)
    {
        try {
            if (!$this->conn) {
                error_log("No database connection available");
                return [];
            }

            $stmt = $this->conn->prepare("CALL sp_GetAllProducts()");
            if (!$stmt->execute()) {
                error_log("Execute failed: " . implode(", ", $stmt->errorInfo()));
                return [];
            }

            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            error_log("Retrieved " . count($result) . " books from database");
            return $result;

        } catch(PDOException $e) {
            error_log("Error in getBestSellingBooks: " . $e->getMessage());
            return [];
        }
    }

    public function getFeaturedBooks($limit = 8)
    {
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("CALL sp_GetAllProducts()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Error in getFeaturedBooks: " . $e->getMessage());
            return [];
        }
    }

    public function getAllBooks()
{
    try {
        if (!$this->conn) {
            error_log("No database connection available in getAllBooks");
            return [];
        }

        $stmt = $this->conn->prepare("CALL sp_GetAllProducts()");
        if (!$stmt->execute()) {
            error_log("Execute failed in getAllBooks: " . implode(", ", $stmt->errorInfo()));
            return [];
        }

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        error_log("getAllBooks retrieved " . count($result) . " books");
        return $result;

    } catch(PDOException $e) {
        error_log("Error in getAllBooks: " . $e->getMessage());
        return [];
    }
}
}