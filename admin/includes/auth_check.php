<?php
session_start();

function checkAdminAuth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: login.php");
        exit();
    }
}

// Call this at the beginning of every admin page (except login)
checkAdminAuth();
