<?php
class Checkout extends Controller 
{
    private $payway;

    function index() {
    $this->payway = $this->loadModel('PaywayModel');
    $data['page_title'] = "Checkout";
    
    // Get cart items before checking
    $cartModel = $this->loadModel('CartModel');
    $cart_items = $cartModel->getCartItems();
    $data['cart_items'] = $cart_items;

    // Calculate totals
    $data['subtotal'] = 0;
    foreach($cart_items as $item) {
        $data['subtotal'] += $item['Price'] * $item['Quantity'];
    }
    $data['total'] = $data['subtotal'];

    // Redirect if cart is empty
    if(empty($cart_items)) {
        header("Location: " . ROOT . "cart");
        exit;
    }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        // AJAX request
        $errors = $this->validateCheckoutForm($_POST);
        
        if(empty($errors)) {
            try {
                $order_id = 'ORDER-' . uniqid();

                $shipping_address = sprintf("%s\n%s\n%s %s\n%s",
                    $_POST['address'],
                    $_POST['city'],
                    $_POST['country'],
                    $_POST['zipcode'],
                    $_POST['phone']
                );

                $payment_data = [
                    'total' => $data['subtotal'],    // Changed from 'amount' to 'total' to match model
                    'firstname' => trim($_POST['firstname']), // Split customer_name into firstname/lastname
                    'lastname' => trim($_POST['lastname']),
                    'email' => trim($_POST['email']),
                    'phone' => trim($_POST['phone'])
                ];
                

                $payway_result = $this->payway->createTransaction($payment_data);
                
                if(isset($payway_result['success']) && $payway_result['success']) {
                    $_SESSION['pending_order'] = [
                    'order_id' => $order_id,
                    'payment_data' => $payment_data,
                    'shipping_address' => sprintf("%s\n%s\n%s %s",
                        $_POST['address'],
                        $_POST['city'],
                        $_POST['country'],
                        $_POST['zipcode']
                    )
                ];

                    echo json_encode([
                        'success' => true,
                        'form_data' => $payway_result['form_data']
                    ]);
                } else {
                    error_log("PayWay Error: " . print_r($payway_result, true));
                    echo json_encode([
                        'success' => false,
                        'error' => $payway_result['error'] ?? 'Payment gateway error'
                    ]);
                }
            } catch (Exception $e) {
                error_log("Checkout Error: " . $e->getMessage());
                echo json_encode([
                    'success' => false,
                    'error' => 'An error occurred while processing your order'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'errors' => $errors
            ]);
        }
        exit;
    }

            // Regular form submission
            $errors = $this->validateCheckoutForm($_POST);
            if(!empty($errors)) {
                $data['errors'] = $errors;
            }
        }

