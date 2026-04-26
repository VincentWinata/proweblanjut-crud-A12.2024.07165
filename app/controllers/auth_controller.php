<?php
// app/controllers/AuthController.php

require_once '../app/models/user_model.php';

class AuthController {
    private $model;

    public function __construct($db_connection) {
        $this->model = new UserModel($db_connection);
    }

    public function login() {
        // Jika ada cookie, set session otomatis
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
            $_SESSION['user_id'] = $_COOKIE['user_id'];
            $_SESSION['username'] = $_COOKIE['username'];
        }

        // Jika sudah login, langsung lempar ke dashboard
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?action=dashboard");
            exit();
        }

        $error = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $this->model->findByUsername($_POST['username']);

            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                if (isset($_POST['remember'])) {
                    setcookie('user_id', $user['id'], time() + (86400 * 7), "/"); 
                    setcookie('username', $user['username'], time() + (86400 * 7), "/");
                }

                header("Location: index.php?action=dashboard");
                exit();
            } else {
                $error = "Login gagal! Periksa kembali username atau password Anda.";
            }
        }
        
        // Tampilkan halaman view login
        require_once '../app/views/auth/login.php';
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?action=dashboard");
            exit();
        }

        $error = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            try {
                $this->model->createUser($username, $password);
                header("Location: index.php?action=login");
                exit();
            } catch(PDOException $e) {
                $error = "Pendaftaran gagal! Username mungkin sudah digunakan.";
            }
        }

        // Tampilkan halaman view register
        require_once '../app/views/auth/register.php';
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        setcookie('user_id', '', time() - 3600, "/");
        setcookie('username', '', time() - 3600, "/");
        header("Location: index.php?action=login");
        exit();
    }
}
?>