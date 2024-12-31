<?php
class SubscriptionModel {
    private $db;

    public function __construct() {
        // Assuming you have a database connection in a config file
        include_once 'config.php';
        $this->db = $db;
    }

    public function insertSubscription($user_id, $subscription_plan, $start_date, $end_date) {
        // SQL query to insert the subscription into the database
        $query = "INSERT INTO subscriptions (user_id, subscription_plan, start_date, end_date) 
                  VALUES (:user_id, :subscription_plan, :start_date, :end_date)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':subscription_plan', $subscription_plan);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);

        return $stmt->execute();
    }
}
?>
