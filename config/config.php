<?php

// Check if Env class exists (it should be loaded by index.php)
if (class_exists('Env')) {
    Env::load(__DIR__ . '/../.env');
}

// App Config
$baseUrl = getenv('BASE_URL') ?: 'http://localhost:8000';
$baseUrl = rtrim($baseUrl, '/'); // Ensure no trailing slash
define('BASEURL', $baseUrl);

define('APP_NAME', getenv('APP_NAME') ?: 'Toko Digital');
define('WA_NUMBER', getenv('WA_NUMBER'));

// Database Config
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'pakasir_shop');

// Pakasir Config
define('PAKASIR_PROJECT_SLUG', getenv('PAKASIR_PROJECT_SLUG'));
define('PAKASIR_API_KEY', getenv('PAKASIR_API_KEY'));
