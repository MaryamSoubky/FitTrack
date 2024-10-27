<?php
include '../Controller/config.php'; // Include your config file
include '../Models/goal_model.php'; // Include your model file

session_start();
$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure all necessary POST variables are set
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Get user ID from session
    $goalType = isset($_POST['goal_type']) ? trim($_POST['goal_type']) : '';
    $targetValue = isset($_POST['target_value']) ? trim($_POST['target_value']) : '';
    $goalStartDate = isset($_POST['goal_start_date']) ? trim($_POST['goal_start_date']) : '';
    $goalEndDate = isset($_POST['goal_end_date']) ? trim($_POST['goal_end_date']) : '';

    // Validate the input
    if (empty($goalType)) {
        $errorMessages[] = "Goal type is required.";
    }
    if (empty($targetValue) || !is_numeric($targetValue)) {
        $errorMessages[] = "Target value must be a number.";
    }
    if (empty($goalStartDate)) {
        $errorMessages[] = "Goal start date is required.";
    }
    if (empty($goalEndDate)) {
        $errorMessages[] = "Goal end date is required.";
    }

    // If no errors, create the goal
    if (empty($errorMessages) && $userId) {
        $goalModel = new GoalModel($conn); // Pass the connection
        $goalModel->createGoal($userId, $goalType, $targetValue, $goalStartDate, $goalEndDate);

        // Redirect or display success message
        header('Location: goal_view.php?goal_added=true');
        exit();
    }
}

// Fetch goals for the logged-in user if needed
if (isset($_SESSION['user_id'])) {
    $goalModel = new GoalModel($conn);
    $goals = $goalModel->getGoals($_SESSION['user_id']);
}
?>
