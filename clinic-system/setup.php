<?php
require_once __DIR__ . '/includes/db_connect.php';

// Default admin credentials
$username = 'admin';
$password_plain = 'admin123';
$role = 'admin';

// Check if admin user already exists
$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
$existing = $stmt->fetch();

if ($existing) {
    echo "Admin user already exists.\n";
} else {
    $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (username, password_hash, role, is_active, created_at) VALUES (?, ?, ?, 1, datetime("now"))');
    $stmt->execute([$username, $password_hash, $role]);
    echo "Default admin user created: username 'admin', password 'admin123'.\n";
}
?>
