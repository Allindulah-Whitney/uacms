<?php
session_start();

// Protect page
if (!isset($_SESSION['logged_in'])) {
    header("Location: user_login.html");
    exit();
}

$fullname = $_SESSION['user_fullname']; 
$email = $_SESSION['user_email'] ?? "email not loaded yet"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <!-- CSS -->
    <link rel="stylesheet" href="profile.css">
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="logo">UACMS</h2>
        <ul>
            <li onclick="window.location.href='dashboard.php'">Dashboard</li>
            <li class="active">My Profile</li>
            <li onclick="window.location.href='update_account.php'">Update Account</li>
            <li onclick="window.location.href='change_password.php'">Change Password</li>
            <li onclick="window.location.href='activity_logs.php'">Activity Logs</li>
            <li onclick="window.location.href='notifications.php'">Notifications</li>
            <li onclick="window.location.href='support.php'">Support</li>
            <li id="logoutBtn">Logout</li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main">
        <header>
            <h1>My Profile</h1>
        </header>

        <div class="profile-container">

            <div class="profile-card">
                <h2>User Information</h2>

                <label>Full Name</label>
                <input type="text" id="fullname" value="<?php echo $fullname; ?>" disabled>

                <label>Email Address</label>
                <input type="email" id="email" value="<?php echo $email; ?>" disabled>

                <button class="edit-btn" onclick="enableEdit()">Edit Profile</button>
                <button class="save-btn" onclick="saveProfile()" style="display:none;">Save Changes</button>
            </div>

        </div>
    </div>

    <!-- JS -->
    <script src="profile.js"></script>

</body>
</html>
