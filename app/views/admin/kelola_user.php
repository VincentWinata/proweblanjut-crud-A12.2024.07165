<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Admin - Lego Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css"> </head>
<body class="bg-light">
    <div class="admin-layout">
        
        <?php include '../app/views/admin/sidebar.php'; ?>

        <main class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-dark fw-bold" style="letter-spacing: 1px;">PENGATURAN AKSES ADMIN</h2>
            </div>
            
            <?php if(!empty($success)): ?>
                <div class="alert alert-dark rounded-0 shadow-sm border-0"><?= $success ?></div>
            <?php endif; ?>
            <?php if(!empty($error)): ?>
                <div class="alert alert-danger rounded-0 shadow-sm border-0"><?= $error ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card card-custom p-4 shadow-sm border-0">
                        <h6 class="mb-4 fw-bold text-uppercase" style="letter-spacing: 1px;">Tambah Admin Baru</h6>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Username</label>
                                <input type="text" class="form-control rounded-0" name="username" required autocomplete="off">
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Password</label>
                                <input type="password" class="form-control rounded-0" name="password" required>
                            </div>
                            <button type="submit" name="tambah_user" class="btn btn-dark w-100 rounded-0 fw-bold" style="letter-spacing: 1px;">SIMPAN ADMIN</button>
                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-custom p-4 shadow-sm border-0">
                        <h6 class="mb-4 fw-bold text-uppercase" style="letter-spacing: 1px;">Daftar Admin Sistem</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr class="text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users_list as $user): ?>
                                    <tr>
                                        <td class="text-muted">#<?= $user['id'] ?></td>
                                        <td>
                                            <strong style="color: #111;"><?= htmlspecialchars($user['username']) ?></strong>
                                            <?php if($user['id'] == $_SESSION['user_id']) echo "<span class='badge bg-secondary rounded-0 ms-2'>Anda</span>"; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($user['id'] != $_SESSION['user_id']): ?>
                                                <a href="index.php?action=kelola_user&hapus=<?= $user['id'] ?>" class="btn btn-sm btn-outline-danger rounded-0 px-3" onclick="return confirm('Hapus hak akses admin ini secara permanen?')">Hapus</a> 
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-light rounded-0 px-3 text-muted" disabled>Hapus</button>
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
        </main>
    </div>
</body>
</html>