<?php
session_start();
require_once __DIR__ . "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: frontend/user_login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$task_id = intval($_POST['task_id'] ?? 0);
if ($task_id <= 0) {
    header("Location: frontend/user/tasks.php?err=1");
    exit();
}

// Ensure task belongs to user
$stmt = $conn->prepare("SELECT id FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $stmt->close();
    header("Location: frontend/user/tasks.php?err=2");
    exit();
}
$stmt->close();

// Mark done
$upd = $conn->prepare("UPDATE tasks SET status = 'done' WHERE id = ?");
$upd->bind_param("i", $task_id);
$ok = $upd->execute();
$upd->close();

header("Location: frontend/user/tasks.php" . ($ok ? "?ok=1" : "?err=3"));
exit();
