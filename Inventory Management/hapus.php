<?php
session_start();
include '../koneksi.php';

// Proteksi agar tidak bisa dieksekusi tanpa login
if (!isset($_SESSION['user_id'])) { 
    header("Location: ../Authentication/login.php"); 
    exit(); 
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // (Opsional) Jika ingin menghapus file gambar fisik dari folder saat data dihapus
    $stmt_cek = $conn->prepare("SELECT gambar FROM barang WHERE id = ?");
    $stmt_cek->execute([$id]);
    $data = $stmt_cek->fetch();
    
    if($data && !empty($data['gambar'])) {
        $file_path = '../' . $data['gambar'];
        if(file_exists($file_path)) {
            unlink($file_path); // Menghapus file gambar dari server
        }
    }

    // Menghapus data dari database
    $stmt = $conn->prepare("DELETE FROM barang WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: barang.php");
exit();
?>