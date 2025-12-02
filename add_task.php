<?php
session_start();
require_once __DIR__ . "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: frontend/user_login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$title = trim($_POST['title'] ?? '');
$due_date = !empty($_POST['due_date']) ? $_POST['due_date'] : null;

if ($title === '') {
    header("Location: user/tasks.php?err=1");
    exit();
}

$stmt = $conn->prepare("INSERT INTO tasks (user_id, title, due_date) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $title, $due_date);
$ok = $stmt->execute();
$stmt->close();

header("Location: frontend/user/tasks.php" . ($ok ? "?ok=1" : "?err=2"));
exit();
