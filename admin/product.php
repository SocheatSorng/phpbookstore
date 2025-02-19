<?php
require_once '../app/core/ImageHandler.php';
$imageHandler = new ImageHandler();
//use this code when using upload image fuction
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
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'image' => '' // Will be updated if file is uploaded
            ];

            // Handle image upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    try {
                        $data['image'] = $imageHandler->uploadImage($_FILES['image']);
                    } catch (Exception $e) {
                        $response = ['success' => false, 'message' => $e->getMessage()];
                        echo json_encode($response);
                        exit;
                    }
                }

            if ($_POST['action'] === 'add') {
                try {
                    $stmt = $conn->prepare("CALL sp_InsertProduct(?, ?, ?, ?, ?, ?)");
                    $result = $stmt->execute([
                        $data['category_id'], 
                        $data['title'], 
                        $data['author'], 
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
                // Get existing image if no new image uploaded
                if (empty($data['image'])) {
                    $stmt = $conn->prepare("SELECT Image FROM tbBook WHERE BookID = ?");
                    $stmt->execute([$_POST['product_id']]);
                    $data['image'] = $stmt->fetchColumn();
                }

                try {
                    $stmt = $conn->prepare("CALL sp_UpdateProduct(?, ?, ?, ?, ?, ?, ?)");
                    $result = $stmt->execute([
                        $_POST['product_id'], 
                        $data['category_id'], 
                        $data['title'],
                        $data['author'], 
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
            // Get image path before deleting
            $stmt = $conn->prepare("SELECT Image FROM tbBook WHERE BookID = ?");
            $stmt->execute([$_POST['product_id']]);
            $imagePath = $stmt->fetchColumn();

            // Delete the product
            $stmt = $conn->prepare("CALL sp_DeleteProduct(?)");
            $result = $stmt->execute([$_POST['product_id']]);
            
            if ($result) {
                // Delete the image file if it exists
                if (!empty($imagePath)) {
                    $imageHandler->deleteImage($imagePath);
                }
                $response = ['success' => true, 'message' => 'Product deleted successfully'];
            }
        }
    } catch(Exception $e) {
        $response = ['success' => false, 'message' => $e->getMessage()];
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
    $stmt = $conn->prepare("CALL sp_GetAllProducts()");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    
    $stmt2 = $conn->prepare("CALL sp_GetAllCategories()");
    $stmt2->execute();
    $categories = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $stmt2->closeCursor();
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#productModal">
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
                                                        <img src="<?php echo '../public/' . htmlspecialchars($product['Image']); ?>"
                                                            alt="<?php echo htmlspecialchars($product['Title']); ?>"
                                                            class="me-3"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                        <?php else: ?>
                                                        <div class="me-3"
                                                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                                            <i class="bi bi-book"></i>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($product['Title']); ?></td>
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
                    <form id="productForm" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" id="product_id" name="product_id">
                            <input type="hidden" id="action" name="action" value="add">

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
                                    <input type="number" class="form-control" id="price" name="price" step="0.01"
                                        required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stock Quantity</label>
                                    <input type="number" class="form-control" id="stock" name="stock" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <div id="currentImage" class="mt-2 d-none">
                                        <img src="" alt="Current product image" style="max-width: 100px;">
                                    </div>
                                </div>
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
            $('#currentImage').addClass('d-none');
        });

        // Form submission handler
        $('#productForm').on('submit', function(e) {
            e.preventDefault();

            // Use FormData to handle file uploads
            const formData = new FormData(this);

            $.ajax({
                url: 'product.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
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
            $('#price').val(productData.Price);
            $('#stock').val(productData.StockQuantity);

            // Show current image if it exists
            // Show current image if it exists
            if (productData.Image) {
                $('#currentImage')
                    .removeClass('d-none')
                    .find('img')
                    .attr('src', '../public/' + productData.Image);
            } else {
                $('#currentImage').addClass('d-none');
            }

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
                        data: {
                            action: 'delete',
                            product_id: productId
                        },
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

        // Image preview when selecting a new file
        $('#image').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#currentImage')
                        .removeClass('d-none')
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