<?php
$host = "localhost";
$user = "root";
$pass = "root";  // Use your MySQL root password
$db = "restaurant_db";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
