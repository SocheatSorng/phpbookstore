<?php
// Test URL detection for PayWay configuration
require_once "../app/init.php";

// Simulate the getBaseUrl method logic
function getBaseUrl() {
    $server_name = $_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost';
    $server_port = $_SERVER['SERVER_PORT'] ?? '80';
    $protocol = 'http'; // Using http for testing
    
    // Local development detection
    if ($server_name === 'localhost' || $server_name === '127.0.0.1') {
        // Local environment - use port 8887
        if ($server_port != '80' && $server_port != '443') {
            return $protocol . '://' . $server_name . ':' . $server_port;
        } else {
            return $protocol . '://' . $server_name . ':8887';
        }
    } else {
        // Cloud/production environment - use standard ports
        if (($protocol === 'http' && $server_port == '80') || 
            ($protocol === 'https' && $server_port == '443')) {
            return $protocol . '://' . $server_name;
        } else {
            return $protocol . '://' . $server_name . ':' . $server_port;
        }
    }
}

echo "<h1>PayWay URL Detection Test</h1>";

echo "<h2>Server Information:</h2>";
echo "<ul>";
echo "<li><strong>SERVER_NAME:</strong> " . ($_SERVER['SERVER_NAME'] ?? 'Not set') . "</li>";
echo "<li><strong>HTTP_HOST:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'Not set') . "</li>";
echo "<li><strong>SERVER_PORT:</strong> " . ($_SERVER['SERVER_PORT'] ?? 'Not set') . "</li>";
echo "<li><strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Not set') . "</li>";
echo "</ul>";

echo "<h2>Detected Base URL:</h2>";
$base_url = getBaseUrl();
echo "<p><strong>" . $base_url . "</strong></p>";

echo "<h2>PayWay URLs that will be generated:</h2>";
echo "<ul>";
echo "<li><strong>Return URL:</strong> " . $base_url . ROOT . "checkout/payment_callback</li>";
echo "<li><strong>Success URL:</strong> " . $base_url . ROOT . "checkout/success?tran_id=XXXXX</li>";
echo "</ul>";

echo "<h2>Environment Detection:</h2>";
$server_name = $_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost';
if ($server_name === 'localhost' || $server_name === '127.0.0.1') {
    echo "<p><span style='color: blue;'>✓ Detected as LOCAL environment</span></p>";
} else {
    echo "<p><span style='color: green;'>✓ Detected as CLOUD/PRODUCTION environment</span></p>";
}

echo "<h2>Test Transaction ID:</h2>";
echo "<p>Your latest transaction ID <strong>1749022855</strong> is now included in test mode.</p>";
echo "<p><a href='" . $base_url . ROOT . "checkout/success?tran_id=1749022855'>Test Success Page</a></p>";
?>
