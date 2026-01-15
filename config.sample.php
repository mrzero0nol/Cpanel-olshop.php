<?php
session_start();

// Database Configuration
// SILAKAN UBAH CONFIG DI BAWAH INI SESUAI DATABASE ANDA
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  // Ganti dengan username database cPanel
define('DB_PASS', '');      // Ganti dengan password database cPanel
define('DB_NAME', 'digital_shop'); // Ganti dengan nama database

// Connect to Database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get site setting
function get_setting($key) {
    global $conn;
    $stmt = $conn->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['setting_value'];
    }
    return '';
}

// Base URL Helper
function base_url($path = '') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'] . '/';
    return $protocol . $domainName . $path;
}
?>
