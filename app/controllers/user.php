<?php
// filepath: /Applications/MAMP/htdocs/phpbookstore/app/controllers/user.php

class User extends Controller
{
    private $userModel;
    private $cartModel;
    
    public function __construct()
    {
        $this->userModel = $this->loadModel('UserModel');
        $this->cartModel = $this->loadModel('CartModel');
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index()
    {
        // Redirect to home if accessed directly
        header("Location: " . ROOT);
        exit;
    }
    
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            return;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Basic validation
        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'error' => 'Please fill in all fields']);
            return;
        }
        
        // Attempt login
        $user = $this->userModel->login($email, $password);
        
        if ($user) {
            // Create session
            $_SESSION['user_id'] = $user->UserID;
            $_SESSION['UserID'] = $user->UserID; // For compatibility with CartModel
            $_SESSION['user_email'] = $user->Email;
            $_SESSION['user_name'] = $user->FirstName . ' ' . $user->LastName;
            $_SESSION['user_role'] = $user->Role;
            
            // Transfer session cart to database
            $this->cartModel->transferSessionCartToDb($user->UserID);
            
            $redirectUrl = ($user->Role == 'admin') ? ROOT . 'admin' : ROOT;
            echo json_encode(['success' => true, 'redirect' => $redirectUrl]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid email or password']);
        }
    }
    
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            return;
        }
        
        $data = [
            'firstName' => trim($_POST['firstName'] ?? ''),
            'lastName' => trim($_POST['lastName'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirmPassword' => $_POST['confirmPassword'] ?? '',
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? '')
        ];
        
        // Validation
        if (empty($data['email']) || empty($data['firstName']) || 
            empty($data['lastName']) || empty($data['password'])) {
            echo json_encode(['success' => false, 'error' => 'Please fill all required fields']);
            return;
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Please enter a valid email']);
            return;
        }
        
        if ($this->userModel->checkEmailExists($data['email'])) {
            echo json_encode(['success' => false, 'error' => 'Email already exists']);
            return;
        }
        
        if (strlen($data['password']) < 6) {
            echo json_encode(['success' => false, 'error' => 'Password must be at least 6 characters']);
            return;
        }
        
        if ($data['password'] !== $data['confirmPassword']) {
            echo json_encode(['success' => false, 'error' => 'Passwords do not match']);
            return;
        }
        
        // Register user
        $userId = $this->userModel->register($data);
        
        if ($userId) {
            // Get the user data
            $user = $this->userModel->getUserById($userId);
            
            // Create session
            $_SESSION['user_id'] = $user->UserID;
            $_SESSION['UserID'] = $user->UserID; // For compatibility with CartModel
            $_SESSION['user_email'] = $user->Email;
            $_SESSION['user_name'] = $user->FirstName . ' ' . $user->LastName;
            $_SESSION['user_role'] = $user->Role;
            
            // Transfer session cart to database
            $this->cartModel->transferSessionCartToDb($user->UserID);
            
            echo json_encode(['success' => true, 'redirect' => ROOT]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Registration failed']);
        }
    }
    
    public function orders()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . ROOT);
            exit;
        }

        $orderModel = $this->loadModel('OrderModel');
        $orders = $orderModel->getUserOrders($_SESSION['user_id']);

        $data = [
            'page_title' => 'My Orders',
            'orders' => $orders
        ];

        $this->view('user_orders', $data);
    }

    public function logout()
    {
        // Clear all session variables
        session_unset();
        // Destroy the session
        session_destroy();
        // Start a new session and initialize cart
        session_start();
        $_SESSION['cart'] = [];

        // Redirect to home
        header("Location: " . ROOT);
        exit;
    }
}