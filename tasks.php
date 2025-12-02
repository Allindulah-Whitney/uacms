<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location:user_login.html");
include "backend/db_connect.php";
$user_id = $_SESSION['user_id'];

// fetch tasks
$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date IS NULL, due_date ASC");
$stmt->bind_param("i",$user_id); $stmt->execute(); $tasks = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Tasks & Projects</title>
<link rel="stylesheet" href="dashboard.css">
<style>
.task { background:#fff;padding:12px;border-radius:8px;margin-bottom:10px;display:flex;justify-content:space-between;align-items:center; }
.task-done { opacity:0.6;text-decoration:line-through; }
.small-btn { padding:6px 8px;border-radius:6px;border:none;cursor:pointer; }
</style>
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="main-content">
    <h1>🗂 Tasks & Projects</h1>
    <div class="content-section">
        <form action="backend/tasks/add_task.php" method="POST" style="margin-bottom:12px;">
            <input name="title" placeholder="New task title" required style="width:70%;padding:8px;">
            <input name="due_date" type="date" style="padding:8px;">
            <button class="small-btn" style="background:#007bff;color:#fff;">Add Task</button>
        </form>

        <?php while($t = $tasks->fetch_assoc()): ?>
            <div class="task <?= $t['status']=='done'?'task-done':'' ?>">
                <div>
                    <strong><?= htmlspecialchars($t['title']) ?></strong><br>
                    <small><?= $t['due_date']? $t['due_date'] : 'No due date' ?></small>
                </div>
                <div>
                    <?php if($t['status']!='done'): ?>
                        <form method="POST" action="../backend/tasks/mark_done.php" style="display:inline;">
                            <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                            <button class="small-btn" style="background:#28a745;color:#fff;">Mark Done</button>
                        </form>
                    <?php endif; ?>
                    <form method="POST" action="../backend/tasks/delete_task.php" style="display:inline;">
                        <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                        <button class="small-btn" style="background:#c62828;color:#fff;">Delete</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
