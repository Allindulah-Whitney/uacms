<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}
require_once "backend/db_connect.php";

// Fetch all users except sender
$stmt = $conn->prepare("SELECT id, username FROM users WHERE id != ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$users = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Compose Message</title>
<link rel="stylesheet" href="dashboard.css">

<style>
    .form-group {
        margin-bottom: 15px;
    }
</style>

</head>
<body>

<div class="dashboard-container">
    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <h2 class="page-title">✉ Compose Message</h2>

        <div class="content-section">
            <form action="send_message.php" method="POST">

                <div class="form-group">
                    <label>Select Recipient</label>
                    <select name="receiver_id" required>
                        <?php while($u = $users->fetch_assoc()): ?>
                            <option value="<?= $u['id'] ?>"><?= $u['username'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="subject" required>
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" rows="5" required></textarea>
                </div>

                <button type="submit" class="btn">Send Message</button>

            </form>
        </div>
    </div>
</div>

</body>
</html>
