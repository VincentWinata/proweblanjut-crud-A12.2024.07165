<?php

class BarangModel {
    private $conn;

    // Konstruktor untuk menerima koneksi database dari luar
    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    // Mengambil semua data barang (sebelumnya ada di barang.php dan index.php)
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM barang ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil satu data barang berdasarkan ID (sebelumnya ada di edit.php)
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM barang WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menyimpan data barang baru (sebelumnya ada di tambah.php)
    public function save($data) {
        $sql = "INSERT INTO barang (nama_barang, kategori, harga, jumlah, deskripsi, gambar, tanggal_masuk) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['nama_barang'], 
            $data['kategori'], 
            $data['harga'], 
            $data['jumlah'], 
            $data['deskripsi'], 
            $data['gambar']
        ]);
    }

    // Memperbarui data barang (sebelumnya ada di edit.php)
    public function update($id, $data) {
        $sql = "UPDATE barang SET nama_barang=?, kategori=?, harga=?, jumlah=?, deskripsi=?, gambar=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['nama_barang'], 
            $data['kategori'], 
            $data['harga'], 
            $data['jumlah'], 
            $data['deskripsi'], 
            $data['gambar'], 
            $id
        ]);
    }

    // Menghapus data barang (sebelumnya ada di hapus.php)
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM barang WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>