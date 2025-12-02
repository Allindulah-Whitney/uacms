<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location:user/user_login.html");
include "backend/db_connect.php";
$user_id = $_SESSION['user_id'];

// fetch tickets
$stmt = $conn->prepare("SELECT * FROM support_tickets WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i",$user_id); $stmt->execute(); $tickets = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Support / Help Center</title>
<link rel="stylesheet" href="dashboard.css">
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main-content">
    <h1>❓ Support / Help Center</h1>

    <div class="content-section">
        <h3>Submit a Ticket</h3>
        <form action="backend/support/submit_ticket.php" method="POST">
            <input type="text" name="subject" placeholder="Subject" required style="width:100%;padding:8px;margin-bottom:8px;">
            <textarea name="message" rows="5" placeholder="Describe your issue" required style="width:100%;padding:8px;"></textarea>
            <button style="margin-top:8px;padding:10px 14px;background:#007bff;color:#fff;border:none;">Submit</button>
        </form>

        <h3 style="margin-top:20px;">Your Tickets</h3>
        <?php if($tickets->num_rows>0): while($tk=$tickets->fetch_assoc()): ?>
            <div style="background:#fff;padding:12px;border-radius:8px;margin-bottom:8px;">
                <strong><?= htmlspecialchars($tk['subject']) ?></strong>
                <div><small><?= $tk['status'] ?> • <?= $tk['created_at'] ?></small></div>
            </div>
        <?php endwhile; else: ?>
            <p>No tickets yet.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
