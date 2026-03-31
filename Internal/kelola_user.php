<?php
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: ../login.php"); 
    exit(); 
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    
    try {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]); 
        $success = "User admin baru berhasil ditambahkan!";
    } catch(PDOException $e) { 
        $error = "Gagal menambah user! (Username mungkin sudah terpakai)"; 
    }
}

if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    if ($id_hapus == $_SESSION['user_id']) {
        $error = "Anda tidak dapat menghapus akun Anda sendiri saat sedang login!";
    } else {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?"); 
        $stmt->execute([$id_hapus]); 
        header("Location: ../kelola_user.php"); 
        exit();
    }
}

$stmt = $conn->query("SELECT id, username FROM users ORDER BY id DESC");
$users_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola User Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="d-flex">
        
        <div class="sidebar d-flex flex-column p-3 text-white" style="width: 260px;">
            <div class="logo-container">
                <a href="../dashboard.php" class="logo-text">🛒 Retail</a>
            </div>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="../dashboard.php" class="nav-link">🏠 Dashboard</a></li>
                <li class="nav-item"><a href="../barang.php" class="nav-link">📦 Kelola Inventaris</a></li>
                <li class="nav-item"><a href="../kelola_user.php" class="nav-link active">👤 Kelola User</a></li>
            </ul>
            <hr class="border-secondary">
            <div class="dropdown">
                <span class="d-flex align-items-center text-white text-decoration-none">
                    <strong>👋 Halo, <?= htmlspecialchars($_SESSION['username']) ?></strong>
                </span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm w-100 mt-3">🚪 Logout</a>
            </div>
        </div>

        <div class="flex-grow-1 p-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-dark fw-bold">Kelola Akses Admin</h2>
            </div>
            
            <?php if(isset($success)): ?>
                <div class="alert alert-success shadow-sm"><?= $success ?></div>
            <?php endif; ?>
            <?php if(isset($error)): ?>
                <div class="alert alert-danger shadow-sm"><?= $error ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card card-custom p-4 shadow-sm border-0">
                        <h5 class="mb-3">Tambah Admin Baru</h5>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" required autocomplete="off">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" name="tambah_user" class="btn btn-primary w-100">Simpan User</button>
                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-custom p-4 shadow-sm border-0">
                        <h5 class="mb-3">Daftar Admin Sistem</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users_list as $user): ?>
                                    <tr>
                                        <td>#<?= $user['id'] ?></td>
                                        <td><strong><?= htmlspecialchars($user['username']) ?></strong>
                                            <?php if($user['id'] == $_SESSION['user_id']) echo "<span class='badge bg-success ms-2'>You</span>"; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($user['id'] != $_SESSION['user_id']): ?>
                                                <a href="../kelola_user.php?hapus=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">Hapus</a> <?php else: ?>
                                                <button class="btn btn-sm btn-secondary" disabled>Hapus</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>