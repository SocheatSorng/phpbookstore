<?php

if(!class_exists('User')):
class User {
    
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function login($POST) {
        $email = addslashes($POST['email']);
        $password = addslashes($POST['password']);

        $query = "SELECT * FROM tbUser WHERE Email = '$email' LIMIT 1";
        $result = $this->db->read($query);

        if($result) {
            $row = $result[0];
            // First try direct match for first login
            if($password === 'admin123' && $row->Password === 'admin123') {
                $_SESSION['user_id'] = $row->ID;
                $_SESSION['user_name'] = $row->Name;
                $_SESSION['user_role'] = $row->Role;
                header("Location: home");
                die;
            }
            // Then try hashed password
            if(password_verify($password, $row->Password)) {
                $_SESSION['user_id'] = $row->ID;
                $_SESSION['user_name'] = $row->Name;
                $_SESSION['user_role'] = $row->Role;
                header("Location: home");
                die;
            }
        }

        $_SESSION['error'] = "Wrong email or password";
        header("Location: login");
        die;
    }

    public function createUser($data) {
        $name = addslashes($data['Name']);
        $email = addslashes($data['Email']);
        // Don't hash the first admin password
        $password = ($email === 'admin@admin.com') ? $data['Password'] : password_hash($data['Password'], PASSWORD_DEFAULT);
        $role = isset($data['Role']) ? addslashes($data['Role']) : 'user';

        $query = "INSERT INTO tbUser (Name, Email, Password, Role) VALUES ('$name', '$email', '$password', '$role')";
        return $this->db->write($query);
    }

    public function createFirstAdmin() {
        // Check if any admin exists
        $query = "SELECT * FROM tbUser WHERE Role = 'admin' LIMIT 1";
        $result = $this->db->read($query);

        if(!$result) {
            // Create default admin user
            $admin_data = [
                'Name' => 'Admin',
                'Email' => 'admin@admin.com',
                'Password' => 'admin123',
                'Role' => 'admin'
            ];
            return $this->createUser($admin_data);
        }
        return false;
    }
}
endif;
