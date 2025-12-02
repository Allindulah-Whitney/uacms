<?php
session_start();
require_once "db_connect.php";
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = ? AND role='user'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
     $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $fullname, $hashedPassword);
        $stmt->fetch();
        if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

 // Verify password
        if (password_verify($password, $hashedPassword, $user['password'])) {

            // create session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_fullname'] = $user['fullname'];
            $_SESSION['logged_in'] = true;

            // redirect to dashboard
            header("Location: frontend/user/dashboard.php");
            exit();
        } else {
            echo "Invalid email or password!";
        }
    } else {
        echo "User not found!";
    }
}
function logLogin($conn, $user_id, $status) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $agent = $_SERVER['HTTP_USER_AGENT'];

    $stmt = $conn->prepare("INSERT INTO login_history (user_id, ip_address, user_agent, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $ip, $agent, $status);
    $stmt->execute();
}

?>


