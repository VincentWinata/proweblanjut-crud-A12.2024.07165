<div class="sidebar d-flex flex-column p-3 text-white" style="width: 260px;">
    <div class="logo-container">
        <a href="../Internal/dashboard.php" class="logo-text">Business Management</a>
    </div>
    
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="index.php?action=dashboard" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="index.php?action=barang" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'barang.php' ? 'active' : '' ?>">
                Kelola Inventaris
            </a>
        </li>
        <li class="nav-item">
            <a href="index.php?action=kelola_user" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'kelola_user.php' ? 'active' : '' ?>">
                Kelola Admin
            </a>
        </li>
    </ul>
    
    <hr class="border-secondary">
    <div class="dropdown">
        <span class="d-flex align-items-center text-white text-decoration-none mb-3">
            <strong>Halo, <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></strong>
        </span>
        <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm w-100">Logout</a>
    </div>
</div>