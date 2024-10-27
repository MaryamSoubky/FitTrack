<?php include '../Controller/goal_controller.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Goal Setting</title>
    <link rel="stylesheet" href="../Public/css/style_goals.css">
</head>
<body>
    <h1>Set Your Fitness Goals</h1>

    <?php if (isset($_GET['goal_created'])): ?>
        <p style="color: green;">Goal created successfully!</p>
    <?php endif; ?>

    <form method="POST" action="goal_view.php">
        <label for="goal_type">Goal Type:</label>
        <input type="text" id="goal_type" name="goal_type" required><br>

        <label for="target_value">Target Value:</label>
        <input type="number" id="target_value" name="target_value" required><br>

        <label for="goal_start_date">Start Date:</label>
        <input type="date" id="goal_start_date" name="goal_start_date" required><br>

        <label for="goal_end_date">End Date:</label>
        <input type="date" id="goal_end_date" name="goal_end_date" required><br>

        <button type="submit">Set Goal</button>
    </form>

    <h2>Your Goals</h2>
    <?php if (!empty($goals)): ?>
        <ul>
            <?php foreach ($goals as $goal): ?>
                <li>
                    <strong><?php echo htmlspecialchars($goal['goal_type']); ?></strong>: 
                    Target: <?php echo htmlspecialchars($goal['target_value']); ?>, 
                    Current: <?php echo htmlspecialchars($goal['current_value']); ?>, 
                    Status: <?php echo htmlspecialchars($goal['status']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No goals set yet.</p>
    <?php endif; ?>
</body>
</html>
