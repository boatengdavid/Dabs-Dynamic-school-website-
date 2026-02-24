<?php
/**
 * index.php — Admin Login Page
 */
session_start();
require_once 'connect.php';

// Already logged in? Go to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin/dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $stmt = $conn->prepare('SELECT id, username, password FROM admin_users WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_logged_in']  = true;
                $_SESSION['admin_id']         = $admin['id'];
                $_SESSION['admin_username']   = $admin['username'];
                $_SESSION['last_regenerated'] = time();
                header('Location: admin/dashboard.php');
                exit();
            }
        }
        $error = 'Invalid username or password. Please try again.';
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DABS School — Admin Login</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
        }
        .login-header {
            background: linear-gradient(135deg, #1e3a5f, #2563eb);
            color: white;
            padding: 2.5rem 2rem 2rem;
            text-align: center;
        }
        .login-header .school-icon {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
        }
        .login-body { padding: 2rem; }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #1e3a5f, #2563eb);
            border: none;
            padding: .75rem;
            font-weight: 600;
            letter-spacing: .5px;
        }
        .btn-login:hover { opacity: .9; }
        .input-group-text { background: #f8fafc; border-right: none; }
        .form-control { border-left: none; }
        .toggle-password { cursor: pointer; background: #f8fafc; }
    </style>
</head>
<body>
<div class="container px-3">
    <div class="login-card card mx-auto">
        <div class="login-header">
            <div class="school-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <h4 class="mb-1 fw-bold">DABS School</h4>
            <p class="mb-0 opacity-75 small">Admin Control Panel</p>
        </div>
        <div class="login-body">
            <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill text-muted"></i></span>
                        <input type="text" name="username" class="form-control"
                               placeholder="Enter username"
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                               required autocomplete="username">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill text-muted"></i></span>
                        <input type="password" name="password" id="passwordInput"
                               class="form-control" placeholder="Enter password"
                               required autocomplete="current-password">
                        <span class="input-group-text toggle-password" onclick="togglePassword()">
                            <i class="bi bi-eye-fill text-muted" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-login w-100 text-white">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login to Dashboard
                </button>
            </form>

            <p class="text-center text-muted small mt-3 mb-0">
                <i class="bi bi-shield-lock me-1"></i>Secure Admin Access Only
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash-fill text-muted';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye-fill text-muted';
    }
}
</script>
</body>
</html>
