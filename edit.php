<?php
include 'koneksi.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$id = $_GET['id'];
$barang = $conn->prepare("SELECT * FROM barang WHERE id = ?");
$barang->execute([$id]);
$data = $barang->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gambar_path = $data['gambar']; 
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar_path = 'uploads/' . time() . '_' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar_path);
    }

    // UBAH: stok menjadi jumlah (tanggal_masuk tidak ikut di-update)
    $sql = "UPDATE barang SET nama_barang=?, kategori=?, harga=?, jumlah=?, deskripsi=?, gambar=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['nama_barang'], $_POST['kategori'], $_POST['harga'], $_POST['jumlah'], $_POST['deskripsi'], $gambar_path, $id]);
    
    header("Location: barang.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card card-custom p-4 col-md-8 mx-auto shadow-sm">
            <h3 class="mb-4">Edit Data Barang</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($data['nama_barang']) ?>" required>
                    </div>
                    <div class="col">
                        <label>Kategori</label>
                        <select name="kategori" class="form-select">
                            <option <?= $data['kategori'] == 'Pakaian' ? 'selected' : '' ?>>Pakaian</option>
                            <option <?= $data['kategori'] == 'Elektronik' ? 'selected' : '' ?>>Elektronik</option>
                            <option <?= $data['kategori'] == 'Makanan' ? 'selected' : '' ?>>Makanan</option>
                            <option <?= $data['kategori'] == 'Aksesoris' ? 'selected' : '' ?>>Aksesoris</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
                    </div>
                    <div class="col">
                        <label>Jumlah</label> <input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah'] ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label>Tanggal Masuk (Otomatis)</label>
                    <input type="text" class="form-control bg-light text-muted" value="<?= date('d F Y, H:i', strtotime($data['tanggal_masuk'])) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                </div>
                <div class="mb-4">
                    <label>Upload Gambar Baru (Opsional)</label>
                    <input type="file" name="gambar" id="gambarInput" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2">Update Barang</button>
                <a href="barang.php" class="btn btn-outline-secondary w-100">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>