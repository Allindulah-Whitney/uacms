<?php
function logActivity($conn, $user_id, $action) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, ip_address, user_agent) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $action, $ip, $ua);
    $stmt->execute();
    $stmt->close();
    logActivity($conn, $user_id, "Added task: {$title}");

}
