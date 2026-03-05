<?php
require_once '../connect.php';
require_once 'auth.php';

$pageTitle = 'Manage Gallery';
$success = '';
$error = '';

// ── DELETE ─────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $row = $conn->query("SELECT image FROM gallery WHERE id = $id")->fetch_assoc();
    if ($row && $row['image'] && file_exists('../uploads/' . $row['image'])) {
        unlink('../uploads/' . $row['image']);
    }
    $conn->query("DELETE FROM gallery WHERE id = $id");
    $success = 'Gallery item deleted successfully.';
}

// ── ADD / EDIT ─────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $title    = $conn->real_escape_string(trim($_POST['title']));
    $category = $conn->real_escape_string($_POST['category']);
    $date     = $conn->real_escape_string($_POST['date']);
    $image    = '';

    if (!empty($_FILES['image']['name'])) {
        $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($ext, $allowed)) {
            $error = 'Invalid image type. Allowed: jpg, jpeg, png, webp, gif.';
        } else {
            $filename = 'gallery_' . time() . '.' . $ext;
            $dest     = '../uploads/' . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                $image = $filename;
                if ($id) {
                    $old = $conn->query("SELECT image FROM gallery WHERE id = $id")->fetch_assoc();
                    if ($old && $old['image'] && file_exists('../uploads/' . $old['image'])) {
                        unlink('../uploads/' . $old['image']);
                    }
                }
            } else {
                $error = 'Failed to upload image. Check uploads/ folder permissions.';
            }
        }
    } elseif (!$id) {
        $error = 'An image is required for new gallery items.';
    }

    if (!$error) {
        if ($id) {
            $imgSql = $image ? ", image = '$image'" : '';
            $conn->query("UPDATE gallery SET title='$title', category='$category', date='$date'$imgSql WHERE id=$id");
            $success = 'Gallery item updated successfully.';
        } else {
            $conn->query("INSERT INTO gallery (title, image, category, date) VALUES ('$title', '$image', '$category', '$date')");
            $success = 'Gallery item added successfully.';
        }
    }
}

// ── FETCH EDIT ROW ─────────────────────────────────────────
$editRow = null;
if (isset($_GET['edit'])) {
    $editRow = $conn->query("SELECT * FROM gallery WHERE id = " . (int) $_GET['edit'])->fetch_assoc();
}

// ── FETCH ALL GALLERY ──────────────────────────────────────
$allGallery = $conn->query('SELECT * FROM gallery ORDER BY date DESC');

$categories = ['academics' => 'Academics', 'sports' => 'Sports', 'cultural' => 'Cultural Events', 'campus' => 'Campus Life'];
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
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i><?= $success ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i><?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">

                <!-- ADD / EDIT FORM -->
                <div class="col-lg-4">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h6>
                                <i class="bi bi-<?= $editRow ? 'pencil' : 'plus-circle' ?> me-2 text-success"></i>
                                <?= $editRow ? 'Edit Gallery Item' : 'Add Gallery Item' ?>
                            </h6>
                            <?php if ($editRow): ?>
                                <a href="gallery.php" class="btn btn-sm btn-outline-secondary">Cancel</a>
                            <?php endif; ?>
                        </div>
                        <div class="admin-card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <?php if ($editRow): ?>
                                    <input type="hidden" name="id" value="<?= $editRow['id'] ?>">
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" required
                                        value="<?= htmlspecialchars($editRow['title'] ?? '') ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                    <select name="category" class="form-select" required>
                                        <?php foreach ($categories as $val => $label): ?>
                                            <option value="<?= $val ?>"
                                                <?= (($editRow['category'] ?? '') === $val) ? 'selected' : '' ?>>
                                                <?= $label ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" required
                                        value="<?= htmlspecialchars($editRow['date'] ?? date('Y-m-d')) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Image
                                        <?php if ($editRow): ?>
                                            <small class="text-muted">(leave blank to keep current)</small>
                                        <?php else: ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="file" name="image" class="form-control" accept="image/*"
                                        <?= !$editRow ? 'required' : '' ?>>
                                    <?php if (!empty($editRow['image'])): ?>
                                        <div class="mt-2">
                                            <img src="../uploads/<?= htmlspecialchars($editRow['image']) ?>"
                                                class="img-thumbnail" style="max-height:100px;" alt="Current image">
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-<?= $editRow ? 'save' : 'plus-lg' ?> me-2"></i>
                                    <?= $editRow ? 'Update Item' : 'Add to Gallery' ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- GALLERY LIST -->
                <div class="col-lg-8">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h6><i class="bi bi-camera me-2 text-success"></i>All Gallery Items</h6>
                            <span class="badge bg-success"><?= $allGallery->num_rows ?> total</span>
                        </div>

                        <?php if ($allGallery->num_rows === 0): ?>
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-camera" style="font-size:2rem"></i>
                                <p class="mt-2">No gallery items yet. Add one!</p>
                            </div>
                        <?php else: ?>
                        <!-- Gallery Grid View -->
                        <div class="p-3">
                            <div class="row g-3">
                                <?php while ($g = $allGallery->fetch_assoc()): ?>
                                <div class="col-sm-6 col-xl-4">
                                    <div class="card h-100 border shadow-sm">
                                        <?php if (!empty($g['image']) && file_exists('../uploads/' . $g['image'])): ?>
                                            <img src="../uploads/<?= htmlspecialchars($g['image']) ?>"
                                                class="card-img-top object-fit-cover" style="height:140px;" alt="">
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:140px;">
                                                <i class="bi bi-image text-muted" style="font-size:2rem"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body p-2">
                                            <p class="fw-semibold small mb-1 text-truncate"><?= htmlspecialchars($g['title']) ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-success"><?= ucfirst($g['category']) ?></span>
                                                <span class="text-muted" style="font-size:0.7rem"><?= date('d M Y', strtotime($g['date'])) ?></span>
                                            </div>
                                        </div>
                                        <div class="card-footer p-2 d-flex gap-1">
                                            <a href="gallery.php?edit=<?= $g['id'] ?>" class="btn btn-sm btn-outline-primary flex-fill">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                            <a href="gallery.php?delete=<?= $g['id'] ?>" class="btn btn-sm btn-outline-danger flex-fill"
                                                onclick="return confirm('Delete this gallery item?')">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div><!-- /page-body -->
    </div><!-- /main-content -->
</div><!-- /admin-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>