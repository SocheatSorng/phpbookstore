<?php
session_start();
require_once "../config/database.php";

// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if already logged in
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if(empty($email) || empty($password)) {
        $error = "Please enter both email and password";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT UserID, Email, Password, Role FROM tbUser WHERE Email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            // Debug logging
            error_log("Login attempt for: " . $email);
            error_log("User found: " . ($user ? 'Yes' : 'No'));
            if ($user) {
                error_log("Password verification: " . (password_verify($password, $user['Password']) ? 'Success' : 'Failed'));
                error_log("User role: " . $user['Role']);
            }

            if($user && password_verify($password, $user['Password'])) {
                if($user['Role'] === 'admin') {
                    // Set session variables
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $user['UserID'];
                    $_SESSION['admin_email'] = $user['Email'];
                    
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "You don't have admin privileges";
                }
            } else {
                $error = "Invalid email or password";
            }
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Admin Login | PHP Bookstore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg position-relative">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">
                        <div class="card-header py-4 text-center bg-primary">
                            <h4 class="text-white">PHP Bookstore Admin</h4>
                        </div>

                        <div class="card-body p-4">
                            <?php if($error): ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>

                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" type="email" name="email" id="emailaddress" required placeholder="Enter your email">
                                    <div class="invalid-feedback">Please provide a valid email.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" name="password" required id="password" placeholder="Enter your password">
                                    <div class="invalid-feedback">Please provide your password.</div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div>

                                <div class="mb-0 text-center">
                                    <button class="btn btn-primary w-100" type="submit"> Log In </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
</body>
</html>
