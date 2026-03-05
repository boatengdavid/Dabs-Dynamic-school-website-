<?php
require_once '../connect.php';
require_once 'auth.php';

$pageTitle = 'Manage Images';
$success   = '';
$error     = '';

$allowed   = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxSize   = 5 * 1024 * 1024;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload') {
    $name = trim($_POST['image_name'] ?? '');
    $file = $_FILES['image_file'] ?? null;
    if (!$name) { $error = 'Please provide an image key/name.'; }
    elseif (!$file || $file['error'] !== UPLOAD_ERR_OK) { $error = 'Upload error. Please try again.'; }
    elseif (!in_array($file['type'], $allowed)) { $error = 'Only JPG, PNG, GIF, and WEBP files are allowed.'; }
    elseif ($file['size'] > $maxSize) { $error = 'File must be under 5MB.'; }
    else {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $slug = preg_replace('/[^a-z0-9_-]/i', '_', $name);
        $filename = $slug . '_' . time() . '.' . $ext;
        $dest = '../uploads/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $dest)) {
            $path = 'uploads/' . $filename;
            $stmt = $conn->prepare('INSERT INTO images (image_name, image_path) VALUES (?, ?) ON DUPLICATE KEY UPDATE image_path = ?');
            $stmt->bind_param('sss', $name, $path, $path);
            $stmt->execute();
            $stmt->close();
            $success = "Image \"$name\" uploaded successfully.";
        } else { $error = 'Failed to save file. Check folder permissions on /uploads.'; }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'replace') {
    $id = (int)($_POST['replace_id'] ?? 0);
    $file = $_FILES['replace_file'] ?? null;
    $existing = $conn->query("SELECT * FROM images WHERE id = $id")->fetch_assoc();
    if (!$existing) { $error = 'Image not found.'; }
    elseif (!$file || $file['error'] !== UPLOAD_ERR_OK) { $error = 'Upload error.'; }
    elseif (!in_array($file['type'], $allowed)) { $error = 'Only JPG, PNG, GIF, WEBP allowed.'; }
    elseif ($file['size'] > $maxSize) { $error = 'File must be under 5MB.'; }
    else {
        @unlink('../' . $existing['image_path']);
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $slug = preg_replace('/[^a-z0-9_-]/i', '_', $existing['image_name']);
        $filename = $slug . '_' . time() . '.' . $ext;
        $dest = '../uploads/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $dest)) {
            $path = 'uploads/' . $filename;
            $stmt = $conn->prepare('UPDATE images SET image_path = ? WHERE id = ?');
            $stmt->bind_param('si', $path, $id);
            $stmt->execute();
            $stmt->close();
            $success = 'Image replaced successfully.';
        } else { $error = 'Failed to save replacement file.'; }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int)($_POST['delete_id'] ?? 0);
    $row = $conn->query("SELECT image_path FROM images WHERE id = $id")->fetch_assoc();
    if ($row) {
        @unlink('../' . $row['image_path']);
        $conn->query("DELETE FROM images WHERE id = $id");
        $success = 'Image deleted successfully.';
    } else { $error = 'Image not found.'; }
}

$images = $conn->query('SELECT * FROM images ORDER BY uploaded_at DESC');

