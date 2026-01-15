<?php
require_once 'config.php';
require_once 'includes/functions.php';

$site_title = get_setting('site_title') ?: 'Digital Shop';
$favicon = get_setting('favicon') ?: 'assets/images/favicon.png';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $site_title; ?></title>
    <link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-200">
    <div class="app-container">
        <!-- Top Bar / Header -->
        <div class="sticky top-0 z-50 bg-white shadow-sm px-4 py-3 flex items-center justify-between">
            <h1 class="text-lg font-bold text-gray-800"><?php echo $site_title; ?></h1>
            <div class="flex items-center space-x-3">
               <?php if(is_logged_in()): ?>
                    <a href="account.php" class="text-gray-600 hover:text-blue-500">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
               <?php else: ?>
                    <a href="login.php" class="text-sm font-bold text-blue-500">Login</a>
               <?php endif; ?>
            </div>
        </div>
