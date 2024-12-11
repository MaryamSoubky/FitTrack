<?php
// Including the database connection file and model
include_once 'config.php';  // Assuming this file is in the root directory
include_once '../Models/workout_model.php';  // Assuming this file is in the Models directory

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collecting the form data
    $exercise = htmlspecialchars($_POST['exercise']);
    $duration = (int)$_POST['duration'];
    $intensity = (int)$_POST['intensity'];
    $frequency = (int)$_POST['frequency'];
    $notes = isset($_POST['notes']) ? htmlspecialchars($_POST['notes']) : '';

    // Assuming you have the user ID stored in session after user login
    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo "You must be logged in to log a workout.";
        exit();
    }
    $user_id = $_SESSION['user_id'];

    // Create an instance of the WorkoutModel
    $workoutModel = new WorkoutModel($conn);

    // Validate and add the workout to the database
    if ($workoutModel->addWorkout($user_id, $exercise, $duration, $intensity, $frequency, $notes)) {
        // Redirect to the same page with a success message
        header("Location: ../Views/workouts.php?message=Workout set successfully");
        exit();
    } else {
        echo "Failed to log the workout. Please try again.";
    }
}
?>
