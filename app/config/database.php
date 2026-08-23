<?php
class Database {
    private $host = "localhost";
    private $db_name = "db_inventory";
    private $user = "root";
    private $pass = "";
    protected $dbh;

    public function __construct() {
        try {
            $this->dbh = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->user, $this->pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Koneksi Database Gagal: " . $e->getMessage());
        }
    }
}
