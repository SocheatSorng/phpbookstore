<!DOCTYPE html>
<html lang="en">

<head>
    <title>PayWay Checkout Sample</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="author" content="PayWay">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            padding: 20px;
            text-align: center;
        }
        .aba_modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .aba_modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 5px;
            max-width: 500px;
        }
        #checkout_button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        #checkout_button:hover {
            background-color: #45a049;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .payment-options {
            text-align: center;
            margin: 20px auto;
            max-width: 500px;
        }
        .qr-code {
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .qr-code img {
            max-width: 200px;
            margin: 0 auto;
        }
        .app-links {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .app-links a {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <!-- PayWay container -->
    <div id="payway-container"></div>

    <div id="aba_main_modal" class="aba_modal">
        <div class="aba_modal-content">
            <!-- Include PHP class -->
             <?php
            require_once 'PayWayApiCheckout.php';
            $item[0]['name'] = 'test1';
            $item[0]['quantity'] = '1';
            $item[0]['price'] = '10.00';

            $item[1]['name'] = 'test2';
            $item[1]['quantity'] = '1';
            $item[1]['price'] = '10.00';

            $items = base64_encode(json_encode($item));
            $req_time = time();
            $merchant_id = "ec439117";
            $transactionId = time();
            $amount = '15.00';
            $firstName = 'Sastra';
            $lastName = 'Thach';
            $phone = '092472657';
            $email = 'Thachsastra@gmail.com';
            $return_params = "Hello World";
            $type = "purchase";
            $payment_option = "bakong";
            $currency = "USD";
            $shipping = '0.60';
?>

            <form method="POST" target="aba_webservice" action="<?php echo PayWayApiCheckout::getApiUrl(); ?>"
                id="aba_merchant_request">
                <input type="hidden" name="hash" value="<?php echo PayWayApiCheckout::getHash($req_time . $merchant_id . $transactionId . $amount . $items . $shipping . $firstName . $lastName . $email . $phone . $type .$payment_option . $currency . $return_params); ?>" id="hash" />
                <input type="hidden" name="tran_id" value="<?php echo $transactionId; ?>" id="tran_id" />
                <input type="hidden" name="amount" value="<?php echo $amount; ?>" id="amount" />
                <input type="hidden" name="firstname" value="<?php echo $firstName; ?>">
                <input type="hidden" name="lastname" value="<?php echo $lastName; ?>">
                <input type="hidden" name="phone" value="<?php echo $phone; ?>">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="hidden" name="items" value="<?php echo $items; ?>" id="items" />
                <input type="hidden" name="return_params" value="<?php echo $return_params; ?>">
                <input type="hidden" name="shipping" value="<?php echo $shipping; ?>">
                <input type="hidden" name="payment_option" value="<?php echo $payment_option; ?>">
                <input type="hidden" name="currency" value="<?php echo $currency; ?>">
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>">
                <input type="hidden" name="req_time" value="<?php echo $req_time; ?>">
                <input type="hidden" name="return_param" value="<?php echo $return_params; ?>">
            </form>
        </div>
    </div>
    <div class="container" style="margin-top: 75px;margin: 0 auto;">
        <div style="width: 200px;margin: 0 auto;">
            <h2>Total: $0.00</h2>
            <input type="button" id="checkout_button" value="Checkout Now">
        </div>
    </div>
    <div class="payment-options" id="payment-section" style="display:none;">
        <h3>Scan QR Code to Pay</h3>
        <div class="qr-code" id="qr-container"></div>
        <div class="app-links">
            <a href="#" id="app-store-link" target="_blank">Download iOS App</a>
            <a href="#" id="play-store-link" target="_blank">Download Android App</a>
        </div>
    </div>
    <!-- Move all scripts to end of body -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
        // Initialize PayWay configuration
        window.AbaPaywayConfig = {
            form: 'aba_merchant_request',
            container: 'payway-container',
            api_key: '<?php echo ABA_PAYWAY_API_KEY; ?>',
            enable_log: true,
            allow_card: true,
            allow_abapay: true
        };
    </script>
    <script src="https://checkout.payway.com.kh/plugins/checkout2-0.js"></script>
    <script>
        $(document).ready(function() {
            var paywayLoaded = false;
            var checkoutInProgress = false;

            function initPayWay() {
                return new Promise((resolve, reject) => {
                    var maxAttempts = 50; // 5 seconds
                    var attempts = 0;
                    var checkPayWay = setInterval(function() {
                        attempts++;
                        if (typeof AbaPayway !== 'undefined') {
                            clearInterval(checkPayWay);
                            paywayLoaded = true;
                            console.log('PayWay loaded successfully');
                            resolve(true);
                        } else if (attempts >= maxAttempts) {
                            clearInterval(checkPayWay);
                            reject(new Error('PayWay failed to load'));
                        }
                    }, 100);
                });
            }

            // Initialize PayWay
            initPayWay().catch(function(error) {
                console.error('PayWay initialization failed:', error);
            });

            $('#checkout_button').click(async function () {
                if (!paywayLoaded) {
                    alert('Payment system is still loading. Please try again in a moment.');
                    return;
                }

                if (checkoutInProgress) {
                    return;
                }

                checkoutInProgress = true;
                $('#checkout_button').prop('disabled', true);
                $('#payment-section').hide();

                try {
                    console.log('Initiating payment...');
                    const response = await new Promise((resolve, reject) => {
                        try {
                            AbaPayway.checkout(function(response) {
                                resolve(response);
                            });
                        } catch (e) {
                            reject(e);
                        }
                    });

                    console.log('Payment response:', response);
                    if(response && response.status && response.status.code === "00") {
                        $('#qr-container').html(`<img src="${response.qrImage}" alt="Payment QR Code"/>`);
                        $('#app-store-link').attr('href', response.app_store);
                        $('#play-store-link').attr('href', response.play_store);
                        $('#payment-section').show();
                    } else {
                        throw new Error(response?.status?.message || 'Payment failed');
                    }
                } catch (e) {
                    console.error('Payment error:', e);
                    alert('Payment system error: ' + e.message);
                } finally {
                    checkoutInProgress = false;
                    $('#checkout_button').prop('disabled', false);
                }
            });
        });
    </script>
</body>
</html>