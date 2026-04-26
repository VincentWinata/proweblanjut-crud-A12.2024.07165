<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Model - Lego Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="bg-light">
    <div class="admin-layout">
        
        <?php include '../app/views/admin/sidebar.php'; ?>

        <main class="main-content">
            <div class="container-fluid">
                <div class="card card-custom p-5 col-md-8 mx-auto shadow-sm">
                    <h4 class="mb-4 fw-bold" style="letter-spacing: 1px;">UBAH DATA MODEL</h4>
                    
                    <?php if(!empty($error_msg)): ?>
                        <div class="alert alert-danger rounded-0 border-0 shadow-sm">
                            <strong>Peringatan:</strong> <?= $error_msg ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label text-muted small fw-bold text-uppercase">Nama Model</label>
                                <input type="text" name="nama_barang" class="form-control rounded-0" value="<?= htmlspecialchars($_POST['nama_barang'] ?? $data_barang['nama_barang']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase">Seri / Kategori</label>
                                <select name="kategori" class="form-select rounded-0">
                                    <?php $selected_kat = $_POST['kategori'] ?? $data_barang['kategori']; ?>
                                    <option value="Technic" <?= $selected_kat == 'Technic' ? 'selected' : '' ?>>Lego Technic</option>
                                    <option value="Icons" <?= $selected_kat == 'Icons' ? 'selected' : '' ?>>Lego Icons</option>
                                    <option value="Speed Champions" <?= $selected_kat == 'Speed Champions' ? 'selected' : '' ?>>Speed Champions</option>
                                    <option value="Creator Expert" <?= $selected_kat == 'Creator Expert' ? 'selected' : '' ?>>Creator Expert</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label text-muted small fw-bold text-uppercase">Harga (IDR)</label>
                                <input type="number" name="harga" class="form-control rounded-0" value="<?= htmlspecialchars($_POST['harga'] ?? $data_barang['harga']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase">Jumlah Box (Stok)</label>
                                <input type="number" name="jumlah" class="form-control rounded-0" value="<?= htmlspecialchars($_POST['jumlah'] ?? $data_barang['jumlah']) ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Tanggal Masuk (Read-Only)</label>
                            <input type="text" class="form-control rounded-0 bg-light text-muted" value="<?= date('d F Y, H:i', strtotime($data_barang['tanggal_masuk'])) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Deskripsi Fitur</label>
                            <textarea name="deskripsi" class="form-control rounded-0" rows="3"><?= htmlspecialchars($_POST['deskripsi'] ?? $data_barang['deskripsi']) ?></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold text-uppercase">Ubah Visual (Opsional)</label>
                            <input type="file" name="gambar" id="gambarInput" class="form-control rounded-0" accept="image/png, image/jpeg, image/jpg">
                            <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG. Max: 2MB.</small>
                            <div class="text-center mt-3">
                                <small class="text-muted d-block mb-2">Visual Saat Ini:</small>
                                <img id="preview" src="<?= !empty($data_barang['gambar']) ? htmlspecialchars($data_barang['gambar']) : 'https://via.placeholder.com/200x150?text=No+Image' ?>" class="img-fluid border p-2" style="max-height: 250px;">
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark rounded-0 fw-bold px-4" style="letter-spacing: 1px;">SIMPAN PERUBAHAN</button>
                            <a href="index.php?action=barang" class="btn btn-outline-secondary rounded-0 px-4">BATAL</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>