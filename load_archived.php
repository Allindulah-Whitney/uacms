<?php
session_start();
require_once __DIR__ . "db_connect.php";

if (!isset($_SESSION['user_id'])) { exit("unauthorized"); }

$user_id = $_SESSION['user_id'];

$q = $conn->prepare("
    SELECT m.*, u.username AS sender_name 
    FROM messages m 
    JOIN users u ON m.sender_id = u.id
    WHERE m.receiver_id = ? AND m.is_archived = 1
    ORDER BY m.sent_at DESC
");
$q->bind_param("i", $user_id);
$q->execute();

$res = $q->get_result();
$data = [];

while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
