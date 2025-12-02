<?php
// Database credentials for XAMPP
$host = "localhost";      // Server
$user = "root";           // Default XAMPP username
$password = "";           // Default XAMPP password (empty)
$dbname = "uacms_db";     // Your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: Uncomment to confirm successful connection
// echo "Database connected successfully!";
?>
