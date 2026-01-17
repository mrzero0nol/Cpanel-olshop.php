<?php

class Product_model {
    private $table = 'products';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllProducts() {
        if (!$this->db->execute()) return [];
        $this->db->query('SELECT p.*, c.name as category_name FROM ' . $this->table . ' p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC');
        return $this->db->resultSet();
    }

    public function searchProducts($keyword) {
        $keyword = "%$keyword%";
        $this->db->query('SELECT p.*, c.name as category_name FROM ' . $this->table . ' p JOIN categories c ON p.category_id = c.id WHERE p.name LIKE :keyword OR p.description LIKE :keyword ORDER BY p.created_at DESC');
        $this->db->bind('keyword', $keyword);
        return $this->db->resultSet();
    }

    public function getProductById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getProductBySlug($slug) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE slug=:slug');
        $this->db->bind('slug', $slug);
        return $this->db->single();
    }

    public function addProduct($data) {
        $query = "INSERT INTO products (category_id, name, slug, description, price, original_price, image, is_active)
                  VALUES (:category_id, :name, :slug, :description, :price, :original_price, :image, :is_active)";

        $this->db->query($query);
        $this->db->bind('category_id', $data['category_id']);
        $this->db->bind('name', $data['name']);
        $this->db->bind('slug', $data['slug']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('price', $data['price']);
        $this->db->bind('original_price', $data['original_price']);
        $this->db->bind('image', $data['image']);
        $this->db->bind('is_active', $data['is_active']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    // Product Accounts (Stock)
    public function addAccount($data) {
        $query = "INSERT INTO product_accounts (product_id, account_data) VALUES (:product_id, :account_data)";
        $this->db->query($query);
        $this->db->bind('product_id', $data['product_id']);
        $this->db->bind('account_data', $data['account_data']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getAccountsByProductId($id) {
        $this->db->query('SELECT * FROM product_accounts WHERE product_id = :product_id AND is_sold = 0');
        $this->db->bind('product_id', $id);
        return $this->db->resultSet();
    }

    public function getAvailableAccount($product_id) {
         $this->db->query('SELECT * FROM product_accounts WHERE product_id = :product_id AND is_sold = 0 LIMIT 1');
         $this->db->bind('product_id', $product_id);
         return $this->db->single();
    }

    public function markAccountAsSold($account_id, $order_id) {
        $this->db->query('UPDATE product_accounts SET is_sold = 1, order_id = :order_id WHERE id = :id');
        $this->db->bind('id', $account_id);
        $this->db->bind('order_id', $order_id);
        $this->db->execute();
    }

    public function getAccountByOrderId($order_id) {
        $this->db->query('SELECT * FROM product_accounts WHERE order_id = :order_id');
        $this->db->bind('order_id', $order_id);
        return $this->db->single();
    }

    public function getAssetsByUserId($user_id) {
        $query = "SELECT pa.*, p.name as product_name, p.image as product_image, o.order_number
                  FROM product_accounts pa
                  JOIN orders o ON pa.order_id = o.id
                  JOIN products p ON pa.product_id = p.id
                  WHERE o.user_id = :user_id AND pa.is_sold = 1
                  ORDER BY pa.created_at DESC";
        $this->db->query($query);
        $this->db->bind('user_id', $user_id);
        return $this->db->resultSet();
    }
}
