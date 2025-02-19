<?php
/*
|--------------------------------------------------------------------------
| ABA PayWay API URL
|--------------------------------------------------------------------------
| API URL that is provided by Payway must be required in your post form
|
*/
define('ABA_PAYWAY_API_URL', 'https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/purchase');

/*
|--------------------------------------------------------------------------
| ABA PayWay API KEY
|--------------------------------------------------------------------------
| API KEY that is generated and provided by PayWay must be required in your post form
|
*/
define('ABA_PAYWAY_API_KEY', '8ccf9c9ae9d0d34f68498ffe60b5e48101535cb2');

/*
|--------------------------------------------------------------------------
| ABA PayWay MERCHANT ID
|--------------------------------------------------------------------------
| MERCHANT ID that is generated and provided by PayWay must be required in your post form
|
*/
define('ABA_PAYWAY_MERCHANT_ID', 'ec438740');

class PayWayApiCheckout {

    /**
     * Returns the getHash
     * For Payway security, you must follow the way of encryption for hash.
     * 
     * @param string $transactionId
     * @param string $amount
     * 
     * @return string getHash
     */

    public static function getHash($str) {
        // Log input string for debugging
        error_log("Input string for hash: " . $str);
        
        // Remove any whitespace
        $str = trim($str);
        
        // Generate hash
        $hash = hash_hmac('sha512', $str, ABA_PAYWAY_API_KEY, true);
        $encodedHash = base64_encode($hash);
        
        // Log generated hash
        error_log("Generated hash: " . $encodedHash);
        
        return $encodedHash;
     }

     /**
      * Returns the getApiUrl
      *
      * @return string getApiUrl
      */

    public static function getApiUrl() {
        return ABA_PAYWAY_API_URL;
    }
}