<?php
class Goals_Model {
    private $user_id;
    private $goal_type;
    private $target_value;
    private $current_value;
    private $start_date;
    private $end_date;
    private $status;

    public function __construct($user_id, $goal_type, $target_value, $current_value, $start_date, $end_date, $status) {
        $this->user_id = $user_id;
        $this->goal_type = $goal_type;
        $this->target_value = $target_value;
        $this->current_value = $current_value;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->status = $status;
    }

    public function save($db) {
        $query = "INSERT INTO goals (user_id, goal_type, target_value, current_value, start_date, end_date, status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('issdsss', $this->user_id, $this->goal_type, $this->target_value, $this->current_value, 
                         $this->start_date, $this->end_date, $this->status);
        return $stmt->execute();
    }
}
?>
