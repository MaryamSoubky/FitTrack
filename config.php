<?php
// config.php
$servername = "localhost:3308"; // or use "::1" if needed
$username = "root";         // MySQL username
$password = "";             // Leave blank if no password is set
$dbname = "final"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>