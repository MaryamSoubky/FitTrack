<?php
// Include the Observer interface
include_once 'Observer.php';  // Adjust the path if necessary

class GoalObserver implements Observer {
    public function update($goal) {
        // This is where you can handle updates after the goal changes
        echo "Goal updated: " . $goal->getGoalDetails() . "\n";
        // You can log changes, send emails, or update UI elements here.
    }
}
?>
