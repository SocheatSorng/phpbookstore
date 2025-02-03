<?php
class PaywayModel
{
    private $merchant_id;
    private $api_key;
    private $api_url;

    public function __construct() {
        // Use same credentials as working example
        $this->merchant_id = "ec439117";  
        $this->api_key = "6603f4de5eba4cda38d1004ea74bcfce2ada4d83";
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

    public function createTransaction($order_data) {
        try {
            $req_time = time();
            $tran_id = time();
            
            // Validate required fields
            if(empty($order_data['total']) || empty($order_data['firstname']) || 
               empty($order_data['lastname']) || empty($order_data['email']) || 
               empty($order_data['phone'])) {
                error_log("PayWay Error: Missing required fields");
                return false;
            }

            // Format phone number
            $phone = $this->formatPhoneNumber($order_data['phone']);
            
            // Ensure proper number formatting for amount
            $amount = number_format((float)$order_data['total'], 2, '.', '');
            
            $form_data = [
                'hash' => '',
                'tran_id' => $tran_id,
                'amount' => $amount,
                'firstname' => trim($order_data['firstname']),
                'lastname' => trim($order_data['lastname']),
                'phone' => $phone,
                'email' => trim($order_data['email']),
                'return_params' => 'Hello World!',
                'merchant_id' => $this->merchant_id,
                'req_time' => $req_time
            ];

            // Generate hash string
            $hash_string = $req_time . 
                          $this->merchant_id . 
                          $tran_id . 
                          $form_data['amount'] . 
                          $form_data['firstname'] . 
                          $form_data['lastname'] . 
                          $form_data['email'] . 
                          $form_data['phone'] . 
                          $form_data['return_params'];

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
}