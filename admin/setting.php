<?php
include 'includes/header.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => ''];
    
    try {
        switch ($_POST['setting_type']) {
            case 'profile':
                $stmt = $conn->prepare("CALL sp_UpdateAdminProfile(?, ?, ?, ?)");
                $stmt->execute([
                    $_SESSION['admin_id'],
                    $_POST['first_name'],
                    $_POST['last_name'],
                    $_POST['email']
                ]);
                $response = ['success' => true, 'message' => 'Profile updated successfully'];
                break;

            case 'password':
                if (password_verify($_POST['current_password'], $admin['Password'])) {
                    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("CALL sp_UpdateUserPassword(?, ?)");
                    $stmt->execute([$_SESSION['admin_id'], $new_password]);
                    $response = ['success' => true, 'message' => 'Password updated successfully'];
                } else {
                    $response = ['success' => false, 'message' => 'Current password is incorrect'];
                }
                break;

            case 'site':
                $stmt = $conn->prepare("CALL sp_UpdateSiteSettings(?, ?, ?)");
                $stmt->execute([
                    $_POST['site_name'],
                    $_POST['site_description'],
                    $_POST['site_logo']
                ]);
                $response = ['success' => true, 'message' => 'Site settings updated successfully'];
                break;
        }
    } catch(PDOException $e) {
        $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<body>
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="page-content">
            <div class="container-fluid">
                <!-- Settings Navigation -->
                <div class="row mb-3">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#profile">Profile Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#site">Site Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#email">Email Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#payment">Payment Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Settings Content -->
                <div class="tab-content">
                    <!-- Profile Settings -->
                    <div class="tab-pane fade show active" id="profile">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Profile Settings</h4>
                            </div>
                            <div class="card-body">
                                <form id="profileForm">
                                    <input type="hidden" name="setting_type" value="profile">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </form>

                                <hr>

                                <form id="passwordForm" class="mt-4">
                                    <input type="hidden" name="setting_type" value="password">
                                    <h5>Change Password</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Current Password</label>
                                        <input type="password" class="form-control" name="current_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" name="confirm_password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Site Settings -->
                    <div class="tab-pane fade" id="site">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Site Settings</h4>
                            </div>
                            <div class="card-body">
                                <form id="siteForm">
                                    <input type="hidden" name="setting_type" value="site">
                                    <div class="mb-3">
                                        <label class="form-label">Site Name</label>
                                        <input type="text" class="form-control" name="site_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Site Description</label>
                                        <textarea class="form-control" name="site_description" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Site Logo</label>
                                        <input type="file" class="form-control" name="site_logo">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Settings</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Email Settings -->
                    <div class="tab-pane fade" id="email">
                        <!-- Add email configuration settings -->
                    </div>

                    <!-- Payment Settings -->
                    <div class="tab-pane fade" id="payment">
                        <!-- Add payment gateway settings -->
                    </div>
                </div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <script>
    $(document).ready(function() {
        // Handle form submissions with AJAX
        $('form').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            
            $.ajax({
                url: 'settings.php',
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                }
            });
        });

        // Password confirmation validation
        $('#passwordForm').on('submit', function(e) {
            const newPass = $('input[name="new_password"]').val();
            const confirmPass = $('input[name="confirm_password"]').val();
            
            if (newPass !== confirmPass) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'New passwords do not match'
                });
            }
        });
    });
    </script>
</body>
</html>
