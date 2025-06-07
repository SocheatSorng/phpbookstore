<?php $this->view("header", $data); ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <!-- Loading State -->
                        <div id="loading_state" class="mb-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Processing...</span>
                            </div>
                            <h3 class="mt-3">Processing your order...</h3>
                            <p class="text-muted">Please wait while we confirm your payment.</p>
                        </div>

                        <!-- Success State -->
                        <div id="success_state" class="mb-4" style="display: none;">
                            <div class="text-success mb-3">
                                <i class="fas fa-check-circle" style="font-size: 4rem;"></i>
                            </div>
                            <h2 class="text-success mb-3">Payment Successful!</h2>
                            <div class="alert alert-success">
                                <h5>Order Confirmed</h5>
                                <p id="order_details" class="mb-0">Your order has been processed successfully.</p>
                            </div>
                            <div class="mt-4">
                                <a href="<?=ROOT?>home" class="btn btn-primary me-2">Continue Shopping</a>
                                <a href="<?=ROOT?>user/orders" class="btn btn-outline-primary">View Orders</a>
                            </div>
                        </div>

                        <!-- Error State -->
                        <div id="error_state" class="mb-4" style="display: none;">
                            <div class="text-danger mb-3">
                                <i class="fas fa-exclamation-triangle" style="font-size: 4rem;"></i>
                            </div>
                            <h2 class="text-danger mb-3">Payment Processing Error</h2>
                            <div class="alert alert-danger">
                                <h5>Order Processing Failed</h5>
                                <p id="error_details" class="mb-0">There was an issue processing your order.</p>
                            </div>
                            <div class="mt-4">
                                <a href="<?=ROOT?>cart" class="btn btn-primary me-2">Return to Cart</a>
                                <a href="<?=ROOT?>contact" class="btn btn-outline-primary">Contact Support</a>
                            </div>
                        </div>

                        <!-- Order Status Display -->
                        <div id="order_status" class="mt-3" style="display: none;">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Order Summary</h5>
                                </div>
                                <div class="card-body" id="order_summary">
                                    <!-- Order details will be populated here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Extract transaction id from URL
    const urlParams = new URLSearchParams(window.location.search);
    const tran_id = urlParams.get("tran_id");

    const loadingState = document.getElementById("loading_state");
    const successState = document.getElementById("success_state");
    const errorState = document.getElementById("error_state");
    const orderStatus = document.getElementById("order_status");
    const orderDetails = document.getElementById("order_details");
    const errorDetails = document.getElementById("error_details");
    const orderSummary = document.getElementById("order_summary");

    function showSuccess(data) {
        loadingState.style.display = "none";
        successState.style.display = "block";

        if (data.order_id) {
            orderDetails.innerHTML = `Your order has been processed successfully.<br><strong>Order ID: #${data.order_id}</strong>`;

            // Show order summary if available
            if (data.order_summary) {
                orderStatus.style.display = "block";
                orderSummary.innerHTML = data.order_summary;
            }
        }
    }

    function showError(message) {
        loadingState.style.display = "none";
        errorState.style.display = "block";
        errorDetails.textContent = message || "Unknown error occurred";
    }

    if (tran_id) {
        console.log("Making request to:", "<?= ROOT ?>checkout/finalizeOrder");
        console.log("Transaction ID:", tran_id);

        // Make the API call to finalize the order
        fetch("<?= ROOT ?>checkout/finalizeOrder", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "tran_id=" + encodeURIComponent(tran_id)
            })
            .then(response => {
                console.log("Response status:", response.status);
                console.log("Response headers:", response.headers);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                // Get the response text first to debug
                return response.text().then(text => {
                    console.log("Raw response text:", text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error("JSON parse error:", e);
                        console.error("Response text that failed to parse:", text);
                        throw new Error("Invalid JSON response: " + text.substring(0, 100));
                    }
                });
            })
            .then(data => {
                console.log("Finalize order response:", data);

                if (data.payment_success) {
                    showSuccess(data);
                } else {
                    showError(data.error || "Payment verification failed");
                }
            })
            .catch(err => {
                console.error("Error finalizing order:", err);
                showError("Failed to process order. Please contact support if this issue persists.");
            });
    } else {
        showError("Missing transaction ID. Please contact support.");
    }
});
</script>

<?php $this->view("footer", $data); ?>