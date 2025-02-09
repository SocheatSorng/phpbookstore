<?php 
include 'includes/header.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

// Fetch dashboard statistics
try {
    $stmt = $conn->prepare("CALL sp_GetDashboardStats()");
    $stmt->execute();
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error fetching statistics: " . $e->getMessage());
}
?>

<body>
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:book-bold-duotone" class="avatar-title fs-32 text-primary"></iconify-icon>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="text-muted mb-0 text-truncate">Books</p>
                                        <h3 class="text-dark mt-1 mb-0"><?php echo number_format($stats['TotalBooks']); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-2 bg-light">
                                <a href="product" class="text-reset fw-semibold fs-12">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:clipboard-list-bold-duotone" class="avatar-title fs-32 text-primary"></iconify-icon>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="text-muted mb-0 text-truncate">Categories</p>
                                        <h3 class="text-dark mt-1 mb-0"><?php echo number_format($stats['TotalCategories']); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-2 bg-light">
                                <a href="category" class="text-reset fw-semibold fs-12">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="avatar-title fs-32 text-primary"></iconify-icon>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="text-muted mb-0 text-truncate">Users</p>
                                        <h3 class="text-dark mt-1 mb-0"><?php echo number_format($stats['TotalUsers']); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-2 bg-light">
                                <a href="user" class="text-reset fw-semibold fs-12">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:bag-smile-bold-duotone" class="avatar-title fs-32 text-primary"></iconify-icon>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="text-muted mb-0 text-truncate">Orders</p>
                                        <h3 class="text-dark mt-1 mb-0"><?php echo number_format($stats['TotalOrders']); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-2 bg-light">
                                <a href="order" class="text-reset fw-semibold fs-12">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:card-send-bold-duotone" class="avatar-title fs-32 text-primary"></iconify-icon>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="text-muted mb-0 text-truncate">Purchases</p>
                                        <h3 class="text-dark mt-1 mb-0"><?php echo number_format($stats['TotalPurchases']); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-2 bg-light">
                                <a href="purchase" class="text-reset fw-semibold fs-12">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-soft-success rounded">
                                            <iconify-icon icon="solar:dollar-minimalistic-bold-duotone" class="avatar-title fs-32 text-success"></iconify-icon>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="text-muted mb-0 text-truncate">Revenue</p>
                                        <h3 class="text-dark mt-1 mb-0">$<?php echo number_format($stats['TotalRevenue'], 2); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-2 bg-light">
                                <span class="text-muted fw-semibold fs-12">From Orders</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Container Fluid -->

<?php include 'includes/footer.php'; ?>