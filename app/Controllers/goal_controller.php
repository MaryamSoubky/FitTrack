<?php
session_start();
include_once '../Models/Goals_Model.php';  // Make sure this path is correct
include_once 'config.php';  // Include database connection

class GoalController {
    private $conn;

    // Constructor to inject the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function handleGoalFormSubmission() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['goal_message'] = "User is not logged in. Please log in to set goals.";
            header('Location: ../Views/goal_view.php');
            exit();
        }

        $user_id = $_SESSION['user_id'];  // Retrieve user_id from session

        // Collect form data
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $goal_type = $_POST['goalType'];
            $target_value = $_POST['targetValue'];
            $current_value = 0;  // Initial value
            $start_date = $_POST['startDate'];
            $end_date = $_POST['endDate'];
            $status = 'active';  // Assuming active status for now

            // Prepare and execute the query
            $stmt = $this->conn->prepare("INSERT INTO Goals (user_id, goal_type, target_value, current_value, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issddss", $user_id, $goal_type, $target_value, $current_value, $start_date, $end_date, $status);

            if ($stmt->execute()) {
                $_SESSION['goal_message'] = "Goal set successfully!";
            } else {
                $_SESSION['goal_message'] = "Failed to set goal. Please try again.";
            }

            $stmt->close();
        }

        // Redirect back to the form page to show the message
        header(header: 'Location: ../Views/goal_view.php');
        exit();
    }
}

// Create an instance of GoalController with the database connection
$goalController = new GoalController($conn);
$goalController->handleGoalFormSubmission();
?>
