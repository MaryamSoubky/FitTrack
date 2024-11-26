<?php
include '../Controller/config.php';

class WorkoutLog_Model {
    private $log_id;
    private $user_id;
    private $exercise_type;
    private $duration;
    private $intensity;
    private $frequency;
    private $created_at;

    public function __construct($user_id, $exercise_type, $duration, $intensity, $frequency) {
        $this->user_id = $user_id;
        $this->exercise_type = $exercise_type;
        $this->duration = $duration;
        $this->intensity = $intensity;
        $this->frequency = $frequency;
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function getLogId() {
        return $this->log_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getExerciseType() {
        return $this->exercise_type;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getIntensity() {
        return $this->intensity;
    }

    public function getFrequency() {
        return $this->frequency;
    }

    public static function getLogById($log_id, $db) {
        $query = "SELECT * FROM Workout_Log WHERE log_id = :log_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":log_id", $log_id);
        $stmt->execute();
        $log_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($log_data) {
            $log = new self(
                $log_data['user_id'],
                $log_data['exercise_type'],
                $log_data['duration'],
                $log_data['intensity'],
                $log_data['frequency']
            );
            $log->log_id = $log_data['log_id'];
            $log->created_at = $log_data['created_at'];
            return $log;
        }
        return null;
    }

    public function save($db) {
        if (isset($this->log_id)) {
            $query = "UPDATE Workout_Log SET user_id = :user_id, exercise_type = :exercise_type, duration = :duration, intensity = :intensity, frequency = :frequency WHERE log_id = :log_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":log_id", $this->log_id);
        } else {
            $query = "INSERT INTO Workout_Log (user_id, exercise_type, duration, intensity, frequency) VALUES (:user_id, :exercise_type, :duration, :intensity, :frequency)";
            $stmt = $db->prepare($query);
        }
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":exercise_type", $this->exercise_type);
        $stmt->bindParam(":duration", $this->duration);
        $stmt->bindParam(":intensity", $this->intensity);
        $stmt->bindParam(":frequency", $this->frequency);
        return $stmt->execute();
    }

    public static function deleteLogById($log_id, $db) {
        $query = "DELETE FROM Workout_Log WHERE log_id = :log_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":log_id", $log_id);
        return $stmt->execute();
    }
}
?>

<?php
include '../Controller/config.php';

class WorkoutLog_Model {
    private $log_id;
    private $user_id;
    private $exercise_type;
    private $duration;
    private $intensity;
    private $frequency;
    private $created_at;

    public function __construct($user_id, $exercise_type, $duration, $intensity, $frequency) {
        $this->user_id = $user_id;
        $this->exercise_type = $exercise_type;
        $this->duration = $duration;
        $this->intensity = $intensity;
        $this->frequency = $frequency;
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function getLogId() {
        return $this->log_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getExerciseType() {
        return $this->exercise_type;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getIntensity() {
        return $this->intensity;
    }

    public function getFrequency() {
        return $this->frequency;
    }

    public static function getLogById($log_id, $db) {
        $query = "SELECT * FROM Workout_Log WHERE log_id = :log_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":log_id", $log_id);
        $stmt->execute();
        $log_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($log_data) {
            $log = new self(
                $log_data['user_id'],
                $log_data['exercise_type'],
                $log_data['duration'],
                $log_data['intensity'],
                $log_data['frequency']
            );
            $log->log_id = $log_data['log_id'];
            $log->created_at = $log_data['created_at'];
            return $log;
        }
        return null;
    }

    public function save($db) {
        if (isset($this->log_id)) {
            $query = "UPDATE Workout_Log SET user_id = :user_id, exercise_type = :exercise_type, duration = :duration, intensity = :intensity, frequency = :frequency WHERE log_id = :log_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":log_id", $this->log_id);
        } else {
            $query = "INSERT INTO Workout_Log (user_id, exercise_type, duration, intensity, frequency) VALUES (:user_id, :exercise_type, :duration, :intensity, :frequency)";
            $stmt = $db->prepare($query);
        }
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":exercise_type", $this->exercise_type);
        $stmt->bindParam(":duration", $this->duration);
        $stmt->bindParam(":intensity", $this->intensity);
        $stmt->bindParam(":frequency", $this->frequency);
        return $stmt->execute();
    }

    public static function deleteLogById($log_id, $db) {
        $query = "DELETE FROM Workout_Log WHERE log_id = :log_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":log_id", $log_id);
        return $stmt->execute();
    }
}
?>
