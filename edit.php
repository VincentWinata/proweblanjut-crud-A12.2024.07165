<?php
include 'koneksi.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$id = $_GET['id'];
$barang = $conn->prepare("SELECT * FROM barang WHERE id = ?");
$barang->execute([$id]);
$data = $barang->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gambar_path = $data['gambar']; 
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar_path = 'uploads/' . time() . '_' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar_path);
    }

    $sql = "UPDATE barang SET nama_barang=?, kategori=?, harga=?, stok=?, deskripsi=?, gambar=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['nama_barang'], $_POST['kategori'], $_POST['harga'], $_POST['stok'], $_POST['deskripsi'], $gambar_path, $id]);
    
    header("Location: barang.php"); exit();
}
?>