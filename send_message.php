<?php
session_start();
require_once "backend/db_connect.php";

$sender = $_SESSION['user_id'];
$receiver = $_POST['receiver_id'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $sender, $receiver, $subject, $message);
$stmt->execute();

header("Location: messages.php?sent=1");
exit();
?>
