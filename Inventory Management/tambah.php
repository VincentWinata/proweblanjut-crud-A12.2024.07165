<?php
session_start();
include '../koneksi.php';

// Proteksi halaman admin
if (!isset($_SESSION['user_id'])) { 
    header("Location: ../Authentication/login.php"); 
    exit(); 
}

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Validasi Input Sisi Server
    $nama_barang = trim($_POST['nama_barang']);
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = trim($_POST['deskripsi']);

    if (empty($nama_barang)) {
        $error_msg = "Nama model tidak boleh kosong.";
    } elseif (!is_numeric($harga) || $harga < 0) {
        $error_msg = "Harga harus berupa angka valid dan tidak boleh negatif.";
    } elseif (!is_numeric($jumlah) || $jumlah < 0) {
        $error_msg = "Jumlah stok harus berupa angka valid dan tidak boleh negatif.";
    } else {
        
        // 2. Logika Unggah File Gambar (Syarat Tugas 3)
        $gambar_path_db = NULL; // Default jika tidak ada gambar yang diunggah

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['gambar']['tmp_name'];
            $file_name = $_FILES['gambar']['name'];
            $file_size = $_FILES['gambar']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_ext = ['jpg', 'jpeg', 'png'];

            // Validasi Tipe dan Ukuran File
            if (!in_array($file_ext, $allowed_ext)) {
                $error_msg = "Gagal: Hanya format JPG, JPEG, dan PNG yang diizinkan.";
            } elseif ($file_size > 2097152) { // Batas 2MB
                $error_msg = "Gagal: Ukuran gambar maksimal 2MB.";
            } else {
                // Buat nama unik dan pindahkan file ke folder uploads
                $nama_unik = uniqid() . '_' . basename($file_name);
                
                // Penting: Path penyimpanan fisik naik satu level (../) dari folder Inventory Management
                $lokasi_simpan = '../uploads/' . $nama_unik; 
                
                // Path yang disimpan ke database (untuk dipanggil via HTML src)
                $gambar_path_db = 'uploads/' . $nama_unik; 
                
                if (!move_uploaded_file($file_tmp, $lokasi_simpan)) {
                    $error_msg = "Sistem gagal memindahkan file gambar ke server.";
                }
            }
        } elseif (isset($_FILES['gambar']) && $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
             $error_msg = "Terjadi kesalahan saat mengunggah file. Pastikan ukuran file tidak melebihi limit server.";
        }

        // 3. Eksekusi Prepared Statements (Hanya jika tidak ada error)
        if (empty($error_msg)) {
            try {
                $sql = "INSERT INTO barang (nama_barang, kategori, harga, jumlah, deskripsi, gambar, tanggal_masuk) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$nama_barang, $kategori, $harga, $jumlah, $deskripsi, $gambar_path_db]);
                
                header("Location: barang.php"); 
                exit();
            } catch(PDOException $e) {
                $error_msg = "Database Error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Model - Lego Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="bg-light">
    <div class="admin-layout">
        
        <?php include '../Internal/sidebar.php'; ?>

        <main class="main-content">
            <div class="container-fluid">
                <div class="card card-custom p-5 col-md-8 mx-auto shadow-sm">
                    <h4 class="mb-4 fw-bold" style="letter-spacing: 1px;">TAMBAH MODEL BARU</h4>
                    
                    <?php if(!empty($error_msg)): ?>
                        <div class="alert alert-danger rounded-0 border-0 shadow-sm">
                            <strong>Peringatan:</strong> <?= $error_msg ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label text-muted small fw-bold text-uppercase">Nama Model</label>
                                <input type="text" name="nama_barang" class="form-control rounded-0" value="<?= htmlspecialchars($_POST['nama_barang'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase">Seri / Kategori</label>
                                <select name="kategori" class="form-select rounded-0">
                                    <?php $selected_kat = $_POST['kategori'] ?? ''; ?>
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
                                <input type="number" name="harga" class="form-control rounded-0" value="<?= htmlspecialchars($_POST['harga'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase">Jumlah Box (Stok)</label>
                                <input type="number" name="jumlah" class="form-control rounded-0" value="<?= htmlspecialchars($_POST['jumlah'] ?? '') ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Deskripsi Fitur</label>
                            <textarea name="deskripsi" class="form-control rounded-0" rows="3"><?= htmlspecialchars($_POST['deskripsi'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold text-uppercase">Unggah Gambar Produk</label>
                            <input type="file" name="gambar" id="gambarInput" class="form-control rounded-0" accept="image/png, image/jpeg, image/jpg">
                            <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG. Max: 2MB.</small>
                            <div class="text-center mt-3">
                                <img id="preview" src="#" alt="Preview Gambar" class="img-fluid border p-2" style="max-height: 250px; display: none;">
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark rounded-0 fw-bold px-4" style="letter-spacing: 1px;">SIMPAN MODEL</button>
                            <a href="barang.php" class="btn btn-outline-secondary rounded-0 px-4">BATAL</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../assets/script.js"></script>
</body>
</html>