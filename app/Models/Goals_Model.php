<?php
include_once 'Subject.php';
include_once '../Controller/config.php';  // Include your DB connection

// Goals_Model.php
class Goals_Model implements Subject {
    private $db;
    private $user_id;
    private $goal_type;
    private $target_value;
    private $current_value;
    private $start_date;
    private $end_date;
    private $status;
    private $calories_burned;
    private $observers = [];

    public function __construct($db) {
        $this->db = $db;
    }

    public function setData($user_id, $goal_type, $target_value, $current_value, $start_date, $end_date, $status, $calories_burned = 0) {
        $this->user_id = $user_id;
        $this->goal_type = $goal_type;
        $this->target_value = $target_value;
        $this->current_value = $current_value;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->status = $status;
        $this->calories_burned = $calories_burned;
    }

    // Add an observer
    public function addObserver(Observer $observer) {
        $this->observers[] = $observer;
    }

    // Remove an observer
    public function removeObserver(Observer $observer) {
        foreach ($this->observers as $key => $obs) {
            if ($obs === $observer) {
                unset($this->observers[$key]);
            }
        }
    }

    // Notify all observers
    public function notifyObservers() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    // Public method to save goal and notify observers
    public function saveGoalAndNotify($duration, $intensity) {
        // Calculate calories burned
        $this->calories_burned = $this->calculateCalories($duration, $intensity);

        // SQL query to insert goal into the database
        $stmt = $this->db->prepare("INSERT INTO Goals (user_id, goal_type, target_value, current_value, start_date, end_date, status, calories_burned)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdsssi", $this->user_id, $this->goal_type, $this->target_value, $this->current_value, 
                         $this->start_date, $this->end_date, $this->status, $this->calories_burned);
        
        if ($stmt->execute()) {
            // Notify observers after saving goal
            $this->notifyObservers();
        } else {
            // Handle database insertion error
            echo "Error: " . $stmt->error;
        }
    }

    // Calculate calories based on goal type
    private function calculateCalories($duration, $intensity) {
        $baseCalories = ($this->goal_type === 'weight_loss') ? 10 : 8;
        if ($intensity === 'high') {
            $baseCalories *= 1.5;
        } elseif ($intensity === 'low') {
            $baseCalories *= 0.75;
        }
        return $baseCalories * $duration;
    }

    // Get goal details (for observer updates)
    public function getGoalDetails() {
        return "Goal Type: " . $this->goal_type . ", Target Value: " . $this->target_value;
    }
}
?>
