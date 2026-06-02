<?php
// Wajib: Beritahu browser/Postman bahwa outputnya adalah JSON
header("Content-Type: application/json; charset=UTF-8");

// Panggil file koneksi yang sudah ada di folder app
require_once '../app/koneksi.php';

try {
    // Menggunakan $conn sesuai dengan yang ada di app/koneksi.php Anda
    $stmt = $conn->prepare("SELECT * FROM barang ORDER BY id DESC");
    $stmt->execute();
    $data_barang = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Kirim respons JSON sukses
    echo json_encode([
        "status" => "sukses",
        "data" => $data_barang
    ]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "pesan" => $e->getMessage()]);
}
?>