<?php

require_once '../Models/WorkoutManager.php';
require_once '../Controller/reports_controller.php';
$db = Database::getInstance();
$conn = $db->getConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Reports</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Public/css/aos.css">
    <link rel="stylesheet" href="../Public/css/main.css">
    <link rel="stylesheet" href="../Public/css/style_reports.css">

</head>
<body>
    <div class="container">
        <h1>Your Reports</h1>

        <!-- Workouts Section -->
        <h2>Workouts</h2>
        <?php if (!empty($workouts)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Exercise Type</th>
                        <th>Duration (minutes)</th>
                        <th>Intensity</th>
                        <th>Frequency</th>
                        <th>Date</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($workouts as $workout) : ?>
                        <tr>
                            <td><?= htmlspecialchars($workout['exercise_type']) ?></td>
                            <td><?= htmlspecialchars($workout['duration']) ?></td>
                            <td><?= htmlspecialchars($workout['intensity']) ?></td>
                            <td><?= htmlspecialchars($workout['frequency']) ?></td>
                            <td><?= htmlspecialchars($workout['log_date']) ?></td>
                            <td><?= htmlspecialchars($workout['notes']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No workouts found.</p>
        <?php endif; ?>

        <!-- Goals Section -->
        <h2>Goals</h2>
        <?php if (!empty($goals)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Goal Type</th>
                        <th>Target Value</th>
                        <th>Current Value</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Calories Burned</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($goals as $goal) : ?>
                        <tr>
                            <td><?= htmlspecialchars($goal['goal_type']) ?></td>
                            <td><?= htmlspecialchars($goal['target_value']) ?></td>
                            <td><?= htmlspecialchars($goal['current_value']) ?></td>
                            <td><?= htmlspecialchars($goal['start_date']) ?></td>
                            <td><?= htmlspecialchars($goal['end_date']) ?></td>
                            <td><?= htmlspecialchars($goal['status']) ?></td>
                            <td><?= htmlspecialchars($goal['calories_burned']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No goals found.</p>
        <?php endif; ?>

    </div>
</body>
</html>
