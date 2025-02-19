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
                        'payment_data' => $payment_data
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

    function success() {
        $data['page_title'] = "Order Confirmed";
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
}