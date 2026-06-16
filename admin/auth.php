<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';

if (empty($_SESSION['admin_ok'])) {
    header('Location: ' . base_url('admin/login'));
    exit;
}

// Perform client IP address validation
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$username = $_SESSION['admin_username'] ?? '';

$admin = get_row("SELECT allowed_ip FROM admins WHERE username = ? LIMIT 1", [$username]);
if ($admin) {
    if ($admin['allowed_ip'] !== null && $admin['allowed_ip'] !== $ip) {
        // IP mismatch: destroy session and kick out
        unset($_SESSION['admin_ok']);
        unset($_SESSION['admin_username']);
        header('Location: ' . base_url('admin/login?error=ip_changed'));
        exit;
    }
}
