<?php
// filepath: /Applications/MAMP/htdocs/phpbookstore/app/models/UserModel.php

class UserModel
{
    private $db;

    public function __construct()
    {
        // Instantiate the Database class
        $this->db = new Database();
    }

    public function login($email, $password)
    {
        try {
            $conn = $this->db->getConnection();
            
            // Call stored procedure to get user by email
            $stmt = $conn->prepare("CALL sp_GetUserByEmail(?)");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($user && password_verify($password, $user->Password)) {
                return $user;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Error in login: " . $e->getMessage());
            return false;
        }
    }

    public function getUserById($userId)
    {
        try {
            $conn = $this->db->getConnection();
            
            // Call stored procedure to get user by ID
            $stmt = $conn->prepare("CALL sp_GetUser(?)");
            $stmt->execute([$userId]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error getting user by ID: " . $e->getMessage());
            return false;
        }
    }

    public function register($data)
    {
        try {
            $conn = $this->db->getConnection();
            
            // Hash the password
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            
            // Call stored procedure to insert user
            $stmt = $conn->prepare("CALL sp_InsertUser(?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['firstName'],
                $data['lastName'],
                $data['email'],
                $hashedPassword,
                $data['phone'] ?? '',
                $data['address'] ?? ''
            ]);
            
            // Get the new user ID
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result->UserID ?? false;
        } catch (Exception $e) {
            error_log("Error in register: " . $e->getMessage());
            return false;
        }
    }

    public function checkEmailExists($email)
    {
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("SELECT Email FROM tbUser WHERE Email = ?");
            $stmt->execute([$email]);
            
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error checking email: " . $e->getMessage());
            return false;
        }
    }
}