<?php
session_start();
include '../koneksi.php';

// Cek Cookie: Jika ada cookie remember me, otomatiskan session [cite: 183, 184]
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
}

// Jika sudah ada session (sudah login), arahkan ke dashboard [cite: 182, 186, 187]
if (isset($_SESSION['user_id'])) {
    header("Location: ../Internal/dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        // Set Session utama [cite: 161]
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Jika Remember Me dicentang, buat Cookie berlaku 7 hari [cite: 162, 164]
        if (isset($_POST['remember'])) {
            setcookie('user_id', $user['id'], time() + (86400 * 7), "/"); 
            setcookie('username', $user['username'], time() + (86400 * 7), "/");
        }

        header("Location: ../Internal/dashboard.php");
        exit();
    } else {
        $error = "Login gagal! Periksa kembali username atau password Anda.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Lego Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-custom p-5">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold" style="letter-spacing: 2px;">ADMIN PORTAL</h4>
                        <p class="text-muted small">Silakan login ke sistem</p>
                    </div>
                    
                    <?php if(isset($error)) echo "<div class='alert alert-danger small'>$error</div>"; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Username</label>
                            <input type="text" name="username" class="form-control rounded-0" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Password</label>
                            <input type="password" name="password" class="form-control rounded-0" required>
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-muted small" for="remember">Ingat Saya</label>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 rounded-0 py-2 fw-bold" style="letter-spacing: 1px;">LOGIN</button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <a href="register.php" class="text-decoration-none text-muted small">Buat akun baru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>