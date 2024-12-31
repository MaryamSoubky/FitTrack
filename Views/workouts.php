<?php
session_start();
require_once '../Models/WorkoutManager.php';
$db = Database::getInstance();
$conn = $db->getConnection();
$workoutManager = new WorkoutManager_Model($conn); // Pass the $conn variable to the model
$userId = $_SESSION['user_id']; // Assumes the user is logged in and their ID is stored in the session.
$recentWorkout = $workoutManager->getRecentWorkout($userId); // Fetch the most recent workout.

$message = '';
$isEditing = false; // Flag to check if we are editing a workout.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exercise = $_POST['exercise'];
    $duration = $_POST['duration'];
    $intensity = $_POST['intensity'];
    $frequency = $_POST['frequency'];
    $notes = $_POST['notes'];

    if (isset($_POST['workout_id'])) {
        // Update an existing workout
        $workoutId = $_POST['workout_id'];
        if ($workoutManager->updateWorkout($workoutId, $userId, $_POST)) {
            $message = "Workout updated successfully.";
        } else {
            $message = "Error updating workout.";
        }
    } else {
        // Log a new workout
        if ($workoutManager->addWorkout($userId, $exercise, $duration, $intensity, $frequency, $notes)) {
            $message = "Workout logged successfully.";
        } else {
            $message = "Error logging workout.";
        }
    }

    // Refresh the data
    $recentWorkout = $workoutManager->getRecentWorkout($userId);
} elseif (isset($_GET['delete_workout'])) {
    // Delete a workout
    $workoutId = $_GET['delete_workout'];
    if ($workoutManager->deleteWorkout($workoutId)) {
        $message = "Workout deleted successfully.";
    } else {
        $message = "Error deleting workout.";
    }
} elseif (isset($_GET['edit_workout'])) {
    $isEditing = true; // Set editing flag to true
    $workoutId = $_GET['edit_workout'];
    $recentWorkout = $workoutManager->getWorkoutById($workoutId); // Fetch workout by ID for editing
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Tracker</title>
    <link rel="stylesheet" href="../Public/css/style_workout.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .workout-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            height: 100px;
        }

        button {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .success {
            color: green;
            font-size: 14px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
        }

        .card hgroup {
            text-align: center;
            margin-bottom: 20px;
        }

        .card h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .card h3 {
            font-size: 18px;
            color: #777;
        }

        .card p {
            font-size: 16px;
            margin: 10px 0;
            color: #555;
        }

        .card p strong {
            color: #333;
        }

        .card .buttons {
            text-align: center;
            margin-top: 20px;
        }

        .card .buttons .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #5cb85c;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            margin: 5px;
            transition: background-color 0.3s ease;
        }

        .card .buttons .button:hover {
            background-color: #4cae4c;
        }

        .card .buttons .button-danger {
            background-color: #d9534f;
        }

        .card .buttons .button-danger:hover {
            background-color: #c9302c;
        }

        @media (max-width: 600px) {
            .card {
                width: 90%;
                padding: 15px;
            }

            .card h2 {
                font-size: 20px;
            }

            .card h3 {
                font-size: 16px;
            }

            .card p {
                font-size: 14px;
            }

            .card .buttons .button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<?php include 'Partials/navbar.php'; ?> <!-- Navbar goes here -->
<main class="container">
    <?php if ($message): ?>
        <div class="alert">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <section class="workout-grid">
        <!-- Recent Workout Card -->
        <?php if ($recentWorkout): ?>
            <section class="card">
                <hgroup>
                    <h2>Your Most Recent Workout</h2>
                    <h3>Details of your latest workout</h3>
                </hgroup>
                <p><strong>Exercise Type:</strong> <?php echo htmlspecialchars($recentWorkout['exercise_type']); ?></p>
                <p><strong>Duration:</strong> <?php echo htmlspecialchars($recentWorkout['duration']); ?> minutes</p>
                <p><strong>Intensity:</strong> <?php echo htmlspecialchars($recentWorkout['intensity']); ?></p>
                <p><strong>Frequency:</strong> <?php echo htmlspecialchars($recentWorkout['frequency']); ?> times per week</p>
                <p><strong>Notes:</strong> <?php echo nl2br(htmlspecialchars($recentWorkout['notes'])); ?></p>
                <p><strong>Logged Date:</strong> <?php echo htmlspecialchars($recentWorkout['log_date']); ?></p>

                <div class="buttons">
                    <a href="?edit_workout=<?php echo $recentWorkout['workout_id']; ?>" class="button">Edit Workout</a>
                    <a href="?delete_workout=<?php echo $recentWorkout['workout_id']; ?>" class="button button-danger" onclick="return confirm('Are you sure you want to delete this workout?')">Delete Workout</a>
                </div>
            </section>
        <?php else: ?>
            <section class="card">
                <hgroup>
                    <h2>No Workouts Logged Yet</h2>
                    <h3>Start tracking your performance now!</h3>
                </hgroup>
            </section>
        <?php endif; ?>

        <!-- Edit Workout Form -->
        <?php if ($isEditing): ?>
            <section class="card">
                <hgroup>
                    <h2>Edit Your Workout</h2>
                    <h3>Modify your workout details</h3>
                </hgroup>
                <form action="workouts.php" method="POST">
                    <input type="hidden" name="workout_id" value="<?php echo htmlspecialchars($recentWorkout['workout_id']); ?>">

                    <label for="exercise">Exercise Type:</label>
                    <input type="text" id="exercise" name="exercise" 
                           value="<?php echo htmlspecialchars($recentWorkout['exercise_type']); ?>" 
                           placeholder="e.g., Running" required>

                    <label for="duration">Duration (minutes):</label>
                    <input type="number" id="duration" name="duration" 
                           value="<?php echo htmlspecialchars($recentWorkout['duration']); ?>" 
                           placeholder="e.g., 60" required>

                    <label for="intensity">Intensity (1-10):</label>
                    <input type="number" id="intensity" name="intensity" 
                           value="<?php echo htmlspecialchars($recentWorkout['intensity']); ?>" 
                           min="1" max="10" required>

                    <label for="frequency">Frequency (per week):</label>
                    <input type="number" id="frequency" name="frequency" 
                           value="<?php echo htmlspecialchars($recentWorkout['frequency']); ?>" 
                           required>

                    <label for="notes">Additional Notes:</label>
                    <textarea id="notes" name="notes"><?php echo htmlspecialchars($recentWorkout['notes']); ?></textarea>

                    <button type="submit">Update Workout</button>
                </form>
            </section>
        <?php else: ?>
            <!-- Form for logging a new workout (hidden if editing) -->
            <section class="card hidden" id="workoutForm">
                <hgroup>
                    <h2>Log Your Workout</h2>
                    <h3>Start tracking your performance</h3>
                </hgroup>
                <form action="workouts.php" method="POST">
                    <label for="exercise">Exercise Type:</label>
                    <input type="text" id="exercise" name="exercise" placeholder="e.g., Running" required>

                    <label for="duration">Duration (minutes):</label>
                    <input type="number" id="duration" name="duration" placeholder="e.g., 60" required>

                    <label for="intensity">Intensity (1-10):</label>
                    <input type="number" id="intensity" name="intensity" min="1" max="10" required>

                    <label for="frequency">Frequency (per week):</label>
                    <input type="number" id="frequency" name="frequency" required>

                    <label for="notes">Additional Notes:</label>
                    <textarea id="notes" name="notes"></textarea>

                    <button type="submit">Log Workout</button>
                </form>
            </section>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
