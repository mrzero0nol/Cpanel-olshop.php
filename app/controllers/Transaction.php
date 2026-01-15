<?php

class Transaction extends Controller {
    public function __construct() {
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
    }

    public function index() {
        $data['title'] = 'Transactions';
        $data['orders'] = $this->model('Order_model')->getAllOrders();

        $this->view('admin/layout/header', $data);
        $this->view('admin/transactions/index', $data);
        $this->view('admin/layout/footer');
    }
}
