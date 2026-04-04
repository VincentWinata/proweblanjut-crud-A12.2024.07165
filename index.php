<?php
include 'koneksi.php';
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
                    Login / Sign Up
                </a>
            </div>
        </div>
    </nav>

    <div class="hero-banner">
        <div class="hero-bg-blurred" style="background-image: url('assets/images/hero-banner.jpg');"></div>
        <div class="hero-bg-sharp" style="background-image: url('assets/images/hero-banner.jpg');"></div>
        
        <div class="container hero-content">
            <div class="hero-text-wrapper" id="heroTextContainer">
                <h1 class="hero-title" id="heroTitle">FIRST CLASS COMFORT & ENGINEERING</h1>
                <p class="lead fw-light hero-subtitle" id="heroDesc" style="letter-spacing: 2px;">Explore the Ultimate Lego Car Lineup.</p>
                <a href="#katalogGrid" id="heroBtn" class="btn btn-outline-light rounded-0 px-4 py-2 mt-3 hero-action-btn" style="letter-spacing: 2px; text-transform: uppercase;">
                    EXPLORE THE LINEUP
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="minimal-nav-wrapper">
            <ul class="minimal-nav-links category-filter-tabs">
                <li><a href="#" class="nav-link active" data-filter="all">ALL MODELS</a></li>
                <li><a href="#" class="nav-link" data-filter="Technic">TECHNIC</a></li>
                <li><a href="#" class="nav-link" data-filter="Icons">ICONS</a></li>
                <li><a href="#" class="nav-link" data-filter="Speed Champions">SPEED CHAMPIONS</a></li>
            </ul>
        </div>

        <div class="product-cluster" id="katalogGrid">
            <?php foreach ($barang_list as $row): ?>
            <a href="#" class="cluster-item product-item" data-category="<?= htmlspecialchars($row['kategori']) ?>">
                <div class="cluster-img-container">
                    <img src="<?= $row['gambar'] ? htmlspecialchars($row['gambar']) : 'https://via.placeholder.com/400x200?text=No+Image' ?>" alt="<?= htmlspecialchars($row['nama_barang']) ?>">
                </div>
                <div class="cluster-info">
                    <span class="cluster-name"><?= htmlspecialchars($row['nama_barang']) ?></span>
                    <span class="cluster-desc">
                        <?= htmlspecialchars($row['kategori']) ?><br>
                        <?= htmlspecialchars($row['jumlah']) ?> Pieces
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        
        <?php if(count($barang_list) == 0): ?>
            <div class="text-center text-muted py-5 mt-4">
                <h5 class="fw-light">Koleksi mobil belum tersedia saat ini.</h5>
            </div>
        <?php endif; ?>

        <div class="text-center mt-5 mb-5">
            <a href="#" class="btn btn-outline-dark rounded-0 px-4 py-2" style="letter-spacing: 1.5px; text-transform: uppercase;">Compare Models</a>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>