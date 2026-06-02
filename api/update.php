<?php
header("Content-Type: application/json; charset=UTF-8");
require_once '../app/koneksi.php';

// Menangkap data JSON mentah dari Postman
$input = json_decode(file_get_contents("php://input"), true);

// Pastikan ID dan data yang mau diubah tersedia
$id = $input['id'] ?? null;
$nama_barang = $input['nama_barang'] ?? null;
$jumlah = $input['jumlah'] ?? null;
$harga = $input['harga'] ?? null;

if ($id && $nama_barang && $jumlah !== null && $harga !== null) {
    try {
        $stmt = $conn->prepare("UPDATE barang SET nama_barang = ?, jumlah = ?, harga = ? WHERE id = ?");
        $stmt->execute([$nama_barang, $jumlah, $harga, $id]);

        echo json_encode(["status" => "sukses", "pesan" => "Data barang berhasil diupdate!"]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["status" => "error", "pesan" => $e->getMessage()]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "gagal", "pesan" => "Data tidak lengkap atau ID tidak ditemukan!"]);
}
?>