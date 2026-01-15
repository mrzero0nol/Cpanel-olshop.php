<?php

class Admin_model {
    private $table = 'admins';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAdminByUsername($username) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
        $this->db->bind('username', $username);
        return $this->db->single();
    }
}
