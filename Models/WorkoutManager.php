<?php
include_once '../Models/Subject_Model.php';
include_once '../Controller/config.php';

class WorkoutManager_Model  {
    private $observers = [];
    private $workoutData;
    private $db;

    // Constructor to initialize the database connection
    public function __construct($db) {
        $this->db = $db;
    }

    
    

    // Delete a workout entry
    public function deleteWorkout($workoutId) {
        $sql = "DELETE FROM workout_log WHERE workout_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $workoutId);

        // Check for execution success and handle errors
        if ($stmt->execute()) {
            return true;
        } else {
            // Log the error
            error_log("Error deleting workout: " . $stmt->error);
            return false;
        }
    }

    // Get the most recent workout of a user
    public function getRecentWorkout($userId) {
        $stmt = $this->db->prepare("SELECT * FROM workout_log WHERE user_id = ? ORDER BY log_date DESC LIMIT 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $workout = $result->fetch_assoc();
        $stmt->close();

        return $workout;
    }

    // Update an existing workout
    public function updateWorkout($workoutId, $userId, $data) {
        $sql = "UPDATE workout_log SET exercise_type = ?, duration = ?, intensity = ?, frequency = ?, notes = ? WHERE workout_id = ? AND user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("siiiiii", $data['exercise'], $data['duration'], $data['intensity'], $data['frequency'], $data['notes'], $workoutId, $userId);

        if ($stmt->execute()) {
            return $stmt->affected_rows > 0;
        } else {
            // Log the error
            error_log("Error updating workout: " . $stmt->error);
            return false;
        }
    }

    // Add a new workout entry
    public function addWorkout($user_id, $exercise, $duration, $intensity, $frequency, $notes) {
        $stmt = $this->db->prepare("INSERT INTO workout_log (user_id, exercise_type, duration, intensity, frequency, notes) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isiiis", $user_id, $exercise, $duration, $intensity, $frequency, $notes);

        // Check if the query executes successfully
        if ($stmt->execute()) {
            return true;
        } else {
            // Log the error
            error_log("Error adding workout: " . $stmt->error);
            return false;
        }
    }

    // Get workout by ID
    public function getWorkoutById($workoutId) {
        // Prepare the SQL query to fetch the workout by its ID
        $query = "SELECT * FROM workout_log WHERE workout_id = ?";
    
        // Prepare the statement using $this->db
        $stmt = $this->db->prepare($query);
    
        // Bind the workout ID parameter
        $stmt->bind_param('i', $workoutId);  // 'i' for integer
    
        // Execute the statement
        $stmt->execute();
    
        // Fetch the workout data
        $result = $stmt->get_result();
        $workout = $result->fetch_assoc();
    
        // Return the workout data if found, otherwise return false
        return $workout ? $workout : false;
    }
    
}
?>
