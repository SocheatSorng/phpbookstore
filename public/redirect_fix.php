<?php
// Temporary redirect script to handle incorrect PayWay redirects
// This helps during the transition period

// Get the current URL
$current_url = $_SERVER['REQUEST_URI'];
$query_string = $_SERVER['QUERY_STRING'];

// Check if this is a checkout success URL that needs fixing
if (strpos($current_url, '/checkout/success') !== false) {
    // Build the correct URL
    $correct_url = 'http://localhost:8887/phpbookstore/public/checkout/success';
    
    // Add query string if it exists
    if (!empty($query_string)) {
        $correct_url .= '?' . $query_string;
    }
    
    // Log the redirect for debugging
    error_log("Redirecting from: " . $current_url . " to: " . $correct_url);
    
    // Redirect to the correct URL
    header("Location: " . $correct_url);
    exit;
}

// If not a checkout URL, show a helpful message
echo "<h1>URL Fix Helper</h1>";
echo "<p>This script helps redirect incorrect PayWay URLs to the correct location.</p>";
echo "<p>Current URL: " . htmlspecialchars($current_url) . "</p>";
echo "<p>If you're seeing this, the PayWay configuration has been updated.</p>";
echo "<p><a href='http://localhost:8887/phpbookstore/public/'>Go to Homepage</a></p>";
?>
