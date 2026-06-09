<?php
require_once 'app/models/user_model.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    // TUGAS 6: Pendaftaran dengan Password Hashing
    public function register() {
        $pesan = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // 1. Lakukan Hashing pada Password menggunakan fungsi bawaan PHP
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 2. Simpan ke database melalui Model
            if ($this->userModel->registerUser($username, $hashed_password)) {
                $pesan = "Registrasi berhasil! Silakan login.";
                // Opsional: header("Location: index.php?action=login");
            } else {
                $pesan = "Gagal mendaftar!";
            }
        }
        // Tampilkan halaman view register
        require 'app/views/auth/register.php';
    }

    // TUGAS 6: Login dengan Password Verify
    public function login() {
        $pesan = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // 1. Ambil data user dari database
            $user = $this->userModel->getUserByUsername($username);

            // 2. Verifikasi apakah password yang diketik cocok dengan Hash di database
            if ($user && password_verify($password, $user['password'])) {
                // Sesi login berhasil
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit;
            } else {
                $pesan = "Username atau password salah!";
            }
        }
        // Tampilkan halaman view login
        require 'app/views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}
?>