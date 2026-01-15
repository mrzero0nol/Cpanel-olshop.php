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
    die('<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Database Error</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 h-screen flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md text-center">
            <h1 class="text-2xl font-bold mb-4 text-red-600">Gagal Koneksi Database</h1>
            <p class="text-gray-600 mb-4">Website tidak dapat terhubung ke database. Pastikan username, password, dan nama database di <code>config.php</code> sudah benar.</p>
            <div class="bg-red-50 text-red-800 p-3 rounded text-sm text-left font-mono overflow-auto mb-4">
                Error: ' . $conn->connect_error . '
            </div>
            <button onclick="location.reload()" class="bg-gray-800 text-white font-bold py-2 px-6 rounded hover:bg-gray-700">
                Coba Lagi
            </button>
        </div>
    </body>
    </html>');
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
