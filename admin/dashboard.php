<?php
require_once '../connect.php';
require_once 'auth.php';

$pageTitle = 'Dashboard';

$totalContent  = $conn->query("SELECT COUNT(*) AS c FROM content")->fetch_assoc()['c'];
$totalImages   = $conn->query("SELECT COUNT(*) AS c FROM images")->fetch_assoc()['c'];
$totalAdmins   = $conn->query("SELECT COUNT(*) AS c FROM admin_users")->fetch_assoc()['c'];
$totalNews     = $conn->query("SELECT COUNT(*) AS c FROM news")->fetch_assoc()['c'];
$totalGallery  = $conn->query("SELECT COUNT(*) AS c FROM gallery")->fetch_assoc()['c'];

$recentContent = $conn->query("SELECT * FROM content ORDER BY updated_at DESC LIMIT 5");
$recentImages  = $conn->query("SELECT * FROM images ORDER BY uploaded_at DESC LIMIT 5");
$recentNews    = $conn->query("SELECT * FROM news ORDER BY date DESC LIMIT 4");
$recentGallery = $conn->query("SELECT * FROM gallery ORDER BY date DESC LIMIT 4");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?> — DABS Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/css/admin.css" rel="stylesheet">
</head>
<body>
<div class="admin-wrapper">
  <?php include 'partials/sidebar.php'; ?>
  <div class="main-content">
    <?php include 'partials/topbar.php'; ?>
    <div class="page-body">

      <div class="page-header">
        <div>
          <div class="page-header-title">Welcome back, Admin 👋</div>
          <div class="page-header-sub">Here's what's happening on your school website today.</div>
        </div>
        <a href="../home.php" target="_blank" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-box-arrow-up-right me-1"></i> View Website
        </a>
      </div>

      <!-- Stats -->
      <div class="stats-grid">
        <div class="stat-card green">
          <div class="stat-card-header"><div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div></div>
          <div class="stat-number"><?= $totalContent ?></div>
          <div class="stat-label">Content Sections</div>
        </div>
        <div class="stat-card blue">
          <div class="stat-card-header"><div class="stat-icon"><i class="bi bi-image"></i></div></div>
          <div class="stat-number"><?= $totalImages ?></div>
          <div class="stat-label">Uploaded Images</div>
        </div>
        <div class="stat-card amber">
          <div class="stat-card-header"><div class="stat-icon"><i class="bi bi-people"></i></div></div>
          <div class="stat-number"><?= $totalAdmins ?></div>
          <div class="stat-label">Admin Users</div>
        </div>
        <div class="stat-card purple">
          <div class="stat-card-header"><div class="stat-icon"><i class="bi bi-newspaper"></i></div></div>
          <div class="stat-number"><?= $totalNews ?></div>
          <div class="stat-label">News Articles</div>
        </div>
        <div class="stat-card teal">
          <div class="stat-card-header"><div class="stat-icon"><i class="bi bi-images"></i></div></div>
          <div class="stat-number"><?= $totalGallery ?></div>
          <div class="stat-label">Gallery Items</div>
        </div>
        <div class="stat-card live">
          <div class="stat-card-header"><div class="stat-icon"><i class="bi bi-activity"></i></div></div>
          <div class="stat-number" style="font-size:22px;padding-top:4px;">Live</div>
          <div class="stat-label">System Status</div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h6><i class="bi bi-lightning-charge text-warning"></i> Quick Actions</h6>
        </div>
        <div class="admin-card-body">
          <div class="row g-3">
            <div class="col-6 col-md-4 col-lg-2">
              <a href="content.php" class="quick-action-card">
                <div class="quick-action-icon" style="background:#f0fdf4;color:#16a34a;"><i class="bi bi-pencil-square"></i></div>
                <div class="quick-action-text"><div class="quick-action-title">Edit Content</div><div class="quick-action-sub">Sections & text</div></div>
              </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
              <a href="images.php" class="quick-action-card">
                <div class="quick-action-icon" style="background:#eff6ff;color:#3b82f6;"><i class="bi bi-cloud-upload"></i></div>
                <div class="quick-action-text"><div class="quick-action-title">Upload Image</div><div class="quick-action-sub">Site images</div></div>
              </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
              <a href="news.php" class="quick-action-card">
                <div class="quick-action-icon" style="background:#f5f3ff;color:#7c3aed;"><i class="bi bi-newspaper"></i></div>
                <div class="quick-action-text"><div class="quick-action-title">Manage News</div><div class="quick-action-sub">Add & edit</div></div>
              </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
              <a href="gallery.php" class="quick-action-card">
                <div class="quick-action-icon" style="background:#f0fdfa;color:#0d9488;"><i class="bi bi-images"></i></div>
                <div class="quick-action-text"><div class="quick-action-title">Gallery</div><div class="quick-action-sub">Photos & media</div></div>
              </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
              <a href="change_password.php" class="quick-action-card">
                <div class="quick-action-icon" style="background:#fffbeb;color:#d97706;"><i class="bi bi-shield-lock"></i></div>
                <div class="quick-action-text"><div class="quick-action-title">Password</div><div class="quick-action-sub">Security</div></div>
              </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
              <a href="logout.php" class="quick-action-card" style="border-color:#fecaca;">
                <div class="quick-action-icon" style="background:#fef2f2;color:#ef4444;"><i class="bi bi-box-arrow-left"></i></div>
                <div class="quick-action-text"><div class="quick-action-title">Logout</div><div class="quick-action-sub">Sign out</div></div>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Content + Images -->
      <div class="row g-4 mb-4">
        <div class="col-lg-7">
          <div class="admin-card mb-0">
            <div class="admin-card-header">
              <h6><i class="bi bi-clock-history text-primary"></i> Recent Content Updates</h6>
              <a href="content.php" class="btn btn-outline-primary btn-sm">Manage All</a>
            </div>
            <div class="table-responsive">
              <table class="table admin-table mb-0">
                <thead><tr><th>Section</th><th>Preview</th><th>Updated</th></tr></thead>
                <tbody>
                  <?php if ($recentContent->num_rows > 0): while ($row = $recentContent->fetch_assoc()): ?>
                  <tr>
                    <td><span class="section-badge"><?= htmlspecialchars($row['section_name']) ?></span></td>
                    <td><div class="content-preview"><?= htmlspecialchars(strip_tags($row['content_text'])) ?></div></td>
                    <td style="white-space:nowrap;font-size:12px;color:var(--text-muted);"><?= date('d M Y', strtotime($row['updated_at'])) ?></td>
                  </tr>
                  <?php endwhile; else: ?>
                  <tr><td colspan="3" class="text-center text-muted py-4">No content yet</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="admin-card mb-0">
            <div class="admin-card-header">
              <h6><i class="bi bi-image text-primary"></i> Recent Images</h6>
              <a href="images.php" class="btn btn-outline-primary btn-sm">Manage All</a>
            </div>
            <div class="table-responsive">
              <table class="table admin-table mb-0">
                <thead><tr><th>Image</th><th>Key Name</th><th>Date</th></tr></thead>
                <tbody>
                  <?php if ($recentImages->num_rows > 0): while ($img = $recentImages->fetch_assoc()): ?>
                  <tr>
                    <td>
                      <?php if (file_exists('../' . $img['image_path'])): ?>
                        <img src="../<?= htmlspecialchars($img['image_path']) ?>" class="img-thumb" alt="">
                      <?php else: ?>
                        <div class="img-thumb-placeholder"><i class="bi bi-image-slash"></i></div>
                      <?php endif; ?>
                    </td>
                    <td><span class="section-badge"><?= htmlspecialchars($img['image_name']) ?></span></td>
                    <td style="font-size:12px;color:var(--text-muted);white-space:nowrap;"><?= date('d M Y', strtotime($img['uploaded_at'])) ?></td>
                  </tr>
                  <?php endwhile; else: ?>
                  <tr><td colspan="3" class="text-center text-muted py-4">No images yet</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent News + Gallery -->
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="admin-card mb-0">
            <div class="admin-card-header">
              <h6><i class="bi bi-newspaper text-primary"></i> Recent News</h6>
              <a href="news.php" class="btn btn-outline-primary btn-sm">Manage All</a>
            </div>
            <div class="table-responsive">
              <table class="table admin-table mb-0">
                <thead><tr><th>Title</th><th>Date</th></tr></thead>
                <tbody>
                  <?php if ($recentNews->num_rows > 0): while ($n = $recentNews->fetch_assoc()): ?>
                  <tr>
                    <td>
                      <div style="font-weight:600;font-size:13px;color:var(--text-primary);"><?= htmlspecialchars(substr($n['title'], 0, 40)) ?><?= strlen($n['title']) > 40 ? '…' : '' ?></div>
                      <div style="font-size:12px;color:var(--text-muted);"><?= htmlspecialchars(substr(strip_tags($n['content']), 0, 50)) ?>…</div>
                    </td>
                    <td style="font-size:12px;color:var(--text-muted);white-space:nowrap;"><?= date('d M Y', strtotime($n['date'])) ?></td>
                  </tr>
                  <?php endwhile; else: ?>
                  <tr><td colspan="2" class="text-center text-muted py-4">No news articles yet</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="admin-card mb-0">
            <div class="admin-card-header">
              <h6><i class="bi bi-images text-primary"></i> Recent Gallery</h6>
              <a href="gallery.php" class="btn btn-outline-primary btn-sm">Manage All</a>
            </div>
            <?php if ($recentGallery->num_rows > 0): ?>
            <div class="gallery-grid" style="padding:16px;">
              <?php while ($g = $recentGallery->fetch_assoc()): ?>
              <div class="gallery-card">
                <img src="../uploads/<?= htmlspecialchars($g['image']) ?>" alt="<?= htmlspecialchars($g['title']) ?>">
                <div class="gallery-card-body">
                  <div class="gallery-card-title"><?= htmlspecialchars($g['title']) ?></div>
                  <div class="gallery-card-meta"><?= ucfirst($g['category']) ?></div>
                </div>
              </div>
              <?php endwhile; ?>
            </div>
            <?php else: ?>
            <div class="text-center text-muted py-5">
              <i class="bi bi-images fs-2 d-block mb-2 opacity-25"></i>
              No gallery items yet
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>