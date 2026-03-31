<?php
include '../koneksi.php';
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM barang WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}
header("Location: ../barang.php");
exit();
?>