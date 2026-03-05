<?php
require_once '../connect.php';
require_once 'auth.php';

$pageTitle = 'Manage News';
$success = '';
$error   = '';

// Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $title   = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $date    = $_POST['date'] ?? date('Y-m-d');
    $image   = '';
    if (!$title || !$content) { $error = 'Title and content are required.'; }
    else {
        if (!empty($_FILES['image']['name'])) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $fn  = 'news_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $fn);
            $image = $fn;
        }
        $stmt = $conn->prepare("INSERT INTO news (title, content, image, date) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $title, $content, $image, $date);
        $stmt->execute(); $stmt->close();
        $success = 'News article added successfully.';
    }
}

// Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id  = (int)($_POST['delete_id'] ?? 0);
    $row = $conn->query("SELECT image FROM news WHERE id = $id")->fetch_assoc();
    if ($row) {
        if ($row['image']) @unlink('../uploads/' . $row['image']);
        $conn->query("DELETE FROM news WHERE id = $id");
        $success = 'Article deleted.';
    }
}

// Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit') {
    $id      = (int)($_POST['edit_id'] ?? 0);
    $title   = trim($_POST['edit_title'] ?? '');
    $content = trim($_POST['edit_content'] ?? '');
    $date    = $_POST['edit_date'] ?? date('Y-m-d');
    if (!$title || !$content) { $error = 'Title and content are required.'; }
    else {
        $row = $conn->query("SELECT image FROM news WHERE id = $id")->fetch_assoc();
        $image = $row['image'] ?? '';
        if (!empty($_FILES['edit_image']['name'])) {
            if ($image) @unlink('../uploads/' . $image);
            $ext   = strtolower(pathinfo($_FILES['edit_image']['name'], PATHINFO_EXTENSION));
            $fn    = 'news_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['edit_image']['tmp_name'], '../uploads/' . $fn);
            $image = $fn;
        }
        $stmt = $conn->prepare("UPDATE news SET title=?, content=?, image=?, date=? WHERE id=?");
        $stmt->bind_param('ssssi', $title, $content, $image, $date, $id);
        $stmt->execute(); $stmt->close();
        $success = 'Article updated successfully.';
    }
}

$news = $conn->query("SELECT * FROM news ORDER BY date DESC");
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
              <h6><i class="bi bi-plus-circle text-success"></i> Add News Article</h6>
            </div>
            <div class="admin-card-body">
              <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="mb-3">
                  <label class="form-label">Title</label>
                  <input type="text" name="title" class="form-control" placeholder="Article title" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Content</label>
                  <textarea name="content" class="form-control" rows="5" placeholder="Article content..." required></textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label">Date</label>
                  <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="mb-3">
                  <label class="form-label">Image <span class="text-muted">(optional)</span></label>
                  <input type="file" name="image" class="form-control" accept="image/*" id="newsImageInput">
                  <img id="newsImagePreview" src="" style="max-width:100%;max-height:120px;border-radius:8px;display:none;margin-top:8px;">
                </div>
                <button type="submit" class="btn btn-success w-100">
                  <i class="bi bi-plus-lg me-2"></i>Publish Article
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- News Table -->
        <div class="col-lg-8">
          <div class="admin-card">
            <div class="admin-card-header">
              <h6><i class="bi bi-newspaper text-primary"></i> All Articles</h6>
              <span class="badge bg-primary"><?= $news->num_rows ?> articles</span>
            </div>
            <div class="table-responsive">
              <table class="table admin-table">
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($news->num_rows === 0): ?>
                  <tr><td colspan="4" class="text-center text-muted py-5">
                    <i class="bi bi-newspaper fs-2 d-block mb-2 opacity-25"></i>No articles yet
                  </td></tr>
                  <?php else: while ($n = $news->fetch_assoc()): ?>
                  <tr>
                    <td>
                      <?php if ($n['image'] && file_exists('../uploads/' . $n['image'])): ?>
                        <img src="../uploads/<?= htmlspecialchars($n['image']) ?>" class="img-thumb" alt="">
                      <?php else: ?>
                        <div class="img-thumb-placeholder"><i class="bi bi-image-slash"></i></div>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div style="font-weight:600;font-size:13px;color:var(--text-primary);"><?= htmlspecialchars(substr($n['title'], 0, 45)) ?><?= strlen($n['title']) > 45 ? '…' : '' ?></div>
                      <div style="font-size:12px;color:var(--text-muted);"><?= htmlspecialchars(substr(strip_tags($n['content']), 0, 60)) ?>…</div>
                    </td>
                    <td style="font-size:12px;color:var(--text-muted);white-space:nowrap;"><?= date('d M Y', strtotime($n['date'])) ?></td>
                    <td class="text-center">
                      <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-sm btn-outline-primary btn-edit-news"
                          data-id="<?= $n['id'] ?>"
                          data-title="<?= htmlspecialchars($n['title'], ENT_QUOTES) ?>"
                          data-content="<?= htmlspecialchars($n['content'], ENT_QUOTES) ?>"
                          data-date="<?= $n['date'] ?>"
                          data-image="<?= htmlspecialchars($n['image'] ?? '') ?>">
                          <i class="bi bi-pencil me-1"></i>Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger btn-delete-news"
                          data-id="<?= $n['id'] ?>"
                          data-title="<?= htmlspecialchars($n['title'], ENT_QUOTES) ?>">
                          <i class="bi bi-trash me-1"></i>Delete
                        </button>
                      </div>
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
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="edit_id" id="editId">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Article</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Title</label>
              <input type="text" name="edit_title" id="editTitle" class="form-control" required>
            </div>
            <div class="col-12">
              <label class="form-label">Content</label>
              <textarea name="edit_content" id="editContent" class="form-control" rows="6" required></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">Date</label>
              <input type="date" name="edit_date" id="editDate" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Replace Image <span class="text-muted">(optional)</span></label>
              <input type="file" name="edit_image" class="form-control" accept="image/*" id="editImageInput">
            </div>
            <div class="col-12">
              <img id="editCurrentImg" src="" alt="" style="max-height:100px;border-radius:8px;display:none;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="delete_id" id="deleteNewsId">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Delete Article</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <p>Are you sure you want to delete <strong id="deleteNewsTitle"></strong>?</p>
          <p class="text-danger small mb-0"><i class="bi bi-exclamation-triangle me-1"></i>This cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger"><i class="bi bi-trash me-1"></i>Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('newsImageInput')?.addEventListener('change', function() {
  const p = document.getElementById('newsImagePreview');
  const r = new FileReader();
  r.onload = e => { p.src = e.target.result; p.style.display = 'block'; };
  r.readAsDataURL(this.files[0]);
});

document.querySelectorAll('.btn-edit-news').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editId').value      = this.dataset.id;
    document.getElementById('editTitle').value   = this.dataset.title;
    document.getElementById('editContent').value = this.dataset.content;
    document.getElementById('editDate').value     = this.dataset.date;
    const img = document.getElementById('editCurrentImg');
    if (this.dataset.image) { img.src = '../uploads/' + this.dataset.image; img.style.display = 'block'; }
    else { img.style.display = 'none'; }
    new bootstrap.Modal(document.getElementById('editModal')).show();
  });
});

document.querySelectorAll('.btn-delete-news').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('deleteNewsId').value        = this.dataset.id;
    document.getElementById('deleteNewsTitle').textContent = this.dataset.title;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
  });
});
</script>
</body>
</html>