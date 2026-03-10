<?php
include 'koneksi.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$total_barang = $conn->query("SELECT COUNT(*) FROM barang")->fetchColumn();
$total_stok = $conn->query("SELECT SUM(jumlah) FROM barang")->fetchColumn(); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="d-flex">
        
        <div class="sidebar d-flex flex-column p-3 text-white" style="width: 260px;">
            <div class="logo-container">
                <a href="dashboard.php" class="logo-text">🛒 Retail</a>
            </div>
            
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link active">
                        🏠 Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="barang.php" class="nav-link">
                        📦 Kelola Inventaris
                    </a>
                </li>
                <li class="nav-item">
                    <a href="kelola_user.php" class="nav-link">
                        👤 Kelola Admin
                    </a>
                </li>
            </ul>
            
            <hr class="border-secondary">
            <div class="dropdown">
                <span class="d-flex align-items-center text-white text-decoration-none">
                    <strong>👋 Halo, <?= htmlspecialchars($_SESSION['username']) ?></strong>
                </span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm w-100 mt-3">🚪 Logout</a>
            </div>
        </div>

        <div class="flex-grow-1 p-5">
            <h2 class="mb-4 text-dark fw-bold">Dashboard Overview</h2>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card card-custom text-white bg-primary p-4 h-100 shadow-sm border-0">
                        <h5 class="text-white-50">Total Jenis Barang</h5>
                        <h1 class="display-5 fw-bold"><?= $total_barang ?> <span class="fs-5 fw-normal">Item</span></h1>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card card-custom text-white bg-success p-4 h-100 shadow-sm border-0">
                        <h5 class="text-white-50">Total Stok Tersedia</h5>
                        <h1 class="display-5 fw-bold"><?= $total_stok ?? 0 ?> <span class="fs-5 fw-normal">Unit</span></h1>
                    </div>
                </div>
            </div>
            
            <div class="card card-custom p-4 shadow-sm border-0">
                <h5 class="text-muted mb-0">Pilih menu di sidebar sebelah kiri untuk mulai mengelola sistem.</h5>
            </div>
        </div>
        
    </div>
</body>
</html>