<?php
// Start the session
session_start();

// Include the config.php to use the $conn database connection
include_once '../Controller/config.php'; // Ensure the path is correct
$db = Database::getInstance();
$conn = $db->getConnection();
// Check if user is logged in and has an active membership
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Debugging: Verify userId and check if session is set
    echo "User ID: $userId<br>";

    // Check the membership status of the user
    $stmt = $conn->prepare("SELECT membership_status FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($membershipStatus);
    $stmt->fetch();
    $stmt->close();

    // Debugging: Verify fetched membership status
    echo "Membership Status: $membershipStatus<br>";

    // If the membership is not active (e.g., 'inactive'), redirect to home page with a message
    if ($membershipStatus === 'inactive') {
        echo "<script>
            alert('You are not a member. Please subscribe to unlock features. You will now be redirected to the subscription page.');
            window.location.href = 'home.php';
        </script>";
        exit();
    }
} else {
    // If user is not logged in, redirect to home page with a message
    echo "<script>
        alert('You are not logged in. Please log in to access this page.');
        window.location.href = 'home.php';
    </script>";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
     <head>
          <title>Schedules</title>
          <link rel="icon" type="image/x-icon" href="../Public/images/icon.png">
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=Edge">
          <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
          <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
          <link rel="stylesheet" href="../Public/css/font-awesome.min.css">
          <link rel="stylesheet" href="../Public/css/aos.css">
          <link rel="stylesheet" href="../Public/css/main.css">
          <link rel="stylesheet" href="../Public/css/styles.css">

          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
          
     </head>
     <body>
     <?php include 'Partials/navbar.php';?>
     <main class="container">
        <div class="grid">
            <!-- Performance Analytics Section with Chart.js -->
            <section id="analytics">
                <hgroup>
                    <h2>Performance Analytics</h2>
                    <h3>Track your progress with interactive charts</h3>
                </hgroup>
                <p>Visualize your workout data, monitor improvements in strength, stamina, and goal achievements.</p>
                <figure>
                    <canvas id="performanceChart"></canvas> <!-- Chart.js canvas -->
                    <figcaption>Weekly Performance Overview</figcaption>
                </figure>
                <h3>Workout Progress</h3>
                <p>Check your weekly and monthly workout performance, calories burned, and goals achieved.</p>
            </section>

            <!-- Reminders Section -->
            <section id="reminders">
                <hgroup>
                    <h2>Reminders & Notifications</h2>
                    <h3>Stay consistent with fitness goals</h3>
                </hgroup>
                <p>Set reminders for your next workout and fitness goals.</p>
                <form id="reminderForm">
                    <label for="reminderText">Reminder</label>
                    <input type="text" id="reminderText" placeholder="Enter reminder..." required>
                    <label for="reminderDate">Date & Time</label>
                    <input type="datetime-local" id="reminderDate" required>
                    <button type="submit" class="btn-reminder">Set Reminder</button>
                </form>
                <ul id="reminderList" class="reminder-list">
                    <!-- Reminder list items will be populated dynamically -->
                </ul>
            </section>

            <!-- Social Sharing Section -->
            <section id="social">
                <hgroup>
                    <h2>Social Sharing</h2>
                    <h3>Share your progress with friends</h3>
                </hgroup>
                <p>Motivate your friends by sharing your fitness achievements on social media.</p>
                <button class="btn-share">Share Progress</button>
                <p id="shareFallback" style="display: none;">Sharing is not supported on this device. You can copy the link manually or use the following social links:</p>
                <ul id="socialLinks" style="display: none;">
                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=YOUR_URL" target="_blank">Share on Facebook</a></li>
                    <li><a href="https://twitter.com/intent/tweet?url=YOUR_URL&text=Check%20out%20my%20fitness%20progress!" target="_blank">Share on Twitter</a></li>
                </ul>
            </section>
        </div>
    </main>


</body>
    
</html>

    
     
          <?php include 'Partials/footer.php';?>
          <script src="../Public/js/jquery.min.js"></script>
          <script src="../Public/js/bootstrap.min.js"></script>
          
          
          <script src="../Public/js/aos.js"></script>
          <script src="../Public/js/smoothscroll.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js library -->
          <script src="../Public/js/custom.js"></script>
          <script src="../public/js/scripts.js"></script>
     </body>
</html>
