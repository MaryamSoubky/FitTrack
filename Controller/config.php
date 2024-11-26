<?php
// Database connection parameters
$host = 'localhost';  // Database host
$dbname = 'fitness_tracker';  // Your database name
$username = 'root';  // Database username
$password = '';  // Database password

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

