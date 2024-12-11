<?php
// Include the database configuration
include '../Controller/config.php'; // Ensure the path is correct
include '../Controller/reports_controller.php'; // Ensure the path is correct


class ReportModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    // Fetch workouts for a specific user
    public function getUserWorkouts($userId) {
        $stmt = $this->db->prepare("SELECT exercise_type, duration, intensity, frequency, log_date FROM workout_log WHERE user_id = ? ORDER BY log_date DESC");
        if (!$stmt) {
            return ["error" => $this->db->error];
        }
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch goals for a specific user
    public function getUserGoals($userId) {
        $stmt = $this->db->prepare("SELECT goal_type, target_value, current_value, start_date, end_date, status FROM goals WHERE user_id = ? ORDER BY start_date DESC");
        if (!$stmt) {
            return ["error" => $this->db->error];
        }
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Initialize database connection
$reportModel = new ReportModel($conn); 

// Retrieve user ID (replace hardcoded value with dynamic retrieval)
session_start();
$userId = $_SESSION['user_id'] ?? null; // Ensure session is started, and user ID is set

if (!$userId) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User ID not provided"]);
    exit;
}

// Fetch data
$workouts = $reportModel->getUserWorkouts($userId);
$goals = $reportModel->getUserGoals($userId);

// Check for errors in data retrieval
if (isset($workouts['error']) || isset($goals['error'])) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        "error" => "Failed to retrieve data",
        "workout_error" => $workouts['error'] ?? null,
        "goals_error" => $goals['error'] ?? null
    ]);
    exit;
}

// Prepare data for frontend display
$response = [
    'workouts' => $workouts,
    'goals' => $goals
];

// Return as JSON for easy integration with the frontend
header('Content-Type: application/json');
echo json_encode($response);
?>
