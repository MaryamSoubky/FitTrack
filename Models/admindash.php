<?php
// Include the database connection
include_once 'config.php';
session_start();

require_once 'database.php'; // Assuming a database connection file is used

class AdminDashboard {

    public function getDashboardStats($admin_id) {
        global $db;

        // Query to get the dashboard statistics for the specific admin
        $query = "SELECT total_users, active_goals, workout_logs_today
                  FROM Admin_Dashboard_Stats
                  WHERE admin_id = :admin_id";

        $statement = $db->prepare($query);
        $statement->bindParam(':admin_id', $admin_id);
        $statement->execute();
        $stats = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        return $stats;
    }

    public function updateDashboardStats($admin_id) {
        global $db;

        // Calculate statistics and update Admin_Dashboard_Stats table
        $totalUsers = $this->getTotalUsers();
        $activeGoals = $this->getActiveGoals();
        $workoutsToday = $this->getWorkoutLogsToday();

        $query = "UPDATE Admin_Dashboard_Stats
                  SET total_users = :totalUsers, active_goals = :activeGoals, workout_logs_today = :workoutsToday
                  WHERE admin_id = :admin_id";

        $statement = $db->prepare($query);
        $statement->bindParam(':totalUsers', $totalUsers);
        $statement->bindParam(':activeGoals', $activeGoals);
        $statement->bindParam(':workoutsToday', $workoutsToday);
        $statement->bindParam(':admin_id', $admin_id);
        $statement->execute();
        $statement->closeCursor();
    }

    private function getTotalUsers() {
        global $db;
        $query = "SELECT COUNT(*) AS total_users FROM Users";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result['total_users'];
    }

    private function getActiveGoals() {
        global $db;
        $query = "SELECT COUNT(*) AS active_goals FROM Goals WHERE status = 'in_progress'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result['active_goals'];
    }

    private function getWorkoutLogsToday() {
        global $db;
        $query = "SELECT COUNT(*) AS workout_logs_today FROM Workout_Log WHERE DATE(log_date) = CURDATE()";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result['workout_logs_today'];
    }
}
