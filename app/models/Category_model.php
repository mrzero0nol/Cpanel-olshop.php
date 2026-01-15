<?php

class Category_model {
    private $table = 'categories';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllCategories() {
        if (!$this->db->execute()) return []; // Graceful fail if no DB
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function addCategory($data) {
        $query = "INSERT INTO categories (name, slug, icon) VALUES (:name, :slug, :icon)";
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('slug', $data['slug']);
        $this->db->bind('icon', $data['icon']);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
