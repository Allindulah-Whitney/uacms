<?php
session_start();
require_once __DIR__ . "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /user_login.html");
    exit();
}

$sender_id = $_SESSION['user_id'];
$original_sender = intval($_POST['original_sender'] ?? 0);
$subject = "RE: " . trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($original_sender <= 0 || $message === '') {
    header("Location: frontend/user/messages.php?err=1");
    exit();
}

$stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $sender_id, $original_sender, $subject, $message);
$ok = $stmt->execute();
$stmt->close();

header("Location: frontend/user/messages.php" . ($ok ? "?reply=1" : "?err=2"));
exit();
