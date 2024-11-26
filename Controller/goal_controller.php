<?php

include_once '../models/GoalModel.php';
include_once './dbconfiq.php';
include_once './config.php';


class GoalController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new GoalModel($dbConnection);
    }

    public function createGoal($userId, $goalType, $targetValue, $deadline) {
        return $this->model->setGoal($userId, $goalType, $targetValue, $deadline);
    }

    public function showGoals($userId) {
        return $this->model->getGoalsByUser($userId);
    }

    public function updateGoalProgress($goalId, $newProgress) {
        return $this->model->updateProgress($goalId, $newProgress);
    }
}
