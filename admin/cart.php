<?php
session_start();
require_once 'database.php';

// Handle AJAX requests first
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    $db = new Database();
    $conn = $db->getConnection();
    $response = ['success' => false, 'message' => ''];
    
    try {
        switch ($_POST['action']) {
            case 'add':
                $stmt = $conn->prepare("CALL sp_AddToCart(?, ?, ?)");
                $stmt->execute([
                    $_POST['user_id'],
                    $_POST['book_id'],
                    $_POST['quantity']
                ]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    $response = [
                        'success' => isset($result['success']) ? $result['success'] : true,
                        'message' => isset($result['message']) ? $result['message'] : 'Item added successfully'
                    ];
                }
                break;
            case 'update':
                $stmt = $conn->prepare("CALL sp_UpdateCartQuantity(?, ?)");
                $stmt->execute([$_POST['cart_id'], $_POST['quantity']]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $response = $result;
                break;
                
            case 'remove':
                $stmt = $conn->prepare("CALL sp_RemoveFromCart(?, ?)");
                $stmt->execute([$_POST['cart_id'], $_SESSION['user_id']]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $response = $result;
                break;
                
            case 'clear':
                $stmt = $conn->prepare("CALL sp_ClearCart(?)");
                $stmt->execute([$_SESSION['user_id']]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $response = $result;
                break;
        }
    } catch(PDOException $e) {
        $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
    
    echo json_encode($response);
    exit;
}

// Regular page display starts here
include 'includes/header.php';

$db = new Database();
$conn = $db->getConnection();

// Get selected user ID from query string if available
$selectedUserId = isset($_GET['user_id']) ? $_GET['user_id'] : ($_SESSION['user_id'] ?? null);

// Fetch cart items, summary, and users
try {
    // Get cart items for selected user
    $stmt = $conn->prepare("CALL sp_GetCartItems(?)");
    $stmt->execute([$selectedUserId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    
    // Get cart summary for selected user
    $stmt = $conn->prepare("CALL sp_GetCartSummary(?)");
    $stmt->execute([$selectedUserId]);
    $cartSummary = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    
    // Get available books
    $stmt = $conn->prepare("CALL sp_GetAllProducts()");
    $stmt->execute();
    $availableBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    
    // Get all users
    $stmt = $conn->prepare("CALL sp_GetAllUsers()");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Shopping Cart</h4>
                                <div>
                                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addToCartModal">
                                        Add to Cart
                                    </button>
                                    <?php if (!empty($cartItems)): ?>
                                        <button type="button" class="btn btn-danger" id="clearCart">Clear Cart</button>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Add to Cart Modal -->
                            <div class="modal fade" id="addToCartModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add to Cart</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form id="addToCartForm">
                                            <div class="modal-body">
                                                <input type="hidden" name="action" value="add">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Select User</label>
                                                    <select class="form-select" name="user_id" required id="userSelect">
                                                        <option value="">Choose a user...</option>
                                                        <?php foreach ($users as $user): ?>
                                                            <option value="<?php echo $user['UserID']; ?>">
                                                                <?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?> 
                                                                (<?php echo htmlspecialchars($user['Email']); ?>)
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Select Book</label>
                                                    <select class="form-select" name="book_id" required>
                                                        <option value="">Choose a book...</option>
                                                        <?php foreach ($availableBooks as $book): ?>
                                                            <option value="<?php echo $book['BookID']; ?>" 
                                                                    data-price="<?php echo $book['Price']; ?>"
                                                                    data-stock="<?php echo $book['StockQuantity']; ?>">
                                                                <?php echo htmlspecialchars($book['Title']); ?> 
                                                                ($<?php echo number_format($book['Price'], 2); ?>) - 
                                                                <?php echo $book['StockQuantity']; ?> in stock
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Quantity</label>
                                                    <input type="number" class="form-control" name="quantity" 
                                                           min="1" value="1" required>
                                                    <small class="text-muted">Available stock: <span id="availableStock">-</span></small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <?php if (empty($cartItems)): ?>
                                    <div class="text-center">
                                        <h5>Cart is empty</h5>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($cartItems as $item): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <?php if ($item['Image']): ?>
                                                                <img src="<?php echo htmlspecialchars($item['Image']); ?>" 
                                                                     alt="<?php echo htmlspecialchars($item['Title']); ?>"
                                                                     class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                            <?php endif; ?>
                                                            <div>
                                                                <h6 class="mb-0"><?php echo htmlspecialchars($item['Title']); ?></h6>
                                                                <small class="text-muted"><?php echo htmlspecialchars($item['Author']); ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>$<?php echo number_format($item['Price'], 2); ?></td>
                                                    <td>
                                                        <div class="input-group" style="width: 140px;">
                                                            <button class="btn btn-outline-secondary quantity-decrease" 
                                                                    type="button" data-cart-id="<?php echo $item['CartID']; ?>">-</button>
                                                            <input type="number" class="form-control text-center quantity-input" 
                                                                   value="<?php echo $item['Quantity']; ?>" 
                                                                   min="1" 
                                                                   max="<?php echo $item['AvailableStock']; ?>"
                                                                   data-cart-id="<?php echo $item['CartID']; ?>">
                                                            <button class="btn btn-outline-secondary quantity-increase" 
                                                                    type="button" data-cart-id="<?php echo $item['CartID']; ?>">+</button>
                                                        </div>
                                                    </td>
                                                    <td>$<?php echo number_format($item['Subtotal'], 2); ?></td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm remove-item" data-cart-id="<?php echo $item['CartID']; ?>">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" class="text-end"><strong>Total Items:</strong></td>
                                                    <td><strong><?php echo $cartSummary['TotalQuantity']; ?></strong></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                                                    <td><strong>$<?php echo number_format($cartSummary['TotalAmount'], 2); ?></strong></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <script>
        $(document).ready(function() {
            // Get modal instance correctly at the top level
            const addToCartModal = new bootstrap.Modal(document.getElementById('addToCartModal'));
            
            // Update quantity
            function updateQuantity(cartId, quantity) {
                $.ajax({
                    url: 'cart.php',
                    type: 'POST',
                    data: {
                        action: 'update',
                        cart_id: cartId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
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

            // Quantity controls
            $('.quantity-decrease').click(function() {
                const input = $(this).siblings('.quantity-input');
                const newValue = parseInt(input.val()) - 1;
                if (newValue >= parseInt(input.attr('min'))) {
                    updateQuantity($(this).data('cart-id'), newValue);
                }
            });

            $('.quantity-increase').click(function() {
                const input = $(this).siblings('.quantity-input');
                const newValue = parseInt(input.val()) + 1;
                if (newValue <= parseInt(input.attr('max'))) {
                    updateQuantity($(this).data('cart-id'), newValue);
                }
            });

            // Remove item
            $('.remove-item').click(function() {
                const cartId = $(this).data('cart-id');
                Swal.fire({
                    title: 'Remove Item',
                    text: "Are you sure you want to remove this item?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, remove it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'cart.php',
                            type: 'POST',
                            data: {
                                action: 'remove',
                                cart_id: cartId
                            },
                            success: function(response) {
                                if (response.success) {
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });

            // Clear cart
            $('#clearCart').click(function() {
                Swal.fire({
                    title: 'Clear Cart',
                    text: "Are you sure you want to clear the entire cart?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, clear it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'cart.php',
                            type: 'POST',
                            data: { action: 'clear' },
                            success: function(response) {
                                if (response.success) {
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });

            // Add to cart form handling - Modified to match category page behavior
            $('#addToCartForm').on('submit', function(e) {
                e.preventDefault();
                const userId = $('#userSelect').val();
                if (!userId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please select a user'
                    });
                    return;
                }
                
                $.ajax({
                    url: 'cart.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            addToCartModal.hide(); // Hide modal first
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(function() {
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

            // Reset form when opening modal
            $('.btn-primary[data-bs-toggle="modal"]').click(function() {
                $('#addToCartForm')[0].reset();
                $('#availableStock').text('-');
            });

            // Update available stock display when book is selected
            $('select[name="book_id"]').change(function() {
                const selectedOption = $(this).find('option:selected');
                const stock = selectedOption.data('stock');
                $('#availableStock').text(stock);
                $('input[name="quantity"]').attr('max', stock);
            });

            // User selection change handler - Modified to use AJAX instead of page reload
            $('#userSelect').change(function() {
                const userId = $(this).val();
                if (userId) {
                    // Store the selected user ID in sessionStorage
                    sessionStorage.setItem('selectedUserId', userId);
                }
            });

            // Restore selected user when opening modal
            $('.btn-primary[data-bs-toggle="modal"]').click(function() {
                const selectedUserId = sessionStorage.getItem('selectedUserId');
                if (selectedUserId) {
                    $('#userSelect').val(selectedUserId);
                }
            });

            // Reset form when opening modal - Modified to preserve user selection
            $('.btn-primary[data-bs-toggle="modal"]').click(function() {
                const selectedUserId = $('#userSelect').val();
                $('#addToCartForm')[0].reset();
                $('#availableStock').text('-');
                if (selectedUserId) {
                    $('#userSelect').val(selectedUserId);
                }
            });
        });
    </script>
</body>
</html>