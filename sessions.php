<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location: user_login.html");
include "backend/db_connect.php";
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id, ip_address, user_agent, created_at, last_seen FROM user_sessions WHERE user_id = ? ORDER BY last_seen DESC");
$stmt->bind_param("i",$user_id); $stmt->execute(); $sessions = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Sessions</title><link rel="stylesheet" href="dashboard.css"></head>
<body>
<?php include "sidebar.php"; ?>
<div class="main-content">
    <h1>Active Sessions</h1>
    <div class="content-section">
        <?php while($s=$sessions->fetch_assoc()): ?>
            <div style="background:#fff;padding:12px;border-radius:8px;margin-bottom:8px;">
                <div><strong>IP:</strong> <?= $s['ip_address'] ?></div>
                <div><small><?= $s['user_agent'] ?></small></div>
                <form method="POST" action="../backend/revoke_session.php"><input type="hidden" name="session_id" value="<?= $s['id'] ?>"><button style="background:#c62828;color:#fff;padding:8px;border:none;border-radius:6px;margin-top:6px;">Revoke</button></form>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
