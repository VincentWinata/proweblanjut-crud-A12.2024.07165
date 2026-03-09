<?php
include 'koneksi.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$total_barang = $conn->query("SELECT COUNT(*) FROM barang")->fetchColumn();
$total_stok = $conn->query("SELECT SUM(stok) FROM barang")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <nav class="navbar navbar-dark navbar-custom px-4">
        <a class="navbar-brand fw-bold" href="#">RetailAdmin</a>
        <span class="text-white">Halo, <?= htmlspecialchars($_SESSION['username']) ?> | <a href="logout.php" class="text-light">Logout</a></span>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4">Dashboard Overview</h2>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card card-custom text-white bg-primary p-4">
                    <h5>Total Jenis Barang</h5>
                    <h2><?= $total_barang ?> Item</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-custom text-white bg-success p-4">
                    <h5>Total Stok Tersedia</h5>
                    <h2><?= $total_stok ?? 0 ?> Unit</h2>
                </div>
            </div>
        </div>
        <a href="barang.php" class="btn btn-dark btn-lg">Kelola Inventaris</a>
        <a href="tambah_user.php" class="btn btn-outline-dark btn-lg">Tambah Admin Baru</a>
    </div>
</body>
</html>