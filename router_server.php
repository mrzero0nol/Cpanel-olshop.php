<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false; // serve existing file
}

$_GET['url'] = ltrim($uri, '/');
require_once __DIR__ . '/public/index.php';
