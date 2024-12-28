<?php
// Database connection settings
$servername = "localhost"; // Adjust if necessary
$port = "3306"; // Or "3308" based on your setup
$username = "root";
$password = ""; // Leave empty for no password
$dbname = "final";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
