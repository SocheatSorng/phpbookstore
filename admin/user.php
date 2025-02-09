<?php
// Handle AJAX requests first
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once 'database.php';
    $db = new Database();
    $conn = $db->getConnection();
    
    $response = ['success' => false, 'message' => ''];
    
    try {
        if ($_POST['action'] === 'add') {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $conn->prepare("CALL sp_InsertUser(?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['email'],
                $password,
                $_POST['phone'],
                $_POST['address']
            ]);
            $response = ['success' => true, 'message' => 'User added successfully'];
        }
        elseif ($_POST['action'] === 'edit') {
            $stmt = $conn->prepare("CALL sp_UpdateUser(?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['user_id'],
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['address'],
                $_POST['role']
            ]);
            $response = ['success' => true, 'message' => 'User updated successfully'];
        }
        elseif ($_POST['action'] === 'delete') {
            $stmt = $conn->prepare("CALL sp_DeleteUser(?)");
            $stmt->execute([$_POST['user_id']]);
            $response = ['success' => true, 'message' => 'User deleted successfully'];
        }
    } catch(PDOException $e) {
        $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

include 'includes/header.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

try {
    $stmt = $conn->prepare("CALL sp_GetAllUsers()");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error fetching users: " . $e->getMessage());
}
?>

<body>
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Users List</h4>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                                    Add User
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Role</th>
                                                <th>Total Orders</th>
                                                <th>Total Spent</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?></td>
                                                <td><?php echo htmlspecialchars($user['Email']); ?></td>
                                                <td><?php echo htmlspecialchars($user['Phone'] ?? 'N/A'); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $user['Role'] === 'admin' ? 'primary' : 'success'; ?>">
                                                        <?php echo ucfirst($user['Role']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $user['TotalOrders']; ?></td>
                                                <td>$<?php echo number_format($user['TotalSpent'], 2); ?></td>
                                                <td><?php echo $user['CreatedAt']; ?></td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-soft-primary btn-sm edit-user" 
                                                                data-user='<?php echo json_encode($user); ?>'>
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-soft-danger btn-sm delete-user" 
                                                                data-id="<?php echo $user['UserID']; ?>">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Modal -->
        <div class="modal fade" id="userModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="userForm">
                        <div class="modal-body">
                            <input type="hidden" id="user_id" name="user_id">
                            <input type="hidden" id="action" name="action" value="add">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3 password-field">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <small class="form-text text-muted">Leave empty to keep existing password when editing</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <script>
    $(document).ready(function() {
        const userModal = new bootstrap.Modal(document.getElementById('userModal'));
        
        // Form submission handler
        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'user.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        userModal.hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => location.reload());
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

        // Edit user handler
        $('.edit-user').click(function() {
            const user = $(this).data('user');
            $('#modalTitle').text('Edit User');
            $('#user_id').val(user.UserID);
            $('#first_name').val(user.FirstName);
            $('#last_name').val(user.LastName);
            $('#email').val(user.Email);
            $('#phone').val(user.Phone);
            $('#address').val(user.Address);
            $('#role').val(user.Role);  // Add this line
            $('#action').val('edit');
            $('.password-field').hide();
            userModal.show();
        });

        // Delete user handler
        $('.delete-user').click(function() {
            const userId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'user.php',
                        type: 'POST',
                        data: {
                            action: 'delete',
                            user_id: userId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => location.reload());
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        }
                    });
                }
            });
        });

        // Reset form when opening for new user
        $('.btn-primary[data-bs-toggle="modal"]').click(function() {
            $('#modalTitle').text('Add User');
            $('#userForm')[0].reset();
            $('#action').val('add');
            $('#user_id').val('');
            $('.password-field').show();
        });
    });
    </script>
</body>
</html>