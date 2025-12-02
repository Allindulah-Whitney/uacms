<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: backend/auth/user_login.php");
    exit();
}

include "backend/db_connect.php";

$user_id = $_SESSION['user_id'];

// Fetch notifications
$sql = "SELECT * FROM notifications WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - User Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <style>
        .page-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #004a99;
            font-weight: 600;
        }

        .notification-card {
            background: #fff;
            padding: 18px;
            margin-bottom: 15px;
            border-left: 5px solid #007bff;
            border-radius: 6px;
            transition: 0.3s;
        }

        .notification-card:hover {
            background: #f0f6ff;
        }

        .notification-title {
            font-size: 18px;
            font-weight: 600;
            color: #003366;
        }

        .notification-body {
            margin-top: 8px;
            color: #333;
        }

        .notification-time {
            margin-top: 10px;
            font-size: 13px;
            color: gray;
        }

        .no-notify {
            background: #fff2cc;
            padding: 20px;
            border-radius: 6px;
            text-align: center;
            font-size: 18px;
            color: #555;
            border-left: 5px solid #ffcc00;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <?php include "sidebar.php"; ?>

    <div class="content">

        <h1 class="page-title">Notifications</h1>

        <?php if ($result->num_rows > 0) { ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="notification-card">
                    <div class="notification-title"><?= htmlspecialchars($row['title']); ?></div>
                    <div class="notification-body"><?= htmlspecialchars($row['message']); ?></div>
                    <div class="notification-time"><?= $row['created_at']; ?></div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="no-notify">You have no notifications yet.</div>
        <?php } ?>

    </div>

</body>

</html>
