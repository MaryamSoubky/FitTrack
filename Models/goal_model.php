<?php
    
include '../Controller/config.php'; 
class GoalModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function setGoal($userId, $goalType, $targetValue, $deadline) {
        $stmt = $this->db->prepare("INSERT INTO goals (user_id, goal_type, target_value, deadline) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $userId, $goalType, $targetValue, $deadline);
        return $stmt->execute();
    }

    public function getGoalsByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM goals WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateProgress($goalId, $newProgress) {
        $stmt = $this->db->prepare("UPDATE goals SET current_value = ? WHERE id = ?");
        $stmt->bind_param("ii", $newProgress, $goalId);
        return $stmt->execute();
    }
}
