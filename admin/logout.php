<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signed Out — DABS Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --green-900: #14532d;
      --green-800: #166534;
      --green-700: #15803d;
      --green-600: #16a34a;
      --green-500: #22c55e;
      --green-400: #4ade80;
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

    .bg-grid {
      position: fixed; inset: 0;
      background-image:
        linear-gradient(rgba(34,197,94,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(34,197,94,0.04) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
    }

    .bg-glow-1 {
      position: fixed; width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(22,163,74,0.15) 0%, transparent 70%);
      top: -100px; left: -100px; pointer-events: none;
      animation: float1 8s ease-in-out infinite;
    }
    .bg-glow-2 {
      position: fixed; width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(34,197,94,0.1) 0%, transparent 70%);
      bottom: -80px; right: -80px; pointer-events: none;
      animation: float2 10s ease-in-out infinite;
    }

    @keyframes float1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(30px,40px)} }
    @keyframes float2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-20px,-30px)} }

    .logout-wrap {
      position: relative; z-index: 10;
      width: 100%; max-width: 420px; padding: 24px;
      animation: popIn 0.5s cubic-bezier(0.34,1.56,0.64,1) both;
    }

    @keyframes popIn {
      from { opacity: 0; transform: scale(0.92) translateY(20px); }
      to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .logout-card {
      background: #0f2b1c;
      border: 1px solid rgba(34,197,94,0.15);
      border-radius: 20px;
      padding: 44px 40px;
      box-shadow: 0 24px 80px rgba(0,0,0,0.4), 0 0 0 1px rgba(34,197,94,0.05);
      text-align: center;
    }

    /* Animated checkmark circle */
    .logout-icon-wrap {
      width: 80px; height: 80px;
      background: linear-gradient(135deg, rgba(22,163,74,0.2), rgba(34,197,94,0.1));
      border: 2px solid rgba(34,197,94,0.3);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 24px;
      position: relative;
      animation: ringPulse 2s ease-in-out infinite;
    }

    @keyframes ringPulse {
      0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.25); }
      50%      { box-shadow: 0 0 0 12px rgba(34,197,94,0); }
    }

    .logout-icon-wrap i {
      font-size: 32px;
      color: var(--green-400);
    }

    .logout-title {
      font-size: 24px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.03em;
      margin-bottom: 8px;
    }

    .logout-subtitle {
      font-size: 14px;
      color: rgba(163,196,173,0.6);
      line-height: 1.6;
      margin-bottom: 32px;
    }

    .divider {
      height: 1px;
      background: rgba(34,197,94,0.12);
      margin-bottom: 28px;
    }

    .brand-row {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 28px;
    }

    .brand-icon {
      width: 38px; height: 38px;
      background: linear-gradient(135deg, var(--green-700), var(--green-500));
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 18px;
      box-shadow: 0 4px 12px rgba(22,163,74,0.3);
    }

    .brand-name {
      font-size: 15px; font-weight: 700; color: #ffffff;
    }
    .brand-sub {
      font-size: 11px; color: rgba(163,196,173,0.5); margin-top: 1px;
    }

    .btn-login {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      width: 100%;
      background: linear-gradient(135deg, var(--green-700), var(--green-600));
      border: none; border-radius: 10px;
      padding: 13px 20px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px; font-weight: 700;
      color: white; cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 4px 16px rgba(22,163,74,0.3);
      text-decoration: none;
      margin-bottom: 12px;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, var(--green-800), var(--green-700));
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(22,163,74,0.4);
      color: white;
    }

    .btn-website {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      width: 100%;
      background: transparent;
      border: 1px solid rgba(34,197,94,0.2);
      border-radius: 10px;
      padding: 11px 20px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px; font-weight: 600;
      color: rgba(163,196,173,0.7);
      cursor: pointer; text-decoration: none;
      transition: all 0.2s ease;
    }

    .btn-website:hover {
      border-color: rgba(34,197,94,0.4);
      color: var(--green-400);
      background: rgba(34,197,94,0.05);
    }

    /* Countdown */
    .countdown-text {
      font-size: 12px;
      color: rgba(163,196,173,0.4);
      margin-top: 20px;
    }

    .countdown-num {
      color: var(--green-400);
      font-weight: 700;
    }

    .logout-footer {
      text-align: center; margin-top: 20px;
      font-size: 12px; color: rgba(163,196,173,0.25);
    }
  </style>
</head>
<body>
  <div class="bg-grid"></div>
  <div class="bg-glow-1"></div>
  <div class="bg-glow-2"></div>

  <div class="logout-wrap">
    <div class="logout-card">

      <!-- Brand -->
      <div class="brand-row">
        <div class="brand-icon" style="background:none;box-shadow:none;padding:2px;">
  <img src="../dabs-logo.png" alt="DABS Logo" style="width:34px;height:34px;object-fit:contain;">
</div>
        <div>
          <div class="brand-name">DABS Dynamic</div>
          <div class="brand-sub">International Schools</div>
        </div>
      </div>

      <div class="divider"></div>

      <!-- Icon -->
      <div class="logout-icon-wrap">
        <i class="bi bi-shield-check"></i>
      </div>

      <div class="logout-title">You've been signed out</div>
      <div class="logout-subtitle">
        Your session has been securely ended.<br>
        Thank you for using the DABS Admin Panel.
      </div>

      <a href="index.php" class="btn-login">
        <i class="bi bi-box-arrow-in-right"></i> Sign Back In
      </a>
      <a href="../home.php" class="btn-website">
        <i class="bi bi-globe"></i> Visit School Website
      </a>

      

    <div class="logout-footer">
      © <?= date('Y') ?> Dabs Dynamic International Schools · Knowledge cum Discipline
    </div>
  </div>

  
</body>
</html>