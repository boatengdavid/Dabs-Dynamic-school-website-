<?php
require_once '../connect.php';
require_once 'auth.php';

$pageTitle = 'Manage Content';
$success   = '';
$error     = '';

// ── Handle content update ──────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_content'])) {
    $id   = (int)($_POST['content_id'] ?? 0);
    $text = $_POST['content_text'] ?? '';

    // Sanitize — allow basic HTML from TinyMCE but strip dangerous tags
    $allowed_tags = '<p><br><strong><em><ul><ol><li><h2><h3><h4><a><span><blockquote>';
    $text = strip_tags($text, $allowed_tags);

    $stmt = $conn->prepare('UPDATE content SET content_text = ? WHERE id = ?');
    $stmt->bind_param('si', $text, $id);
    if ($stmt->execute()) {
        $success = 'Content updated successfully.';
    } else {
        $error = 'Update failed: ' . $conn->error;
    }
    $stmt->close();
}

// ── Fetch all content sections ─────────────────────────────
$sections = $conn->query('SELECT * FROM content ORDER BY section_name ASC');
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
            <div class="alert alert-success alert-dismissible alert-auto-dismiss fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <!-- Content Table -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h6><i class="bi bi-file-text me-2 text-primary"></i>All Content Sections</h6>
                    <span class="badge bg-primary"><?= $sections->num_rows ?> sections</span>
                </div>
                <div class="table-responsive">
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Section Name</th>
                                <th>Content Preview</th>
                                <th>Last Updated</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        // Reset pointer
                        $sections->data_seek(0);
                        while ($row = $sections->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-muted small"><?= $i++ ?></td>
                            <td><span class="section-badge"><?= htmlspecialchars($row['section_name']) ?></span></td>
                            <td>
                                <div class="content-preview">
                                    <?= htmlspecialchars(strip_tags($row['content_text'])) ?: '<em class="text-muted">Empty</em>' ?>
                                </div>
                            </td>
                            <td class="text-muted small"><?= date('d M Y, H:i', strtotime($row['updated_at'])) ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary btn-edit-content"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    data-id="<?= $row['id'] ?>"
                                    data-section="<?= htmlspecialchars($row['section_name']) ?>"
                                    data-content="<?= htmlspecialchars($row['content_text']) ?>">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Edit Content Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="">
                <input type="hidden" name="update_content" value="1">
                <input type="hidden" name="content_id" id="editContentId">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>
                        Editing: <span id="editSectionDisplay" class="opacity-75 fw-normal"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <input type="hidden" name="section_name" id="editSectionName">
                    <label class="form-label fw-semibold">Content</label>
                    <textarea id="editContentText" name="content_text" class="form-control" rows="8"></textarea>
                    <div class="form-text mt-2">
                        <i class="bi bi-info-circle me-1"></i>
                        Use the toolbar above to format text. Changes are saved immediately.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- TinyMCE WYSIWYG Editor (free CDN) -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#editContentText',
    height: 320,
    menubar: false,
    plugins: 'lists link autolink',
    toolbar: 'undo redo | bold italic underline | bullist numlist | link | removeformat',
    content_style: 'body { font-family: Segoe UI, sans-serif; font-size: 15px; }',
    branding: false,
    promotion: false,
    setup: function(editor) {
        // Sync TinyMCE content back to hidden textarea on form submit
        editor.on('change', function() { editor.save(); });
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
