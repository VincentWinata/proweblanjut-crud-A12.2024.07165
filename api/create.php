<?php
header("Content-Type: application/json; charset=UTF-8");
require_once '../app/koneksi.php';

// Menangkap data JSON mentah dari Postman
$input = json_decode(file_get_contents("php://input"), true);

// Pastikan data yang dibutuhkan ada (sesuaikan dengan nama field di tabel barang Anda)
if (isset($input['nama_barang']) && isset($input['jumlah']) && isset($input['harga'])) {
    
    try {
        $stmt = $conn->prepare("INSERT INTO barang (nama_barang, jumlah, harga) VALUES (?, ?, ?)");
        $stmt->execute([
            $input['nama_barang'], 
            $input['jumlah'], 
            $input['harga']
        ]);
        
        echo json_encode(["status" => "sukses", "pesan" => "Data barang berhasil ditambahkan"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "pesan" => "Gagal menyimpan: " . $e->getMessage()]);
    }

} else {
    // Jika ada field yang kosong/tidak dikirim
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "gagal", "pesan" => "Data tidak lengkap!"]);
}
?>