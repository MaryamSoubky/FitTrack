<?php
include_once '../config.php';

class ReportsModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Fetch workouts and goals for all users
    public function getAllUsersReportData() {
        // Fetch workouts for all users
        $workoutsQuery = "SELECT 
                              u.name AS user_name, 
                              w.exercise_type, 
                              w.duration, 
                              w.intensity, 
                              w.frequency, 
                              w.log_date 
                          FROM workout_log w
                          JOIN users u ON w.user_id = u.user_id";

        $workoutsResult = $this->conn->query($workoutsQuery);
        $workouts = [];
        if ($workoutsResult->num_rows > 0) {
            while ($row = $workoutsResult->fetch_assoc()) {
                $workouts[] = $row;
            }
        }

        // Fetch goals for all users
        $goalsQuery = "SELECT 
                           u.name AS user_name, 
                           g.goal_type, 
                           g.target_value, 
                           g.current_value, 
                           g.start_date, 
                           g.end_date, 
                           g.status 
                       FROM goals g
                       JOIN users u ON g.user_id = u.user_id";

        $goalsResult = $this->conn->query($goalsQuery);
        $goals = [];
        if ($goalsResult->num_rows > 0) {
            while ($row = $goalsResult->fetch_assoc()) {
                $goals[] = $row;
            }
        }

        // Return combined data
        return [
            'workouts' => $workouts,
            'goals' => $goals
        ];
    }
}
?>
