<?php
session_start();

// Protect page
if (!isset($_SESSION['logged_in'])) {
    header("Location: user_login.html");
    exit();
}

// Load data
$fullname = $_SESSION['user_fullname'] ?? "";
$email = $_SESSION['user_email'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account</title>

    <link rel="stylesheet" href="update_account.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="logo">UACMS</h2>
        <ul>
            <li onclick="window.location.href='dashboard.php'">Dashboard</li>
            <li onclick="window.location.href='profile.php'">My Profile</li>
            <li class="active">Update Account</li>
            <li onclick="window.location.href='change_password.php'">Change Password</li>
            <li onclick="window.location.href='activity_logs.php'">Activity Logs</li>
            <li onclick="window.location.href='notifications.php'">Notifications</li>
            <li onclick="window.location.href='support.php'">Support</li>
            <li id="logoutBtn">Logout</li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <header>
            <h1>Update Account</h1>
        </header>

        <div class="update-container">
            <form action="../backend/update_user.php" method="POST" class="update-card">

                <h2>Edit Your Details</h2>

                <label>Full Name</label>
                <input type="text" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>

                <label>Email Address</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

                <button type="submit" class="save-btn">Save Changes</button>
            </form>
        </div>
    </div>

    <script src="update_account.js"></script>

</body>
</html>
