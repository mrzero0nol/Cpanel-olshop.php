<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $data['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f5f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-bottom: 70px; }
        .product-card { border: none; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); transition: transform 0.2s; background: white; overflow: hidden; text-decoration: none; color: inherit; display: block; height: 100%; }
        .product-card:active { transform: scale(0.98); }
        .product-img { height: 120px; object-fit: cover; width: 100%; background: #eee; }
        .category-item { text-align: center; margin-bottom: 15px; text-decoration: none; color: #333; display: block; }
        .category-icon { width: 50px; height: 50px; background: white; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin: 0 auto 5px auto; color: #0d6efd; }
        .bottom-nav { position: fixed; bottom: 0; left: 0; width: 100%; background: white; border-top: 1px solid #eee; display: flex; justify-content: space-around; padding: 10px 0; z-index: 1000; }
        .nav-item { text-align: center; color: #aaa; text-decoration: none; font-size: 12px; }
        .nav-item.active { color: #0d6efd; }
        .nav-item i { display: block; font-size: 20px; margin-bottom: 2px; }
        .search-bar { border-radius: 20px; background: white; border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.05); padding: 10px 20px; width: 100%; }
        .banner-slider { border-radius: 15px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="container mt-3">
