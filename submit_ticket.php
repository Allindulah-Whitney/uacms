<?php
session_start();
require_once __DIR__ . "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: frontend/user/user_login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($subject === '' || $message === '') {
    header("Location: frontend/user/support.php?err=1");
    exit();
}

$stmt = $conn->prepare("INSERT INTO support_tickets (user_id, subject, message) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $subject, $message);
$ok = $stmt->execute();
$stmt->close();

header("Location: frontend/user/support.php" . ($ok ? "?ok=1" : "?err=2"));
exit();
