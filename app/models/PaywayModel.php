<?php

class PaywayModel
{
    private $merchant_id;
    private $api_key;
    private $api_url;

    public function __construct() {
        $this->merchant_id = "ec438740";  
        $this->api_key = "8ccf9c9ae9d0d34f68498ffe60b5e48101535cb2";
        $this->api_url = "https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/purchase";
    }

    private function formatPhoneNumber($phone) {
        // Remove any non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If starts with 0, remove it
        if (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }
        
        // If doesn't start with 855, add it
        if (substr($phone, 0, 3) !== '855') {
            $phone = '855' . $phone;
        }
        
        return $phone;
    }

    // Replace your current createTransaction method with this updated version:
    public function createTransaction($order_data) {
        try {
            $req_time = time();
            $tran_id = time();
            
            // Format values
            $amount = number_format((float)$order_data['total'], 2, '.', '');
            $phone = $this->formatPhoneNumber($order_data['phone']);
            
            // First prepare all form data
            $form_data = [
                'req_time' => $req_time,
                'merchant_id' => $this->merchant_id,
                'tran_id' => $tran_id,
                'amount' => $amount,
                'firstname' => trim($order_data['firstname']),
                'lastname' => trim($order_data['lastname']),
                'email' => trim($order_data['email']),
                'phone' => $phone,
                'return_url' => base64_encode('http://localhost:8887/phpbookstore/public/checkout/payment_callback'),
                'continue_success_url' => 'http://localhost:8887/phpbookstore/public/checkout/success?tran_id=' . $tran_id, // Add tran_id
                'return_params' => 'Hello World!'
            ];

            // Create hash string including ALL parameters in correct order
            $hash_string = $form_data['req_time'] . 
                        $form_data['merchant_id'] . 
                        $form_data['tran_id'] . 
                        $form_data['amount'] . 
                        $form_data['firstname'] . 
                        $form_data['lastname'] . 
                        $form_data['email'] . 
                        $form_data['phone'] . 
                        $form_data['return_url'] . 
                        $form_data['continue_success_url'] . 
                        $form_data['return_params'];

            // Add hash to form data
            $form_data['hash'] = base64_encode(hash_hmac('sha512', $hash_string, $this->api_key, true));
            
            error_log("PayWay Debug - Form Data: " . print_r($form_data, true));
            
            return [
                'success' => true,
                'form_data' => $form_data
            ];
            
        } catch (Exception $e) {
            error_log("PayWay Error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    public function verifyTransaction($tran_id) {
        $req_time = time();
        $hash = base64_encode(hash_hmac('sha512', 
            $req_time . $this->merchant_id . $tran_id, 
            $this->api_key, 
            true
        ));

        $check_url = 'https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/check-transaction';
        
        $data = [
            'req_time' => $req_time,
            'merchant_id' => $this->merchant_id,
            'tran_id' => $tran_id,
            'hash' => $hash
        ];

        // Make API call to verify transaction
        $ch = curl_init($check_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function validateCallback($data) {
        // Verify the transaction status from PayWay

        error_log("PayWay Callback Data: " . print_r($data, true));

        if(empty($data['tran_id']) || empty($data['status'])) {
            return false;
        }

        $transaction = $this->verifyTransaction($data['tran_id']);
        
        if(!$transaction || $transaction['status'] != 0) {
            return false;
        }

        return true;
    }
}