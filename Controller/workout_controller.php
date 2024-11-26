<?php
include_once 'config.php'; 
include_once '../Models/workout_model.php'; 


class WorkoutController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new WorkoutModel($dbConnection);
    }

    public function addWorkout() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Sanitize user input
            $exercise = htmlspecialchars($_POST['exercise']);
            $duration = (int)$_POST['duration'];
            $intensity = (int)$_POST['intensity'];
            $frequency = (int)$_POST['frequency'];
            $notes = isset($_POST['notes']) ? htmlspecialchars($_POST['notes']) : '';

            // Server-side validation
            if (strlen($exercise) < 3 || strlen($exercise) > 50) {
                echo "Exercise type must be between 3 and 50 characters.";
                return;
            }

            if ($duration < 1 || $duration > 300) {
                echo "Duration must be between 1 and 300 minutes.";
                return;
            }

            if ($intensity < 1 || $intensity > 10) {
                echo "Intensity must be between 1 and 10.";
                return;
            }

            if ($frequency < 1 || $frequency > 7) {
                echo "Frequency must be between 1 and 7 days per week.";
                return;
            }

            // Add workout to the database
            if ($this->model->addWorkout($exercise, $duration, $intensity, $frequency, $notes)) {
                header("Location: workoutSuccess.php");
            } else {
                echo "Failed to log the workout. Please try again.";
            }
        }
    }

    public function showWorkouts() {
        return $this->model->getWorkouts();
            // Add workout to the database
            if ($this->model->addWorkout($exercise, $duration, $intensity, $frequency, $notes)) {
                header("Location: workoutSuccess.php");
            } else {
                echo "Failed to log the workout. Please try again.";
            }

    }
}
?>
