<?php
session_start();

function checkAuth() {
    $currentPage = basename($_SERVER['PHP_SELF']);
    
    // Allow access to login page and assets
    if($currentPage === 'login.php' || strpos($_SERVER['REQUEST_URI'], '/assets/') !== false) {
        return;
    }
    
    // Check if user is logged in
    if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: login.php");
        exit();
    }
}