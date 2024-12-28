<?php
// Include database connection
include_once 'config.php';

// Check if id and form data are set
if (isset($_GET['id'])) {
    $goalId = intval($_GET['id']); // Ensure the id is an integer

    // Fetch existing goal details
    $stmt = $conn->prepare("SELECT goal_type, target_value, start_date, end_date FROM Goals WHERE id = ?");
    $stmt->bind_param("i", $goalId);
    $stmt->execute();
    $stmt->store_result();

    // If the goal exists, fetch data
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($goal_type, $target_value, $start_date, $end_date);
        $stmt->fetch();
    } else {
        echo "Goal not found.";
        exit();
    }
    $stmt->close();

    // Process form submission for editing
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newGoalType = $_POST['goal_type'];
        $newTargetValue = $_POST['target_value'];
        $newStartDate = $_POST['start_date'];
        $newEndDate = $_POST['end_date'];

        // Prepare and execute UPDATE query
        $updateStmt = $conn->prepare("UPDATE Goals SET goal_type = ?, target_value = ?, start_date = ?, end_date = ? WHERE id = ?");
        $updateStmt->bind_param("ssssi", $newGoalType, $newTargetValue, $newStartDate, $newEndDate, $goalId);
        $updateStmt->execute();
        $updateStmt->close();

        // Redirect back to the admin page after updating
        header("Location: admin.php");
        exit();
    }
} else {
    // If no id is provided, redirect to admin with an error
    header("Location: admin.php?error=missing_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Goal</title>
</head>
<body>
    <h2>Edit Goal</h2>
    <form method="POST" action="edit_goal.php?id=<?php echo $goalId; ?>">
        <label for="goal_type">Goal Type:</label>
        <input type="text" name="goal_type" id="goal_type" value="<?php echo htmlspecialchars($goal_type); ?>" required><br><br>

        <label for="target_value">Target Value:</label>
        <input type="text" name="target_value" id="target_value" value="<?php echo htmlspecialchars($target_value); ?>" required><br><br>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($start_date); ?>" required><br><br>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" value="<?php echo htmlspecialchars($end_date); ?>" required><br><br>

        <button type="submit">Update Goal</button>
    </form>

    <a href="admin.php">Back to Dashboard</a>
</body>
</html>
