// order.php

<!DOCTYPE html>
<html lang="en">
     
<?php
// Handle AJAX requests first
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    ob_clean(); // Clear any previous output
    require_once 'database.php';
    $db = new Database();
    $conn = $db->getConnection();
    
    $response = ['success' => false, 'message' => ''];
    
    try {
        if ($_POST['action'] === 'add') {
            $stmt = $conn->prepare("CALL sp_InsertOrder(?, ?, ?, ?, ?)");
            $result = $stmt->execute([
                $_POST['user_id'],
                $_POST['total_amount'],
                $_POST['status'],
                $_POST['shipping_address'],
                $_POST['payment_method']
            ]);
            
            if ($result) {
                $response = ['success' => true, 'message' => 'Order added successfully'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to add order'];
            }
        }
        elseif ($_POST['action'] === 'update_status') {
            $stmt = $conn->prepare("CALL sp_UpdateOrderStatus(?, ?)");
            $stmt->execute([
                $_POST['order_id'],
                $_POST['status']
            ]);
            $response = ['success' => true, 'message' => 'Order status updated successfully'];
        }
        elseif ($_POST['action'] === 'delete') {
            $stmt = $conn->prepare("CALL sp_DeleteOrder(?)");
            $stmt->execute([$_POST['order_id']]);
            $response = ['success' => true, 'message' => 'Order deleted successfully'];
        }
    } catch(PDOException $e) {
        error_log("Order Insert Error: " . $e->getMessage());
        $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Regular page display
include 'includes/header.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

// Update the users fetch code to use stored procedure
try {
    $stmt = $conn->prepare("CALL sp_GetAllUsers()");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor(); // Important: close the cursor before next query
    
    // Then fetch orders
    $stmt = $conn->prepare("CALL sp_GetAllOrders()");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
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
                                <h4 class="card-title">Orders List</h4>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal">
                                    Add Order
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover table-centered">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Created at</th>
                                                <th>Customer</th>
                                                <th>Total Amount</th>
                                                <th>Status</th>
                                                <th>Payment Method</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td>
                                                    <a href="order-detail.php?id=<?php echo $order['OrderID']; ?>" class="text-primary">
                                                        #<?php echo $order['OrderID']; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $order['OrderDate']; ?></td>
                                                <td>
                                                    <a href="#!" class="link-primary fw-medium">
                                                        <?php echo htmlspecialchars($order['FirstName'] . ' ' . $order['LastName']); ?>
                                                    </a>
                                                </td>
                                                <td>$<?php echo number_format($order['TotalAmount'], 2); ?></td>
                                                <td>
                                                    <select class="form-select form-select-sm status-select" 
                                                            data-order-id="<?php echo $order['OrderID']; ?>">
                                                        <option value="pending" <?php echo $order['Status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="processing" <?php echo $order['Status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                                        <option value="delivered" <?php echo $order['Status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                                        <option value="cancelled" <?php echo $order['Status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                    </select>
                                                </td>
                                                <td><?php echo htmlspecialchars($order['PaymentMethod']); ?></td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-soft-danger btn-sm delete-order" 
                                                                data-id="<?php echo $order['OrderID']; ?>">
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

        <!-- Order Modal -->
        <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="orderForm">
                        <div class="modal-body">
                            <input type="hidden" id="order_id" name="order_id">
                            <input type="hidden" id="action" name="action" value="add">
                            
                            <div class="mb-3">
                                <label class="form-label">Customer</label>
                                <select class="form-select" id="user_id" name="user_id" required>
                                    <option value="">Select Customer</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?php echo $user['UserID']; ?>">
                                            <?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?> 
                                            (<?php echo htmlspecialchars($user['Email']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Total Amount</label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount" step="0.01" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="Cash">Cash</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Shipping Address</label>
                                <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required></textarea>
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
        const orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
        
        // Reset form when opening modal for adding
        $('.btn-primary[data-bs-toggle="modal"]').click(function() {
            $('#modalTitle').text('Add Order');
            $('#orderForm')[0].reset();
            $('#action').val('add');
            $('#order_id').val('');
        });

        // Handle form submission
        $('#orderForm').on('submit', function(e) {
            e.preventDefault();
            
            // Debug log
            console.log('Form data:', $(this).serialize());
            
            $.ajax({
                url: 'order.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log('Server response:', response);
                    if (response.success) {
                        orderModal.hide();
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
                            text: response.message || 'Failed to add order'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.log('Response:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'A network error occurred. Please try again.'
                    });
                }
            });
        });

        // Handle status changes
        $('.status-select').change(function() {
            const orderId = $(this).data('order-id');
            const newStatus = $(this).val();
            
            $.ajax({
                url: 'order.php',
                type: 'POST',
                data: {
                    action: 'update_status',
                    order_id: orderId,
                    status: newStatus
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
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

        // Handle delete order
        $('.delete-order').click(function() {
            const orderId = $(this).data('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'order.php',
                        type: 'POST',
                        data: {
                            action: 'delete',
                            order_id: orderId
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
    });
    </script>
</body>
</html>