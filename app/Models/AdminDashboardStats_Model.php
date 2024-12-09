<?php
include '../config.php';

class AdminDashboardStats_Model {
    private $stat_id;
    private $user_count;
    private $admin_count;
    private $workout_log_count;
    private $goal_count;

    public function __construct($user_count, $admin_count, $workout_log_count, $goal_count) {
        $this->user_count = $user_count;
        $this->admin_count = $admin_count;
        $this->workout_log_count = $workout_log_count;
        $this->goal_count = $goal_count;
    }

    public function getStatId() {
        return $this->stat_id;
    }

    public function getUserCount() {
        return $this->user_count;
    }

    public function getAdminCount() {
        return $this->admin_count;
    }

    public function getWorkoutLogCount() {
        return $this->workout_log_count;
    }

    public function getGoalCount() {
        return $this->goal_count;
    }

    public static function getStats($db) {
        $query = "SELECT COUNT(*) AS user_count FROM Users";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $user_count = $stmt->fetchColumn();

        $query = "SELECT COUNT(*) AS admin_count FROM Admins";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $admin_count = $stmt->fetchColumn();

        $query = "SELECT COUNT(*) AS workout_log_count FROM Workout_Log";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $workout_log_count = $stmt->fetchColumn();

        $query = "SELECT COUNT(*) AS goal_count FROM Goals";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $goal_count = $stmt->fetchColumn();

        return new self($user_count, $admin_count, $workout_log_count, $goal_count);
    }
}
?>
