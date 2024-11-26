<?php
include '../Controller/config.php';  // Adjust the path as necessary

class WorkoutModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function addWorkout($exercise, $duration, $intensity, $frequency, $notes) {
        $stmt = $this->db->prepare("INSERT INTO workouts (exercise, duration, intensity, frequency, notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiis", $exercise, $duration, $intensity, $frequency, $notes);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getWorkouts() {
        $result = $this->db->query("SELECT * FROM workouts ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
