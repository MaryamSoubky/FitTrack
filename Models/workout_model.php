<?php
// workout_model.php

class WorkoutModel {
    private $conn;

    public function __construct() {
        include '../Controller/config.php'; // Include your DB connection here
        $this->conn = $conn;
    }

    public function logWorkout($exercise_type, $duration, $intensity, $frequency) {
        // Assuming you have a session variable for the logged-in user ID
        $user_id = $_SESSION['user_id'];
        $date_logged = date('Y-m-d H:i:s'); // Get the current date and time

        // Prepare and execute the insert statement
        $stmt = $this->conn->prepare("INSERT INTO workouts (user_id, exercise_type, duration, intensity, frequency, date_logged) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issiis", $user_id, $exercise_type, $duration, $intensity, $frequency, $date_logged);

        if (!$stmt->execute()) {
            // Handle error here if needed
            return false;
        }

        $stmt->close();
        return true;
    }

    public function getProgress() {
        $user_id = $_SESSION['user_id'];
        $progress = [
            'total_workouts' => 0,
            'total_duration' => 0
        ];

        // Get the total number of workouts
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM workouts WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($progress['total_workouts']);
        $stmt->fetch();
        $stmt->close();

        // Get the total duration of workouts
        $stmt = $this->conn->prepare("SELECT SUM(duration) FROM workouts WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($progress['total_duration']);
        $stmt->fetch();
        $stmt->close();

        return $progress;
    }
}
