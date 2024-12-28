<?php
include_once 'config.php';
include_once '../Models/admindash.php';

session_start();

// Redirect if not logged in as admin
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Initialize variables
$totalUsers = $activeGoals = $workoutsToday = 0;
$admin_id = $_SESSION['user_id'];

// Fetch total users count
$totalUsersQuery = "SELECT COUNT(*) FROM users";
$totalUsersResult = $conn->query($totalUsersQuery);
if ($totalUsersResult) {
    $totalUsers = $totalUsersResult->fetch_row()[0]; // Get the first column of the first row
} else {
    die("Error fetching total users: " . $conn->error);
}

// Fetch admin statistics
$statsQuery = "SELECT active_goals, workout_logs_today FROM Admin_Dashboard_Stats WHERE admin_id = ?";
$stmt = $conn->prepare($statsQuery);
$stmt->bind_param("i", $admin_id);

if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

$stmt->bind_result($activeGoals, $workoutsToday);
if (!$stmt->fetch()) {
    die("Error fetching results: " . $stmt->error);
}
$stmt->close();

// Fetch recent user activities
$recentActivitiesQuery = "SELECT u.username, w.exercise_type, w.duration, w.log_date 
                          FROM Workout_Log w 
                          JOIN Users u ON w.user_id = u.id 
                          ORDER BY w.log_date DESC 
                          LIMIT 5";
$recentActivitiesResult = $conn->query($recentActivitiesQuery);
if (!$recentActivitiesResult) {
    die("Error fetching recent activities: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../Public/css/style_admin.css">
    <style>
        /* Basic Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
        }
        .container {
            padding: 20px;
        }
        
        /* Dashboard Stats Styling */
        .dashboard-stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            justify-content: space-between;
        }

        .stat-card {
            background: #fff;
            padding: 20px;
            flex: 1;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            font-size: 1.2em;
            color: #333;
        }

        .stat-card p {
            font-size: 2em;
            color: #1f2937;
            margin-top: 10px;
        }

        /* Recent Activities Table Styling */
        .recent-activities {
            margin-top: 40px;
        }

        .recent-activities h2 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table thead {
            background-color: #1f2937;
            color: #fff;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        table tbody tr:hover {
            background-color: #f1f5f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to Admin Dashboard</h2>
        <p>View key metrics and recent user activity below.</p>

        <!-- Dashboard Statistics -->
        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?php echo htmlspecialchars($totalUsers); ?></p>
            </div>
            <div class="stat-card">
                <h3>Active Goals</h3>
                <p><?php echo htmlspecialchars($activeGoals); ?></p>
            </div>
            <div class="stat-card">
                <h3>Workouts Today</h3>
                <p><?php echo htmlspecialchars($workoutsToday); ?></p>
            </div>
        </div>

        <!-- Recent User Activities -->
        <div class="recent-activities">
            <h2>Recent User Activities</h2>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Exercise Type</th>
                        <th>Duration (min)</th>
                        <th>Log Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($activity = $recentActivitiesResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($activity['username']); ?></td>
                        <td><?php echo htmlspecialchars($activity['exercise_type']); ?></td>
                        <td><?php echo htmlspecialchars($activity['duration']); ?></td>
                        <td><?php echo htmlspecialchars($activity['log_date']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
