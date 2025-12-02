<?php
session_start();
include "backend/db_connect.php";

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT ip_address, user_agent, login_time, status 
                        FROM login_history 
                        WHERE user_id = ? 
                        ORDER BY login_time DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login History</title>
    <link rel="stylesheet" href="assets/css/login_history.css">
    <script defer src="assets/js/login_history.js"></script>
</head>

<body>

<!-- Sidebar Toggle -->
<div class="sidebar-toggle" onclick="toggleSidebar()">☰</div>

<!-- SIDEBAR -->
<?php include "sidebar.php"; ?>

<!-- MAIN CONTENT -->
<div class="main-content">
    <h1>Login History</h1>
    <p class="subtitle">Track all successful and failed login attempts.</p>

    <div class="history-container">
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>IP Address</th>
                    <th>Device / Browser</th>
                    <th>Login Time</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr class="<?php echo strtolower($row['status']); ?>">
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['ip_address']; ?></td>
                        <td><?php echo substr($row['user_agent'], 0, 40) . "..."; ?></td>
                        <td><?php echo $row['login_time']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if ($result->num_rows == 0) { ?>
            <p class="empty">No login logs found.</p>
        <?php } ?>
    </div>
</div>

</body>
</html>
