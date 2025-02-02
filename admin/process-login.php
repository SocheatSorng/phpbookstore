<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    if (!$email || !$password) {
        $_SESSION['login_error'] = 'Please enter both email and password.';
        header("Location: login.php");
        exit();
    }

    try {
        // Prepare SQL statement
        $stmt = $pdo->prepare("SELECT ID, Email, Password, Role FROM tbUser WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verify user exists and password is correct
        if ($user && password_verify($password, $user['Password'])) {
            // Check if user is an admin
            if ($user['Role'] !== 'admin') {
                $_SESSION['login_error'] = 'Access denied. Admin privileges required.';
                header("Location: login.php");
                exit();
            }

            // Set session variables
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['user_email'] = $user['Email'];
            $_SESSION['user_role'] = $user['Role'];

            // Set remember me cookie if requested
            if (isset($_POST['remember'])) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 days
                // You might want to store this token in the database for validation
            }

            header("Location: index.php");
            exit();
        } else {
            $_SESSION['login_error'] = 'Invalid email or password.';
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['login_error'] = 'Database error. Please try again later.';
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
