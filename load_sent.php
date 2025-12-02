<?php
session_start();
require_once __DIR__ . "db_connect.php";

if (!isset($_SESSION['user_id'])) { exit("unauthorized"); }

$user_id = $_SESSION['user_id'];

$query = $conn->prepare("
    SELECT m.*, u.username AS receiver_name 
    FROM messages m 
    JOIN users u ON m.receiver_id = u.id
    WHERE sender_id = ?
    ORDER BY m.sent_at DESC
");
$query->bind_param("i", $user_id);
$query->execute();

$result = $query->get_result();
$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
