<?php 
// Handle AJAX requests first
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once 'database.php';
    $db = new Database();
    $conn = $db->getConnection();
    
    $response = ['success' => false, 'message' => ''];
    
    try {
        if ($_POST['action'] === 'add') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            
            $stmt = $conn->prepare("CALL sp_InsertCategory(?, ?)");
            $result = $stmt->execute([$name, $description]);
            
            if ($result) {
                $response = ['success' => true, 'message' => 'Category added successfully'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to add category'];
            }
            
        } elseif ($_POST['action'] === 'delete') {
            $categoryId = $_POST['category_id'];
            
            $stmt = $conn->prepare("CALL sp_DeleteCategory(?)");
            $result = $stmt->execute([$categoryId]);
            
            if ($result) {
                $response = ['success' => true, 'message' => 'Category deleted successfully'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to delete category'];
            }
            
        } elseif ($_POST['action'] === 'edit') {
            $categoryId = $_POST['category_id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            
            $stmt = $conn->prepare("CALL sp_UpdateCategory(?, ?, ?)");
            $result = $stmt->execute([$categoryId, $name, $description]);
            
            if ($result) {
                $response = ['success' => true, 'message' => 'Category updated successfully'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to update category'];
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

// Fetch categories using stored procedure
try {
    $stmt = $conn->prepare("CALL sp_GetAllCategories()");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error fetching categories: " . $e->getMessage());
}
?>

<body>
    <!-- START Wrapper -->
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="page-content">
            <div class="container-xxl">

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                                <h4 class="card-title flex-grow-1">All Categories List</h4>

                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                    Add Category
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($categories as $category): ?>
                                            <tr>
                                                <td><?php echo $category['CategoryID']; ?></td>
                                                <td><?php echo htmlspecialchars($category['Name']); ?></td>
                                                <td><?php echo htmlspecialchars($category['Description']); ?></td>
                                                <td><?php echo $category['CreatedAt']; ?></td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-soft-primary btn-sm edit-category" 
                                                                data-id="<?php echo $category['CategoryID']; ?>"
                                                                data-name="<?php echo htmlspecialchars($category['Name']); ?>"
                                                                data-description="<?php echo htmlspecialchars($category['Description']); ?>">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-soft-danger btn-sm delete-category" 
                                                                data-id="<?php echo $category['CategoryID']; ?>">
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
                            <div class="card-footer border-top">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end mb-0">
                                        <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
                                        <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Modal -->
        <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="categoryForm">
                        <div class="modal-body">
                            <input type="hidden" id="categoryId" name="category_id">
                            <input type="hidden" id="action" name="action" value="add">
                            
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
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
        
        <!-- Add jQuery before other scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script>
            $(document).ready(function() {
                // Get the modal instance
                const categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'));
                
                // Form submission
                $('#categoryForm').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: 'category.php',
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                categoryModal.hide();
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

                // Edit category
                $('.edit-category').click(function() {
                    $('#modalTitle').text('Edit Category');
                    $('#categoryId').val($(this).data('id'));
                    $('#name').val($(this).data('name'));
                    $('#description').val($(this).data('description'));
                    $('#action').val('edit');
                    $('#categoryModal').modal('show');
                });

                // Delete category
                $('.delete-category').click(function() {
                    const categoryId = $(this).data('id');
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
                                url: 'category.php',
                                type: 'POST',
                                data: {
                                    action: 'delete',
                                    category_id: categoryId
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire(
                                            'Deleted!',
                                            response.message,
                                            'success'
                                        ).then(function() {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            response.message,
                                            'error'
                                        );
                                    }
                                }
                            });
                        }
                    });
                });

                // Reset form when opening modal for adding
                $('.btn-primary[data-bs-toggle="modal"]').click(function() {
                    $('#modalTitle').text('Add Category');
                    $('#categoryForm')[0].reset();
                    $('#action').val('add');
                    $('#categoryId').val('');
                });
            });
        </script>
    </div>
</body>