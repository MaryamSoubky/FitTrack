<?php
class Subscription_Model {
    private $db;

    public function __construct() {
        include_once '../Controller/config.php'; // Assuming you have your DB connection here
        $this->db = $db;
    }

    public function addSubscription($user_id, $subscription_plan, $start_date, $end_date) {
        $query = "INSERT INTO subscriptions (user_id, subscription_plan, start_date, end_date)
                  VALUES (:user_id, :subscription_plan, :start_date, :end_date)";
        $stmt = $this->db->prepare($query);

        // Bind parameters to the query
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':subscription_plan', $subscription_plan);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);

        // Execute the query
        if ($stmt->execute()) {
            echo "Subscription added successfully!";
        } else {
            echo "Failed to add subscription.";
        }
    }
}
?>
