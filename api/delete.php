<?php
header("Content-Type: application/json; charset=UTF-8");
require_once '../app/koneksi.php';

// Menangkap data JSON mentah dari Postman
$input = json_decode(file_get_contents("php://input"), true);

// Hanya butuh ID untuk menghapus
$id = $input['id'] ?? null;

if ($id) {
    try {
        $stmt = $conn->prepare("DELETE FROM barang WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(["status" => "sukses", "pesan" => "Data barang berhasil dihapus!"]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["status" => "error", "pesan" => $e->getMessage()]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "gagal", "pesan" => "ID barang wajib dikirim!"]);
}
?>