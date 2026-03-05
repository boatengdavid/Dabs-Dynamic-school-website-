<header class="admin-topbar">
  <div class="topbar-left">
    <!-- Hamburger (mobile only) -->
    <button class="sidebar-toggle" id="sidebarToggleBtn" aria-label="Open menu">
      <i class="bi bi-list"></i>
    </button>
    <div>
      <div class="topbar-page-title"><?= $pageTitle ?? 'Dashboard' ?></div>
      <div class="topbar-breadcrumb">
        <a href="dashboard.php">Home</a>
        <span>›</span>
        <span><?= $pageTitle ?? 'Dashboard' ?></span>
      </div>
    </div>
  </div>

  <div class="topbar-right">
    <div class="topbar-date">
      <i class="bi bi-calendar3" style="font-size:11px;"></i>
      <?= date('D, d M Y') ?>
    </div>
    <div class="topbar-status">
      <span class="status-dot"></span>
      Live
    </div>
    <div class="topbar-admin">
      <div class="topbar-admin-avatar">A</div>
      <span class="topbar-admin-name"><?= htmlspecialchars($_SESSION['admin_username'] ?? 'admin') ?></span>
      <i class="bi bi-chevron-down" style="font-size:10px;color:#9ca3af;"></i>
    </div>
  </div>
</header>

<!-- Sidebar toggle script — runs after sidebar & topbar are both in DOM -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var sidebar   = document.getElementById('adminSidebar');
    var overlay   = document.getElementById('sidebarOverlay');
    var toggleBtn = document.getElementById('sidebarToggleBtn');

    if (!sidebar || !overlay || !toggleBtn) return;

    function openSidebar() {
      sidebar.classList.add('open');
      overlay.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
      sidebar.classList.remove('open');
      overlay.classList.remove('active');
      document.body.style.overflow = '';
    }

    toggleBtn.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);

    // Close when a nav link is tapped on mobile
    sidebar.querySelectorAll('.sidebar-link').forEach(function (link) {
      link.addEventListener('click', function () {
        if (window.innerWidth < 768) closeSidebar();
      });
    });
  });
</script>