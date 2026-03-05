<?php
/**
 * admin/partials/sidebar.php
 * Shared sidebar navigation — include in every admin page
 */
$current = basename($_SERVER['PHP_SELF']);
?>
<!-- Sidebar -->
<nav id="sidebar" class="sidebar d-flex flex-column">
    <div class="sidebar-brand d-flex align-items-center gap-2 px-3 py-3">
        <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <div>
            <div class="brand-name">DABS School</div>
            <div class="brand-sub">Admin Panel</div>
        </div>
    </div>

    <hr class="sidebar-divider">

    <ul class="nav flex-column px-2 flex-grow-1">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= $current === 'dashboard.php' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-section-label">CONTENT</li>
        <li class="nav-item">
            <a href="content.php" class="nav-link <?= $current === 'content.php' ? 'active' : '' ?>">
                <i class="bi bi-file-text"></i> <span>Manage Content</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="images.php" class="nav-link <?= $current === 'images.php' ? 'active' : '' ?>">
                <i class="bi bi-images"></i> <span>Manage Images</span>
            </a>
        </li>

        <li class="nav-section-label">NEWS & GALLERY</li>
        <li class="nav-item">
            <a href="news.php" class="nav-link <?= $current === 'news.php' ? 'active' : '' ?>">
                <i class="bi bi-newspaper"></i> <span>Manage News</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="gallery.php" class="nav-link <?= $current === 'gallery.php' ? 'active' : '' ?>">
                <i class="bi bi-camera"></i> <span>Manage Gallery</span>
            </a>
        </li>

        <li class="nav-section-label">ACCOUNT</li>
        <li class="nav-item">
            <a href="change_password.php" class="nav-link <?= $current === 'change_password.php' ? 'active' : '' ?>">
                <i class="bi bi-shield-lock"></i> <span>Change Password</span>
            </a>
        </li>
        <li class="nav-item mt-auto">
            <a href="logout.php" class="nav-link text-danger">
                <i class="bi bi-box-arrow-left"></i> <span>Logout</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer px-3 py-2">
        <i class="bi bi-person-circle me-1"></i>
        <span><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
    </div>
</nav>