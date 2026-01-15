<?php
require_once 'config.php';
require_once 'includes/functions.php';

require_login();

if (!isset($_GET['product_id'])) {
    redirect('index.php');
}

$product_id = (int)$_GET['product_id'];
$user_id = $_SESSION['user_id'];

// Fetch Product and Stock
$stmt = $conn->prepare("SELECT p.*, (SELECT COUNT(*) FROM product_licenses WHERE product_id = p.id AND status = 'available') as stock FROM products p WHERE p.id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "Produk tidak ditemukan.";
    exit();
}

if ($product['stock'] <= 0) {
    echo "Stok habis.";
    exit();
}

// Check for Settings
$slug = get_setting('pakasir_slug');
if (!$slug) {
    echo "Konfigurasi pembayaran (Slug) belum diatur oleh Admin.";
    exit();
}

// Create Order
$amount = $product['price'];
$stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, total_amount, status) VALUES (?, ?, ?, 'pending')");
$stmt->bind_param("iid", $user_id, $product_id, $amount);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;

    // Redirect to Pakasir
    // Format: https://app.pakasir.com/pay/{slug}/{amount}?order_id={order_id}
    // Amount usually needs to be integer? Let's cast to int if it's IDR.
    $amount_int = (int)$amount;
    $url = "https://app.pakasir.com/pay/{$slug}/{$amount_int}?order_id={$order_id}";

    redirect($url);
} else {
    echo "Gagal membuat pesanan: " . $conn->error;
}
?>
