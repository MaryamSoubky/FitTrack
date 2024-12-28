<?php

require_once '../Models/reports_model.php';
require_once '../config.php'; // Database connection
class Reports_Controller
{
    private $model;
    private $db;

    public function __construct($db)
    {
        $this->model = new Reports_Model($db);
        $this->db = $db;
    }

    public function displayReports()
    {
        // Fetch data from the model
        $totalUsers = $this->model->getTotalUsers();
        $activeGoals = $this->model->getActiveGoals();
        $today = date("Y-m-d");
        $workoutsToday = $this->model->getWorkoutsToday($today);
        $recentActivitiesResult = $this->model->getRecentActivities();
        $goalDetails = $this->model->getGoalDetails();

        // Pass data to the view
        require '../Views/reports.php';  // Ensure that you pass these variables properly
    }
}

?>
