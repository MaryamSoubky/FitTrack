<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'config.php';  // Include your database connection
include_once '../Models/Goals_Model.php';  // Include GoalModel class
include_once '../Models/GoalObserver.php';  // Include GoalObserver class

// Assume you have the user ID from the session
$user_id = $_SESSION['user_id'];

// Create a new GoalModel (subject)
$goalModel = new Goals_Model($conn);



// Set goal data (example values, you should replace these with dynamic values)
$goalModel->setData($user_id, 'weight_loss', 5, 0, '2024-01-01', '2024-12-31', 'active');

// Example goal settings for duration and intensity (these would come from the form)
$duration = 30;  // 30 minutes
$intensity = 'medium';  // medium intensity

// Save the goal and notify observers
$goalModel->saveGoalAndNotify($duration, $intensity);

// Function to get the current user's goal from the database
function getUserCurrentGoal() {
    global $conn;  // Use the $conn variable for the database connection
    $user_id = $_SESSION['user_id'];  // Get user ID from session or authentication
    // Adjust the query to order by goal_id, which is the primary key
    $query = "SELECT * FROM goals WHERE user_id = ? ORDER BY goal_id DESC LIMIT 1";  
    $stmt = $conn->prepare($query);  // Use $conn for preparing the statement
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();  // Returns the current goal or null if none
}

// Check if the form has been submitted to update or delete the goal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle goal update or deletion logic here
    if (isset($_POST['updateGoal'])) {
        // Handle goal update
        $goalType = $_POST['goalType'];
        $targetValue = $_POST['targetValue'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        // Update the goal in the database
        $updateQuery = "UPDATE goals SET goal_type = ?, target_value = ?, start_date = ?, end_date = ? WHERE user_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('ssssi', $goalType, $targetValue, $startDate, $endDate, $user_id);
        $stmt->execute();

        $_SESSION['goal_message'] = "Goal updated successfully!";
        header('Location: ../Views/goal_view.php');  // Redirect back to the goal setting page
    } elseif (isset($_POST['deleteGoal'])) {
        // Handle goal deletion
        $deleteQuery = "DELETE FROM goals WHERE user_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        $_SESSION['goal_message'] = "Goal deleted successfully!";
        header('Location: ../Views/goal_view.php');  // Redirect back to the goal setting page
    }
}
?>
