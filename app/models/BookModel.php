<?php
require_once __DIR__ . '/../../admin/database.php';

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

    public function getBannerBooks($limit = 3)
    {
        try {
            $stmt = $this->conn->prepare("SELECT BookID, Title, Price, Image, Description FROM tbBook ORDER BY RAND() LIMIT ?");
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Error in getBannerBooks: " . $e->getMessage());
            return [];
        }
    }

    public function getCategories()
    {
        try {
            $stmt = $this->conn->prepare("SELECT CategoryID, Name, Description, Image FROM tbCategory ORDER BY Name");
            if (!$stmt->execute()) {
                error_log("Execute failed in getCategories: " . implode(", ", $stmt->errorInfo()));
                return [];
            }

            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            error_log("getCategories retrieved " . count($result) . " categories");
            return $result;

        } catch(PDOException $e) {
            error_log("Error in getCategories: " . $e->getMessage());
            return [];
        }
    }

    public function getBooksByCategory($categoryId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT b.* 
                FROM tbBook b 
                JOIN tbBookCategory bc ON b.BookID = bc.BookID 
                WHERE bc.CategoryID = ?");
            $stmt->execute([$categoryId]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Error in getBooksByCategory: " . $e->getMessage());
            return [];
        }
    }

    public function getBookDetails($bookId) 
    {
        try {
            if (!$this->conn) {
                error_log("No database connection available in getBookDetails");
                return null;
            }
    
            $stmt = $this->conn->prepare("CALL sp_GetBookDetail(?)");
            if (!$stmt->execute([$bookId])) {
                error_log("Execute failed in getBookDetails: " . implode(", ", $stmt->errorInfo()));
                return null;
            }
    
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if (!$result) {
                error_log("No book found with ID: " . $bookId);
                return null;
            }
    
            // Close the current cursor to avoid "Command out of sync" errors
            $stmt->closeCursor();
            
            return $result;
    
        } catch(PDOException $e) {
            error_log("Error in getBookDetails: " . $e->getMessage());
            throw $e;
        }
    }

    public function getBookReviews($bookId) 
    {
        try {
            $stmt = $this->conn->prepare("CALL sp_GetBookReviews(?)");
            $stmt->execute([$bookId]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Error getting book reviews: " . $e->getMessage());
            return [];
        }
    }

    public function getRelatedBooks($categoryId, $currentBookId, $limit = 6) 
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT * FROM tbBook 
                WHERE CategoryID = ? 
                AND BookID != ?
                LIMIT ?
            ");
            $stmt->execute([$categoryId, $currentBookId, $limit]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Error getting related books: " . $e->getMessage());
            return [];
        }
    }
}