<?php
require_once 'config.php';

// Get JSON Data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    http_response_code(400);
    exit('Invalid JSON');
}

$order_id = $data['order_id'];
$amount = $data['amount'];
$status = $data['status'];
$project = $data['project'];

// 1. Verify Project Slug
$my_slug = get_setting('pakasir_slug');
if ($project !== $my_slug) {
    http_response_code(403);
    exit('Invalid Project');
}

// 2. Verify with API (Recommended)
$api_key = get_setting('pakasir_apikey');
$verify_url = "https://app.pakasir.com/api/transactiondetail?project={$my_slug}&amount={$amount}&order_id={$order_id}&api_key={$api_key}";

// Use curl to verify
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $verify_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$verify_data = json_decode($response, true);

if (!$verify_data || !isset($verify_data['transaction']) || $verify_data['transaction']['status'] !== 'completed') {
    // If API check fails or not completed, ignore.
    http_response_code(200);
    exit('Transaction not verified or not completed');
}

// 3. Process Order
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    http_response_code(404);
    exit('Order not found');
}

if ($order['status'] == 'paid') {
    http_response_code(200);
    exit('Order already paid');
}

// Check Amount
if ((int)$order['total_amount'] != (int)$amount) {
     http_response_code(400);
     exit('Amount mismatch');
}

// 4. Mark Paid
$stmt = $conn->prepare("UPDATE orders SET status = 'paid', pakasir_inv_id = ? WHERE id = ?");
$payment_method = $data['payment_method'] ?? 'pakasir';
$stmt->bind_param("si", $payment_method, $order_id);
$stmt->execute();

// 5. Assign License
$product_id = $order['product_id'];

// Find one available license
$lic_stmt = $conn->prepare("SELECT id FROM product_licenses WHERE product_id = ? AND status = 'available' LIMIT 1");
$lic_stmt->bind_param("i", $product_id);
$lic_stmt->execute();
$lic_res = $lic_stmt->get_result();

if ($lic_row = $lic_res->fetch_assoc()) {
    $license_id = $lic_row['id'];

    // Assign to order
    $update_lic = $conn->prepare("UPDATE product_licenses SET status = 'sold', order_id = ? WHERE id = ?");
    $update_lic->bind_param("ii", $order_id, $license_id);
    $update_lic->execute();
}

http_response_code(200);
echo "Payment Processed";
?>
