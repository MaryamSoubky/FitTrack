<?php
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $activityId = intval($_GET['id']);

    // Fetch the activity details
    $query = "SELECT * FROM Workout_Log WHERE workout_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $activityId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $activity = $result->fetch_assoc();
    } else {
        echo "Activity not found.";
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update activity details
    $activityId = intval($_POST['id']);
    $exerciseType = $_POST['exercise_type'];
    $duration = intval($_POST['duration']);
    $logDate = $_POST['log_date'];

    $updateQuery = "UPDATE Workout_Log SET exercise_type = ?, duration = ?, log_date = ? WHERE workout_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sisi", $exerciseType, $duration, $logDate, $activityId);

    if ($stmt->execute()) {
        echo "Activity updated successfully!";
        header("Location: admin.php"); // Redirect to admin dashboard
        exit();
    } else {
        echo "Error updating activity.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Activity</title>
</head>
<body>
    <h2>Edit Activity</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $activity['workout_id']; ?>">
        <label>Exercise Type:</label>
        <input type="text" name="exercise_type" value="<?php echo htmlspecialchars($activity['exercise_type']); ?>" required><br>
        <label>Duration (min):</label>
        <input type="number" name="duration" value="<?php echo htmlspecialchars($activity['duration']); ?>" required><br>
        <label>Log Date:</label>
        <input type="datetime-local" name="log_date" value="<?php echo htmlspecialchars($activity['log_date']); ?>" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
