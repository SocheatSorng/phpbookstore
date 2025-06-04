<?php
// Test script to simulate payment completion
session_start();

// Include the app initialization to access models
require_once "../app/init.php";

// Simulate a pending order in session
$_SESSION['pending_order'] = [
    'UserID' => 1,
    'TotalAmount' => 29.99,
    'ShippingAddress' => "123 Test Street\nTest City\nTest Country 12345",
    'cart_items' => [
        [
            'BookID' => 1,
            'Title' => 'Test Book 1',
            'Price' => 19.99,
            'Quantity' => 1
        ],
        [
            'BookID' => 2,
            'Title' => 'Test Book 2',
            'Price' => 10.00,
            'Quantity' => 1
        ]
    ],
    'payment_data' => [
        'address' => '123 Test Street',
        'city' => 'Test City',
        'country' => 'Test Country',
        'zipcode' => '12345'
    ]
];

// Simulate user session
$_SESSION['user'] = [
    'UserID' => 1,
    'FirstName' => 'Test',
    'LastName' => 'User',
    'Email' => 'test@example.com'
];

$_SESSION['UserID'] = 1;

echo "<h1>Payment Test Setup</h1>";
echo "<p>Session data has been set up for testing.</p>";
echo "<p>You can now test the payment success URL:</p>";
echo "<a href='http://localhost:8887/phpbookstore/public/checkout/success?tran_id=TEST123456' target='_blank'>";
echo "Test Payment Success Page";
echo "</a>";
echo "<br><br>";
echo "<p>Or test with your transaction IDs:</p>";
echo "<a href='http://localhost:8887/phpbookstore/public/checkout/success?tran_id=1749006963' target='_blank'>";
echo "Test with Transaction ID: 1749006963";
echo "</a>";
echo "<br>";
echo "<a href='http://localhost:8887/phpbookstore/public/checkout/success?tran_id=1749008606' target='_blank'>";
echo "Test with Transaction ID: 1749008606";
echo "</a>";

echo "<h2>Session Data:</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h2>Testing Instructions:</h2>";
echo "<ol>";
echo "<li>Click one of the test links above</li>";
echo "<li>You should see a loading spinner initially</li>";
echo "<li>The page should then show either success or error state</li>";
echo "<li>Check browser console for any JavaScript errors</li>";
echo "<li>Check server logs for backend processing details</li>";
echo "</ol>";

echo "<h2>Expected Behavior:</h2>";
echo "<ul>";
echo "<li><strong>Success Case:</strong> Green checkmark, order confirmation, order summary table</li>";
echo "<li><strong>Error Case:</strong> Red warning icon, error message, support links</li>";
echo "</ul>";
?>
