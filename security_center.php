<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.html");
    exit();
}
include "../backend/db_connect.php";

$user_id = $_SESSION['user_id'];

// Simple query for sessions table (create table suggested below)
// If you don't have sessions table, this will show current session only
$stmt = $conn->prepare("SELECT id, ip_address, user_agent, created_at, last_seen FROM user_sessions WHERE user_id = ? ORDER BY last_seen DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$sessions = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Security Center</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        .session-card { background:#fff;padding:15px;border-radius:8px;margin-bottom:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);}
        .btn-revoke { background:#c62828;color:#fff;border:none;padding:8px 12px;border-radius:6px;cursor:pointer;}
    </style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main-content">
    <h1>🔐 Security Center</h1>
    <p class="subtitle">Active sessions and device activity. Revoke sessions you don't recognize.</p>

    <div class="content-section">
        <?php if ($sessions && $sessions->num_rows>0): ?>
            <?php while($s = $sessions->fetch_assoc()): ?>
                <div class="session-card">
                    <div><strong>IP:</strong> <?= htmlspecialchars($s['ip_address']) ?></div>
                    <div><strong>Agent:</strong> <?= htmlspecialchars(substr($s['user_agent'],0,80)) ?>...</div>
                    <div><strong>Started:</strong> <?= $s['created_at'] ?></div>
                    <div><strong>Last Seen:</strong> <?= $s['last_seen'] ?></div>
                    <form method="POST" action="../backend/revoke_session.php" style="margin-top:8px;">
                        <input type="hidden" name="session_id" value="<?= $s['id'] ?>">
                        <button class="btn-revoke">Revoke</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No active sessions found for your account.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
