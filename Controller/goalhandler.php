<?php

include_once '../Controllers/GoalController.php';
include_once '../config.php';


$goalController = new GoalController($dbConnection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = 1; // Static example user ID, update this based on user session
    $goalType = $_POST['goalType'];
    $targetValue = (int)$_POST['targetValue'];
    $deadline = $_POST['deadline'];

    if ($goalController->createGoal($userId, $goalType, $targetValue, $deadline)) {
        echo "Goal has been set successfully!";
    } else {
        echo "Failed to set goal. Please try again.";
    }
}
?>