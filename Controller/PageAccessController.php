<?php
// Include the database connection from config.php
include_once 'config.php'; // Adjust path if necessary

// Get the Singleton instance and the connection
$db = Database::getInstance();
$conn = $db->getConnection();  // Ensure you're using the active connection


// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to check the subscription status
// Function to check the subscription status
function checkSubscriptionStatus() {
    global $conn;  // Ensure the global $conn variable is used

    // Check if the connection is still open
    if (!$conn->ping()) {
        return 'Database connection is closed';  // Connection is closed
    }

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Prepare SQL query to check subscription plan for the logged-in user
        $stmt = $conn->prepare("SELECT * FROM subscriptions WHERE user_id = ? ORDER BY end_date DESC LIMIT 1");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();

        // Fetch the result and check subscription status
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Process the most recent subscription
            $row = $result->fetch_assoc();

            // Check the subscription plan
            if (isset($row['subscription_plan'])) {
                return $row['subscription_plan'];  // Return the subscription plan
            } else {
                return 'Subscription plan not found';  // Handle case where subscription_plan is missing
            }
        } else {
            return 'No active subscription found';  // Default response if no subscription is found
        }
    } else {
        return 'User not logged in';  // If no user is logged in, return appropriate message
    }
}

// Call checkSubscriptionStatus when needed (e.g., before showing page content)
$subscriptionPlan = checkSubscriptionStatus();
echo $subscriptionPlan;  // Output the subscription plan
?>
