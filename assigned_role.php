<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: backend/auth/user_login.php");
    exit();
}

include "backend/db_connect.php";

$user_id = $_SESSION['user_id'];

// Fetch user role
$sql = "SELECT roles.role_name, roles.description
        FROM users 
        INNER JOIN roles ON users.role_id = roles.id
        WHERE users.id = '$user_id'";

$result = $conn->query($sql);
$role = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Role - User Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <style>
        .page-title {
            font-size: 28px;
            color: #004a99;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .role-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 8px;
            border-left: 5px solid #007bff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .role-title {
            font-size: 24px;
            color: #003366;
            font-weight: 700;
        }

        .role-desc {
            margin-top: 10px;
            font-size: 16px;
            color: #333;
        }

        .permissions-box {
            margin-top: 25px;
            background: #f0f6ff;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #cce0ff;
        }

        .permissions-title {
            font-size: 20px;
            color: #003d80;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .perm-item {
            padding: 8px 0;
            border-bottom: 1px dashed #aac8f0;
            color: #333;
            font-size: 15px;
        }

        .perm-item:last-child {
            border-bottom: none;
        }

        .no-role {
            background: #fff2cc;
            padding: 20px;
            text-align: center;
            border-radius: 6px;
            font-size: 18px;
            border-left: 5px solid #ffcc00;
            color: #555;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <?php include "sidebar.php"; ?>

    <div class="content">

        <h1 class="page-title">Assigned Role</h1>

        <?php if ($role) { ?>

            <div class="role-card">
                <div class="role-title">
                    <?= htmlspecialchars($role['role_name']); ?>
                </div>
                <div class="role-desc">
                    <?= htmlspecialchars($role['description']); ?>
                </div>
            </div>

            <!-- Fetch permissions of this role -->
            <?php
            $role_name = $role['role_name'];

            $perm_sql = "SELECT permission 
                         FROM permissions 
                         WHERE role_name = '$role_name'";

            $perm_result = $conn->query($perm_sql);
            ?>

            <div class="permissions-box">
                <div class="permissions-title">Role Permissions</div>

                <?php if ($perm_result->num_rows > 0) { ?>
                    <?php while ($perm = $perm_result->fetch_assoc()) { ?>
                        <div class="perm-item"><?= htmlspecialchars($perm['permission']); ?></div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="perm-item">No permissions assigned.</div>
                <?php } ?>
            </div>

        <?php } else { ?>
            <div class="no-role">No role assigned to your account.</div>
        <?php } ?>

    </div>

</body>
</html>
