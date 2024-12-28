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

    // Redirect to subscription page if membership is inactive
    if ($membershipStatus === 'inactive') {
        echo "<script>
            alert('You are not a member. Please subscribe to unlock features. Redirecting to the subscription page.');
            window.location.href = 'home.php';
        </script>";
        exit();
    }

    // Check if the user has any workout history
    $stmt = $conn->prepare("
        SELECT workout_id, exercise_type, duration, intensity, frequency, log_date, notes 
        FROM workout_log 
        WHERE user_id = ? 
        ORDER BY log_date DESC 
        LIMIT 1
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $workout = $result->fetch_assoc(); // Fetch the most recent workout if it exists
    $stmt->close();
} else {
    // Redirect to home page if not logged in
    echo "<script>
        alert('You are not logged in. Please log in to access this page.');
        window.location.href = 'home.php';
    </script>";
    exit();
}

// Handle the deletion of a workout if the delete button is clicked
if (isset($_GET['delete_workout'])) {
    $workoutId = $_GET['delete_workout'];

    $stmt = $conn->prepare("DELETE FROM workout_log WHERE workout_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $workoutId, $userId);
    $stmt->execute();
    $stmt->close();

    // Set session message for workout deletion
    $_SESSION['message'] = "Workout deleted successfully!";
    header("Location: workouts.php");
    exit();
}

// Handle the editing of a workout (if the user clicks on edit)
if (isset($_GET['edit_workout'])) {
    $workoutId = $_GET['edit_workout'];

    // Fetch the workout data to populate the form
    $stmt = $conn->prepare("SELECT * FROM workout_log WHERE workout_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $workoutId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $workout = $result->fetch_assoc();
    $stmt->close();
}

// Handle the form submission for updating the workout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_workout'])) {
    $workoutId = $_POST['workout_id'];
    $exerciseType = $_POST['exercise'];
    $duration = $_POST['duration'];
    $intensity = $_POST['intensity'];
    $frequency = $_POST['frequency'];
    $notes = $_POST['notes'];

    // Update the workout in the database
    $stmt = $conn->prepare("UPDATE workout_log SET exercise_type = ?, duration = ?, intensity = ?, frequency = ?, notes = ? WHERE workout_id = ? AND user_id = ?");
    $stmt->bind_param("siiiiii", $exerciseType, $duration, $intensity, $frequency, $notes, $workoutId, $userId);
    $stmt->execute();
    $stmt->close();

    // Set session message for workout update
    $_SESSION['message'] = "Workout updated successfully!";
    header("Location: workouts.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Workout Logger</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="../Public/css/style_workout.css">
    <style>
       
       .buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .button {
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        background-color: #03045E;
        color: white;
        border: none;
        transition: background-color 0.3s ease;
    }

    .button-danger {
        background-color: #03045E;
    }

    .button:hover, .button-danger:hover {
        background-color: #03045E;
    }
    </style>
</head>
<body>
    <?php include 'Partials/navbar.php'; ?>

    <main class="container">
        <div class="workout-grid">
            <?php if ($workout): ?>
                <!-- Display the most recent workout -->
                <section class="card">
                    <hgroup>
                        <h2>Your Most Recent Workout</h2>
                        <h3>Details of your latest workout</h3>
                    </hgroup>
                    <p><strong>Exercise Type:</strong> <?= htmlspecialchars($workout['exercise_type']); ?></p>
                    <p><strong>Duration:</strong> <?= htmlspecialchars($workout['duration']); ?> minutes</p>
                    <p><strong>Intensity:</strong> <?= htmlspecialchars($workout['intensity']); ?></p>
                    <p><strong>Frequency:</strong> <?= htmlspecialchars($workout['frequency']); ?> times per week</p>
                    <p><strong>Notes:</strong> <?= nl2br(htmlspecialchars($workout['notes'])); ?></p>
                    <p><strong>Logged Date:</strong> <?= htmlspecialchars($workout['log_date']); ?></p>
                 

                    <!-- Edit and Delete Buttons -->
                    <div class="buttons">
                        <a href="?edit_workout=<?= $workout['workout_id']; ?>" class="button">Edit Workout</a>
                        <a href="?delete_workout=<?= $workout['workout_id']; ?>" class="button button-danger" onclick="return confirm('Are you sure you want to delete this workout?')">Delete Workout</a>
                    </div>
                </section>
            <?php endif; ?>

            <!-- If the user is editing the workout, show the edit form -->
            <?php if (isset($_GET['edit_workout']) && $workout): ?>
                <section class="card">
                    <hgroup>
                        <h2>Edit Workout</h2>
                        <h3>Modify your workout details</h3>
                    </hgroup>
                    <form action="" method="POST">
                        <input type="hidden" name="workout_id" value="<?= $workout['workout_id']; ?>">

                        <label for="exercise">Exercise Type:</label>
                        <input type="text" id="exercise" name="exercise" value="<?= htmlspecialchars($workout['exercise_type']); ?>" required>

                        <label for="duration">Duration (minutes):</label>
                        <input type="number" id="duration" name="duration" value="<?= htmlspecialchars($workout['duration']); ?>" required>

                        <label for="intensity">Intensity (1-10):</label>
                        <input type="number" id="intensity" name="intensity" min="1" max="10" value="<?= htmlspecialchars($workout['intensity']); ?>" required>

                        <label for="frequency">Frequency (per week):</label>
                        <input type="number" id="frequency" name="frequency" min="1" max="7" value="<?= htmlspecialchars($workout['frequency']); ?>" required>

                        <label for="notes">Additional Notes:</label>
                        <textarea id="notes" name="notes" rows="4" required><?= htmlspecialchars($workout['notes']); ?></textarea>

                        <button type="submit" name="update_workout" class="button-primary">Update Workout</button>
                    </form>
                </section>
            <?php endif; ?>

            <!-- If no workout, show the workout log form -->
            <?php if (!$workout): ?>
                <section class="card">
                    <hgroup>
                        <h2>Log Your Workout</h2>
                        <h3>Start tracking your performance</h3>
                    </hgroup>
                    <form action="../Controller/workout_controller.php" method="POST">
                        <label for="exercise">Exercise Type:</label>
                        <input type="text" id="exercise" name="exercise" placeholder="e.g., Running" required>

                        <label for="duration">Duration (minutes):</label>
                        <input type="number" id="duration" name="duration" placeholder="e.g., 60" required>

                        <label for="intensity">Intensity (1-10):</label>
                        <input type="number" id="intensity" name="intensity" min="1" max="10" required>

                        <label for="frequency">Frequency (per week):</label>
                        <input type="number" id="frequency" name="frequency" min="1" max="7" required>

                        <label for="notes">Additional Notes:</label>
                        <textarea id="notes" name="notes" rows="4" placeholder="How did the workout feel?"></textarea>

                        <button type="submit" class="button-primary">Submit Workout</button>
                    </form>
                </section>
            <?php endif; ?>
        </div>
    </main>

    <!-- Display success message if set in session -->
    <?php if (isset($_SESSION['message'])): ?>
        <script>
            alert("<?= $_SESSION['message']; ?>");
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</body>
</html>
