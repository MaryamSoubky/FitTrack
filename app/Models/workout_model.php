<?php
class WorkoutModel {
    private $db;

    // Constructor to initialize the database connection
    public function __construct($conn) {
        $this->db = $conn;
    }

    // Method to add a workout to the database
    public function addWorkout($user_id, $exercise, $duration, $intensity, $frequency, $notes) {
        // Prepare the SQL query to insert the workout data into the database
        $stmt = $this->db->prepare("INSERT INTO workout_log (user_id, exercise_type, duration, intensity, frequency, notes) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isiiis", $user_id, $exercise, $duration, $intensity, $frequency, $notes);

        // Execute the query and return true if it was successful, false otherwise
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Method to get all workouts of a specific user
    public function getWorkouts($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM workout_log WHERE user_id = ? ORDER BY log_date DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);  // Return the result as an associative array
    }
}
?>
