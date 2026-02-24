<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Change to your MySQL username
define('DB_PASS', '');           // Change to your MySQL password
define('DB_NAME', 'dabs_school');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('<div style="font-family:sans-serif;padding:2rem;color:red;">
        ❌ Database connection failed: ' . $conn->connect_error . '
        <br><br>Please check your credentials in <strong>connect.php</strong>
    </div>');
}

$conn->set_charset('utf8mb4');
?>
