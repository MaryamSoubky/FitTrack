<?php
// current_goals_view.php

session_start();
include_once '../Controller/config.php';  // Include the database connection
include_once '../Models/Goals_Model.php'; // Include the model

// Fetch the current goals for the logged-in user
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Query to get current goals for the user
    $query = "SELECT * FROM goals WHERE user_id = ? AND status = 'active'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $_SESSION['goal_message'] = "Please log in to view your goals.";
    header('Location: ../Views/goal_view.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Current Goals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <style>
        .goal-card {
            border: 1px solid #ddd;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .goal-card:hover {
            transform: scale(1.02);
        }

        .goal-card h3 {
            color: #2980b9;
        }

        .goal-card p {
            font-size: 0.9rem;
            color: #444;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <!-- Navbar Section -->
    <?php include 'Partials/navbar.php'; ?>

    <main class="container">
        <section class="current-goals">
            <h2>Your Current Goals</h2>

            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="goal-card">
                <h3><?php echo ucfirst($row['goal_type']); ?> Goal</h3>
                <p>Target: <?php echo $row['target_value']; ?> (Current: <?php echo $row['current_value']; ?>)</p>
                <p>Start Date: <?php echo $row['start_date']; ?> | End Date: <?php echo $row['end_date']; ?></p>
                <p>Status: <?php echo ucfirst($row['status']); ?></p>
            </div>
            <?php endwhile; ?>

        </section>
    </main>

    <!-- Footer Section with Contact -->
    <footer class="container" id="contact">
        <small><a href="#">Privacy Policy</a> • <a href="#">Contact Us</a></small>
    </footer>
</body>

</html>
