<?php
// Include database connection
include_once 'config.php';

if (isset($_GET['id'])) {
    $goalId = intval($_GET['id']); // Ensure the id is an integer

    // Prepare and execute DELETE statement
    $stmt = $conn->prepare("DELETE FROM Goals WHERE id = ?");
    $stmt->bind_param("i", $goalId);
    $stmt->execute();
    $stmt->close();

    // Redirect to the admin page after deletion
    header("Location: admin.php");
    exit();
} else {
    // If no id is provided, redirect back to the admin page with an error
    header("Location: admin.php?error=missing_id");
    exit();
}
?>
