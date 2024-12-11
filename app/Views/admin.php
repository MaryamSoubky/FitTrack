<?php
// Include the database connection
include_once 'config.php';
include_once '../Models/adminclass.php';

// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Initialize variables for dashboard stats
$admin_id = $_SESSION['user_id'];
$totalUsers = $activeGoals = $workoutsToday = 0;

// Fetch total users directly from Users table
$totalUsersQuery = "SELECT COUNT(*) FROM Users";
$result = $conn->query($totalUsersQuery);
$totalUsers = $result->fetch_row()[0];

// Fetch statistics for the admin dashboard from Admin_Dashboard_Stats
$query = "SELECT active_goals, workout_logs_today FROM Admin_Dashboard_Stats WHERE admin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($activeGoals, $workoutsToday);
$stmt->fetch();
$stmt->close();

// Fetch recent user activities (e.g., recent workout logs)
$recentActivitiesQuery = "SELECT u.username, w.exercise_type, w.duration, w.log_date 
                          FROM Workout_Log w 
                          JOIN Users u ON w.user_id = u.user_id 
                          ORDER BY w.log_date DESC 
                          LIMIT 5";
$recentActivitiesResult = $conn->query($recentActivitiesQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Public/css/style_admin.css">
    <title>Admin Dashboard</title>
    <style>
       /* General Body Styling */
       body {
            display: flex;
            background-color: #f4f7fa;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #1f2937;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px;
            height: 100vh;
        }

        .sidebar .image img {
            width: 60px;
            border-radius: 50%;
        }

        .sidebar .menu-links li a {
            display: flex;
            align-items: center;
            color: #cbd5e1;
            padding: 10px 15px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar .menu-links li a:hover {
            background-color: #374151;
            color: #fff;
            border-radius: 5px;
        }

        .sidebar .bottom-content {
            margin-top: auto;
        }

        /* Main Content Styling */
        .home {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .home h2 {
            font-size: 1.8em;
            color: #333;
            margin: 10px 0;
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
    <!-- Sidebar Navigation -->
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                </span>
                <div class="text logo-text">
                    <span class="name">Admin Panel</span>
                    <span class="profession">Dashboard</span>
                </div>
            </div>
        </header>

        <ul class="menu-links">
            <li class="nav-link">
                <a href="./admin_management.php">
                    <span class="text nav-text">Admin Management</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="./user_management.php">
                    <span class="text nav-text">User Management</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="../Views/reports.php">
                    <span class="text nav-text">reports </span>
                </a>
            </li>
        </ul>

        <div class="bottom-content">
            <form method="POST" action="">
                <button type="submit" name="logout" style="width:100%; padding: 10px; background: none; border: none; color: #cbd5e1;">
                    <span class="text nav-text">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <section class="home">
        <h2>Welcome to Admin Dashboard</h2>
        <p>Use the sidebar to manage users and admins.</p>

        <!-- Dashboard Statistics -->
        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="stat-card">
                <h3>Active Goals</h3>
                <p><?php echo $activeGoals; ?></p>
            </div>
            <div class="stat-card">
                <h3>Workouts Today</h3>
                <p><?php echo $workoutsToday; ?></p>
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
    </section>

    <script src="../Public/js/script_admin.js"></script>
</body>
</html>