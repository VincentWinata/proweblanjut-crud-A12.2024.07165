<?php
include '../koneksi.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$barang_list = $conn->query("SELECT * FROM barang ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Inventaris - RetailPro</title>
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
                    <a href="../dashboard.php" class="nav-link">
                        🏠 Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="barang.php" class="nav-link active">
                        📦 Kelola Inventaris
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../kelola_user.php" class="nav-link">
                        👤 Kelola User
                    </a>
                </li>
            </ul>
            
            <hr class="border-secondary">
            <div class="dropdown">
                <span class="d-flex align-items-center text-white text-decoration-none">
                    <strong>👋 Halo, <?= htmlspecialchars($_SESSION['username']) ?></strong>
                </span>
                <a href="../logout.php" class="btn btn-outline-danger btn-sm w-100 mt-3">🚪 Logout</a>
            </div>
        </div>
        <div class="flex-grow-1 p-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-dark fw-bold">Inventaris Barang</h2>
            </div>
            
            <div class="card card-custom p-4 shadow-sm border-0">
                <div class="row mb-4 align-items-center">
                    <div class="col-md-6">
                        <a href="tambah.php" class="btn btn-primary">+ Tambah Barang Baru</a>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white">🔍</span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari nama atau kategori barang...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tableBarang">
                        <thead class="table-dark">
                            <tr>
                                <th>Gambar</th>
                                <th>Kategori</th>
                                <th>Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Tanggal Masuk</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barang_list as $row): ?>
                            <tr>
                                <td>
                                    <img src="<?= $row['gambar'] ? htmlspecialchars($row['gambar']) : 'https://via.placeholder.com/70?text=No+Image' ?>" class="thumbnail" alt="Gambar">
                                </td>
                                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row['kategori']) ?></span></td>
                                <td>
                                    <strong><?= htmlspecialchars($row['nama_barang']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($row['deskripsi']) ?></small>
                                </td>
                                <td class="text-success fw-bold">Rp. <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                <td><?= $row['jumlah'] ?></td> 
                                <td>
                                    <small><?= date('d M Y, H:i', strtotime($row['tanggal_masuk'])) ?></small>
                                </td>
                                <td class="text-center">
                                    <a href="../edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>