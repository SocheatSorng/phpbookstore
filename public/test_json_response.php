<?php
// Test JSON response to verify server configuration
session_start();
require_once "../app/init.php";

// Clean any output buffer
ob_clean();
header('Content-Type: application/json');

$response = [
    'success' => true,
    'message' => 'JSON response test successful',
    'server_info' => [
        'server_name' => $_SERVER['SERVER_NAME'] ?? 'unknown',
        'http_host' => $_SERVER['HTTP_HOST'] ?? 'unknown',
        'server_port' => $_SERVER['SERVER_PORT'] ?? 'unknown',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
        'root_constant' => ROOT,
        'assets_constant' => ASSETS
    ],
    'environment' => [
        'is_local' => ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1'),
        'protocol' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http'
    ],
    'timestamp' => date('Y-m-d H:i:s')
];

echo json_encode($response, JSON_PRETTY_PRINT);
exit;
?>