// All registered key names and their descriptions
$keyGuide = [
    // Homepage
    'hero_banner'            => 'Homepage — Hero background image',
    'about_photo'            => 'Homepage — About section photo',
    // About page
    'about_hero'             => 'About page — Hero background image',
    'proprietor_photo'       => 'About page — Proprietor/Director photo',
    'proprietress_photo'     => 'About page — Proprietress photo',
    'headteacher_photo'      => 'About page — Headteacher photo',
    'administrator_photo'    => 'About page — Administrator photo',
    // Academics page
    'academics_hero'         => 'Academics page — Hero background image',
    'extracurricular_sports' => 'Academics page — Beyond the Classroom: Sports',
    'extracurricular_cultural'=> 'Academics page — Beyond the Classroom: Cultural',
    'extracurricular_clubs'  => 'Academics page — Beyond the Classroom: Clubs',
    // Admissions page
    'admissions_hero'        => 'Admissions page — Hero background image',
];
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

            <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Upload Form + Key Guide -->
                <div class="col-lg-4">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h6><i class="bi bi-upload me-2 text-success"></i>Upload New Image</h6>
                        </div>
                        <div class="admin-card-body">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="upload">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Image Key / Name</label>
                                    <input type="text" name="image_name" class="form-control" placeholder="e.g. hero_banner" required>
                                    <div class="form-text">Must match the key name exactly from the reference below.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Select Image</label>
                                    <input type="file" id="imageUpload" name="image_file" class="form-control" accept="image/*" required>
                                    <div class="form-text">JPG, PNG, GIF, WEBP — max 5MB</div>
                                </div>
                                <img id="imagePreview" src="" alt="Preview" style="max-width:100%;max-height:150px;border-radius:8px;display:none;margin-bottom:.5rem;">
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-cloud-upload me-2"></i>Upload Image
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Key Reference Guide -->
                    <div class="admin-card mt-3">
                        <div class="admin-card-header">
                            <h6><i class="bi bi-key me-2 text-warning"></i>Key Name Reference</h6>
                        </div>
                        <div class="admin-card-body" style="max-height:420px;overflow-y:auto;">
                            <p class="small text-muted mb-3">Use these exact key names when uploading images:</p>
                            <?php
                            $sections = [
                                'Homepage' => ['hero_banner','about_photo'],
                                'About Page' => ['about_hero','proprietor_photo','proprietress_photo','headteacher_photo','administrator_photo'],
                                'Academics Page' => ['academics_hero','extracurricular_sports','extracurricular_cultural','extracurricular_clubs'],
                                'Admissions Page' => ['admissions_hero'],
                            ];
                            foreach ($sections as $sectionLabel => $keys):
                            ?>
                            <p class="small fw-bold text-green-700 mb-1 mt-2"><?= $sectionLabel ?></p>
                            <?php foreach ($keys as $k): ?>
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <span class="section-badge text-nowrap"><?= $k ?></span>
                                <span class="small text-muted"><?= $keyGuide[$k] ?? '' ?></span>
                            </div>
                            <?php endforeach; endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Images Table -->
                <div class="col-lg-8">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h6><i class="bi bi-images me-2 text-primary"></i>All Images</h6>
                            <span class="badge bg-primary"><?= $images->num_rows ?> images</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table admin-table">
                                <thead>
                                    <tr>
                                        <th>Preview</th>
                                        <th>Name / Key</th>
                                        <th>Path</th>
                                        <th>Uploaded</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if ($images->num_rows === 0): ?>
                                <tr><td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-images fs-2 d-block mb-2 opacity-25"></i>No images uploaded yet
                                </td></tr>
                                <?php else: ?>
                                <?php while ($img = $images->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?php if (file_exists('../' . $img['image_path'])): ?>
                                        <img src="../<?= htmlspecialchars($img['image_path']) ?>" class="img-thumb" alt="">
                                        <?php else: ?>
                                        <div class="img-thumb-placeholder"><i class="bi bi-image-slash"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-semibold small">
                                        <?= htmlspecialchars($img['image_name']) ?>
                                        <?php if (isset($keyGuide[$img['image_name']])): ?>
                                        <br><span class="text-muted fw-normal" style="font-size:.75rem;"><?= $keyGuide[$img['image_name']] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted small"><?= htmlspecialchars($img['image_path']) ?></td>
                                    <td class="text-muted small"><?= date('d M Y', strtotime($img['uploaded_at'])) ?></td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn btn-sm btn-outline-warning btn-replace-image"
                                                data-id="<?= $img['id'] ?>"
                                                data-name="<?= htmlspecialchars($img['image_name']) ?>"
                                                data-path="<?= htmlspecialchars($img['image_path']) ?>">
                                                <i class="bi bi-arrow-repeat me-1"></i>Replace
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-delete-image"
                                                data-id="<?= $img['id'] ?>"
                                                data-name="<?= htmlspecialchars($img['image_name']) ?>">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Replace Modal -->
<div class="modal fade" id="replaceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="replace">
                <input type="hidden" name="replace_id" id="replaceId">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-arrow-repeat me-2"></i>Replace Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-3">Replacing: <strong id="replaceImageName"></strong></p>
                    <div class="mb-2">
                        <small class="text-muted fw-semibold">Current image:</small><br>
                        <img id="replaceCurrentImg" src="" alt="" style="max-width:120px;max-height:80px;border-radius:6px;margin-top:.25rem;">
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label fw-semibold">New Image File</label>
                        <input type="file" id="replaceFileInput" name="replace_file" class="form-control" accept="image/*" required>
                    </div>
                    <img id="replacePreview" src="" alt="preview" style="max-width:100%;max-height:180px;border-radius:8px;display:none;margin-top:.5rem;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning"><i class="bi bi-arrow-repeat me-1"></i>Replace Image</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="delete_id" id="deleteImageId">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Delete Image</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p>Are you sure you want to delete <strong id="deleteImageName"></strong>?</p>
                    <p class="text-danger small mb-0"><i class="bi bi-exclamation-triangle me-1"></i>This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash me-1"></i>Delete Permanently</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
<script>
document.getElementById('imageUpload')?.addEventListener('change', function() {
    const preview = document.getElementById('imagePreview');
    const reader = new FileReader();
    reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
    reader.readAsDataURL(this.files[0]);
});

document.querySelectorAll('.btn-replace-image').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.getElementById('replaceId').value = this.dataset.id;
        document.getElementById('replaceImageName').textContent = this.dataset.name;
        const cur = document.getElementById('replaceCurrentImg');
        cur.src = '../' + this.dataset.path;
        cur.style.display = 'block';
        const prev = document.getElementById('replacePreview');
        prev.src = ''; prev.style.display = 'none';
        new bootstrap.Modal(document.getElementById('replaceModal')).show();
    });
});

document.getElementById('replaceFileInput')?.addEventListener('change', function() {
    const prev = document.getElementById('replacePreview');
    const reader = new FileReader();
    reader.onload = e => { prev.src = e.target.result; prev.style.display = 'block'; };
    reader.readAsDataURL(this.files[0]);
});

document.querySelectorAll('.btn-delete-image').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.getElementById('deleteImageId').value = this.dataset.id;
        document.getElementById('deleteImageName').textContent = this.dataset.name;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });
});
</script>
</body>
</html>
