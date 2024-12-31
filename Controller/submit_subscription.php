<?php
include_once 'config.php';
$db = Database::getInstance();
$conn = $db->getConnection();

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if the user is logged in (you can modify this according to your app's authentication system)
if (!isset($_SESSION['user_id'])) {
    die('You must be logged in to submit a subscription.');
}

// Include database connection
include_once 'config.php';

// Get form data
$user_id = $_POST['user_id'];
$subscription_plan = $_POST['subscription_plan'];
$start_date = $_POST['start_date'];

// Calculate the end date based on the subscription plan
$end_date = '';
switch ($subscription_plan) {
    case '1_month':
        $end_date = date('Y-m-d', strtotime($start_date . ' + 30 days'));
        break;
    case '3_month':
        $end_date = date('Y-m-d', strtotime($start_date . ' + 90 days'));
        break;
    case '6_month':
        $end_date = date('Y-m-d', strtotime($start_date . ' + 180 days'));
        break;
    case '1_year':
        $end_date = date('Y-m-d', strtotime($start_date . ' + 365 days'));
        break;
    default:
        die('Invalid subscription plan.');
}

// Prepare the query to insert subscription data
$query = "INSERT INTO subscriptions (user_id, subscription_plan, start_date, end_date) 
          VALUES (?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($query);

// Bind the parameters to the prepared statement
$stmt->bind_param("isss", $user_id, $subscription_plan, $start_date, $end_date);

// Execute the query
if ($stmt->execute()) {
    // Subscription added successfully
    // Now update the user's membership_status to active
    $update_query = "UPDATE users SET membership_status = 'active' WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $user_id);

    if ($update_stmt->execute()) {
        // If update is successful, show success message
        echo 'Subscription successfully submitted!';
        
        // Redirect to the appropriate page after success
        header("Location: ../Views/home.php"); // Redirect to home or dashboard after subscription
        exit;
    } else {
        // If membership update fails
        echo 'Error updating membership status: ' . $update_stmt->error;
    }
} else {
    // Error during insertion
    echo 'Error: ' . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
