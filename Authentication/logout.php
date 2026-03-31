<?php
session_start();

// Hapus semua Session [cite: 194]
session_unset();
session_destroy();

// Hapus Cookie Remember Me dengan mengembalikan waktu ke belakang (-3600 detik) 
if(isset($_COOKIE['user_id'])) {
    setcookie("user_id", "", time() - 3600, "/");
}
if(isset($_COOKIE['username'])) {
    setcookie("username", "", time() - 3600, "/");
}

// Arahkan kembali ke halaman login di folder yang sama [cite: 196]
header("Location: login.php");
exit();
?>