<?php
/**
 * admin/partials/topbar.php
 * $pageTitle must be set before including this
 */
?>
<nav class="topbar d-flex align-items-center justify-content-between px-4">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-sm sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list fs-5"></i>
        </button>
        <h5 class="mb-0 fw-semibold"><?= $pageTitle ?? 'Dashboard' ?></h5>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="text-muted small d-none d-md-inline">
            <i class="bi bi-clock me-1"></i><?= date('D, d M Y') ?>
        </span>
        <div class="dropdown">
            <button class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle text-primary"></i>
                <span class="d-none d-md-inline"><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="change_password.php"><i class="bi bi-shield-lock me-2"></i>Change Password</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
