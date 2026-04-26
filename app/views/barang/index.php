<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Inventaris - Lego Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css"> </head>
<body class="bg-light">
    <div class="admin-layout">
        
        <?php include '../app/views/admin/sidebar.php'; ?>

        <main class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-dark fw-bold" style="letter-spacing: 1px;">Katalog Kendaraan</h2>
            </div>
            
            <div class="card card-custom p-4 shadow-sm border-0">
                <div class="row mb-4 align-items-center">
                    <div class="col-md-6">
                        <a href="index.php?action=tambah_barang" class="btn btn-dark fw-bold rounded-0" style="letter-spacing: 1px;">+ TAMBAH MODEL BARU</a>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">Cari</span>
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Ketik nama atau kategori...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tableBarang">
                        <thead class="table-dark">
                            <tr class="text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">
                                <th>Visual</th>
                                <th>Kategori</th>
                                <th>Spesifikasi Model</th>
                                <th>Harga (IDR)</th>
                                <th>Stok</th>
                                <th>Tgl Masuk</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barang_list as $row): ?>
                            <tr>
                                <td>
                                    <img src="<?= !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'https://via.placeholder.com/70x50?text=No+Image' ?>" class="thumbnail rounded-1" alt="Gambar Model" style="object-fit: cover; width: 70px; height: 50px;">
                                </td>
                                <td><span class="badge bg-secondary rounded-0 fw-normal px-2 py-1"><?= htmlspecialchars($row['kategori']) ?></span></td>
                                <td>
                                    <strong style="color: #111;"><?= htmlspecialchars($row['nama_barang']) ?></strong><br>
                                    <small class="text-muted d-inline-block text-truncate" style="max-width: 200px;"><?= htmlspecialchars($row['deskripsi']) ?></small>
                                </td>
                                <td class="fw-bold">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars($row['jumlah']) ?> Unit</td> 
                                <td>
                                    <small class="text-muted"><?= date('d M Y, H:i', strtotime($row['tanggal_masuk'])) ?></small>
                                </td>
                                <td class="text-center">
                                    <a href="index.php?action=edit_barang&id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-dark mb-1 w-100 rounded-0">Edit</a>
                                    <a href="index.php?action=hapus_barang&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger w-100 rounded-0" onclick="return confirm('Hapus model ini dari katalog secara permanen?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if(count($barang_list) == 0): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <em>Belum ada data model kendaraan di inventaris.</em>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>