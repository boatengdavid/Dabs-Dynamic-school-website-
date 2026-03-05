<?php
require_once '../connect.php';
require_once 'auth.php';

$pageTitle = 'Manage News';
$success = '';
$error = '';

// ── DELETE ─────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $row = $conn->query("SELECT image FROM news WHERE id = $id")->fetch_assoc();
    if ($row && $row['image'] && file_exists('../uploads/' . $row['image'])) {
        unlink('../uploads/' . $row['image']);
    }
    $conn->query("DELETE FROM news WHERE id = $id");
    $success = 'News article deleted successfully.';
}

// ── ADD / EDIT ─────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id      = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $title   = $conn->real_escape_string(trim($_POST['title']));
    $content = $conn->real_escape_string(trim($_POST['content']));
    $date    = $conn->real_escape_string($_POST['date']);
    $image   = '';

    if (!empty($_FILES['image']['name'])) {
        $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($ext, $allowed)) {
            $error = 'Invalid image type. Allowed: jpg, jpeg, png, webp, gif.';
        } else {
            $filename = 'news_' . time() . '.' . $ext;
            $dest     = '../uploads/' . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                $image = $filename;
                if ($id) {
                    $old = $conn->query("SELECT image FROM news WHERE id = $id")->fetch_assoc();
                    if ($old && $old['image'] && file_exists('../uploads/' . $old['image'])) {
                        unlink('../uploads/' . $old['image']);
                    }
                }
            } else {
                $error = 'Failed to upload image. Check uploads/ folder permissions.';
            }
        }
    }

    if (!$error) {
        if ($id) {
            $imgSql = $image ? ", image = '$image'" : '';
            $conn->query("UPDATE news SET title='$title', content='$content', date='$date'$imgSql WHERE id=$id");
            $success = 'News article updated successfully.';
        } else {
            $conn->query("INSERT INTO news (title, content, image, date) VALUES ('$title', '$content', '$image', '$date')");
            $success = 'News article added successfully.';
        }
    }
}

// ── FETCH EDIT ROW ─────────────────────────────────────────
$editRow = null;
if (isset($_GET['edit'])) {
    $editRow = $conn->query("SELECT * FROM news WHERE id = " . (int) $_GET['edit'])->fetch_assoc();
}

// ── FETCH ALL NEWS ─────────────────────────────────────────
$allNews = $conn->query('SELECT * FROM news ORDER BY date DESC');
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
                <div class="col-lg-5">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h6>
                                <i class="bi bi-<?= $editRow ? 'pencil' : 'plus-circle' ?> me-2 text-primary"></i>
                                <?= $editRow ? 'Edit News Article' : 'Add News Article' ?>
                            </h6>
                            <?php if ($editRow): ?>
                                <a href="news.php" class="btn btn-sm btn-outline-secondary">Cancel</a>
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
                                    <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                                    <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($editRow['content'] ?? '') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" required
                                        value="<?= htmlspecialchars($editRow['date'] ?? date('Y-m-d')) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Image <?= $editRow ? '<small class="text-muted">(leave blank to keep current)</small>' : '' ?>
                                    </label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <?php if (!empty($editRow['image'])): ?>
                                        <div class="mt-2">
                                            <img src="../uploads/<?= htmlspecialchars($editRow['image']) ?>"
                                                class="img-thumbnail" style="max-height:100px;" alt="Current image">
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-<?= $editRow ? 'save' : 'plus-lg' ?> me-2"></i>
                                    <?= $editRow ? 'Update Article' : 'Add Article' ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- NEWS LIST -->
                <div class="col-lg-7">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h6><i class="bi bi-newspaper me-2 text-primary"></i>All News Articles</h6>
                            <span class="badge bg-primary"><?= $allNews->num_rows ?> total</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table admin-table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if ($allNews->num_rows === 0): ?>
                                    <tr><td colspan="4" class="text-center text-muted py-5">No news articles yet. Add one!</td></tr>
                                <?php else: ?>
                                <?php while ($n = $allNews->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($n['image']) && file_exists('../uploads/' . $n['image'])): ?>
                                            <img src="../uploads/<?= htmlspecialchars($n['image']) ?>" class="img-thumb" alt="">
                                        <?php else: ?>
                                            <div class="img-thumb-placeholder"><i class="bi bi-image"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-semibold small"><?= htmlspecialchars($n['title']) ?></div>
                                        <div class="text-muted" style="font-size:0.75rem">
                                            <?= htmlspecialchars(substr(strip_tags($n['content']), 0, 70)) ?>...
                                        </div>
                                    </td>
                                    <td class="text-muted small"><?= date('d M Y', strtotime($n['date'])) ?></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="news.php?edit=<?= $n['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="news.php?delete=<?= $n['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this article?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
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
        </div><!-- /page-body -->
    </div><!-- /main-content -->
</div><!-- /admin-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>