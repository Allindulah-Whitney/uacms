<?php
session_start();

// Prevent access if not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: user_login.html");
    exit();
}

// Load user info
$fullname = $_SESSION['user_fullname'] ?? "User";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <!-- CSS -->
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="logo">UACMS</h2>
        <ul>
           <!-- Sidebar Toggle Button -->
<div class="sidebar-toggle" onclick="toggleSidebar()">☰</div>

<div class="sidebar" id="sidebar">
    <h2>User Panel</h2>
    <ul>
<li><a href="dashboard.php">🏠 Dashboard</a></li>

        <li class="section">PROFILE</li>
        <li><a href="profile.php">👤 View Profile</a></li>
        <li><a href="update_account.php">✏️ Update Account</a></li>
        <li><a href="change_password.html">🔒 Change Password</a></li>
</li><li><a href="messages.php">📨 Messages</a></li>
       
        <li class="section">ACTIVITY</li>
        <li><a href="activity_logs.php">📄 Activity Logs</a></li>
        <li><a href="login_history.php">📊 Login History</a></li>
        <li><a href="notifications.php">🔔 Notifications</a></li>
<li><a href="reports.php">📊 Reports</a></li>
<li><a href="security.php">🔐 Security</a></li>
<li><a href="announcements.php">📢 Announcements</a></li>
        
        <li class="section">ACCESS</li>
        <li><a href="user_role.php">🛡 Assigned Role</a></li>
        <li><a href="permissions.php">⚙️ Permissions</a></li>
        <li><a href="request_upgrade.php">⬆ Upgrade Access</a>
<li><a href="support.php">❓ Support</a></li>
<li><a href="tasks.php">🗂 Tasks</a></li>
<li><a href="settings.php">⚙️ Settings</a></li>

        
        <li><a href="backend/user/logout.php" class="logout">🚪 Logout</a></li>
    </ul>
</div>


        </ul>
    </div>

    <!-- Main Content -->
    <div class="main">
        <header>
            <h1>Welcome Back, <?php echo htmlspecialchars($fullname); ?>!</h1>
            <span class="date" id="dateDisplay"></span>
        </header>

        <section class="cards">

            <div class="card">
                <h3>Account Status</h3>
                <p>Your account is active and secure.</p>
            </div>

            <div class="card">
                <h3>Notifications</h3>
                <p>You have 2 unread notifications.</p>
            </div>

            <div class="card">
                <h3>Last Login</h3>
                <p>Tracking your login history helps secure your account.</p>
            </div>

            <div class="card">
                <h3>Support</h3>
                <p>Need help? Contact the help desk anytime.</p>
            </div>

        </section>
    </div>

    <!-- JS -->
    <script src="dashboard.js"></script>

</body>
</html>
