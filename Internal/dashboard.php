<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: ../Authentication/login.php"); 
    exit(); 
}

$total_barang = $conn->query("SELECT COUNT(*) FROM barang")->fetchColumn();
$total_stok = $conn->query("SELECT SUM(jumlah) FROM barang")->fetchColumn(); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Lego Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h2 class="mb-4 text-dark fw-bold">Dashboard Overview</h2>
        
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card card-custom text-white bg-dark p-4 h-100 shadow-sm border-0">
                    <h5 class="text-white-50">Total Model Lego</h5>
                    <h1 class="display-5 fw-bold"><?= $total_barang ?> <span class="fs-5 fw-normal">Model</span></h1>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card card-custom text-white bg-secondary p-4 h-100 shadow-sm border-0">
                    <h5 class="text-white-50">Total Stok Tersedia</h5>
                    <h1 class="display-5 fw-bold"><?= $total_stok ?? 0 ?> <span class="fs-5 fw-normal">Unit Box</span></h1>
                </div>
            </div>
        </div>
        
        <div class="card card-custom p-4 shadow-sm border-0 bg-white">
            <h5 class="text-muted mb-0">Selamat datang di panel admin. Gunakan navigasi di kiri untuk mengelola katalog.</h5>
        </div>
    </div>

</body>
</html>