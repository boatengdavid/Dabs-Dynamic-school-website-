<?php
/**
 * admin/auth.php — Session Protection Guard
 * Include at the top of every admin page
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

// Regenerate session ID periodically to prevent fixation
if (!isset($_SESSION['last_regenerated'])) {
    session_regenerate_id(true);
    $_SESSION['last_regenerated'] = time();
} elseif (time() - $_SESSION['last_regenerated'] > 300) {
    session_regenerate_id(true);
    $_SESSION['last_regenerated'] = time();
}
?>
