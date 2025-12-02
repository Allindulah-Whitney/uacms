<?php
session_start();
require_once "db_connect.php";
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $uname, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION["admin_id"] = $id;
            $_SESSION["admin_username"] = $uname;
            $_SESSION["role"] = "admin";

            echo "Admin login successful!";
        } else {
            echo "Incorrect admin password!";
        }

    } else {
        echo "Admin account not found!";
    }
}
?>
