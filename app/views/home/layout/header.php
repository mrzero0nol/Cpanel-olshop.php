<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $data['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --bg-color: #f8f9fa;
            --text-color: #212529;
            --card-radius: 12px;
            --nav-height: 65px;
        }
        body {
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            padding-bottom: calc(var(--nav-height) + 20px);
            color: var(--text-color);
            -webkit-font-smoothing: antialiased;
        }

        /* Components */
        .search-container {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--bg-color);
            padding-top: 1rem;
            padding-bottom: 0.5rem;
        }
        .search-bar {
            border-radius: 50px;
            background: white;
            border: 1px solid #e9ecef;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            padding: 12px 20px;
            width: 100%;
            transition: all 0.3s ease;
            outline: none;
        }
        .search-bar:focus {
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.1);
            border-color: var(--primary-color);
        }

        .banner-slider {
            border-radius: var(--card-radius);
            overflow: hidden;
            margin-bottom: 24px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        /* Categories */
        .category-item {
            text-align: center;
            margin-bottom: 10px;
            text-decoration: none;
            color: var(--text-color);
            display: block;
            transition: transform 0.2s;
        }
        .category-item:active { transform: scale(0.95); }
        .category-icon {
            width: 56px;
            height: 56px;
            background: white;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.04);
            margin: 0 auto 8px auto;
            color: var(--primary-color);
        }

        /* Product Card */
        .product-card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            transition: transform 0.2s, box-shadow 0.2s;
            background: white;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
            position: relative;
        }
        .product-card:active { transform: scale(0.98); }
        .product-img {
            height: 140px;
            object-fit: cover;
            width: 100%;
            background: #f1f3f5;
        }
        .discount-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #ff4757;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 6px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(255, 71, 87, 0.3);
        }

        /* Bottom Nav */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: white;
            border-top: 1px solid #f1f3f5;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            z-index: 1000;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.03);
            height: var(--nav-height);
        }
        .nav-item {
            text-align: center;
            color: #adb5bd;
            text-decoration: none;
            font-size: 11px;
            font-weight: 500;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }
        .nav-item.active { color: var(--primary-color); }
        .nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
<div class="container">
