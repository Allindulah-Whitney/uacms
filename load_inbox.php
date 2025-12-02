<?php
session_start();
require_once __DIR__ . "db_connect.php";

if (!isset($_SESSION['user_id'])) { exit("unauthorized"); }

$user_id = $_SESSION['user_id'];

$query = $conn->prepare("SELECT m.*, u.username AS sender_name 
    FROM messages m 
    JOIN users u ON m.sender_id = u.id
    WHERE m.receiver_id = ? AND m.is_archived = 0
    ORDER BY m.sent_at DESC");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
