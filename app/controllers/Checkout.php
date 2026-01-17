<?php

class Checkout extends Controller {

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['product_id'];
            $phone = $_POST['phone'];
            $method = $_POST['payment_method'];

            // 1. Get Product
            $product = $this->model('Product_model')->getProductById($productId);
            if (!$product) {
                Flasher::setFlash('Error', 'Product not found', 'danger');
                header('Location: ' . BASEURL);
                exit;
            }

            // 2. Check Stock
            $stock = $this->model('Product_model')->getAvailableAccount($productId);
            if (!$stock) {
                 Flasher::setFlash('Error', 'Stock unavailable', 'danger');
                 header('Location: ' . BASEURL . '/shop/detail/' . $product['slug']);
                 exit;
            }

            // 3. Create Order Number
            $orderNumber = 'INV' . date('YmdHis') . rand(100, 999);

            // 4. Create Order in DB
            $orderData = [
                'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
                'product_id' => $productId,
                'order_number' => $orderNumber,
                'total_amount' => $product['price'],
                'payment_method' => $method,
                'phone' => $phone
            ];

            $orderId = $this->model('Order_model')->createOrder($orderData);

            // 5. Call Pakasir API
            // Amount must be integer
            $pakasirResponse = Pakasir::createTransaction($orderNumber, (int)$product['price'], $method);

            if ($pakasirResponse) {
                // 6. Save Transaction
                // Pakasir response contains payment info.

                $transData = [
                    'order_id' => $orderId,
                    'pakasir_id' => '',
                    'amount' => $pakasirResponse['total_payment'],
                    'status' => 'pending',
                    'payload' => json_encode($pakasirResponse)
                ];

                $this->model('Order_model')->addTransaction($transData);

                header('Location: ' . BASEURL . '/checkout/pay/' . $orderNumber);
                exit;
            } else {
                Flasher::setFlash('Error', 'Failed to create payment gateway transaction', 'danger');
                header('Location: ' . BASEURL . '/shop/detail/' . $product['slug']);
                exit;
            }
        }
    }

    public function pay($orderNumber) {
        $order = $this->model('Order_model')->getOrderByNumber($orderNumber);
        if (!$order) {
            echo "Order not found";
            exit;
        }

        // Check Status API if pending
        if ($order['status'] == 'pending') {
            $statusData = Pakasir::checkStatus($order['order_number'], (int)$order['total_amount']);
            if ($statusData && isset($statusData['status']) && $statusData['status'] == 'completed') {
                // Mark as paid
                $this->model('Order_model')->updateStatus($order['id'], 'paid');
            }
        }

        // If already paid (or just updated)
        $order = $this->model('Order_model')->getOrderByNumber($orderNumber); // Reload
        if ($order['status'] == 'paid') {
            $this->assignStockIfNeeded($order);
            $this->showSuccess($order);
            return;
        }

        $transaction = $this->model('Order_model')->getTransactionByOrderId($order['id']);
        $payload = json_decode($transaction['payload'], true);

        $data['title'] = 'Payment ' . $orderNumber;
        $data['order'] = $order;
        $data['payment'] = $payload;

        $this->view('home/layout/header', $data);
        $this->view('checkout/pay', $data);
        $this->view('home/layout/footer');
    }

    private function showSuccess($order) {
        $account = $this->model('Product_model')->getAccountByOrderId($order['id']);

        $data['title'] = 'Purchase Successful';
        $data['order'] = $order;
        $data['account'] = $account;

        $this->view('home/layout/header', $data);
        $this->view('checkout/success', $data);
        $this->view('home/layout/footer');
    }

    private function assignStockIfNeeded($order) {
        $productModel = $this->model('Product_model');

        // Check if already assigned
        $existing = $productModel->getAccountByOrderId($order['id']);
        if ($existing) {
            return;
        }

        // Get available stock
        $stock = $productModel->getAvailableAccount($order['product_id']);
        if ($stock) {
            $productModel->markAccountAsSold($stock['id'], $order['id']);
        }
    }
}
