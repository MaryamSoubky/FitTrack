<?php
// Include the database connection
include_once 'config.php';
session_start();

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
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
    </nav>

    <!-- Main Content -->
    <section class="home">
        <div class="text">Welcome to Admin Dashboard</div>
        <p>Use the sidebar to manage users and admins.</p>
    </section>

    <script src="../Public/js/script_admin.js"></script>
</body>
</html>
