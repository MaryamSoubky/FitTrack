<?php
session_start();
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

        h1, h2 {
            color: #2c3e50;
            text-align: center;
        }

        /* Navbar Styling */
        nav.container-fluid {
            background-color: #2980b9;
            padding: 1rem;
            border-bottom: 2px solid #3498db;
        }

        nav.container-fluid ul li strong {
            color: #fff;
            font-size: 1.5rem;
        }

        nav ul a {
            color: #fff;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav ul a:hover {
            color: #cce7f3;
        }

        /* Form and Goals Sections */
        .goal-form, .current-goals {
            margin: 30px auto;
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-top: 15px;
            font-weight: bold;
            color: #34495e;
        }

        input[type="number"], input[type="date"], select {
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

        /* Footer Styling */
        footer.container {
            margin-top: 40px;
            padding: 1.5rem;
            text-align: center;
            background-color: #2980b9;
            color: white;
            border-top: 2px solid #3498db;
        }

        footer a {
            color: #cce7f3;
            text-decoration: none;
        }

        footer a:hover {
            color: #eaf7ff;
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
        </section>

        <!-- Display Success/Failure Message -->
        <?php if (isset($_SESSION['goal_message'])): ?>
            <div class="alert">
                <?php echo $_SESSION['goal_message']; ?>
            </div>
            <?php unset($_SESSION['goal_message']); ?>
        <?php endif; ?>

        <!-- Current Goals and Progress Tracker -->
        <section class="current-goals" id="current-goals">
            <h2>Your Current Goals</h2>
            <div id="goalList"></div>
        </section>
    </main>

    <!-- Footer Section with Contact -->
    <footer class="container" id="contact">
        <small><a href="#">Privacy Policy</a> • <a href="#">Contact Us</a></small>
    </footer>
</body>

</html>