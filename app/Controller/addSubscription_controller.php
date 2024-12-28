<?php
include_once '../Model/SubscriptionModel.php'; // Assuming you have a Subscription model for DB interactions

function addSubscription($user_id, $subscription_plan) {
    $subscriptionModel = new SubscriptionModel();
    
    // Get the current date for subscription start date
    $start_date = date('Y-m-d');
    
    // Calculate the end date based on the subscription plan
    switch ($subscription_plan) {
        case '1_month':
            $end_date = date('Y-m-d', strtotime('+1 month', strtotime($start_date)));
            break;
        case '3_months':
            $end_date = date('Y-m-d', strtotime('+3 months', strtotime($start_date)));
            break;
        case '6_months':
            $end_date = date('Y-m-d', strtotime('+6 months', strtotime($start_date)));
            break;
        case '1_year':
            $end_date = date('Y-m-d', strtotime('+1 year', strtotime($start_date)));
            break;
        default:
            return false;
    }

    // Insert subscription into the database
    return $subscriptionModel->insertSubscription($user_id, $subscription_plan, $start_date, $end_date);
}
?>
