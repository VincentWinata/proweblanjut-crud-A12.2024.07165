<?php
// app/controllers/admin_controller.php

require_once '../app/models/user_model.php';

class AdminController {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    // Fungsi untuk memuat halaman Dashboard Admin
    public function dashboard() {
        if (!isset($_SESSION['user_id'])) { 
            header("Location: index.php?action=login"); 
            exit(); 
        }

        // Ambil data statistik untuk Dashboard
        $total_barang = $this->conn->query("SELECT COUNT(*) FROM barang")->fetchColumn();
        $total_stok = $this->conn->query("SELECT SUM(jumlah) FROM barang")->fetchColumn(); 

        // Tampilkan View Dashboard
        require_once '../app/views/admin/dashboard.php';
    }

    // Fungsi untuk memuat halaman Kelola Admin (User)
    public function kelolaUser() {
        if (!isset($_SESSION['user_id'])) { 
            header("Location: index.php?action=login"); 
            exit(); 
        }

        $userModel = new UserModel($this->conn);
        $success = null;
        $error = null;

        // Proses Tambah User Baru
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_user'])) {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
            try {
                $userModel->createUser($username, $password);
                $success = "Akses admin baru berhasil ditambahkan.";
            } catch(PDOException $e) { 
                $error = "Gagal menambah admin. Username mungkin sudah terpakai."; 
            }
        }

        // Proses Hapus User
        if (isset($_GET['hapus'])) {
            $id_hapus = $_GET['hapus'];
            if ($id_hapus == $_SESSION['user_id']) {
                $error = "Tindakan ditolak. Anda tidak dapat menghapus akun yang sedang digunakan.";
            } else {
                $userModel->deleteUser($id_hapus);
                header("Location: index.php?action=kelola_user"); 
                exit();
            }
        }

        // Ambil daftar user untuk ditampilkan
        $users_list = $userModel->getAllUsers();
        
        // Tampilkan View Kelola User
        require_once '../app/views/admin/kelola_user.php';
    }
}
?>