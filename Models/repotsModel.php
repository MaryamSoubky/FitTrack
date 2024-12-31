<?php
class Reports_Model {
    private $db;
    private $user_id;

    public function __construct($db, $user_id) {
        $this->db = $db;
        $this->user_id = $user_id;
    }

    // Fetch workouts from the database
    public function getWorkouts() {
        $query = "SELECT workout_id, exercise_type, duration, intensity, frequency, log_date, notes 
                  FROM Workout_Log WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any workouts are returned
        if ($result->num_rows > 0) {
            $workouts = $result->fetch_all(MYSQLI_ASSOC);
            return $workouts;
        } else {
            // Debugging: log the query and result count
            error_log("No workouts found for user ID: " . $this->user_id);
            return [];
        }
    }

    // Fetch goals from the database
    public function getGoals() {
        $query = "SELECT goal_id, goal_type, target_value, current_value, start_date, end_date, status, calories_burned 
                  FROM Goals WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any goals are returned
        if ($result->num_rows > 0) {
            $goals = $result->fetch_all(MYSQLI_ASSOC);
            return $goals;
        } else {
            // Debugging: log the query and result count
            error_log("No goals found for user ID: " . $this->user_id);
            return [];
        }
    }
}
