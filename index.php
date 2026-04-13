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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body style="background-color: #fff;" class="is-frontend">

    <nav class="navbar navbar-expand-lg navbar-store fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center m-0" href="index.php">
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Lexus_logo.svg" height="20" class="me-3" style="filter: brightness(0) invert(1);" alt="Brand Logo">
                <span style="font-size: 1.1rem; letter-spacing: 3px;">LEGO COLLECTION</span>
            </a>
            
            <div class="d-flex align-items-center gap-4">
                <a href="#" class="nav-link text-white text-uppercase d-none d-md-flex align-items-center" style="font-size: 0.8rem; letter-spacing: 1.5px;">
                    <i class="fas fa-sliders-h me-2"></i> Configure
                </a>
                <a href="#" class="nav-link text-white text-uppercase d-none d-md-flex align-items-center" style="font-size: 0.8rem; letter-spacing: 1.5px;">
                    <i class="fab fa-whatsapp me-2" style="font-size: 1.1rem;"></i> WhatsApp
                </a>
                <a href="Authentication/login.php" class="nav-link text-white text-uppercase d-flex align-items-center" style="font-size: 0.8rem; letter-spacing: 1.5px;">
                    <i class="far fa-user-circle me-2" style="font-size: 1.1rem;"></i> Login
                </a>
            </div>
        </div>
    </nav>

    <div class="dynamic-banner">
        <div class="banner-bg-blurred" style="background-image: url('assets/images/hero-banner.jpg');"></div>
        <div class="banner-bg-sharp" style="background-image: url('assets/images/hero-banner.jpg');"></div>
        
        <div class="container banner-content">
            <div class="banner-text-wrapper">
                <h1 class="banner-title">FIRST CLASS COMFORT & ENGINEERING</h1>
                <p class="lead fw-light banner-subtitle" style="letter-spacing: 2px;">Explore the Ultimate Lego Car Lineup.</p>
                <a href="#parkingAreaSection" class="btn btn-outline-light rounded-0 px-4 py-2 mt-3 banner-btn" style="letter-spacing: 2px; text-transform: uppercase;">
                    EXPLORE THE LINEUP
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5" id="parkingAreaSection">
        <div class="minimal-nav-wrapper fade-in-element" id="parkingNav">
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
                   <img src="<?= !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'https://via.placeholder.com/400x200?text=Belum+Ada+Gambar' ?>" alt="<?= htmlspecialchars($row['nama_barang']) ?>">
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
 
        <div class="container">
            <div class="fade-in-element mt-5 mb-5 d-flex justify-content-start" id="parkingBtnWrapper" style="padding-left: 20px;">
                <a href="#" class="btn btn-outline-dark rounded-0 px-4 py-2" style="letter-spacing: 1.5px; text-transform: uppercase;">Compare Models</a>
            </div>
        </div>
    </div>

    <div class="dynamic-banner">
        <div class="banner-bg-blurred" style="background-image: url('assets/images/showroom.jpg');"></div>
        <div class="banner-bg-sharp" style="background-image: url('assets/images/showroom.jpg');"></div>
        
        <div class="container banner-content">
            <div class="banner-text-wrapper">
                <h1 class="banner-title">SHOWROOM MODELS</h1>
                <p class="lead fw-light banner-subtitle" style="letter-spacing: 2px;">Explore our exclusive in-store collection.</p>
                <a href="#" class="btn btn-outline-light rounded-0 px-4 py-2 mt-3 banner-btn" style="letter-spacing: 2px; text-transform: uppercase;">
                    FIND A STORE
                </a>
            </div>
        </div>
    </div>

    <div class="dynamic-banner">
        <div class="banner-bg-blurred" style="background-image: url('assets/images/commitment.jpg');"></div>
        <div class="banner-bg-sharp" style="background-image: url('assets/images/commitment.jpg');"></div>
        
        <div class="container banner-content">
            <div class="banner-text-wrapper">
                <h1 class="banner-title">OUR COMMITMENT</h1>
                <p class="lead fw-light banner-subtitle" style="letter-spacing: 2px;">Crafting the ultimate building experience.</p>
                <a href="#" class="btn btn-outline-light rounded-0 px-4 py-2 mt-3 banner-btn" style="letter-spacing: 2px; text-transform: uppercase;">
                    READ MORE
                </a>
            </div>
        </div>
    </div>

    <div class="dynamic-banner">
        <div class="banner-bg-blurred" style="background-image: url('assets/images/event.jpg');"></div>
        <div class="banner-bg-sharp" style="background-image: url('assets/images/event.jpg');"></div>
        
        <div class="container banner-content">
            <div class="banner-text-wrapper">
                <h1 class="banner-title">UPCOMING EVENTS</h1>
                <p class="lead fw-light banner-subtitle" style="letter-spacing: 2px;">Join our community of master builders.</p>
                <a href="#" class="btn btn-outline-light rounded-0 px-4 py-2 mt-3 banner-btn" style="letter-spacing: 2px; text-transform: uppercase;">
                    VIEW SCHEDULE
                </a>
            </div>
        </div>
    </div>

    <footer class="store-footer">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5>Discover Collection</h5>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">The Builder Pursuits</a></li>
                        <li><a href="#">News & Events</a></li>
                        <li><a href="#">Press Room</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5>Contact Us</h5>
                    <ul>
                        <li><a href="#">Find a Store</a></li>
                        <li><a href="#">Book a Demo</a></li>
                        <li><a href="#">Online Enquiry</a></li>
                    </ul>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="social-icons mb-3">
                        <span class="me-3">Join us on</span>
                        <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
                        <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                        <a href="#"><i class="fa-brands fa-x-twitter"></i> Twitter</a>
                        <a href="#"><i class="fab fa-youtube"></i> YouTube</a>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <p class="mb-3">Lego Collection Indonesia – PT Builder Astra Motor – Jl. Proklamasi No.35, Pegangsaan, Menteng,<br>Kota Jakarta Pusat, DKI Jakarta 10320</p>
                    <div class="d-flex align-items-center flex-wrap gap-4 mb-4">
                        <span>Contact us at</span>
                        <span><i class="fas fa-phone me-2"></i> +62 21 3909999</span>
                        <span><i class="fas fa-envelope me-2"></i> customercare@lego-collection.co.id</span>
                        <span><i class="fab fa-whatsapp me-2"></i> +62 821 80 900 900</span>
                    </div>
                </div>
            </div>

            <div class="footer-divider"></div>

            <div class="row pb-3 align-items-center">
                <div class="col-md-6">
                    <span class="me-4">Copyright &copy; Lego Collection 2026</span>
                    <a href="#" class="text-dark me-4 text-decoration-none hover-underline">Privacy & Legal</a>
                    <a href="#" class="text-dark text-decoration-none hover-underline">International Site <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i></a>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0 text-muted" style="font-size: 0.8rem;">
                    Model availability and specifications may vary by market.<br>
                    Contact your <a href="#" class="text-dark">local store</a> for more information.
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/script.js"></script>
</body>
</html>