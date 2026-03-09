<?php
include 'koneksi.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$barang_list = $conn->query("SELECT * FROM barang ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Inventaris Barang</h2>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </div>
        
        <div class="card card-custom p-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="tambah.php" class="btn btn-primary">+ Tambah Barang</a>
                </div>
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="🔍 Cari nama atau kategori...">
                </div>
            </div>

            <table class="table table-hover align-middle" id="tableBarang">
                <thead class="table-dark">
                    <tr>
                        <th>Gambar</th>
                        <th>Kategori</th>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($barang_list as $row): ?>
                    <tr>
                        <td>
                            <img src="<?= $row['gambar'] ? htmlspecialchars($row['gambar']) : 'https://via.placeholder.com/70' ?>" class="thumbnail">
                        </td>
                        <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row['kategori']) ?></span></td>
                        <td>
                            <strong><?= htmlspecialchars($row['nama_barang']) ?></strong><br>
                            <small class="text-muted"><?= htmlspecialchars($row['deskripsi']) ?></small>
                        </td>
                        <td class="text-success fw-bold">Rp. <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['stok'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>