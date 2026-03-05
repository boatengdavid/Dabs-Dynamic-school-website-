<!-- Mobile overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="admin-sidebar" id="adminSidebar">

  <!-- Brand -->
  <a href="dashboard.php" class="sidebar-brand">
    <div class="sidebar-brand-icon" style="background:none;box-shadow:none;padding:2px;">
  <img src="../dabs-logo.png" alt="DABS Logo" style="width:36px;height:36px;object-fit:contain;">
</div>
    <div class="sidebar-brand-text">
      <div class="sidebar-brand-name">DABS School</div>
      <div class="sidebar-brand-sub">Admin Panel</div>
    </div>
  </a>

  <!-- Navigation -->
  <nav class="sidebar-nav">

    <div class="sidebar-section-label">Main</div>
    <a href="dashboard.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>">
      <i class="bi bi-grid-1x2"></i> Dashboard
    </a>

    <div class="sidebar-section-label">Content</div>
    <a href="content.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'content.php' ? 'active' : '' ?>">
      <i class="bi bi-file-earmark-text"></i> Manage Content
    </a>
    <a href="images.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'images.php' ? 'active' : '' ?>">
      <i class="bi bi-image"></i> Manage Images
    </a>

    <div class="sidebar-section-label">News & Gallery</div>
    <a href="news.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'news.php' ? 'active' : '' ?>">
      <i class="bi bi-newspaper"></i> Manage News
    </a>
    <a href="gallery.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'gallery.php' ? 'active' : '' ?>">
      <i class="bi bi-images"></i> Manage Gallery
    </a>

    <div class="sidebar-divider"></div>

    <div class="sidebar-section-label">Account</div>
    <a href="change_password.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'change_password.php' ? 'active' : '' ?>">
      <i class="bi bi-shield-lock"></i> Change Password
    </a>

  </nav>

  <!-- Footer -->
  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="sidebar-user-avatar">A</div>
      <div class="sidebar-user-info">
        <div class="sidebar-user-name"><?= htmlspecialchars($_SESSION['admin_username'] ?? 'admin') ?></div>
        <div class="sidebar-user-role">Administrator</div>
      </div>
    </div>
    <a href="logout.php" class="sidebar-logout">
      <i class="bi bi-box-arrow-left"></i> Sign Out
    </a>
  </div>

</aside>