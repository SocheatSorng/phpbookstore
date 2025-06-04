<?php $this->view("header", $data); ?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">My Orders</h2>
                
                <?php if (empty($data['orders'])): ?>
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-shopping-bag" style="font-size: 4rem; color: #ccc;"></i>
                        </div>
                        <h4>No Orders Found</h4>
                        <p class="text-muted">You haven't placed any orders yet.</p>
                        <a href="<?=ROOT?>shop" class="btn btn-primary">Start Shopping</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $current_order_id = null;
                                $order_items = [];
                                $order_total = 0;
                                
                                foreach ($data['orders'] as $order): 
                                    if ($current_order_id !== $order['OrderID']):
                                        // Display previous order if exists
                                        if ($current_order_id !== null):
                                ?>
                                    <tr>
                                        <td>#<?= $current_order_id ?></td>
                                        <td><?= date('M j, Y', strtotime($order_date)) ?></td>
                                        <td>
                                            <?php foreach ($order_items as $item): ?>
                                                <div class="small">
                                                    <?= htmlspecialchars($item['BookTitle']) ?> 
                                                    <span class="text-muted">(<?= $item['Quantity'] ?>x)</span>
                                                </div>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>$<?= number_format($order_total, 2) ?></td>
                                        <td>
                                            <span class="badge bg-<?= getStatusColor($order_status) ?>">
                                                <?= ucfirst($order_status) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="viewOrderDetails(<?= $current_order_id ?>)">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                <?php 
                                        endif;
                                        
                                        // Start new order
                                        $current_order_id = $order['OrderID'];
                                        $order_date = $order['OrderDate'];
                                        $order_status = $order['Status'];
                                        $order_total = $order['TotalAmount'];
                                        $order_items = [];
                                    endif;
                                    
                                    // Add item to current order
                                    $order_items[] = [
                                        'BookTitle' => $order['BookTitle'],
                                        'Quantity' => $order['Quantity']
                                    ];
                                endforeach;
                                
                                // Display last order
                                if ($current_order_id !== null):
                                ?>
                                    <tr>
                                        <td>#<?= $current_order_id ?></td>
                                        <td><?= date('M j, Y', strtotime($order_date)) ?></td>
                                        <td>
                                            <?php foreach ($order_items as $item): ?>
                                                <div class="small">
                                                    <?= htmlspecialchars($item['BookTitle']) ?> 
                                                    <span class="text-muted">(<?= $item['Quantity'] ?>x)</span>
                                                </div>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>$<?= number_format($order_total, 2) ?></td>
                                        <td>
                                            <span class="badge bg-<?= getStatusColor($order_status) ?>">
                                                <?= ucfirst($order_status) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="viewOrderDetails(<?= $current_order_id ?>)">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                <!-- Order details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function viewOrderDetails(orderId) {
    // You can implement this to show order details in a modal
    alert('Order details for Order #' + orderId + ' - Feature coming soon!');
}

<?php
function getStatusColor($status) {
    switch(strtolower($status)) {
        case 'pending': return 'warning';
        case 'processing': return 'info';
        case 'shipped': return 'primary';
        case 'delivered': return 'success';
        case 'cancelled': return 'danger';
        default: return 'secondary';
    }
}
?>
</script>

<?php $this->view("footer", $data); ?>
