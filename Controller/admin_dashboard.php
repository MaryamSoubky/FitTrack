<?php
include_once 'config.php';
include_once '../Models/admindash.php';

session_start();

// Redirect if not logged in as admin
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
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
    <!-- Sidebar Navigation -->
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="photos/download (1).png" alt="logo">
                </span>
                <div class="text logo-text">
                    <span class="name">Admin Panel</span>
                    <span class="profession">Dashboard</span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <ul class="menu-links">
                <li class="nav-link">
                    <a href="admin_management.php">
                        <i class='bx bx-user-circle icon'></i>
                        <span class="text nav-text">Admin Management</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="user_management.php">
                        <i class='bx bx-user-check icon'></i>
                        <span class="text nav-text">User Management</span>
                    </a>
                </li>
            </ul>

            <div class="bottom-content">
                <li class="">
                    <form method="POST" action="">
                        <button type="submit" name="logout">
                            <i class='bx bx-log-out icon'></i>
                            <span class="text nav-text">Logout</span>
                        </button>
                    </form>
                </li>
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
