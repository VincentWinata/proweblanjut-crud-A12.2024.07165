<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: ../Authentication/login.php"); 
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gambar_path_db = null;
    
    // Proses Upload Gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $nama_file = time() . '_' . basename($_FILES['gambar']['name']);
        $lokasi_simpan = '../assets/images/' . $nama_file;
        $gambar_path_db = 'assets/images/' . $nama_file; // Ini yang disimpan di DB
        
        move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi_simpan);
    }
    
    $tanggal_masuk = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO barang (nama_barang, kategori, harga, jumlah, deskripsi, gambar, tanggal_masuk) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['nama_barang'], $_POST['kategori'], $_POST['harga'], $_POST['jumlah'], $_POST['deskripsi'], $gambar_path_db, $tanggal_masuk]);
    
    header("Location: barang.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Model - Lego Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card card-custom p-5 col-md-8 mx-auto shadow-sm">
            <h4 class="mb-4 fw-bold" style="letter-spacing: 1px;">TAMBAH MODEL KENDARAAN</h4>
            <form method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label text-muted small fw-bold text-uppercase">Nama Model</label>
                        <input type="text" name="nama_barang" class="form-control rounded-0" required autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold text-uppercase">Seri / Kategori</label>
                        <select name="kategori" class="form-select rounded-0">
                            <option value="Technic">Lego Technic</option>
                            <option value="Icons">Lego Icons</option>
                            <option value="Speed Champions">Speed Champions</option>
                            <option value="Creator Expert">Creator Expert</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label text-muted small fw-bold text-uppercase">Harga (IDR)</label>
                        <input type="number" name="harga" class="form-control rounded-0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold text-uppercase">Jumlah Box (Stok)</label>
                        <input type="number" name="jumlah" class="form-control rounded-0" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase">Deskripsi Fitur</label>
                    <textarea name="deskripsi" class="form-control rounded-0" rows="3"></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold text-uppercase">Upload Visual (PNG/JPG)</label>
                    <input type="file" name="gambar" id="gambarInput" class="form-control rounded-0" accept="image/*">
                    <div class="text-center mt-3">
                        <img id="preview" alt="Preview Image" class="img-fluid border p-2" style="max-height: 250px; display: none;">
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark rounded-0 fw-bold px-4" style="letter-spacing: 1px;">SIMPAN KE KATALOG</button>
                    <a href="barang.php" class="btn btn-outline-secondary rounded-0 px-4">BATAL</a>
                </div>
            </form>
        </div>
    </div>
    <script src="../assets/script.js"></script>
</body>
</html>