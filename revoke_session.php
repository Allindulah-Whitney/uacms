<?php
session_start();
require_once __DIR__ . "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: frontend/user_login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$session_id = isset($_POST['session_id']) ? intval($_POST['session_id']) : 0;

if ($session_id <= 0) {
    header("Location: frontend/user/sessions.php?err=1");
    exit();
}

// Ensure the session belongs to this user before deleting
$stmt = $conn->prepare("SELECT id FROM user_sessions WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $session_id, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $stmt->close();
    header("Location:frontend/user/sessions.php?err=2");
    exit();
}
$stmt->close();

// Delete session record
$del = $conn->prepare("DELETE FROM user_sessions WHERE id = ?");
$del->bind_param("i", $session_id);
$del->execute();
$del->close();

// If user revoked current session, destroy and redirect to login
if (isset($_SESSION['session_db_id']) && $_SESSION['session_db_id'] == $session_id) {
    // remove server-side session record already deleted; now end session
    session_unset();
    session_destroy();
    header("Location: frontend/user_login.html");
    exit();
}

header("Location:frontend/user/sessions.php?ok=1");
exit();
