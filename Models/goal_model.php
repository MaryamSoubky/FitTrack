<?php
include '../Controller/config.php';  // Adjust the path as necessary

class GoalModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function createGoal($userId, $goalType, $targetValue, $goalStartDate, $goalEndDate) {
        $stmt = $this->conn->prepare("INSERT INTO goals (user_id, goal_type, target_value, goal_start_date, goal_end_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $userId, $goalType, $targetValue, $goalStartDate, $goalEndDate);
        $stmt->execute();
        $stmt->close();
    }

    public function getGoals($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM goals WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Add more methods as needed
}
?>
