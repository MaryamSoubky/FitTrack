<?php
// workout_controller.php
include '../Models/workout_model.php'; // Ensure this path is correct

session_start();
$errorMessages = [];
$progress = [];

// Initialize the WorkoutModel
$workoutModel = new WorkoutModel();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exercise_type = trim($_POST['exercise_type']);
    $duration = trim($_POST['duration']);
    $intensity = $_POST['intensity'];
    $frequency = trim($_POST['frequency']);

    // Validation
    if (empty($exercise_type)) {
        $errorMessages[] = "Exercise type is required.";
    }
    if (empty($duration) || $duration <= 0) {
        $errorMessages[] = "Duration must be a positive number.";
    }
    if ($frequency < 1 || $frequency > 7) {
        $errorMessages[] = "Frequency must be between 1 and 7.";
    }

    // If no errors, log the workout
    if (empty($errorMessages)) {
        $workoutModel->logWorkout($exercise_type, $duration, $intensity, $frequency);

        // Redirect to the same page with a success message
        header('Location: workout.php?logged=true');
        exit();
    }
}

// Get progress regardless of whether there were errors or not
$progress = $workoutModel->getProgress();
?>
