<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $sql = "INSERT INTO barang (nama_barang, harga, stok) VALUES (:nama_barang, :harga, :stok)";
    $stmt = $conn->prepare($sql);
    
    $stmt->execute([
        ':nama_barang' => $nama_barang,
        ':harga' => $harga,
        ':stok' => $stok
    ]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Tambah Barang Baru</h2>
    <form method="POST">
        Nama Barang: <input type="text" name="nama_barang" required><br><br>
        Harga: <input type="number" step="0.01" name="harga" required><br><br>
        Stok: <input type="number" name="stok" required><br><br>
        <button type="submit">Simpan</button>
    </form>
    <br>
    <a href="index.php">Kembali</a>
</body>
</html>