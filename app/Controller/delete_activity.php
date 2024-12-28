<?php
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $activityId = intval($_GET['id']);

    // Delete the activity
    $deleteQuery = "DELETE FROM Workout_Log WHERE workout_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $activityId);

    if ($stmt->execute()) {
        echo "Activity deleted successfully!";
        header("Location: admin.php"); // Redirect to admin dashboard
        exit();
    } else {
        echo "Error deleting activity.";
    }
} else {
    echo "Invalid request.";
}
?>
