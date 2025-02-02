<?php
class Database {
    private $host = "localhost";
    private $db_name = "bookstore_db";
    private $username = "user";
    private $password = "User@1234";
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }

        return $this->conn;
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
