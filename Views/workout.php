<?php
// Ensure this path is correct
include '../Controller/workout_controller.php'; // Adjust path as necessary
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log Workout</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Public/css/aos.css">
    <link rel="stylesheet" href="../Public/css/main.css">
    <link rel="stylesheet" href="../Public/css/style_workout.css">

</head>
<body>
    <?php include 'Partials/navbar.php';?>
    <h1>Log Your Workout</h1>

    <?php if (isset($_GET['logged']) && $_GET['logged'] == 'true'): ?>
        <p style="color:green;">Workout logged successfully!</p>
    <?php endif; ?>

    <form method="POST" action="workout.php">
        <label for="exercise_type">Exercise Type:</label>
        <input type="text" id="exercise_type" name="exercise_type" required><br>

        <label for="duration">Duration (in minutes):</label>
        <input type="number" id="duration" name="duration" required><br>

        <label for="intensity">Intensity:</label>
        <select id="intensity" name="intensity">
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select><br>

        <label for="frequency">Frequency (times per week):</label>
        <input type="number" id="frequency" name="frequency" required><br>

        <button type="submit">Log Workout</button>
    </form>

    <h2>Your Progress</h2>
    <p>Total Workouts: <?php echo isset($progress['total_workouts']) ? $progress['total_workouts'] : 0; ?></p>
    <p>Total Duration: <?php echo isset($progress['total_duration']) ? $progress['total_duration'] : 0; ?> minutes</p>
    <?php include 'Partials/footer.php';?>
</body>
</html>
