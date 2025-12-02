<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location: user_login.html");
include "backend/db_connect.php";
$user_id = $_SESSION['user_id'];

$recent = $conn->prepare("SELECT action, created_at FROM activity_logs WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$recent->bind_param("i",$user_id); $recent->execute(); $recentRes = $recent->get_result();
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Activity Overview</title><link rel="stylesheet" href="dashboard.css"></head>
<body>
<?php include "sidebar.php"; ?>
<div class="main-content">
    <h1>Activity Overview</h1>
    <div class="content-section">
        <h3>Recent Actions</h3>
        <ul>
            <?php while($r = $recentRes->fetch_assoc()): ?>
                <li><?= htmlspecialchars($r['action']) ?> — <small><?= $r['created_at'] ?></small></li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
</body>
</html>
