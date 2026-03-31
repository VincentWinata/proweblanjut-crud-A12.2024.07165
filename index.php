<?php
include 'koneksi.php';

// Ambil semua barang yang jumlahnya lebih dari 0 (stok tersedia)
$stmt = $conn->query("SELECT * FROM barang WHERE jumlah > 0 ORDER BY id DESC");
$barang_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lego Collection | First Class Experience</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body style="background-color: #fff;">

    <nav class="navbar navbar-expand-lg navbar-store sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Lexus_logo.svg" height="24" class="me-3" style="filter: brightness(0) invert(1);" alt="Brand Logo">
                LEGO COLLECTION
            </a>
            <div>
                <a href="Authentication/login.php" class="nav-link text-white text-uppercase" style="font-size: 0.8rem; letter-spacing: 2px;">
                    <span class="me-2"></span> Login / Sign Up
                </a>
            </div>
        </div>
    </nav>

    <div class="hero-banner" style="background-image: url('assets/images/hero-banner.jpg');">
        <div class="container">
            <h1 class="hero-title">FIRST CLASS COMFORT & ENGINEERING</h1>
            <p class="lead fw-light" style="letter-spacing: 2px;">Explore the Ultimate Lego Car Lineup.</p>
        </div>
    </div>

    <div class="container py-5">
        
        <ul class="nav nav-pills justify-content-center category-filter-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-filter="all">ALL MODELS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="Technic">TECHNIC</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="Icons">ICONS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="Speed Champions">SPEED CHAMPIONS</a>
            </li>
        </ul>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 mt-2" id="katalogGrid">
            <?php foreach ($barang_list as $row): ?>
            <div class="col product-item" data-category="<?= htmlspecialchars($row['kategori']) ?>">
                <div class="card product-card h-100 text-center">
                    <div class="product-img-wrapper">
                        <img src="<?= $row['gambar'] ? htmlspecialchars($row['gambar']) : 'https://via.placeholder.com/300x200?text=No+Image' ?>" alt="<?= htmlspecialchars($row['nama_barang']) ?>">
                    </div>
                    <div class="card-body pt-4">
                        <small class="text-muted text-uppercase fw-bold" style="letter-spacing: 1.5px; font-size: 0.75rem;">
                            <?= htmlspecialchars($row['kategori']) ?>
                        </small>
                        <h5 class="card-title fw-bold mt-2 mb-1" style="color: #111;">
                            <?= htmlspecialchars($row['nama_barang']) ?>
                        </h5>
                        <p class="text-muted small mb-3 text-truncate" title="<?= htmlspecialchars($row['deskripsi']) ?>">
                            <?= htmlspecialchars($row['deskripsi']) ?>
                        </p>
                        <a href="#" class="btn btn-outline-dark btn-sm rounded-0 px-4 py-2" style="letter-spacing: 1px;">
                            EXPLORE MODEL
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if(count($barang_list) == 0): ?>
            <div class="text-center text-muted py-5 mt-4">
                <h5 class="fw-light">Koleksi mobil belum tersedia saat ini.</h5>
            </div>
        <?php endif; ?>

    </div>

    <script src="assets/script.js"></script>
</body>
</html>