<?php
session_start();
include "backend/db_connect.php";

// If user not logged in, redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch logs
$stmt = $conn->prepare("SELECT action, ip_address, user_agent, created_at FROM activity_logs WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
function logActivity($conn, $user_id, $action) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $agent = $_SERVER['HTTP_USER_AGENT'];

    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, ip_address, user_agent) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $action, $ip, $agent);
    $stmt->execute();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Activity Logs</title>
    <link rel="stylesheet" href="assets/css/activity_logs.css">
    <script src="assets/js/activity_logs.js" defer></script>
</head>

<body>

<!-- Sidebar Toggle -->
<div class="sidebar-toggle" onclick="toggleSidebar()">☰</div>

<!-- SIDEBAR (Imports from your dashboard) -->
<?php include "sidebar.php"; ?>

<!-- MAIN CONTENT -->
<div class="main-content">
    <h1>User Activity Logs</h1>
    <p class="subtitle">Below is a history of your account activity.</p>

    <div class="logs-container">
        <table>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>IP Address</th>
                    <th>Device / Browser</th>
                    <th>Time</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['action']; ?></td>
                        <td><?php echo $row['ip_address']; ?></td>
                        <td class="device"><?php echo substr($row['user_agent'], 0, 40) . "..."; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if ($result->num_rows == 0) { ?>
            <p class="empty">No activity logs found.</p>
        <?php } ?>
    </div>
</div>

</body>
</html>
