<?php
session_start();
require_once __DIR__ . "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: frontend/user/user_login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$email_notify = isset($_POST['email_notify']) ? 1 : 0;
$timezone = trim($_POST['timezone'] ?? 'UTC');

// Upsert into user_settings
// Check existing
$stmt = $conn->prepare("SELECT id FROM user_settings WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    $upd = $conn->prepare("UPDATE user_settings SET email_notify = ?, timezone = ? WHERE user_id = ?");
    $upd->bind_param("isi", $email_notify, $timezone, $user_id);
    $ok = $upd->execute();
    $upd->close();
} else {
    $stmt->close();
    $ins = $conn->prepare("INSERT INTO user_settings (user_id, email_notify, timezone) VALUES (?, ?, ?)");
    $ins->bind_param("iis", $user_id, $email_notify, $timezone);
    $ok = $ins->execute();
    $ins->close();
}

header("Location: frontend/user/settings.php" . ($ok ? "?ok=1" : "?err=1"));
exit();
