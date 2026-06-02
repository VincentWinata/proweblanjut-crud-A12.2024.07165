<?php
// api/db.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "retail_db"; // Menggunakan database retail yang sudah kita buat sebelumnya

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die(json_encode(["error" => "Koneksi gagal: " . $e->getMessage()]));
}
?>