<?php
require_once '../connect.php';
require_once 'auth.php';

$pageTitle = 'Dashboard';

// ── Stats ──────────────────────────────────────────────────
$totalContent = $conn->query('SELECT COUNT(*) AS c FROM content')->fetch_assoc()['c'];
$totalImages  = $conn->query('SELECT COUNT(*) AS c FROM images')->fetch_assoc()['c'];
$totalAdmins  = $conn->query('SELECT COUNT(*) AS c FROM admin_users')->fetch_assoc()['c'];

// ── Recent content updates ─────────────────────────────────
$recentContent = $conn->query('SELECT section_name, content_text, updated_at FROM content ORDER BY updated_at DESC LIMIT 5');

// ── Recent images ──────────────────────────────────────────
$recentImages = $conn->query('SELECT image_name, image_path, uploaded_at FROM images ORDER BY uploaded_at DESC LIMIT 5');
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

            <!-- Stat Cards -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="bi bi-file-text"></i></div>
                        <div>
                            <div class="stat-value"><?= $totalContent ?></div>
                            <div class="stat-label">Content Sections</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="bi bi-images"></i></div>
                        <div>
                            <div class="stat-value"><?= $totalImages ?></div>
                            <div class="stat-label">Uploaded Images</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon orange"><i class="bi bi-people"></i></div>
                        <div>
                            <div class="stat-value"><?= $totalAdmins ?></div>
                            <div class="stat-label">Admin Users</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon purple"><i class="bi bi-activity"></i></div>
                        <div>
                            <div class="stat-value">Live</div>
                            <div class="stat-label">System Status</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Recent Content Updates -->
                <div class="col-lg-7">
                    <div class="admin-card h-100">
                        <div class="admin-card-header">
                            <h6><i class="bi bi-clock-history me-2 text-primary"></i>Recent Content Updates</h6>
                            <a href="content.php" class="btn btn-sm btn-outline-primary">Manage All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table admin-table">
                                <thead>
                                    <tr>
                                        <th>Section</th>
                                        <th>Preview</th>
                                        <th>Updated</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if ($recentContent->num_rows === 0): ?>
                                    <tr><td colspan="4" class="text-center text-muted py-4">No content yet</td></tr>
                                <?php else: ?>
                                <?php while ($row = $recentContent->fetch_assoc()): ?>
                                <tr>
                                    <td><span class="section-badge"><?= htmlspecialchars($row['section_name']) ?></span></td>
                                    <td><div class="content-preview"><?= htmlspecialchars(strip_tags($row['content_text'])) ?></div></td>
                                    <td class="text-muted small"><?= date('d M Y', strtotime($row['updated_at'])) ?></td>
                                    <td>
                                        <a href="content.php" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Images -->
                <div class="col-lg-5">
                    <div class="admin-card h-100">
                        <div class="admin-card-header">
                            <h6><i class="bi bi-images me-2 text-success"></i>Recent Images</h6>
                            <a href="images.php" class="btn btn-sm btn-outline-success">Manage All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table admin-table">
                                <thead>
                                    <tr><th>Image</th><th>Name</th><th>Date</th></tr>
                                </thead>
                                <tbody>
                                <?php if ($recentImages->num_rows === 0): ?>
                                    <tr><td colspan="3" class="text-center text-muted py-4">No images yet</td></tr>
                                <?php else: ?>
                                <?php while ($img = $recentImages->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?php if (file_exists('../' . $img['image_path'])): ?>
                                        <img src="../<?= htmlspecialchars($img['image_path']) ?>" class="img-thumb" alt="">
                                        <?php else: ?>
                                        <div class="img-thumb-placeholder"><i class="bi bi-image"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small"><?= htmlspecialchars($img['image_name']) ?></td>
                                    <td class="text-muted small"><?= date('d M', strtotime($img['uploaded_at'])) ?></td>
                                </tr>
                                <?php endwhile; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="admin-card mt-4">
                <div class="admin-card-header">
                    <h6><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</h6>
                </div>
                <div class="admin-card-body d-flex flex-wrap gap-2">
                    <a href="content.php" class="btn btn-primary"><i class="bi bi-pencil-square me-2"></i>Edit Content</a>
                    <a href="images.php" class="btn btn-success"><i class="bi bi-upload me-2"></i>Upload Image</a>
                    <a href="change_password.php" class="btn btn-outline-secondary"><i class="bi bi-shield-lock me-2"></i>Change Password</a>
                    <a href="logout.php" class="btn btn-outline-danger"><i class="bi bi-box-arrow-left me-2"></i>Logout</a>
                </div>
            </div>

        </div><!-- /page-body -->
    </div><!-- /main-content -->
</div><!-- /admin-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
