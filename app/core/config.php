<?php
/*set your website title*/
define('WEBSITE_TITLE', "PhpBookStore");

/*set database variables*/
define('DB_TYPE','mysql');
define('DB_NAME','bookstore_db');
define('DB_USER','user');
define('DB_PASS','User@1234');
define('DB_HOST','localhost');

/*protocol type http or https*/
define('PROTOCAL','http');

/*Dynamic root and asset paths based on environment*/
function getEnvironmentPaths() {
    $server_name = $_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost';

    // Local development detection (localhost or 127.0.0.1)
    if ($server_name === 'localhost' || $server_name === '127.0.0.1') {
        return [
            'root' => '/phpbookstore/public/',
            'assets' => '/phpbookstore/public/assets/'
        ];
    } else {
        // Production environment (IP: 43.209.1.155 or any other domain)
        return [
            'root' => '/public/',
            'assets' => '/public/assets/'
        ];
    }
}

$paths = getEnvironmentPaths();
define('ROOT', $paths['root']);
define('ASSETS', $paths['assets']);

/*set to true to allow error reporting
set to false when you upload online to stop error reporting*/
define('DEBUG',true);

if(DEBUG) {
    ini_set("display_errors",1);
} else {
    ini_set("display_errors",0);
}

// Add this to your routes or make sure it exists
$routes['chat/processMessage'] = 'chat/processMessage';