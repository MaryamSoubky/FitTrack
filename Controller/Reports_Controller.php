<?php
// Include the Reports_Model class
include_once '../Models/Reports_Model.php';  

class Reports_Controller {
    private $model;
    private $user_id;

    public function __construct($db, $user_id) {
        $this->model = new Reports_Model($db, $user_id);
        $this->user_id = $user_id;
    }

    // Fetch the reports data and prepare for the view
    public function getReports() {
        $workouts = $this->model->getWorkouts();
        $goals = $this->model->getGoals();

        // Prepare the data to pass to the view
        return ['workouts' => $workouts, 'goals' => $goals];
    }
}
?>
