<?php
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
                $stmt = $conn->prepare("CALL sp_InsertBookDetail(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['book_id'],
                    $_POST['isbn10'],
                    $_POST['isbn13'],
                    $_POST['publisher'],
                    $_POST['publish_year'],
                    $_POST['edition'],
                    $_POST['page_count'],
                    $_POST['language'],
                    $_POST['format'],
                    $_POST['dimensions'],
                    $_POST['weight'],
                    $_POST['description'] ?? ''
                ]);
                $response = ['success' => true, 'message' => 'Book details added successfully'];
                break;

            case 'update':
                $stmt = $conn->prepare("CALL sp_UpdateBookDetail(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['book_id'],
                    $_POST['isbn10'],
                    $_POST['isbn13'],
                    $_POST['publisher'],
                    $_POST['publish_year'],
                    $_POST['edition'],
                    $_POST['page_count'],
                    $_POST['language'],
                    $_POST['format'],
                    $_POST['dimensions'],
                    $_POST['weight'],
                    $_POST['description'] ?? ''
                ]);
                $response = ['success' => true, 'message' => 'Book details updated successfully'];
                break;

            case 'delete':
                $stmt = $conn->prepare("CALL sp_DeleteBookDetail(?)");
                $stmt->execute([$_POST['detail_id']]);
                $response = ['success' => true, 'message' => 'Book details deleted successfully'];
                break;
        }
        
        echo json_encode($response);
        exit;
        
    } catch(PDOException $e) {
        echo json_encode([
            'success' => false, 
            'message' => 'Database error: ' . $e->getMessage()
        ]);
        exit;
    }
}

// Rest of the page code for normal display
include 'includes/header.php';

$db = new Database();
$conn = $db->getConnection();

