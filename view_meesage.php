<?php
session_start();
require_once "backend/db_connect.php";

$msg_id = $_GET['id'];

// Fetch message
$stmt = $conn->prepare("SELECT m.*, u.username AS sender 
                        FROM messages m 
                        JOIN users u ON m.sender_id = u.id 
                        WHERE m.id = ?");
$stmt->bind_param("i", $msg_id);
$stmt->execute();
$message = $stmt->get_result()->fetch_assoc();

// Mark as read
$conn->query("UPDATE messages SET is_read = 1 WHERE id = $msg_id");
?>

<!DOCTYPE html>
<html>
<head>
<title>View Message</title>
<link rel="stylesheet" href="dashboard.css">
</head>

<body>

<div class="dashboard-container">

<?php include "sidebar.php"; ?>

<div class="main-content">
    <h2 class="page-title">📨 Message from <?= htmlspecialchars($message['sender']) ?></h2>

    <div class="content-section">
        <h3><?= htmlspecialchars($message['subject']) ?></h3>
        <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
        <small>Sent: <?= $message['created_at'] ?></small>

        <br><br>
        <a href="reply_message.php?id=<?= $message['id'] ?>" class="btn">Reply</a>
    </div>

</div>

</div>

</body>
</html>
