<?php

class User_model {
    private $table = 'users';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function register($data) {
        $query = "INSERT INTO users (name, email, password, phone) VALUES (:name, :email, :password, :phone)";
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind('phone', $data['phone']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email = :email');
        $this->db->bind('email', $email);
        return $this->db->single();
    }

    public function getUserById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function login($email, $password) {
        $row = $this->findUserByEmail($email);
        if ($row) {
            if (password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }
}
