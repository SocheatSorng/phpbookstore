<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'bookstore_db';
    private $username = 'user';  // Change to your MySQL username
    private $password = 'User@1234';      // Change to your MySQL password
    private $conn;
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ];

    public function getConnection() {
        try {
            if ($this->conn === null || !$this->isConnectionAlive()) {
                $this->conn = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                    $this->username,
                    $this->password,
                    $this->options
                );
            }
            return $this->conn;
        } catch(PDOException $e) {
            // Log error and redirect to error page
            error_log("Database Connection Error: " . $e->getMessage());
            header("Location: error.php?message=Database connection failed");
            exit;
        }
    }

    private function isConnectionAlive() {
        try {
            if ($this->conn instanceof PDO) {
                $this->conn->query("SELECT 1");
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($email, $password) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbUser WHERE Email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if(password_verify($password, $user['Password'])) {
                    if($user['Role'] == 'admin') {
                        return true;
                    }
                }
            }
            return false;
        } catch(PDOException $e) {
            return false;
        }
    }
}
