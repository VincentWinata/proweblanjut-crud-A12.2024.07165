<?php
// Pastikan rute file model tepat
require_once __DIR__ . '/../models/user_model.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function register() {
        $pesan = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $cek_user = $this->userModel->findByUsername($username);

            if ($cek_user) {
                $pesan = "Username '$username' sudah terdaftar! Silakan gunakan nama lain.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                try {
                    if ($this->userModel->createUser($username, $hashed_password)) {
                        // PERBAIKAN 1: Tampilkan pop-up sukses, lalu paksa pindah ke halaman Login
                        echo "<script>
                                alert('Registrasi berhasil! Silakan login dengan akun Anda.');
                                window.location.href = 'index.php?action=login';
                              </script>";
                        exit; // Hentikan eksekusi kode di sini
                    } else {
                        $pesan = "Gagal mendaftar!";
                    }
                } catch (PDOException $e) {
                    $pesan = "Terjadi kesalahan sistem: " . $e->getMessage();
                }
            }
        }
        
        require __DIR__ . '/../views/auth/register.php';
    }

    public function login() {
        $pesan = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $user = $this->userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // PERBAIKAN 2: Ubah tujuan halaman setelah login. 
                // Ganti tulisan di dalam tanda kutip ini dengan rute dashboard/kelola barang Anda!
                // Contoh: Jika halaman dashboard Anda diakses via ?action=dashboard
                header("Location: index.php?action=dashboard"); 
                exit;
            } else {
                $pesan = "Username atau password salah!";
            }
        }
        
        require __DIR__ . '/../views/auth/login.php';
    }
        

    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}
?>