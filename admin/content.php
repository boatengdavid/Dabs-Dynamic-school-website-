<?php
require_once '../connect.php';
require_once 'auth.php';

$pageTitle = 'Manage Content';
$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit') {
    $id      = (int)($_POST['edit_id'] ?? 0);
    $content = trim($_POST['edit_content'] ?? '');
    if (!$content) { $error = 'Content cannot be empty.'; }
    else {
        $stmt = $conn->prepare("UPDATE content SET content_text=?, updated_at=NOW() WHERE id=?");
        $stmt->bind_param('si', $content, $id);
        $stmt->execute(); $stmt->close();
        $success = 'Content updated successfully.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $section = trim($_POST['section_name'] ?? '');
    $content = trim($_POST['content_text'] ?? '');
    if (!$section || !$content) { $error = 'Section name and content are required.'; }
    else {
        $stmt = $conn->prepare("INSERT INTO content (section_name, content_text) VALUES (?,?) ON DUPLICATE KEY UPDATE content_text=?, updated_at=NOW()");
        $stmt->bind_param('sss', $section, $content, $content);
        $stmt->execute(); $stmt->close();
        $success = "Section \"$section\" saved successfully.";
    }
}

$contents = $conn->query("SELECT * FROM content ORDER BY updated_at DESC");
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
        <!-- Add Form -->
        <div class="col-lg-4">
          <div class="admin-card">
            <div class="admin-card-header">
              <h6><i class="bi bi-plus-circle text-success"></i> Add New Section</h6>
            </div>
            <div class="admin-card-body">
              <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="mb-3">
                  <label class="form-label">Section Key Name</label>
                  <input type="text" name="section_name" class="form-control" placeholder="e.g. hero_headline" required>
                  <div class="form-text">Use lowercase with underscores. No spaces.</div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Content</label>
                  <textarea name="content_text" class="form-control" rows="5" placeholder="Enter content text..." required></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100">
                  <i class="bi bi-plus-lg me-2"></i>Save Section
                </button>
              </form>
            </div>
          </div>

          <!-- Contact keys reference -->
          <div class="admin-card mt-3">
            <div class="admin-card-header">
              <h6><i class="bi bi-info-circle text-warning"></i> Contact Section Keys</h6>
            </div>
            <div class="admin-card-body">
              <p class="small text-muted mb-3">These keys control the contact page:</p>
              <div class="d-flex flex-column gap-2">
                <span class="section-badge">contact_phone</span>
                <span class="section-badge">contact_email</span>
                <span class="section-badge">contact_address_1</span>
                <span class="section-badge">contact_address_2</span>
                <span class="section-badge">hero_headline</span>
                <span class="section-badge">hero_subtext</span>
                <span class="section-badge">about_paragraph_1</span>
                <span class="section-badge">about_paragraph_2</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Content Table -->
        <div class="col-lg-8">
          <div class="admin-card">
            <div class="admin-card-header">
              <h6><i class="bi bi-file-earmark-text text-primary"></i> All Content Sections</h6>
              <span class="badge bg-primary"><?= $contents->num_rows ?> sections</span>
            </div>
            <div class="table-responsive">
              <table class="table admin-table">
                <thead>
                  <tr>
                    <th>Section</th>
                    <th>Preview</th>
                    <th>Updated</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($contents->num_rows === 0): ?>
                  <tr><td colspan="4" class="text-center text-muted py-5">
                    <i class="bi bi-file-earmark-text fs-2 d-block mb-2 opacity-25"></i>No content sections yet
                  </td></tr>
                  <?php else: while ($row = $contents->fetch_assoc()): ?>
                  <tr>
                    <td><span class="section-badge"><?= htmlspecialchars($row['section_name']) ?></span></td>
                    <td><div class="content-preview"><?= htmlspecialchars(strip_tags($row['content_text'])) ?></div></td>
                    <td style="font-size:12px;color:var(--text-muted);white-space:nowrap;"><?= date('d M Y', strtotime($row['updated_at'])) ?></td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-outline-primary btn-edit-content"
                        data-id="<?= $row['id'] ?>"
                        data-section="<?= htmlspecialchars($row['section_name'], ENT_QUOTES) ?>"
                        data-content="<?= htmlspecialchars($row['content_text'], ENT_QUOTES) ?>">
                        <i class="bi bi-pencil me-1"></i>Edit
                      </button>
                    </td>
                  </tr>
                  <?php endwhile; endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="edit_id" id="editContentId">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Section: <span id="editSectionDisplay" class="text-success"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <label class="form-label">Content</label>
          <textarea name="edit_content" id="editContentText" class="form-control" rows="7" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.btn-edit-content').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editContentId').value       = this.dataset.id;
    document.getElementById('editSectionDisplay').textContent = this.dataset.section;
    document.getElementById('editContentText').value    = this.dataset.content;
    new bootstrap.Modal(document.getElementById('editModal')).show();
  });
});
</script>
</body>
</html>