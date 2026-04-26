<?php
// public/index.php

// 1. Inisialisasi Lingkungan
session_start();
require_once '../app/koneksi.php';

// 2. Tentukan aksi dari URL (default: home)
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

if ($action == 'home') {
    require_once '../app/controllers/barang_controller.php';
    $controller = new BarangController($conn);
    $controller->index();
} 

// --- RUTE AUTENTIKASI ---
elseif ($action == 'login') {
    require_once '../app/controllers/auth_controller.php';
    $controller = new AuthController($conn);
    $controller->login();
}
elseif ($action == 'register') {
    require_once '../app/controllers/auth_controller.php';
    $controller = new AuthController($conn);
    $controller->register();
}
elseif ($action == 'logout') {
    require_once '../app/controllers/auth_controller.php';
    $controller = new AuthController($conn);
    $controller->logout();
}

// --- RUTE ADMIN (Dashboard & Kelola User) ---
elseif ($action == 'dashboard') {
    require_once '../app/controllers/admin_controller.php';
    $controller = new AdminController($conn);
    $controller->dashboard();
} 
elseif ($action == 'kelola_user') {
    require_once '../app/controllers/admin_controller.php';
    $controller = new AdminController($conn);
    $controller->kelolaUser();
}

// --- RUTE CRUD BARANG ---
elseif ($action == 'barang') {
    require_once '../app/controllers/barang_controller.php';
    $controller = new BarangController($conn);
    $controller->adminIndex();
}
elseif ($action == 'tambah_barang') {
    require_once '../app/controllers/barang_controller.php';
    $controller = new BarangController($conn);
    $controller->create();
}
elseif ($action == 'edit_barang') {
    require_once '../app/controllers/barang_controller.php';
    $controller = new BarangController($conn);
    $controller->edit();
}
elseif ($action == 'hapus_barang') {
    require_once '../app/controllers/barang_controller.php';
    $controller = new BarangController($conn);
    $controller->destroy();
}

// --- FALLBACK ---
else {
    echo "<div style='text-align:center; margin-top:50px;'>";
    echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
    echo "<a href='index.php?action=home'>Kembali ke Beranda</a>";
    echo "</div>";
}
?>