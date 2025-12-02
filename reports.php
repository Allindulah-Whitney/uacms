<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: user_login.html");
include "backend/db_connect.php";

$user_id = $_SESSION['user_id'];

// Example count queries
$countLogins = $conn->query("SELECT COUNT(*) as c FROM login_history WHERE user_id = $user_id")->fetch_assoc()['c'];
$countMessages = $conn->query("SELECT COUNT(*) as c FROM messages WHERE receiver_id = $user_id")->fetch_assoc()['c'];
$countActivities = $conn->query("SELECT COUNT(*) as c FROM activity_logs WHERE user_id = $user_id")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Reports & Analytics</title>
<link rel="stylesheet" href="dashboard.css">
<style>
.cards { display:grid; grid-template-columns: repeat(auto-fit,minmax(200px,1fr)); gap:16px; }
.stat-card { background:#fff;padding:18px;border-radius:10px;box-shadow:0 3px 12px rgba(0,0,0,0.06); }
.stat-number { font-size:28px;color:#0d47a1;font-weight:700; }
</style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main-content">
    <h1>📊 Reports & Analytics</h1>
    <div class="cards">
        <div class="stat-card"><div>Logins</div><div class="stat-number"><?= $countLogins ?></div></div>
        <div class="stat-card"><div>Messages</div><div class="stat-number"><?= $countMessages ?></div></div>
        <div class="stat-card"><div>Activity Logs</div><div class="stat-number"><?= $countActivities ?></div></div>
    </div>

    <section style="margin-top:20px;">
        <h3>Recent Activities</h3>
        <div class="content-section">
            <table style="width:100%;border-collapse:collapse">
                <thead><tr><th>Action</th><th>When</th></tr></thead>
                <tbody>
                <?php
                $stmt = $conn->prepare("SELECT action, created_at FROM activity_logs WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
                $stmt->bind_param("i",$user_id); $stmt->execute(); $res=$stmt->get_result();
                while($r = $res->fetch_assoc()):
                ?>
                    <tr><td><?= htmlspecialchars($r['action']) ?></td><td><?= $r['created_at'] ?></td></tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
</body>
</html>
