<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location: user_login.html");
include "../backend/db_connect.php";
$user_id = $_SESSION['user_id'];

// Load settings if stored
$stmt = $conn->prepare("SELECT email_notify, timezone FROM user_settings WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i",$user_id); $stmt->execute(); $res=$stmt->get_result();
$settings = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Settings</title>
<link rel="stylesheet" href="dashboard.css">
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main-content">
    <h1>⚙️ Settings</h1>
    <div class="content-section">
        <form method="POST" action="../backend/settings/save_settings.php">
            <label><input type="checkbox" name="email_notify" <?= (!empty($settings['email_notify']) && $settings['email_notify'])? 'checked':'' ?>> Email notifications</label><br><br>
            <label>Timezone</label><br>
            <select name="timezone" style="padding:8px;">
                <option value="Africa/Nairobi" <?= ($settings['timezone']=='Africa/Nairobi')?'selected':'' ?>>Africa/Nairobi</option>
                <option value="UTC" <?= ($settings['timezone']=='UTC')?'selected':'' ?>>UTC</option>
            </select>
            <br><br>
            <button style="background:#007bff;color:#fff;padding:10px;border:none;border-radius:6px;">Save Settings</button>
        </form>
    </div>
</div>
</body>
</html>
