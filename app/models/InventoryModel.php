<?php
require_once __DIR__ . '/../config/Database.php';

class InventoryModel extends Database {
    
    // Mengambil semua data barang dan merelasikannya ke tabel Gudang & Vendor
    public function getAllInventory($search = '') {
        $query = "SELECT i.*, s.nama_gudang, v.nama_vendor 
                  FROM inventory i
                  LEFT JOIN storage_unit s ON i.id_gudang = s.id_gudang
                  LEFT JOIN vendor v ON i.id_vendor = v.id_vendor";
        
        if (!empty($search)) {
            $query .= " WHERE i.nama_barang LIKE :search OR i.serial_number LIKE :search";
        }

        $stmt = $this->dbh->prepare($query);
        if (!empty($search)) {
            $stmt->bindValue(':search', "%$search%");
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil daftar barang yang stoknya 0 untuk memicu Notifikasi/Alert
    public function getOutOfStockItems() {
        $query = "SELECT nama_barang FROM inventory WHERE kuantitas_stok <= 0";
        $stmt = $this->dbh->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Memasukkan data barang baru ke database (Create)
    public function insertInventory($data) {
        $query = "INSERT INTO inventory (serial_number, nama_barang, jenis_barang, kuantitas_stok, harga, id_gudang, id_vendor) 
                  VALUES (:serial_number, :nama_barang, :jenis_barang, :kuantitas_stok, :harga, :id_gudang, :id_vendor)";
        $stmt = $this->dbh->prepare($query);
        return $stmt->execute($data);
    }

    // Mengambil data pendukung untuk dropdown pilihan Gudang
    public function getStorageUnits() {
        $stmt = $this->dbh->query("SELECT id_gudang, nama_gudang FROM storage_unit");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil data pendukung untuk dropdown pilihan Vendor
    public function getVendors() {
        $stmt = $this->dbh->query("SELECT id_vendor, nama_vendor FROM vendor");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Memasukkan gudang cabang baru (STORAGE UNIT)
    public function insertStorageUnit($nama_gudang, $lokasi) {
        $query = "INSERT INTO storage_unit (nama_gudang, lokasi) VALUES (:nama_gudang, :lokasi)";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindValue(':nama_gudang', $nama_gudang);
        $stmt->bindValue(':lokasi', $lokasi);
        return $stmt->execute();
    }

    // Memasukkan vendor / supplier baru (VENDOR)
    public function insertVendor($nama_vendor, $kontak, $nama_barang) {
        $query = "INSERT INTO vendor (nama_vendor, kontak, nama_barang) VALUES (:nama_vendor, :kontak, :nama_barang)";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindValue(':nama_vendor', $nama_vendor);
        $stmt->bindValue(':kontak', $kontak);
        $stmt->bindValue(':nama_barang', $nama_barang);
        return $stmt->execute();
    }
}
