<?php
session_start();
include "db_connect.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: frontend/user_login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get form input
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validate passwords match
if ($new_password !== $confirm_password) {
    die("Error: New passwords do not match.");
}

// 1. Fetch current user password from DB
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($stored_password);
$stmt->fetch();

// 2. Verify current password
if (!password_verify($current_password, $stored_password)) {
    die("Error: Current password is incorrect.");
}

// 3. Hash new password
$new_hashed = password_hash($new_password, PASSWORD_DEFAULT);

// 4. Update password in database
$update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$update->bind_param("si", $new_hashed, $user_id);

if ($update->execute()) {
    echo "Password successfully updated!";
    header("refresh:2; url=uacms/frontend/user/dashboard.php");
} else {
    echo "Error updating password.";
}

$stmt->close();
$conn->close();
?>
