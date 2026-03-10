<?php
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    
    try {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        $success = "User admin baru berhasil ditambahkan!";
    } catch(PDOException $e) { 
        $error = "Gagal menambah user! (Mungkin username sudah terpakai)"; 
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah User Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="d-flex align-items-center vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card card-custom p-4 shadow-sm">
                    <h4 class="card-title text-center mb-4">Tambah Admin Baru</h4>
                    
                    <?php if(isset($success)): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>
                    
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username Baru</label>
                            <input type="text" class="form-control" name="username" required autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100 mb-2">Simpan User</button>
                        <a href="dashboard.php" class="btn btn-outline-secondary w-100">Kembali ke Dashboard</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>