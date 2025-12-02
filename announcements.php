<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location: user_login.html");
include "backend/db_connect.php";

$res = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Announcements</title>
<link rel="stylesheet" href="dashboard.css">
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main-content">
    <h1>📢 Announcements</h1>
    <div class="content-section">
        <?php while($a=$res->fetch_assoc()): ?>
            <div style="background:#fff;padding:14px;border-radius:8px;margin-bottom:12px;border-left:5px solid #007bff;">
                <strong><?= htmlspecialchars($a['title']) ?></strong>
                <div style="color:#666"><?= nl2br(htmlspecialchars($a['body'])) ?></div>
                <small style="color:#999"><?= $a['created_at'] ?></small>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
