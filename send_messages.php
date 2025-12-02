<?php
session_start();
require_once __DIR__ . "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.html");
    exit();
}

$sender_id = $_SESSION['user_id'];
$receiver_id = intval($_POST['receiver_id'] ?? 0);
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($receiver_id <= 0 || $message === '') {
    header("Location: frontend/user/messages.php?err=1");
    exit();
}

$stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $sender_id, $receiver_id, $subject, $message);
$ok = $stmt->execute();
$stmt->close();

header("Location: frontend/user/messages.php" . ($ok ? "?ok=1" : "?err=2"));
exit();
