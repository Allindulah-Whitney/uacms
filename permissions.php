<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: backend/auth/user_login.php");
    exit();
}

include "backend/db_connect.php";

$user_id = $_SESSION['user_id'];

// Fetch user's role details
$sql = "SELECT roles.role_name 
        FROM users 
        INNER JOIN roles ON users.role_id = roles.id
        WHERE users.id = '$user_id'";

$result = $conn->query($sql);
$role = $result->fetch_assoc();
$role_name = $role ? $role['role_name'] : null;

// Fetch permissions for the role
$perm_sql = "SELECT permission 
             FROM permissions 
             WHERE role_name = '$role_name'";

$permissions = $conn->query($perm_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permissions - User Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <style>
        .page-title {
            font-size: 28px;
            color: #004a99;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .role-banner {
            background: #e6f0ff;
            padding: 18px;
            border-left: 5px solid #007bff;
            border-radius: 6px;
            margin-bottom: 25px;
            font-size: 18px;
            color: #003d80;
            font-weight: 600;
        }

        .permission-card {
            background: #ffffff;
            padding: 18px;
            margin-bottom: 15px;
            border-radius: 6px;
            border-left: 5px solid #0066cc;
            box-shadow: 0 1px 6px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .permission-card:hover {
            background: #f0f6ff;
        }

        .permission-text {
            font-size: 16px;
            color: #333;
        }

        .no-permission {
            background: #fff3cd;
            padding: 20px;
            border-radius: 6px;
            border-left: 5px solid #ffcc00;
            color: #555;
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <?php include "sidebar.php"; ?>

    <div class="content">

        <h1 class="page-title">Your Permissions</h1>

        <?php if ($role_name) { ?>
            <div class="role-banner">
                Role Assigned: <strong><?= htmlspecialchars($role_name); ?></strong>
            </div>

            <?php if ($permissions->num_rows > 0) { ?>
                <?php while ($perm = $permissions->fetch_assoc()) { ?>
                    <div class="permission-card">
                        <div class="permission-text">
                            <?= htmlspecialchars($perm['permission']); ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="no-permission">This role has no permissions assigned.</div>
            <?php } ?>

        <?php } else { ?>
            <div class="no-permission">No role assigned to your account.</div>
        <?php } ?>

    </div>

</body>

</html>
