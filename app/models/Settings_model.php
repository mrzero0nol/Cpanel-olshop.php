<?php

class Settings_model {
    private $table = 'settings';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getSettings() {
        if (!$this->db->execute()) return [];
        $this->db->query('SELECT * FROM ' . $this->table);
        $results = $this->db->resultSet();
        $settings = [];
        foreach($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function updateSetting($key, $value) {
        // Check if exists
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE setting_key = :key');
        $this->db->bind('key', $key);
        if ($this->db->single()) {
            $query = "UPDATE settings SET setting_value = :value WHERE setting_key = :key";
        } else {
            $query = "INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value)";
        }

        $this->db->query($query);
        $this->db->bind('key', $key);
        $this->db->bind('value', $value);
        return $this->db->execute();
    }
}
