<?php
include '../Controller/config.php';

class Goals_Model {
    private $goal_id;
    private $user_id;
    private $goal_type;
    private $target_value;
    private $progress;

    public function __construct($user_id, $goal_type, $target_value) {
        $this->user_id = $user_id;
        $this->goal_type = $goal_type;
        $this->target_value = $target_value;
        $this->progress = 0; // Default initial progress
    }

    public function getGoalId() {
        return $this->goal_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getGoalType() {
        return $this->goal_type;
    }

    public function getTargetValue() {
        return $this->target_value;
    }

    public function getProgress() {
        return $this->progress;
    }

    public function setProgress($progress) {
        $this->progress = $progress;
    }

    public static function getGoalById($goal_id, $db) {
        $query = "SELECT * FROM Goals WHERE goal_id = :goal_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":goal_id", $goal_id);
        $stmt->execute();
        $goal_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($goal_data) {
            $goal = new self($goal_data['user_id'], $goal_data['goal_type'], $goal_data['target_value']);
            $goal->goal_id = $goal_data['goal_id'];
            $goal->progress = $goal_data['progress'];
            return $goal;
        }
        return null;
    }

    public function save($db) {
        if (isset($this->goal_id)) {
            $query = "UPDATE Goals SET user_id = :user_id, goal_type = :goal_type, target_value = :target_value, progress = :progress WHERE goal_id = :goal_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":goal_id", $this->goal_id);
        } else {
            $query = "INSERT INTO Goals (user_id, goal_type, target_value, progress) VALUES (:user_id, :goal_type, :target_value, :progress)";
            $stmt = $db->prepare($query);
        }
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":goal_type", $this->goal_type);
        $stmt->bindParam(":target_value", $this->target_value);
        $stmt->bindParam(":progress", $this->progress);
        return $stmt->execute();
    }

    public static function deleteGoalById($goal_id, $db) {
        $query = "DELETE FROM Goals WHERE goal_id = :goal_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":goal_id", $goal_id);
        return $stmt->execute();
    }
}
?>

<?php
include '../Controller/config.php';

class Goals_Model {
    private $goal_id;
    private $user_id;
    private $goal_type;
    private $target_value;
    private $progress;

    public function __construct($user_id, $goal_type, $target_value) {
        $this->user_id = $user_id;
        $this->goal_type = $goal_type;
        $this->target_value = $target_value;
        $this->progress = 0; // Default initial progress
    }

    public function getGoalId() {
        return $this->goal_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getGoalType() {
        return $this->goal_type;
    }

    public function getTargetValue() {
        return $this->target_value;
    }

    public function getProgress() {
        return $this->progress;
    }

    public function setProgress($progress) {
        $this->progress = $progress;
    }

    public static function getGoalById($goal_id, $db) {
        $query = "SELECT * FROM Goals WHERE goal_id = :goal_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":goal_id", $goal_id);
        $stmt->execute();
        $goal_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($goal_data) {
            $goal = new self($goal_data['user_id'], $goal_data['goal_type'], $goal_data['target_value']);
            $goal->goal_id = $goal_data['goal_id'];
            $goal->progress = $goal_data['progress'];
            return $goal;
        }
        return null;
    }

    public function save($db) {
        if (isset($this->goal_id)) {
            $query = "UPDATE Goals SET user_id = :user_id, goal_type = :goal_type, target_value = :target_value, progress = :progress WHERE goal_id = :goal_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":goal_id", $this->goal_id);
        } else {
            $query = "INSERT INTO Goals (user_id, goal_type, target_value, progress) VALUES (:user_id, :goal_type, :target_value, :progress)";
            $stmt = $db->prepare($query);
        }
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":goal_type", $this->goal_type);
        $stmt->bindParam(":target_value", $this->target_value);
        $stmt->bindParam(":progress", $this->progress);
        return $stmt->execute();
    }

    public static function deleteGoalById($goal_id, $db) {
        $query = "DELETE FROM Goals WHERE goal_id = :goal_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":goal_id", $goal_id);
        return $stmt->execute();
    }
}
?>