// Fetch book details and books
try {
    $stmt = $conn->prepare("CALL sp_GetAllBookDetails()");
    $stmt->execute();
    $bookDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    
    $stmt = $conn->prepare("CALL sp_GetAllProducts()");
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<div class="wrapper">
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Book Details</h4>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookDetailModal">
                                Add Book Details
                            </button>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Book Info</th>
                                            <th>ISBN</th>
                                            <th>Publisher</th>
                                            <th>Format</th>
                                            <th>Edition</th>
                                            <th>Details</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($bookDetails as $detail): ?>
                                        <tr>
                                            <td>
                                                <h6 class="mb-0"><?php echo htmlspecialchars($detail['BookTitle']); ?></h6>
                                                <small class="text-muted"><?php echo htmlspecialchars($detail['BookAuthor']); ?></small>
                                            </td>
                                            <td>
                                                <?php if ($detail['ISBN13']): ?>
                                                    ISBN-13: <?php echo htmlspecialchars($detail['ISBN13']); ?><br>
                                                <?php endif; ?>
                                                <?php if ($detail['ISBN10']): ?>
                                                    ISBN-10: <?php echo htmlspecialchars($detail['ISBN10']); ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($detail['Publisher']); ?>
                                                <?php if ($detail['PublishYear']): ?>
                                                    <small class="d-block text-muted"><?php echo $detail['PublishYear']; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($detail['Format']); ?></td>
                                            <td><?php echo htmlspecialchars($detail['Edition']); ?></td>
                                            <td>
                                                <?php if ($detail['PageCount']): ?>
                                                    <small class="d-block">Pages: <?php echo $detail['PageCount']; ?></small>
                                                <?php endif; ?>
                                                <?php if ($detail['Language']): ?>
                                                    <small class="d-block">Language: <?php echo htmlspecialchars($detail['Language']); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-soft-primary btn-sm edit-detail" 
                                                            data-id="<?php echo $detail['BookID']; ?>"
                                                            data-detail='<?php echo json_encode($detail); ?>'>
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-soft-danger btn-sm delete-detail" 
                                                            data-id="<?php echo $detail['DetailID']; ?>"
                                                            data-title="<?php echo htmlspecialchars($detail['BookTitle']); ?>">
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

    <!-- Book Detail Modal -->
    <div class="modal fade" id="bookDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Book Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="bookDetailForm">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="detail_id" id="detail_id">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Book</label>
                                <select class="form-select" name="book_id" id="book_id" required>
                                    <option value="">Select Book</option>
                                    <?php foreach ($books as $book): ?>
                                        <option value="<?php echo $book['BookID']; ?>">
                                            <?php echo htmlspecialchars($book['Title']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Publisher</label>
                                <input type="text" class="form-control" name="publisher" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Publish Year</label>
                                <input type="number" class="form-control" name="publish_year" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Edition</label>
                                <input type="text" class="form-control" name="edition">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Format</label>
                                <select class="form-select" name="format" required>
                                    <option value="Hardcover">Hardcover</option>
                                    <option value="Paperback">Paperback</option>
                                    <option value="Ebook">Ebook</option>
                                    <option value="Audiobook">Audiobook</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Page Count</label>
                                <input type="number" class="form-control" name="page_count">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Language</label>
                                <input type="text" class="form-control" name="language" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Weight (kg)</label>
                                <input type="number" class="form-control" name="weight" step="0.01">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Dimensions</label>
                                <input type="text" class="form-control" name="dimensions" placeholder="e.g., 8.5 x 11 inches">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ISBN-10</label>
                                <input type="text" class="form-control" name="isbn10" maxlength="10" pattern="[0-9X]{10}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">ISBN-13</label>
                                <input type="text" class="form-control" name="isbn13" pattern="[0-9-]{13,17}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3"></textarea>
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
    const detailModal = new bootstrap.Modal(document.getElementById('bookDetailModal'));
    
    // Form submission handler
    $('#bookDetailForm').on('submit', function(e) {
        e.preventDefault();
        
        // Collect all form data
        const formData = {
            action: $('input[name="action"]').val(),
            book_id: $('#book_id').val(),
            detail_id: $('#detail_id').val(),
            isbn10: $('input[name="isbn10"]').val(),
            isbn13: $('input[name="isbn13"]').val(),
            publisher: $('input[name="publisher"]').val(),
            publish_year: $('input[name="publish_year"]').val(),
            edition: $('input[name="edition"]').val(),
            page_count: $('input[name="page_count"]').val(),
            language: $('input[name="language"]').val(),
            format: $('select[name="format"]').val(),
            dimensions: $('input[name="dimensions"]').val(),
            weight: $('input[name="weight"]').val(),
            description: $('textarea[name="description"]').val()
        };

        $.ajax({
            url: 'attribute.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    detailModal.hide();
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

    // Edit button handler
    $('.edit-detail').click(function() {
        const detail = $(this).data('detail');
        $('#bookDetailForm')[0].reset();
        $('input[name="action"]').val('update');
        $('#detail_id').val(detail.DetailID);
        
        // Populate form fields
        $('#book_id').val(detail.BookID);
        $('input[name="isbn10"]').val(detail.ISBN10);
        $('input[name="isbn13"]').val(detail.ISBN13);
        $('input[name="publisher"]').val(detail.Publisher);
        $('input[name="publish_year"]').val(detail.PublishYear);
        $('input[name="edition"]').val(detail.Edition);
        $('input[name="page_count"]').val(detail.PageCount);
        $('input[name="language"]').val(detail.Language);
        $('select[name="format"]').val(detail.Format);
        $('input[name="dimensions"]').val(detail.Dimensions);
        $('input[name="weight"]').val(detail.Weight);
        $('input[name="preview_url"]').val(detail.PreviewURL);
        
        detailModal.show();
    });

    // Delete button handler
    $('.delete-detail').click(function() {
        const bookId = $(this).data('id');
        const bookTitle = $(this).data('title');
        
        Swal.fire({
            title: 'Delete Book Details',
            text: `Are you sure you want to delete details for "${bookTitle}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'attribute.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        detail_id: bookId  // bookId is actually detailId from data-id
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
            }
        });
    });

    // Reset form when opening for new entry
    $('.btn-primary[data-bs-toggle="modal"]').click(function() {
        $('#bookDetailForm')[0].reset();
        $('input[name="action"]').val('add');
        $('#detail_id').val('');
    });
});
</script>
</body>
</html>