        $this->view("checkout", $data);
    }

    function confirm() {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['pending_order'])) {
            $payment_result = $this->payway->handleCallback($_POST);
            
            if($payment_result['success']) {
                // Clear cart after successful payment
                if(isset($_SESSION['user'])) {
                    // Load CartModel to clear database cart
                    $cartModel = $this->loadModel('CartModel');
                    if($cartModel) {
                        $cartModel->clearCart($_SESSION['user']['UserID']);
                    }
                }
                // Clear session cart
                unset($_SESSION['cart']);
                // Clear pending order
                unset($_SESSION['pending_order']);

                header("Location: " . ROOT . "checkout/success");
                exit;
            }
        }

        // If callback processing fails
        header("Location: " . ROOT . "checkout/error");
        exit;
    }

    // In checkout.php success method
    public function success() {
        $data['page_title'] = "Order Confirmed";
        $tran_id = $_GET['tran_id'] ?? null;

        error_log("Success page accessed with tran_id: " . $tran_id);
        error_log("Session pending_order exists: " . (isset($_SESSION['pending_order']) ? 'yes' : 'no'));

        // Set default state - will be updated by JavaScript if transaction processing succeeds
        $data['payment_success'] = false;
        $data['show_processing'] = true;

        if(!$tran_id) {
            $data['error'] = 'Missing transaction ID';
            $data['show_processing'] = false;
        }

        $this->view("checkout_success", $data);
    }

    // Legacy success method - keeping for backward compatibility
    public function success_old() {
        $data['page_title'] = "Order Confirmed";
        $tran_id = $_GET['tran_id'] ?? null;

        error_log("Transaction ID: " . $tran_id);

        if($tran_id && isset($_SESSION['pending_order'])) {
            $payway = $this->loadModel('PaywayModel');
            $transaction = $payway->verifyTransaction($tran_id);

            error_log("PayWay Transaction Result: " . print_r($transaction, true));

            if($transaction && isset($transaction['status']) && $transaction['status'] == 0) {
                $orderModel = $this->loadModel('OrderModel');
                $cartModel = $this->loadModel('CartModel');
                
                try {
                    // Get cart items for order details
                    $cart_items = $cartModel->getCartItems();
                    
                    // Get payment data from session
                    $payment_data = $_SESSION['pending_order']['payment_data'];
                    
                    // Format shipping address from session data
                    $shipping_address = sprintf("%s\n%s\n%s %s",
                        $payment_data['address'] ?? '',
                        $payment_data['city'] ?? '',
                        $payment_data['country'] ?? '',
                        $payment_data['zipcode'] ?? ''
                    );

                    // Create order data
                    $order_data = [
                        'UserID' => $_SESSION['user']['UserID'] ?? null,
                        'TotalAmount' => $transaction['amount'],
                        'Status' => 'processing',
                        'ShippingAddress' => $shipping_address,
                        'PaymentMethod' => 'PayWay'
                    ];

                    error_log("Creating Order with data: " . print_r($order_data, true));

                    // Create order and get OrderID
                    $order_id = $orderModel->createOrder($order_data);
                    
                    // Add order details for each cart item
                    foreach($cart_items as $item) {
                        $orderModel->addOrderDetail([
                            'OrderID' => $order_id,
                            'BookID' => $item['BookID'],
                            'Quantity' => $item['Quantity'],
                            'Price' => $item['Price']
                        ]);
                    }
                    
                    // Clear both session and database cart
                    if (isset($_SESSION['user'])) {
                        $cartModel->clearCart($_SESSION['user']['UserID']);
                    }
                    // Always clear session cart
                    unset($_SESSION['cart']);
                    // Clear pending order
                    unset($_SESSION['pending_order']);
                    
                    $data['payment_success'] = true;
                    $data['order_id'] = $order_id;
                } catch(Exception $e) {
                    error_log("Order Creation Error: " . $e->getMessage());
                    $data['payment_success'] = false;
                    $data['error'] = $e->getMessage();
                }
            } else {
                $data['payment_success'] = false;
                $data['error'] = 'Invalid transaction';
            }
        } else {
            $data['payment_success'] = false;
            $data['error'] = 'Missing transaction ID or pending order';
        }
        
        $this->view("checkout_success", $data);
    }

    function error() {
        $data['page_title'] = "Payment Failed";
        $this->view("checkout_error", $data);
    }

    private function validateCheckoutForm($post) {
        $errors = [];

        if(empty($post['firstname'])) {
            $errors[] = "First name is required";
        }

        if(empty($post['lastname'])) {
            $errors[] = "Last name is required";
        }

        if(empty($post['email']) || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email is required";
        }

        if(empty($post['phone'])) {
            $errors[] = "Phone number is required";
        } else {
            // Check if phone number is valid Cambodian format
            $phone = preg_replace('/[^0-9]/', '', $post['phone']);
            if (!preg_match('/^(0|855)?[1-9][0-9]{7,8}$/', $phone)) {
                $errors[] = "Please enter a valid phone number (e.g., 012345678 or 855123456789)";
            }
        }

        if(empty($post['address'])) {
            $errors[] = "Address is required";
        }

        if(empty($post['city'])) {
            $errors[] = "City is required";
        }

        if(empty($post['country'])) {
            $errors[] = "Country is required";
        }

        if(empty($post['zipcode'])) {
            $errors[] = "ZIP code is required";
        }

        return $errors;
    }
    public function finalizeOrder() {
        // Ensure clean output - no whitespace or other content before JSON
        ob_clean();
        header('Content-Type: application/json');

        $response = ['payment_success' => false];
        $tran_id = $_POST['tran_id'] ?? null;

        error_log("FinalizeOrder called with tran_id: " . $tran_id);
        error_log("Session pending_order exists: " . (isset($_SESSION['pending_order']) ? 'yes' : 'no'));
        error_log("Server environment: " . ($_SERVER['SERVER_NAME'] ?? 'unknown'));

        if(!$tran_id) {
            $response['error'] = 'Missing transaction ID';
            echo json_encode($response);
            exit;
        }

        if(!isset($_SESSION['pending_order'])) {
            $response['error'] = 'No pending order found. Order may have already been processed.';
            echo json_encode($response);
            exit;
        }

        try {
            $payway = $this->loadModel('PaywayModel');
            $transaction = $payway->verifyTransaction($tran_id);

            error_log("Transaction verification result: " . print_r($transaction, true));

            if($transaction && isset($transaction['status']) && $transaction['status'] == 0) {
                $orderModel = $this->loadModel('OrderModel');
                $cartModel = $this->loadModel('CartModel');
                
                try {
                    // Get cart items for order details
                    $cart_items = $cartModel->getCartItems();
                    
                    // Get payment data from session
                    $payment_data = $_SESSION['pending_order']['payment_data'];
                    
                    // Format shipping address
                    $shipping_address = sprintf("%s\n%s\n%s %s",
                        $payment_data['address'] ?? '',
                        $payment_data['city'] ?? '',
                        $payment_data['country'] ?? '',
                        $payment_data['zipcode'] ?? ''
                    );
                    
                    // Create order data
                    $order_data = [
                        'UserID' => $_SESSION['user']['UserID'] ?? null,
                        'TotalAmount' => $transaction['amount'],
                        'Status' => 'processing',
                        'ShippingAddress' => $shipping_address,
                        'PaymentMethod' => 'PayWay'
                    ];
        
                    // Create order and get OrderID
                    $order_id = $orderModel->createOrder($order_data);
                    
                    // Add order details for each cart item
                    foreach($cart_items as $item) {
                        $orderModel->addOrderDetail([
                            'OrderID' => $order_id,
                            'BookID' => $item['BookID'],
                            'Quantity' => $item['Quantity'],
                            'Price' => $item['Price']
                        ]);
                    }
                    
                    // Clear cart using CartModel method
                    $userId = $_SESSION['user']['UserID'] ?? null;
                    if($userId) {
                        $cartModel->clearCart($userId);
                    }

                    // Clear session cart
                    unset($_SESSION['cart']);

                    // Build order summary for display
                    $order_summary_html = $this->buildOrderSummaryHTML($cart_items, $order_data['TotalAmount']);

                    // Clear pending order
                    unset($_SESSION['pending_order']);

                    $response = [
                        'payment_success' => true,
                        'order_id' => $order_id,
                        'order_summary' => $order_summary_html,
                        'total_amount' => $order_data['TotalAmount']
                    ];

                } catch(Exception $e) {
                    error_log("Order Creation Error: " . $e->getMessage());
                    $response['error'] = $e->getMessage();
                }
            } else {
                $response['error'] = 'Payment verification failed. Transaction status: ' . ($transaction['status'] ?? 'unknown');
            }

        } catch(Exception $e) {
            error_log("FinalizeOrder Exception: " . $e->getMessage());
            error_log("Exception trace: " . $e->getTraceAsString());
            $response['error'] = 'An error occurred while processing your order: ' . $e->getMessage();
        }

        // Ensure we always return valid JSON
        $json_response = json_encode($response);
        if ($json_response === false) {
            error_log("JSON encoding failed: " . json_last_error_msg());
            $json_response = json_encode(['payment_success' => false, 'error' => 'Internal server error']);
        }

        echo $json_response;
        exit;
    }

    private function buildOrderSummaryHTML($cart_items, $total_amount) {
        $html = '<div class="order-summary">';
        $html .= '<table class="table table-sm">';
        $html .= '<thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>';
        $html .= '<tbody>';

        foreach($cart_items as $item) {
            $subtotal = $item['Price'] * $item['Quantity'];
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($item['Title'] ?? 'Unknown Book') . '</td>';
            $html .= '<td>' . $item['Quantity'] . '</td>';
            $html .= '<td>$' . number_format($item['Price'], 2) . '</td>';
            $html .= '<td>$' . number_format($subtotal, 2) . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '<tfoot>';
        $html .= '<tr class="table-active"><th colspan="3">Total</th><th>$' . number_format($total_amount, 2) . '</th></tr>';
        $html .= '</tfoot>';
        $html .= '</table>';
        $html .= '</div>';

        return $html;
    }
}