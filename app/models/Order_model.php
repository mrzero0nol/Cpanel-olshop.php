<?php

class Order_model {
    private $table = 'orders';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function createOrder($data) {
        $query = "INSERT INTO orders (user_id, product_id, order_number, total_amount, status, payment_method, phone)
                  VALUES (:user_id, :product_id, :order_number, :total_amount, 'pending', :payment_method, :phone)";

        $this->db->query($query);
        $this->db->bind('user_id', $data['user_id']);
        $this->db->bind('product_id', $data['product_id']);
        $this->db->bind('order_number', $data['order_number']);
        $this->db->bind('total_amount', $data['total_amount']);
        $this->db->bind('payment_method', $data['payment_method']);
        $this->db->bind('phone', $data['phone']);

        $this->db->execute();
        return $this->db->lastInsertId();
    }

    public function getOrderByNumber($number) {
        $this->db->query('SELECT * FROM orders WHERE order_number = :number');
        $this->db->bind('number', $number);
        return $this->db->single();
    }

    public function getAllOrders() {
        $this->db->query('SELECT o.*, u.name as user_name FROM orders o LEFT JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC');
        return $this->db->resultSet();
    }

    public function getOrderById($id) {
        $this->db->query('SELECT * FROM orders WHERE id = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function updateStatus($id, $status) {
        $this->db->query('UPDATE orders SET status = :status WHERE id = :id');
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    // Transaction related
    public function addTransaction($data) {
        $query = "INSERT INTO transactions (order_id, pakasir_id, amount, status, payload)
                  VALUES (:order_id, :pakasir_id, :amount, :status, :payload)";
        $this->db->query($query);
        $this->db->bind('order_id', $data['order_id']);
        $this->db->bind('pakasir_id', $data['pakasir_id']);
        $this->db->bind('amount', $data['amount']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('payload', $data['payload']);

        return $this->db->execute();
    }

    public function getTransactionByOrderId($orderId) {
        $this->db->query('SELECT * FROM transactions WHERE order_id = :order_id ORDER BY id DESC LIMIT 1');
        $this->db->bind('order_id', $orderId);
        return $this->db->single();
    }

    public function getIncomeReport($month, $year) {
        $query = "SELECT SUM(total_amount) as total FROM orders
                  WHERE status = 'paid'
                  AND MONTH(created_at) = :month
                  AND YEAR(created_at) = :year";
        $this->db->query($query);
        $this->db->bind('month', $month);
        $this->db->bind('year', $year);
        $result = $this->db->single();
        return $result ? $result['total'] : 0;
    }
}
