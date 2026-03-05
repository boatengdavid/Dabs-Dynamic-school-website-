<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

require_once '../connect.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username']  = $user['username'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — DABS Dynamic International Schools</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --green-950: #052e16;
      --green-900: #14532d;
      --green-800: #166534;
      --green-700: #15803d;
      --green-600: #16a34a;
      --green-500: #22c55e;
      --green-400: #4ade80;
      --green-300: #86efac;
      --green-100: #dcfce7;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #0a1f14;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    /* Animated background */
    .bg-grid {
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(34,197,94,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(34,197,94,0.04) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
    }

    .bg-glow-1 {
      position: fixed;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(22,163,74,0.15) 0%, transparent 70%);
      top: -100px; left: -100px;
      pointer-events: none;
      animation: float1 8s ease-in-out infinite;
    }

    .bg-glow-2 {
      position: fixed;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(34,197,94,0.1) 0%, transparent 70%);
      bottom: -80px; right: -80px;
      pointer-events: none;
      animation: float2 10s ease-in-out infinite;
    }

    @keyframes float1 {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(30px, 40px); }
    }
    @keyframes float2 {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(-20px, -30px); }
    }

    /* Login card */
    .login-wrap {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 420px;
      padding: 24px;
      animation: slideUp 0.5s ease both;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .login-card {
      background: #0f2b1c;
      border: 1px solid rgba(34,197,94,0.15);
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 24px 80px rgba(0,0,0,0.4), 0 0 0 1px rgba(34,197,94,0.05);
    }

    /* Brand */
    .login-brand {
      text-align: center;
      margin-bottom: 32px;
    }

    .login-brand-icon {
      width: 64px; height: 64px;
      background: linear-gradient(135deg, var(--green-700), var(--green-500));
      border-radius: 16px;
      display: flex; align-items: center; justify-content: center;
      font-size: 28px;
      margin: 0 auto 16px;
      box-shadow: 0 8px 24px rgba(22,163,74,0.4);
    }

    .login-brand-name {
      font-size: 20px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.02em;
    }

    .login-brand-sub {
      font-size: 12px;
      color: rgba(163,196,173,0.6);
      margin-top: 4px;
      font-weight: 400;
    }

    /* Divider */
    .login-divider {
      height: 1px;
      background: rgba(34,197,94,0.12);
      margin-bottom: 28px;
    }

    /* Title */
    .login-title {
      font-size: 22px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.03em;
      margin-bottom: 6px;
    }

    .login-subtitle {
      font-size: 13px;
      color: rgba(163,196,173,0.6);
      margin-bottom: 28px;
    }

    /* Form */
    .form-group { margin-bottom: 18px; }

    .form-label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      color: rgba(163,196,173,0.7);
      margin-bottom: 8px;
    }

    .input-wrap { position: relative; }

    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: rgba(163,196,173,0.4);
      font-size: 15px;
      pointer-events: none;
    }

    .form-input {
      width: 100%;
      background: rgba(0,0,0,0.25);
      border: 1px solid rgba(34,197,94,0.15);
      border-radius: 10px;
      padding: 12px 14px 12px 40px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px;
      color: #ffffff;
      outline: none;
      transition: all 0.2s ease;
    }

    .form-input::placeholder { color: rgba(163,196,173,0.3); }

    .form-input:focus {
      border-color: var(--green-500);
      background: rgba(0,0,0,0.35);
      box-shadow: 0 0 0 3px rgba(34,197,94,0.12);
    }

    /* Toggle password */
    .toggle-pw {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: rgba(163,196,173,0.4);
      cursor: pointer;
      font-size: 15px;
      padding: 0;
      transition: color 0.2s;
    }
    .toggle-pw:hover { color: var(--green-400); }

    /* Error */
    .login-error {
      background: rgba(239,68,68,0.12);
      border: 1px solid rgba(239,68,68,0.25);
      border-radius: 10px;
      padding: 11px 14px;
      font-size: 13px;
      color: #fca5a5;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
    }

    /* Submit button */
    .btn-login {
      width: 100%;
      background: linear-gradient(135deg, var(--green-700), var(--green-600));
      border: none;
      border-radius: 10px;
      padding: 13px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px;
      font-weight: 700;
      color: white;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 4px 16px rgba(22,163,74,0.3);
      letter-spacing: 0.01em;
      margin-top: 8px;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, var(--green-800), var(--green-700));
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(22,163,74,0.4);
    }

    .btn-login:active { transform: translateY(0); }

    /* Footer */
    .login-footer {
      text-align: center;
      margin-top: 24px;
      font-size: 12px;
      color: rgba(163,196,173,0.35);
    }
  </style>
</head>
<body>
  <div class="bg-grid"></div>
  <div class="bg-glow-1"></div>
  <div class="bg-glow-2"></div>

  <div class="login-wrap">
    <div class="login-card">
      <div class="login-brand">
        <div class="login-brand-icon" style="background:none;box-shadow:none;">
  <img src="../dabs-logo.png" alt="DABS Logo" style="width:52px;height:52px;object-fit:contain;border-radius:12px;">
</div>
        <div class="login-brand-name">DABS Dynamic</div>
        <div class="login-brand-sub">International Schools — Admin</div>
      </div>

      <div class="login-divider"></div>

      <div class="login-title">Sign In</div>
      <div class="login-subtitle">Enter your credentials to access the admin panel</div>

      <?php if ($error): ?>
      <div class="login-error">
        <i class="bi bi-exclamation-circle-fill"></i>
        <?= htmlspecialchars($error) ?>
      </div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label class="form-label">Username</label>
          <div class="input-wrap">
            <i class="bi bi-person input-icon"></i>
            <input type="text" name="username" class="form-input" placeholder="Enter username" required autocomplete="username">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <div class="input-wrap">
            <i class="bi bi-lock input-icon"></i>
            <input type="password" id="passwordInput" name="password" class="form-input" placeholder="Enter password" required autocomplete="current-password">
            <button type="button" class="toggle-pw" onclick="togglePw()">
              <i class="bi bi-eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>
        <button type="submit" class="btn-login">
          <i class="bi bi-box-arrow-in-right me-2"></i>Sign In to Dashboard
        </button>
      </form>
    </div>

    <div class="login-footer">
      © <?= date('Y') ?> Dabs Dynamic International Schools · Knowledge cum Discipline
    </div>
  </div>

  <script>
    function togglePw() {
      const input = document.getElementById('passwordInput');
      const icon  = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
      } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
      }
    }
  </script>
</body>
</html>