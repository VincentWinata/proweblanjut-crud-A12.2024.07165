<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register - Lego Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css"> </head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-custom p-5">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold" style="letter-spacing: 2px;">SISTEM REGISTRASI</h4>
                        <p class="text-muted small">Daftarkan akun admin baru</p>
                    </div>
                    
                    <?php if(isset($error)) echo "<div class='alert alert-danger small'>$error</div>"; ?>
                    
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Username</label>
                            <input type="text" name="username" class="form-control rounded-0" required autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold text-uppercase">Password</label>
                            <input type="password" name="password" class="form-control rounded-0" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 rounded-0 py-2 fw-bold" style="letter-spacing: 1px;">DAFTAR AKUN</button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <a href="index.php?action=login" class="text-decoration-none text-muted small">Sudah punya akun? Login di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>