<?php
function logActivity($conn, $user_id, $action) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, ip_address, user_agent) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $action, $ip, $ua);
    $stmt->execute();
    $stmt->close();
    logActivity($conn, $user_id, "Added task: {$title}");

}<?php
require_once __DIR__ . "db_connect.php";

/**
 * Log activity (useful for audit)
 */
function logActivity($conn, $user_id, $action) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, ip_address, user_agent) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $action, $ip, $ua);
    $stmt->execute();
    $stmt->close();
}

/**
 * Returns an array of permissions for a given user id.
 * Checks:
 *  - users.role_id (single-role)
 *  - user_roles table (multiple roles) if present
 */
function getUserPermissions($conn, $user_id) {
    $permissions = [];

    // 1) If users.role_id exists, get those permissions
    $sql = "SELECT role_id FROM users WHERE id = ? LIMIT 1";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($role_id);
        if ($stmt->fetch()) {
            if ($role_id) {
                $stmt->close();
                $q = $conn->prepare("SELECT permission FROM role_permissions WHERE role_id = ?");
                $q->bind_param("i", $role_id);
                $q->execute();
                $res = $q->get_result();
                while ($r = $res->fetch_assoc()) $permissions[$r['permission']] = true;
                $q->close();
            } else {
                $stmt->close();
            }
        } else {
            $stmt->close();
        }
    }

    // 2) If user_roles table exists, also fetch permissions for each role
    $q2 = $conn->prepare("SELECT role_id FROM user_roles WHERE user_id = ?");
    if ($q2) {
        $q2->bind_param("i", $user_id);
        $q2->execute();
        $res2 = $q2->get_result();
        while ($r2 = $res2->fetch_assoc()) {
            $rid = $r2['role_id'];
            $q3 = $conn->prepare("SELECT permission FROM role_permissions WHERE role_id = ?");
            $q3->bind_param("i", $rid);
            $q3->execute();
            $res3 = $q3->get_result();
            while ($p = $res3->fetch_assoc()) $permissions[$p['permission']] = true;
            $q3->close();
        }
        $q2->close();
    }

    // Return array keys as list
    return array_keys($permissions);
}

