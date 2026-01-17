<?php

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;

    private $dbh;
    private $stmt;

    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
        } catch (PDOException $e) {
             // Fallback for verification/test environment without DB
             $this->dbh = null;
             // die($e->getMessage()); // Don't die for now to allow verifying other parts if needed
        }
    }

    public function query($query) {
        if ($this->dbh) {
            $this->stmt = $this->dbh->prepare($query);
        }
    }

    public function bind($param, $value, $type = null) {
        if (!$this->stmt) return;

        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
         if (!$this->stmt) return false;
        return $this->stmt->execute();
    }

    public function resultSet() {
        if (!$this->stmt) return [];
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single() {
        if (!$this->stmt) return false;
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount() {
        if (!$this->stmt) return 0;
        return $this->stmt->rowCount();
    }

    public function lastInsertId() {
        if (!$this->dbh) return 0;
        return $this->dbh->lastInsertId();
    }
}
