<?php 
// Handle AJAX requests first
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once 'database.php';
    $db = new Database();
    $conn = $db->getConnection();
    
    $response = ['success' => false, 'message' => ''];
    
    try {
        if ($_POST['action'] === 'add' || $_POST['action'] === 'edit') {
            $data = [
                'category_id' => $_POST['category_id'],
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'isbn' => $_POST['isbn'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'image' => $_POST['image'] ?? '' // Optional image URL
            ];

            if ($_POST['action'] === 'add') {
                try {
                    $stmt = $conn->prepare("CALL sp_InsertProduct(?, ?, ?, ?, ?, ?, ?, ?)");
                    $result = $stmt->execute([
                        $data['category_id'], 
                        $data['title'], 
                        $data['author'], 
                        $data['isbn'] ?: null,  // Convert empty string to null
                        $data['description'], 
                        $data['price'],
                        $data['stock'], 
                        $data['image']
                    ]);
                    $response = ['success' => true, 'message' => 'Product added successfully'];
                } catch(PDOException $e) {
                    error_log("Product Insert Error: " . $e->getMessage());
                    $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
                }
            } else if ($_POST['action'] === 'edit') {
                try {
                    $stmt = $conn->prepare("CALL sp_UpdateProduct(?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $result = $stmt->execute([
                        $_POST['product_id'], 
                        $data['category_id'], 
                        $data['title'],
                        $data['author'], 
                        $data['isbn'], 
                        $data['description'],
                        $data['price'], 
                        $data['stock'], 
                        $data['image']
                    ]);
                    $response = ['success' => true, 'message' => 'Product updated successfully'];
                } catch(PDOException $e) {
                    error_log("Product Update Error: " . $e->getMessage());
                    $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
                }
            }
            
        } elseif ($_POST['action'] === 'delete') {
            $stmt = $conn->prepare("CALL sp_DeleteProduct(?)");
            $result = $stmt->execute([$_POST['product_id']]);
            
            if ($result) {
                $response = ['success' => true, 'message' => 'Product deleted successfully'];
            }
        }
    } catch(PDOException $e) {
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

// Fetch products and categories
try {
    // First query
    $stmt = $conn->prepare("CALL sp_GetAllProducts()");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor(); // Close the cursor for the first query
    
    // Second query with new statement
    $stmt2 = $conn->prepare("CALL sp_GetAllCategories()");
    $stmt2->execute();
    $categories = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $stmt2->closeCursor(); // Close the cursor for the second query
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
                                <h4 class="card-title">Products List</h4>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                                    Add Product
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if (!empty($product['Image'])): ?>
                                                            <img src="<?php echo htmlspecialchars($product['Image']); ?>" 
                                                                 alt="<?php echo htmlspecialchars($product['Title']); ?>"
                                                                 class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                        <?php else: ?>
                                                            <img src="../assets/images/no-image.png" 
                                                                 alt="No Image"
                                                                 class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                        <?php endif; ?>
                                                        <div>
                                                            <h6 class="mb-0"><?php echo htmlspecialchars($product['Title']); ?></h6>
                                                            <small class="text-muted"><?php echo htmlspecialchars($product['Author']); ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($product['CategoryName']); ?></td>
                                                <td>$<?php echo number_format($product['Price'], 2); ?></td>
                                                <td><?php echo $product['StockQuantity']; ?></td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-soft-primary btn-sm edit-product" 
                                                                data-id="<?php echo $product['BookID']; ?>"
                                                                data-product='<?php echo json_encode($product); ?>'>
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-soft-danger btn-sm delete-product" 
                                                                data-id="<?php echo $product['BookID']; ?>">
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

        <!-- Product Modal -->
        <div class="modal fade" id="productModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="productForm">
                        <div class="modal-body">
                            <input type="hidden" id="product_id" name="product_id">
                            <input type="hidden" id="action" name="action" value="add">
                            
                            <!-- Basic Information -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Author</label>
                                    <input type="text" class="form-control" id="author" name="author" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['CategoryID']; ?>">
                                                <?php echo htmlspecialchars($category['Name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stock Quantity</label>
                                    <input type="number" class="form-control" id="stock" name="stock" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Image URL</label>
                                    <input type="url" class="form-control" id="image" name="image">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
            const productModal = new bootstrap.Modal(document.getElementById('productModal'));
            
            // Reset form and image preview when opening add modal
            $('.btn-primary[data-bs-toggle="modal"]').click(function() {
                $('#modalTitle').text('Add Product');
                $('#productForm')[0].reset();
                $('#action').val('add');
                $('#product_id').val('');
            });

            // Form submission handler
            $('#productForm').on('submit', function(e) {
                e.preventDefault();
                
                // Collect only basic product data
                const formData = {
                    action: $('#action').val(),
                    product_id: $('#product_id').val(),
                    category_id: $('#category_id').val(),
                    title: $('#title').val(),
                    author: $('#author').val(),
                    price: $('#price').val(),
                    stock: $('#stock').val(),
                    image: $('#image').val(),
                    description: $('#description').val()
                };

                $.ajax({
                    url: 'product.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            productModal.hide();
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

            // Edit product
            $('.edit-product').click(function() {
                const productData = $(this).data('product');
                $('#modalTitle').text('Edit Product');
                $('#product_id').val(productData.BookID);
                $('#title').val(productData.Title);
                $('#author').val(productData.Author);
                $('#category_id').val(productData.CategoryID);
                $('#isbn').val(productData.ISBN);
                $('#price').val(productData.Price);
                $('#stock').val(productData.StockQuantity);
                $('#description').val(productData.Description);
                $('#image').val(productData.Image); // Add this line to set the image URL
                $('#action').val('edit');
                
                productModal.show();
            });

            // Delete product
            $('.delete-product').click(function() {
                const productId = $(this).data('id');
                
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
                            url: 'product.php',
                            type: 'POST',
                            data: { action: 'delete', product_id: productId },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
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
                                        text: response.message
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
                    }
                });
            });

            // Preview image before upload
            $('#image').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#currentImage').removeClass('d-none')
                            .find('img')
                            .attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

        });
    </script>
</body>
</html>