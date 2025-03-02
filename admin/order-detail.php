<?php
include 'includes/header.php';
require_once 'database.php';

// Handle AJAX requests first
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    ob_clean();
    $db = new Database();
    $conn = $db->getConnection();
    
    $response = ['success' => false, 'message' => ''];
    
    try {
        if ($_POST['action'] === 'update_status') {
            $stmt = $conn->prepare("CALL sp_UpdateOrderStatus(?, ?)");
            $stmt->execute([
                $_POST['order_id'],
                $_POST['status']
            ]);
            $response = ['success' => true, 'message' => 'Order status updated successfully'];
        }
    } catch(PDOException $e) {
        $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Get OrderID from URL parameter
$orderId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($orderId <= 0) {
    header('Location: order.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

// Fetch order details using stored procedures
try {
    // Get order details
    $stmt = $conn->prepare("CALL sp_GetOrderDetails(?)");
    $stmt->execute([$orderId]);
    $orderDetails = $stmt->fetchAll();
    $stmt->closeCursor();
    
    // Calculate totals
    $subTotal = 0;
    foreach ($orderDetails as $item) {
        $subTotal += ($item['Price'] * $item['Quantity']);
    }
    
    // Calculate other amounts
    $taxRate = 0.155; // 15.5%
    $tax = $subTotal * $taxRate;
    $discount = 0; // You can add discount logic if needed
    $deliveryCharge = 10; // You can make this dynamic
    $totalAmount = $subTotal + $tax - $discount + $deliveryCharge;
    
} catch(PDOException $e) {
    die("Error fetching order details: " . $e->getMessage());
}
?>

<body>
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="page-content">
            <div class="container-fluid">
                <!-- Order Details Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Order #<?= htmlspecialchars($orderId) ?> Details</h4>
                                <div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                                        Update Status
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>Book Title</th>
                                                <th>Author</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orderDetails as $item): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($item['Title']) ?></td>
                                                <td><?= htmlspecialchars($item['Author']) ?></td>
                                                <td><?= htmlspecialchars($item['Quantity']) ?></td>
                                                <td>$<?= number_format($item['Price'], 2) ?></td>
                                                <td>$<?= number_format($item['Price'] * $item['Quantity'], 2) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                                <td>$<?= number_format($subTotal, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Tax (15.5%):</strong></td>
                                                <td>$<?= number_format($tax, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Delivery Charge:</strong></td>
                                                <td>$<?= number_format($deliveryCharge, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                                <td><strong>$<?= number_format($totalAmount, 2) ?></strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">New Status</label>
                        <select class="form-select" id="status">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateStatus">Update Status</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        const orderId = <?= $orderId ?>;
        const statusModal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
        
        // Handle status update
        $('#updateStatus').click(function() {
            const newStatus = $('#status').val();
            
            $.ajax({
                url: 'order-detail.php',
                type: 'POST',
                data: {
                    action: 'update_status',
                    order_id: orderId,
                    status: newStatus
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        statusModal.hide();
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
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'A network error occurred'
                    });
                }
            });
        });
    });
    </script>
</body>
</html>