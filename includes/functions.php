<?php
// includes/functions.php

function sanitize($conn, $input) {
    return htmlspecialchars(strip_tags(trim($conn->real_escape_string($input))));
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

function require_login() {
    if (!is_logged_in()) {
        redirect('login.php');
    }
}

function require_admin_login() {
    if (!is_admin_logged_in()) {
        redirect('../admin/login.php');
    }
}

function flash($name, $text = '', $type = 'success') {
    if ($text != '') {
        $_SESSION[$name] = ['text' => $text, 'type' => $type];
    } elseif (isset($_SESSION[$name])) {
        $msg = $_SESSION[$name];
        unset($_SESSION[$name]);
        return '<div class="alert alert-' . $msg['type'] . '">' . $msg['text'] . '</div>';
    }
    return '';
}

function validate_image($file) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $filename = $file['name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // Check extension
    if (!in_array($ext, $allowed)) {
        return false;
    }

    // Check MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($mime, $allowed_mimes)) {
        return false;
    }

    return true;
}
?>
