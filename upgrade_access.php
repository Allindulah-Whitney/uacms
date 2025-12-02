<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: backend/auth/user_login.php");
    exit();
}

include "backend/db_connect.php";

$user_id = $_SESSION['user_id'];

// Get current user role
$sql = "SELECT users.role_id, roles.role_name 
        FROM users 
        INNER JOIN roles ON users.role_id = roles.id 
        WHERE users.id = '$user_id'";

$result = $conn->query($sql);
$user = $result->fetch_assoc();

$current_role_id = $user['role_id'];
$current_role = $user['role_name'];

// Fetch roles ABOVE current role
$roles_sql = "SELECT * FROM roles WHERE id > '$current_role_id'";
$upgrade_roles = $conn->query($roles_sql);

// Handle upgrade request submission
$message = "";
if(isset($_POST['submit_request'])) {
    $requested_role = $_POST['requested_role'];

    $insert = "INSERT INTO role_upgrade_requests (user_id, current_role, requested_role) 
               VALUES ('$user_id', '$current_role', '$requested_role')";

    if($conn->query($insert)) {
        $message = "Your upgrade request has been submitted successfully.";
    } else {
        $message = "Error submitting request.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upgrade Access - User Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <style>
        .page-title {
            font-size: 28px;
            color: #004a99;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .info-box {
            background: #e6f2ff;
            padding: 20px;
            border-left: 5px solid #007bff;
            border-radius: 6px;
            margin-bottom: 25px;
        }

        .info-title {
            font-size: 20px;
            font-weight: 600;
            color: #003d80;
        }

        .message-success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-left: 5px solid #28a745;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .upgrade-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .upgrade-label {
            font-size: 18px;
            font-weight: 600;
            color: #003d80;
            margin-bottom: 10px;
        }

        select, button {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            border-radius: 6px;
            border: 1px solid #aac8f0;
            margin-bottom: 15px;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            font-size: 17px;
            cursor: pointer;
        }

        button:hover {
            background: #005fcc;
        }

        .no-options {
            background: #fff2cc;
            padding: 20px;
            border-radius: 6px;
            font-size: 18px;
            border-left: 5px solid #ffcc00;
        }
    </style>
</head>

<body>

<?php include "sidebar.php"; ?>

<div class="content">

    <h1 class="page-title">Upgrade Access Level</h1>

    <?php if ($message != "") { ?>
        <div class="message-success"><?= $message; ?></div>
    <?php } ?>

    <div class="info-box">
        <div class="info-title">Your Current Role: <strong><?= htmlspecialchars($current_role); ?></strong></div>
        <p>You may request a higher access role. Your request must be approved by an administrator.</p>
    </div>

    <?php if ($upgrade_roles->num_rows > 0) { ?>
        <div class="upgrade-card">
            <form method="POST">

                <label class="upgrade-label">Select Role to Upgrade To</label>

                <select name="requested_role" required>
                    <option value="">-- Choose a role --</option>

                    <?php while ($role = $upgrade_roles->fetch_assoc()) { ?>
                        <option value="<?= $role['role_name']; ?>">
                            <?= $role['role_name']; ?>
                        </option>
                    <?php } ?>
                </select>

                <button type="submit" name="submit_request">Submit Upgrade Request</button>

            </form>
        </div>

    <?php } else { ?>
        <div class="no-options">
            No higher roles available for upgrade.
        </div>
    <?php } ?>

</div>

</body>
</html>
