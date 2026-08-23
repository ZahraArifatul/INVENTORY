<?php

class InventoryModel {
    private $db;

    public function __construct() {
        // Sesuaikan koneksi database kamu jika perlu
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=inventory", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }

    // 1. Ambil semua data inventory (dengan fitur pencarian)
    public function getAllInventory($search = '') {
        $sql = "SELECT i.*, g.nama_gudang, v.nama_vendor 
                FROM inventory i
                LEFT JOIN gudang g ON i.id_gudang = g.id_gudang
                LEFT JOIN vendor v ON i.id_vendor = v.id_vendor";

        if (!empty($search)) {
            $sql .= " WHERE i.nama_barang LIKE :search 
                       OR i.jenis_barang LIKE :search 
                       OR i.serial_number LIKE :search";
        }

        $stmt = $this->db->prepare($sql);
        if (!empty($search)) {
            $searchTerm = "%{$search}%";
            $stmt->bindParam(':search', $searchTerm);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Ambil barang yang stoknya habis (0)
    public function getOutOfStockItems() {
        $sql = "SELECT * FROM inventory WHERE kuantitas_stok <= 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Tambah barang baru
    public function insertInventory($data) {
        $sql = "INSERT INTO inventory (serial_number, nama_barang, jenis_barang, kuantitas_stok, harga, id_gudang, id_vendor) 
                VALUES (:serial_number, :nama_barang, :jenis_barang, :kuantitas_stok, :harga, :id_gudang, :id_vendor)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // 4. Ambil 1 barang berdasarkan ID
    public function getInventoryById($id) {
        $sql = "SELECT * FROM inventory WHERE id_inventory = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 5. Update data barang
    public function updateInventory($id, $data) {
        $sql = "UPDATE inventory 
                SET serial_number = :serial_number, 
                    nama_barang = :nama_barang, 
                    jenis_barang = :jenis_barang, 
                    kuantitas_stok = :kuantitas_stok, 
                    harga = :harga, 
                    id_gudang = :id_gudang, 
                    id_vendor = :id_vendor 
                WHERE id_inventory = :id";
        
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // 6. Hapus barang
    public function deleteInventory($id) {
        $sql = "DELETE FROM inventory WHERE id_inventory = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // 7. Ambil daftar gudang
    public function getStorageUnits() {
        $sql = "SELECT * FROM gudang";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 8. Ambil daftar vendor
    public function getVendors() {
        $sql = "SELECT * FROM vendor";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 9. Tambah gudang baru
    public function insertStorageUnit($nama_gudang, $lokasi) {
        $sql = "INSERT INTO gudang (nama_gudang, lokasi) VALUES (:nama_gudang, :lokasi)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nama_gudang', $nama_gudang);
        $stmt->bindParam(':lokasi', $lokasi);
        return $stmt->execute();
    }

    // 10. Tambah vendor baru (SUDAH DIPERBAIKI SESUAI STRUKTUR DB)
    public function insertVendor($nama_vendor, $kontak_vendor, $nama_barang_vendor) {
        $query = "INSERT INTO vendor (nama_vendor, kontak_vendor, nama_barang_vendor) 
                  VALUES (:nama_vendor, :kontak_vendor, :nama_barang_vendor)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama_vendor', $nama_vendor);
        $stmt->bindParam(':kontak_vendor', $kontak_vendor);
        $stmt->bindParam(':nama_barang_vendor', $nama_barang_vendor);

        return $stmt->execute();
    }
}