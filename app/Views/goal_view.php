<?php
// Start the session
session_start();

// Include the config.php to use the $conn database connection
include_once '../Controller/config.php'; // Ensure the path is correct

// Check if user is logged in and has an active membership
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Check the membership status of the user
    $stmt = $conn->prepare("SELECT membership_status FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($membershipStatus);
    $stmt->fetch();
    $stmt->close();

    if ($membershipStatus === 'inactive') {
        echo "<script>
            alert('You are not a member. Please subscribe to unlock features. You will now be redirected to the subscription page.');
            window.location.href = 'home.php';
        </script>";
        exit();
    }
} else {
    echo "<script>
        alert('You are not logged in. Please log in to access this page.');
        window.location.href = 'home.php';
    </script>";
    exit();
}

// Check if the user has an existing goal
$stmt = $conn->prepare("SELECT * FROM Goals WHERE user_id = ? AND status = 'active'");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$existingGoal = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Goal Setting & Tracking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <style>
        /* CSS Styling */
        body {
            font-family: 'Helvetica Neue', sans-serif;
            background-color: #f4f8fb;
            margin: 0;
        }

        h1,
        h2 {
            color: #2c3e50;
            text-align: center;
        }

        /* Form and Goals Sections */
        .goal-form,
        .current-goals {
            margin: 30px auto;
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        }

        .goal-form label,
        .current-goals label {
            margin-top: 15px;
            font-weight: bold;
            color: #34495e;
        }

        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button[type="submit"] {
            padding: 12px 20px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 20px;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #3498db;
        }

        /* Goal Card Styling */
        .goal-card {
            border: 1px solid #ddd;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .goal-card h3 {
            color: #2980b9;
        }

        .goal-card p {
            font-size: 0.9rem;
            color: #444;
            line-height: 1.5;
        }

        /* Buttons for Goal Edit/Delete */
        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .button {
            padding: 10px 20px;
            background-color: #03045E;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button-danger {
            background-color: #e74c3c;
        }

        .button:hover,
        .button-danger:hover {
            background-color: #3498db;
        }
    </style>
</head>

<body>
    <!-- Navbar Section -->
    <?php include 'Partials/navbar.php';?>

    <!-- Main Section -->
    <main class="container">
        <!-- Goal Setting Form -->
        <section class="goal-form" id="goal-form">
            <h2>Define Your Fitness Goal</h2>
            <?php if ($existingGoal): ?>
                <!-- Display Existing Goal -->
                <div class="goal-card">
                    <h3>Your Current Goal: <?= htmlspecialchars($existingGoal['goal_type']); ?></h3>
                    <p>Target Value: <?= htmlspecialchars($existingGoal['target_value']); ?> kg</p>
                    <p>Start Date: <?= htmlspecialchars($existingGoal['start_date']); ?></p>
                    <p>End Date: <?= htmlspecialchars($existingGoal['end_date']); ?></p>
                    <p>Status: <?= htmlspecialchars($existingGoal['status']); ?></p>

                    <!-- Edit and Delete buttons -->
                    <div class="buttons">
                        <a href="?edit_goal=<?= $existingGoal['goal_id']; ?>" class="button">Edit Goal</a>
                        <a href="?delete_goal=<?= $existingGoal['goal_id']; ?>" class="button button-danger" onclick="return confirm('Are you sure you want to delete this goal?')">Delete Goal</a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Display Goal Form if No Existing Goal -->
                <form action="../Controller/goal_controller.php" method="POST">
                    <label for="goalType">Goal Type:</label>
                    <select id="goalType" name="goalType" required>
                        <option value="weight_loss">Weight Loss</option>
                        <option value="strength_gain">Strength Gain</option>
                    </select>

                    <label for="targetValue">Target Value (e.g., 5 kg):</label>
                    <input type="number" id="targetValue" name="targetValue" placeholder="Enter your target" required>

                    <label for="startDate">Start Date:</label>
                    <input type="date" id="startDate" name="startDate" required>

                    <label for="endDate">End Date:</label>
                    <input type="date" id="endDate" name="endDate" required>

                    <button type="submit" class="button-primary">Set Goal</button>
                </form>
            <?php endif; ?>
        </section>

        <!-- Success/Failure Message -->
        <?php if (isset($_SESSION['goal_message'])): ?>
            <div class="alert">
                <?php echo $_SESSION['goal_message']; ?>
            </div>
            <?php unset($_SESSION['goal_message']); ?>
        <?php endif; ?>

    </main>

    <!-- Footer Section -->
    <footer class="container" id="contact">
        <small><a href="#">Privacy Policy</a> • <a href="#">Contact Us</a></small>
    </footer>
</body>

</html>
