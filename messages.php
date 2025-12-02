<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}
require_once "backend/db_connect.php";

$user_id = $_SESSION['user_id'];

// Fetch messages
$stmt = $conn->prepare("SELECT * FROM messages WHERE receiver_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$messages = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Dashboard - Messages</title>
<link rel="stylesheet" href="dashboard.css">

<style>
    .message-card {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 12px;
        cursor: pointer;
        border-left: 5px solid #6c63ff;
        background: #f7f7ff;
        transition: 0.2s;
    }

    .message-card.unread {
        background: #fff6e6;
        border-left-color: #ff9f43;
        font-weight: bold;
    }

    .message-card:hover {
        transform: scale(1.01);
    }

    .delete-btn {
        float: right;
        padding: 5px 10px;
        border: none;
        background: #ff4f4f;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

</head>
<body>

<div class="dashboard-container">

    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <h2 class="page-title">📩 Messages</h2>

        <a href="compose_message.php" class="btn">+ Compose New Message</a>

        <div class="content-section">
            <?php while ($m = $messages->fetch_assoc()): ?>
            <form action="delete_message.php" method="POST">
                <input type="hidden" name="msg_id" value="<?= $m['id'] ?>">

                <div class="message-card <?= $m['is_read'] == 0 ? 'unread' : '' ?>" 
                     onclick="window.location='view_message.php?id=<?= $m['id'] ?>'">

                    <button type="submit" class="delete-btn">Delete</button>

                    <div class="message-title"><?= htmlspecialchars($m['subject']) ?></div>
                    <div class="message-preview">
                        <?= htmlspecialchars(substr($m['message'], 0, 80)) ?>...
                    </div>
                    <div class="message-date">
                        <?= date("M d, Y - h:i A", strtotime($m['created_at'])) ?>
                    </div>
                </div>
            </form>
            <?php endwhile; ?>
        </div>
    </div>

</div>

</body>
</html>
