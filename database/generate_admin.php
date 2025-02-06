<?php
require_once __DIR__ . "/../config/database.php";

$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Generated hash: " . $hash . "\n";

// Update admin password
$stmt = $pdo->prepare("UPDATE tbUser SET Password = ? WHERE Email = 'admin@admin.com'");
$stmt->execute([$hash]);
echo "Admin password updated successfully\n";

// Verify the update
$stmt = $pdo->prepare("SELECT Password FROM tbUser WHERE Email = 'admin@admin.com'");
$stmt->execute();
$user = $stmt->fetch();
echo "Stored hash: " . $user['Password'] . "\n";
echo "Verification test: " . (password_verify($password, $user['Password']) ? "Success" : "Failed") . "\n";
