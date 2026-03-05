<?php
require_once '../connect.php';
require_once 'auth.php';

$pageTitle = 'Manage Gallery';
$success = '';
$error   = '';

$categories = ['academics','sports','cultural','campus'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $title    = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? 'campus';
    $date     = $_POST['date'] ?? date('Y-m-d');
    $image    = '';
    if (!$title) { $error = 'Title is required.'; }
    elseif (empty($_FILES['image']['name'])) { $error = 'Please select an image.'; }
    else {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $fn  = 'gallery_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $fn);
        $image = $fn;
        $stmt = $conn->prepare("INSERT INTO gallery (title, image, category, date) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $title, $image, $category, $date);
        $stmt->execute(); $stmt->close();
        $success = 'Gallery item added.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id  = (int)($_POST['delete_id'] ?? 0);
    $row = $conn->query("SELECT image FROM gallery WHERE id = $id")->fetch_assoc();
    if ($row) {
        if ($row['image']) @unlink('../uploads/' . $row['image']);
        $conn->query("DELETE FROM gallery WHERE id = $id");
        $success = 'Gallery item deleted.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit') {
    $id       = (int)($_POST['edit_id'] ?? 0);
    $title    = trim($_POST['edit_title'] ?? '');
    $category = $_POST['edit_category'] ?? 'campus';
    $date     = $_POST['edit_date'] ?? date('Y-m-d');
    if (!$title) { $error = 'Title is required.'; }
    else {
        $row   = $conn->query("SELECT image FROM gallery WHERE id = $id")->fetch_assoc();
        $image = $row['image'] ?? '';
        if (!empty($_FILES['edit_image']['name'])) {
            if ($image) @unlink('../uploads/' . $image);
            $ext   = strtolower(pathinfo($_FILES['edit_image']['name'], PATHINFO_EXTENSION));
            $fn    = 'gallery_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['edit_image']['tmp_name'], '../uploads/' . $fn);
            $image = $fn;
        }
        $stmt = $conn->prepare("UPDATE gallery SET title=?, image=?, category=?, date=? WHERE id=?");
        $stmt->bind_param('ssssi', $title, $image, $category, $date, $id);
        $stmt->execute(); $stmt->close();
        $success = 'Gallery item updated.';
    }
}

$gallery = $conn->query("SELECT * FROM gallery ORDER BY date DESC");
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
              <h6><i class="bi bi-plus-circle text-success"></i> Add Gallery Item</h6>
            </div>
            <div class="admin-card-body">
              <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="mb-3">
                  <label class="form-label">Title</label>
                  <input type="text" name="title" class="form-control" placeholder="Photo title" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Category</label>
                  <select name="category" class="form-select">
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat ?>"><?= ucfirst($cat) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Date</label>
                  <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="mb-3">
                  <label class="form-label">Image</label>
                  <input type="file" name="image" class="form-control" accept="image/*" id="galleryImageInput" required>
                  <img id="galleryImagePreview" src="" style="max-width:100%;max-height:130px;border-radius:8px;display:none;margin-top:8px;object-fit:cover;">
                </div>
                <button type="submit" class="btn btn-success w-100">
                  <i class="bi bi-plus-lg me-2"></i>Add to Gallery
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- Gallery Grid -->
        <div class="col-lg-8">
          <div class="admin-card">
            <div class="admin-card-header">
              <h6><i class="bi bi-images text-primary"></i> All Gallery Items</h6>
              <span class="badge bg-primary"><?= $gallery->num_rows ?> items</span>
            </div>
            <?php if ($gallery->num_rows === 0): ?>
            <div class="text-center text-muted py-5">
              <i class="bi bi-images fs-2 d-block mb-2 opacity-25"></i>No gallery items yet
            </div>
            <?php else: ?>
            <div style="padding:20px;">
              <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:16px;">
                <?php while ($g = $gallery->fetch_assoc()): ?>
                <div class="gallery-card">
                  <?php if ($g['image'] && file_exists('../uploads/' . $g['image'])): ?>
                    <img src="../uploads/<?= htmlspecialchars($g['image']) ?>" alt="<?= htmlspecialchars($g['title']) ?>">
                  <?php else: ?>
                    <div style="height:120px;background:#f1f4f7;display:flex;align-items:center;justify-content:center;color:#9ca3af;">
                      <i class="bi bi-image-slash fs-3"></i>
                    </div>
                  <?php endif; ?>
                  <div class="gallery-card-body">
                    <div class="gallery-card-title"><?= htmlspecialchars($g['title']) ?></div>
                    <div class="gallery-card-meta">
                      <span class="section-badge" style="font-size:10px;padding:2px 8px;"><?= ucfirst($g['category']) ?></span>
                    </div>
                  </div>
                  <div class="gallery-card-actions">
                    <button class="btn btn-sm btn-outline-primary flex-fill btn-edit-gallery"
                      data-id="<?= $g['id'] ?>"
                      data-title="<?= htmlspecialchars($g['title'], ENT_QUOTES) ?>"
                      data-category="<?= $g['category'] ?>"
                      data-date="<?= $g['date'] ?>"
                      data-image="<?= htmlspecialchars($g['image'] ?? '') ?>"
                      style="font-size:11px;padding:4px 6px;">
                      <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger flex-fill btn-delete-gallery"
                      data-id="<?= $g['id'] ?>"
                      data-title="<?= htmlspecialchars($g['title'], ENT_QUOTES) ?>"
                      style="font-size:11px;padding:4px 6px;">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </div>
                <?php endwhile; ?>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="edit_id" id="editId">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Gallery Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="edit_title" id="editTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="edit_category" id="editCategory" class="form-select">
              <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat ?>"><?= ucfirst($cat) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="edit_date" id="editDate" class="form-control">
          </div>
          <div class="mb-2">
            <label class="form-label">Replace Image <span class="text-muted">(optional)</span></label>
            <input type="file" name="edit_image" class="form-control" accept="image/*">
          </div>
          <img id="editCurrentImg" src="" alt="" style="max-height:100px;border-radius:8px;margin-top:8px;display:none;object-fit:cover;">
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
        <input type="hidden" name="delete_id" id="deleteGalleryId">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Delete Item</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <p>Delete <strong id="deleteGalleryTitle"></strong>?</p>
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
document.getElementById('galleryImageInput')?.addEventListener('change', function() {
  const p = document.getElementById('galleryImagePreview');
  const r = new FileReader();
  r.onload = e => { p.src = e.target.result; p.style.display = 'block'; };
  r.readAsDataURL(this.files[0]);
});

document.querySelectorAll('.btn-edit-gallery').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editId').value       = this.dataset.id;
    document.getElementById('editTitle').value    = this.dataset.title;
    document.getElementById('editCategory').value = this.dataset.category;
    document.getElementById('editDate').value     = this.dataset.date;
    const img = document.getElementById('editCurrentImg');
    if (this.dataset.image) { img.src = '../uploads/' + this.dataset.image; img.style.display = 'block'; }
    else { img.style.display = 'none'; }
    new bootstrap.Modal(document.getElementById('editModal')).show();
  });
});

document.querySelectorAll('.btn-delete-gallery').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('deleteGalleryId').value          = this.dataset.id;
    document.getElementById('deleteGalleryTitle').textContent = this.dataset.title;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
  });
});
</script>
</body>
</html>