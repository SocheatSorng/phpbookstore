<?php
// Start with handling AJAX requests before any HTML output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once 'database.php';
    $db = new Database();
    $conn = $db->getConnection();
    
    $response = ['success' => false, 'message' => ''];
    
    try {
        if ($_POST['action'] === 'add') {
            $stmt = $conn->prepare("CALL sp_InsertPurchase(?, ?, ?)");
            $stmt->execute([
                $_POST['book_id'],
                $_POST['quantity'],
                $_POST['payment_method']
            ]);
            $response = ['success' => true, 'message' => 'Purchase added successfully'];
        }
        elseif ($_POST['action'] === 'edit') {
            $stmt = $conn->prepare("CALL sp_UpdatePurchase(?, ?, ?, ?)");
            $stmt->execute([
                $_POST['purchase_id'],
                $_POST['book_id'],
                $_POST['quantity'],
                $_POST['payment_method']
            ]);
            $response = ['success' => true, 'message' => 'Purchase updated successfully'];
        }
        elseif ($_POST['action'] === 'delete') {
            $stmt = $conn->prepare("CALL sp_DeletePurchase(?)");
            $stmt->execute([$_POST['purchase_id']]);
            $response = ['success' => true, 'message' => 'Purchase deleted successfully'];
        }
    } catch(PDOException $e) {
        $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
    
    // Ensure clean output
    ob_clean(); // Clear any previous output
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Regular page display starts here
include 'includes/header.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

// Fetch purchases and books
try {
    $stmt = $conn->prepare("CALL sp_GetAllPurchases()");
    $stmt->execute();
    $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    
    $stmt = $conn->prepare("CALL sp_GetAllProducts()");
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<div class="wrapper">
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/navbar.php'; ?>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Purchase List</h4>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#purchaseModal">
                                Add Purchase
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Book Title</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                            <th>Payment Method</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($purchases as $purchase): ?>
                                        <tr>
                                            <td><?php echo $purchase['PurchaseID']; ?></td>
                                            <td><?php echo htmlspecialchars($purchase['Title']); ?></td>
                                            <td><?php echo $purchase['Quantity']; ?></td>
                                            <td>$<?php echo number_format($purchase['UnitPrice'], 2); ?></td>
                                            <td>$<?php echo number_format($purchase['TotalAmount'], 2); ?></td>
                                            <td><?php echo htmlspecialchars($purchase['PaymentMethod']); ?></td>
                                            <td><?php echo $purchase['OrderDate']; ?></td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-soft-primary btn-sm edit-purchase" 
                                                            data-purchase='<?php echo json_encode($purchase); ?>'>
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-soft-danger btn-sm delete-purchase" 
                                                            data-id="<?php echo $purchase['PurchaseID']; ?>">
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

    <!-- Purchase Modal -->
    <div class="modal fade" id="purchaseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Purchase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="purchaseForm">
                    <div class="modal-body">
                        <input type="hidden" id="purchase_id" name="purchase_id">
                        <input type="hidden" id="action" name="action" value="add">
                        
                        <div class="mb-3">
                            <label class="form-label">Book</label>
                            <select class="form-select" id="book_id" name="book_id" required>
                                <option value="">Select Book</option>
                                <?php foreach ($books as $book): ?>
                                    <option value="<?php echo $book['BookID']; ?>">
                                        <?php echo htmlspecialchars($book['Title']); ?> 
                                        ($<?php echo number_format($book['Price'], 2); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="Cash">Cash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Credit Card">Credit Card</option>
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
    // Get the modal instance
    const purchaseModal = new bootstrap.Modal(document.getElementById('purchaseModal'));
    
    // Form submission
    $('#purchaseForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'purchase.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    purchaseModal.hide();  // Hide modal first
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {  // Add callback function
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'An error occurred'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'A network error occurred. Please try again.'
                });
            }
        });
    });

    // Edit purchase
    $('.edit-purchase').click(function() {
        const purchase = $(this).data('purchase');
        $('#modalTitle').text('Edit Purchase');
        $('#purchase_id').val(purchase.PurchaseID);
        $('#book_id').val(purchase.BookID);
        $('#quantity').val(purchase.Quantity);
        $('#payment_method').val(purchase.PaymentMethod);
        $('#action').val('edit');
        purchaseModal.show();
    });

    // Delete purchase
    $('.delete-purchase').click(function() {
        const purchaseId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'purchase.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        purchase_id: purchaseId
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

    // Reset form when opening for new purchase
    $('.btn-primary[data-bs-toggle="modal"]').click(function() {
        $('#modalTitle').text('Add Purchase');
        $('#purchaseForm')[0].reset();
        $('#purchase_id').val('');
        $('#action').val('add');
    });

    // Show book price when book is selected
    $('#book_id').change(function() {
        const selectedOption = $(this).find('option:selected');
        const price = selectedOption.data('price');
        $('#unit_price').val(price ? '$' + price.toFixed(2) : '');
    });
});
</script>

</body>

</html>