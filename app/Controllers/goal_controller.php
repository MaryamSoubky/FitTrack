<?php

require_once(__ROOT__ . "controller/Controller.php");
include_once '../Models/GoalModel.php';
include_once '../config.php';


class GoalController extends Controller{
    private $model;

    public function __construct($dbConnection) {
        $this->model = new GoalModel($dbConnection);
    }

    public function createGoal() {
	$userId = $_REQUEST['userId'];
	$password = $_REQUEST['password'];
	$goalType = $_REQUEST['goalType'];
	$targetValue = $_REQUEST['targetValue'];
	$deadline = $_REQUEST['deadline'];
        return $this->model->setGoal($userId, $goalType, $targetValue, $deadline);
    }
    public function edit() {
	$userId = $_REQUEST['userId'];
	$password = $_REQUEST['password'];
	$goalType = $_REQUEST['goalType'];
	$targetValue = $_REQUEST['targetValue'];
	$deadline = $_REQUEST['deadline'];

	$this->model->editGoal($userId,$goalType,$targetValue,$deadline);
    }

    public function delete(){
	$this->model->deleteGoal();
    }

    public function showGoals($userId) {
        return $this->model->getGoalsByUser($userId);
    }

    public function updateGoalProgress($goalId, $newProgress) {
        return $this->model->updateProgress($goalId, $newProgress);
    }
}
