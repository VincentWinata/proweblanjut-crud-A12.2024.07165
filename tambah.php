<?php
include 'koneksi.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gambar_path = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar_path = 'uploads/' . time() . '_' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar_path);
    }
    $tanggal_masuk = date('Y-m-d H:i:s');
    $sql = "INSERT INTO barang (nama_barang, kategori, harga, jumlah, deskripsi, gambar, tanggal_masuk) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['nama_barang'], $_POST['kategori'], $_POST['harga'], $_POST['jumlah'], $_POST['deskripsi'], $gambar_path, $tanggal_masuk]);
    
    header("Location: barang.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card card-custom p-4 col-md-8 mx-auto shadow-sm">
            <h3 class="mb-4">Tambah Data Barang</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required autocomplete="off">
                    </div>
                    <div class="col">
                        <label>Kategori</label>
                        <select name="kategori" class="form-select">
                            <option>Pakaian</option>
                            <option>Elektronik</option>
                            <option>Makanan</option>
                            <option>Aksesoris</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="col">
                        <label>Jumlah</label> <input type="number" name="jumlah" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>
                <div class="mb-4">
                    <label>Upload Gambar</label>
                    <input type="file" name="gambar" id="gambarInput" class="form-control" accept="image/*">
                    <img id="preview" alt="Preview Image" class="mt-2" style="max-height: 200px; display: none; border-radius: 8px;">
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2">Simpan ke Inventaris</button>
                <a href="barang.php" class="btn btn-outline-secondary w-100">Batal</a>
            </form>
        </div>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>