<?php
class Checkout extends Controller 
{
    private $payway;

    function index() {
        // Initialize cart in session if it doesn't exist
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [
                [
                    'id' => 1,
                    'name' => 'Test Product',
                    'price' => 10.00,
                    'quantity' => 1,
                    'image' => ASSETS . 'images/product-item1.png'
                ]
            ];
        }

        $this->payway = $this->loadModel('PaywayModel');
    $data['page_title'] = "Checkout";
    
    // Calculate totals
    $data['subtotal'] = $this->calculateTotal($_SESSION['cart']);
    $data['total'] = $data['subtotal'];

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            // AJAX request
            $errors = $this->validateCheckoutForm($_POST);
            
            if(empty($errors)) {
                $order_id = 'ORDER-' . uniqid();

                $payment_data = [
                    'order_id' => $order_id,
                    'total' => $data['total'],
                    'items' => $_SESSION['cart'],
                    'firstname' => trim($_POST['firstname']),
                    'lastname' => trim($_POST['lastname']),
                    'email' => trim($_POST['email']),
                    'phone' => trim($_POST['phone'])
                ];

                $payway_result = $this->payway->createTransaction($payment_data);
                
                if(isset($payway_result['success']) && $payway_result['success']) {
                    echo json_encode([
                        'success' => true,
                        'form_data' => $payway_result['form_data']
                    ]);
                } else {
                    error_log("PayWay Controller Error - Result: " . print_r($payway_result, true));
                    echo json_encode([
                        'success' => false,
                        'error' => $payway_result['error'] ?? 'Payment initialization failed'
                    ]);
                }
                exit;
            } else {
                echo json_encode([
                    'success' => false,
                    'errors' => $errors
                ]);
                exit;
            }
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
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $payment_result = $this->payway->handleCallback($_POST);
            
            if($payment_result['success']) {
                // Clear cart
                unset($_SESSION['cart']);

                // Redirect to success page
                header("Location: " . ROOT . "checkout/success");
                exit;
            }
        }

        // If callback processing fails, redirect to error page
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
            $errors['firstname'] = "First name is required";
        }

        if(empty($post['lastname'])) {
            $errors['lastname'] = "Last name is required";
        }

        if(empty($post['email']) || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Valid email is required";
        }

        if(empty($post['phone'])) {
            $errors['phone'] = "Phone number is required";
        } else {
            // Check if phone number is valid Cambodian format
            $phone = preg_replace('/[^0-9]/', '', $post['phone']);
            if (!preg_match('/^(0|855)?[1-9][0-9]{7,8}$/', $phone)) {
                $errors['phone'] = "Please enter a valid phone number (e.g., 012345678 or 855123456789)";
            }
        }

        if(empty($post['address'])) {
            $errors['address'] = "Address is required";
        }

        if(empty($post['city'])) {
            $errors['city'] = "City is required";
        }

        if(empty($post['country'])) {
            $errors['country'] = "Country is required";
        }

        if(empty($post['zipcode'])) {
            $errors['zipcode'] = "ZIP code is required";
        }

        return $errors;
    }

    private function calculateTotal($cart_items) {
        if(!is_array($cart_items)) {
            return 0;
        }
        
        $total = 0;
        foreach($cart_items as $item) {
            if(isset($item['price']) && isset($item['quantity'])) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        return $total;
    }
    
}