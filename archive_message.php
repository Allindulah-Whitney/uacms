<?php
session_start();
require_once __DIR__ . "db_connect.php";

if (!isset($_SESSION['user_id'])) { exit("unauthorized"); }

$user_id = $_SESSION['user_id'];
$message_id = intval($_POST['message_id'] ?? 0);

$stmt = $conn->prepare("UPDATE messages SET is_archived = 1 WHERE id = ? AND receiver_id = ?");
$stmt->bind_param("ii", $message_id, $user_id);
$stmt->execute();
$stmt->close();

echo "ok";
