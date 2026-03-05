<?php
require_once '../connect.php';
require_once 'auth.php';

$pageTitle = 'Change Password';
$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current  = $_POST['current_password'] ?? '';
    $new      = $_POST['new_password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';
    $username = $_SESSION['admin_username'];

    $stmt = $conn->prepare("SELECT password FROM admin_users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user || !password_verify($current, $user['password'])) {
        $error = 'Current password is incorrect.';
    } elseif (strlen($new) < 6) {
        $error = 'New password must be at least 6 characters.';
    } elseif ($new !== $confirm) {
        $error = 'New passwords do not match.';
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE admin_users SET password=? WHERE username=?");
        $stmt->bind_param('ss', $hash, $username);
        $stmt->execute(); $stmt->close();
        $success = 'Password updated successfully.';
    }
}
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

      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">

          <?php if ($success): ?>
          <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
          </div>
          <?php endif; ?>
          <?php if ($error): ?>
          <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
          </div>
          <?php endif; ?>

          <div class="admin-card">
            <div class="admin-card-header">
              <h6><i class="bi bi-shield-lock text-warning"></i> Change Your Password</h6>
            </div>
            <div class="admin-card-body">
              <!-- User badge -->
              <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-4" style="background:var(--green-50);border:1px solid rgba(22,163,74,0.15);">
                <div style="width:42px;height:42px;background:linear-gradient(135deg,#15803d,#22c55e);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:16px;">A</div>
                <div>
                  <div style="font-weight:700;font-size:14px;color:var(--text-primary);"><?= htmlspecialchars($_SESSION['admin_username']) ?></div>
                  <div style="font-size:12px;color:var(--text-muted);">Administrator Account</div>
                </div>
              </div>

              <form method="POST">
                <div class="mb-4">
                  <label class="form-label">Current Password</label>
                  <div class="input-group">
                    <input type="password" id="currentPw" name="current_password" class="form-control" placeholder="Enter current password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="toggleField('currentPw','eyeCurrent')">
                      <i class="bi bi-eye" id="eyeCurrent"></i>
                    </button>
                  </div>
                </div>

                <div class="mb-4">
                  <label class="form-label">New Password</label>
                  <div class="input-group">
                    <input type="password" id="newPw" name="new_password" class="form-control" placeholder="Min. 6 characters" required minlength="6">
                    <button class="btn btn-outline-secondary" type="button" onclick="toggleField('newPw','eyeNew')">
                      <i class="bi bi-eye" id="eyeNew"></i>
                    </button>
                  </div>
                  <!-- Strength indicator -->
                  <div class="mt-2">
                    <div style="height:4px;border-radius:2px;background:#e5e7eb;overflow:hidden;">
                      <div id="strengthBar" style="height:100%;width:0%;background:var(--green-500);transition:all 0.3s;border-radius:2px;"></div>
                    </div>
                    <div id="strengthLabel" class="form-text mt-1"></div>
                  </div>
                </div>

                <div class="mb-4">
                  <label class="form-label">Confirm New Password</label>
                  <div class="input-group">
                    <input type="password" id="confirmPw" name="confirm_password" class="form-control" placeholder="Repeat new password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="toggleField('confirmPw','eyeConfirm')">
                      <i class="bi bi-eye" id="eyeConfirm"></i>
                    </button>
                  </div>
                  <div id="matchMsg" class="form-text mt-1"></div>
                </div>

                <!-- Security tips -->
                <div class="p-3 rounded-3 mb-4" style="background:#fffbeb;border:1px solid rgba(217,119,6,0.2);">
                  <p class="small fw-semibold mb-2" style="color:#92400e;"><i class="bi bi-lightbulb me-1"></i> Password Tips</p>
                  <ul class="small mb-0" style="color:#78350f;padding-left:16px;">
                    <li>Use at least 8 characters</li>
                    <li>Mix uppercase, lowercase, numbers and symbols</li>
                    <li>Avoid using your name or common words</li>
                  </ul>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                  <i class="bi bi-shield-check me-2"></i>Update Password
                </button>
              </form>
            </div>
          </div>

          <div class="text-center mt-3">
            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
              <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleField(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon  = document.getElementById(iconId);
  if (input.type === 'password') { input.type = 'text'; icon.className = 'bi bi-eye-slash'; }
  else { input.type = 'password'; icon.className = 'bi bi-eye'; }
}

// Password strength
document.getElementById('newPw').addEventListener('input', function() {
  const val = this.value;
  const bar = document.getElementById('strengthBar');
  const lbl = document.getElementById('strengthLabel');
  let score = 0;
  if (val.length >= 6) score++;
  if (val.length >= 10) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^a-zA-Z0-9]/.test(val)) score++;
  const levels = [
    { w: '20%', c: '#ef4444', t: 'Very weak' },
    { w: '40%', c: '#f97316', t: 'Weak' },
    { w: '60%', c: '#eab308', t: 'Fair' },
    { w: '80%', c: '#84cc16', t: 'Good' },
    { w: '100%', c: '#22c55e', t: 'Strong' },
  ];
  const level = levels[Math.min(score - 1, 4)] || { w: '0%', c: '#e5e7eb', t: '' };
  bar.style.width = level.w;
  bar.style.background = level.c;
  lbl.textContent = level.t;
  lbl.style.color = level.c;
});

// Confirm match
document.getElementById('confirmPw').addEventListener('input', function() {
  const newPw = document.getElementById('newPw').value;
  const msg   = document.getElementById('matchMsg');
  if (this.value === '') { msg.textContent = ''; return; }
  if (this.value === newPw) {
    msg.textContent = '✓ Passwords match';
    msg.style.color = '#16a34a';
  } else {
    msg.textContent = '✗ Passwords do not match';
    msg.style.color = '#ef4444';
  }
});
</script>
</body>
</html>