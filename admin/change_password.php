<?php
require_once '../connect.php';
require_once 'auth.php';

$pageTitle = 'Change Password';
$success   = '';
$error     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new     = $_POST['new_password']     ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $id  = $_SESSION['admin_id'];
    $row = $conn->query("SELECT password FROM admin_users WHERE id = $id")->fetch_assoc();

    if (!password_verify($current, $row['password'])) {
        $error = 'Your current password is incorrect.';
    } elseif (strlen($new) < 8) {
        $error = 'New password must be at least 8 characters long.';
    } elseif (!preg_match('/[A-Z]/', $new)) {
        $error = 'Password must contain at least one uppercase letter.';
    } elseif (!preg_match('/[0-9]/', $new)) {
        $error = 'Password must contain at least one number.';
    } elseif ($new !== $confirm) {
        $error = 'New passwords do not match.';
    } else {
        $hash = password_hash($new, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('UPDATE admin_users SET password = ? WHERE id = ?');
        $stmt->bind_param('si', $hash, $id);
        $stmt->execute();
        $stmt->close();
        $success = 'Password changed successfully!';
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
                <div class="col-lg-5">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h6><i class="bi bi-shield-lock me-2 text-primary"></i>Change Your Password</h6>
                        </div>
                        <div class="admin-card-body">

                            <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible alert-auto-dismiss fade show d-flex align-items-center gap-2">
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

                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Current Password</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">New Password</label>
                                    <input type="password" name="new_password" id="newPass" class="form-control" required minlength="8">
                                    <div class="form-text">Min 8 characters, at least 1 uppercase and 1 number.</div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Confirm New Password</label>
                                    <input type="password" name="confirm_password" id="confirmPass" class="form-control" required>
                                </div>

                                <!-- Password strength indicator -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Password Strength</small>
                                        <small id="strengthLabel" class="text-muted">—</small>
                                    </div>
                                    <div class="progress" style="height:6px;">
                                        <div id="strengthBar" class="progress-bar" style="width:0%;transition:width .3s"></div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-check-lg me-2"></i>Update Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
<script>
// Password strength meter
document.getElementById('newPass')?.addEventListener('input', function() {
    const val   = this.value;
    const bar   = document.getElementById('strengthBar');
    const label = document.getElementById('strengthLabel');
    let score = 0;
    if (val.length >= 8)              score++;
    if (/[A-Z]/.test(val))            score++;
    if (/[0-9]/.test(val))            score++;
    if (/[^A-Za-z0-9]/.test(val))     score++;

    const configs = [
        { width: '0%',   color: 'bg-secondary', text: '—'        },
        { width: '25%',  color: 'bg-danger',     text: 'Weak'     },
        { width: '50%',  color: 'bg-warning',    text: 'Fair'     },
        { width: '75%',  color: 'bg-info',        text: 'Good'     },
        { width: '100%', color: 'bg-success',    text: 'Strong'   },
    ];
    const c = configs[score];
    bar.style.width = c.width;
    bar.className   = 'progress-bar ' + c.color;
    label.textContent = c.text;
});
</script>
</body>
</html>
