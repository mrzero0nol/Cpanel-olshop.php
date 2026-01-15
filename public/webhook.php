<?php
// Start Session if not started (init.php might need it, though webhook is stateless usually)
// Pakasir webhook is server-to-server.

require_once __DIR__ . '/../app/init.php';

// Get JSON Body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['order_id'])) {
    http_response_code(400);
    exit('Invalid payload');
}

$orderNumber = $data['order_id'];
$amount = $data['amount'];

// Models
$orderModel = new Order_model();
$productModel = new Product_model();

// Get Order
$order = $orderModel->getOrderByNumber($orderNumber);

if (!$order) {
    http_response_code(404);
    exit('Order not found');
}

// Verify with Pakasir API (Safety check)
$statusData = Pakasir::checkStatus($orderNumber, $amount);

if ($statusData && isset($statusData['status']) && $statusData['status'] == 'completed') {
    if ($order['status'] != 'paid') {
        // Update Status
        $orderModel->updateStatus($order['id'], 'paid');

        // Assign Stock
        // Check if already assigned
        $existing = $productModel->getAccountByOrderId($order['id']);
        if (!$existing) {
             $stock = $productModel->getAvailableAccount($order['product_id']);
             if ($stock) {
                 $productModel->markAccountAsSold($stock['id'], $order['id']);
             }
        }
    }
}

http_response_code(200);
echo 'OK';
