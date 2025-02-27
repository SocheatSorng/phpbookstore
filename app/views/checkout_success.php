<?php $this->view("header", $data); ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-success mb-4">Payment Successful!</h2>
                        <p class="mb-4">Thank you for your purchase.</p>
                        <a href="<?=ROOT?>" class="btn btn-primary">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<html>

<head>
    <title>Order Confirmed</title>
</head>

<body>
    <h1>Order Confirmed</h1>
    <h2>Coming Soon</h2>


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Extract transaction id from URL, assuming it's passed as "tran_id"
        const urlParams = new URLSearchParams(window.location.search);
        const tran_id = urlParams.get("tran_id");

        if (tran_id) {
            fetch("<?= ROOT ?>checkout/finalizeOrder", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "tran_id=" + encodeURIComponent(tran_id)
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Finalize order response:", data);
                    if (data.payment_success) {
                        document.getElementById("order_status").innerText =
                            "Your order has been processed successfully. Order ID: " + data.order_id;
                    } else {
                        document.getElementById("order_status").innerText =
                            "Error processing your order: " + (data.error || "Unknown error");
                    }
                })
                .catch(err => {
                    console.error("Error finalizing order:", err);
                    document.getElementById("order_status").innerText = "Failed to process order.";
                });
        } else {
            document.getElementById("order_status").innerText = "Missing transaction ID.";
        }
    });
    </script>
</body>

</html>

<?php $this->view("footer", $data); ?>