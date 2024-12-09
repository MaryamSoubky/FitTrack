<?php
// Ensure this path is correct
include '../Controller/workout_controller.php'; // Adjust path as necessary
?>





<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Workout Logger</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="../Public/css/style_workout.css"> <!-- Link to Custom Styles -->
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="container-fluid">
        <ul>
            <li><strong>Workout Tracker</strong></li>
        </ul>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Progress</a></li>
            <li><a href="#" role="button">Log Workout</a></li>
        </ul>
    </nav>

    <!-- Main Section -->
    <main class="container">
        <section class="workout-card">
            <hgroup>
                <h2>Log Your Workout</h2>
                <h3>Track your exercise performance efficiently</h3>
            </hgroup>
            <form action="../Controller/workout_controller.php" method="POST">
                <!-- Exercise Type -->
                <label for="exercise">Exercise Type:</label>
                <input type="text" id="exercise" name="exercise" placeholder="e.g., Running, Cycling" required>

                <!-- Duration -->
                <label for="duration">Duration (minutes):</label>
                <input type="number" id="duration" name="duration" placeholder="e.g., 60" min="1" max="300" required>

                <!-- Intensity -->
                <label for="intensity">Intensity (1-10):</label>
                <input type="number" id="intensity" name="intensity" min="1" max="10" required>

                <!-- Frequency -->
                <label for="frequency">Frequency (per week):</label>
                <input type="number" id="frequency" name="frequency" min="1" max="7" required>

                <!-- Notes (Optional) -->
                <label for="notes">Additional Notes:</label>
                <textarea id="notes" name="notes" rows="4" placeholder="How did the workout feel?"></textarea>

                <!-- Submit Button -->
                <button type="submit" class="button-primary">Submit Workout</button>
            </form>
        </section>
    </main>

    <!-- Footer Section -->
    <footer class="container">
        <small><a href="#">Terms of Service</a> • <a href="#">Privacy Policy</a></small>
    </footer>
</body>

</html>
