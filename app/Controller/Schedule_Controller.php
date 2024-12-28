<?php
// ScheduleController.php
include_once 'config.php';
include_once '../Models/Schedule_Model.php';

class ScheduleController {

    private $scheduleModel;

    public function __construct($db_connection) {
        $this->scheduleModel = new Schedule_Model($db_connection);
    }

    public function updateSchedule($day, $time, $activity) {
        // Validate input
        if (empty($day) || empty($time) || empty($activity)) {
            return "All fields are required!";
        }

        // Call the model to update the schedule
        if ($this->scheduleModel->updateSchedule($day, $time, $activity)) {
            return "Schedule updated successfully!";
        } else {
            return "Failed to update schedule.";
        }
    }
}
?>
