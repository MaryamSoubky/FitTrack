<?php
include_once '../Controller/config.php';
include_once '../Controller/admin_management.php';
$db = Database::getInstance();
$conn = $db->getConnection();

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../Views/index.php");
    exit();
}

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Views/index.php");
    exit();
} else {
    $userId = $_SESSION['user_id'];

    // Check if the user_id exists in the Admin table
    $stmt = $conn->prepare("SELECT * FROM Admins WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // If user is not an admin, redirect to the main page
        header("Location: ../Views/index.php");
        exit();
    }

    // Instantiate the controller
    $adminController = new AdminController($conn, $userId);
}

// Handle admin addition
if (isset($_POST['addAdmin'])) {
    $user_id = trim($_POST['user_id']);
    $access_level = trim($_POST['access_level']);
    $adminController->addAdmin($user_id, $access_level);
    echo "<script>alert('Admin added successfully!');</script>";
}

// Handle admin editing
if (isset($_POST['editAdmin']) && $adminController->getUserAccessLevel() === 'super_admin') {
    $admin_id = $_POST['adminId'];
    $new_access_level = trim($_POST['newAccessLevel']);
    $adminController->updateAdmin($admin_id, $new_access_level);
    echo "<script>alert('Admin access level updated successfully!');</script>";
}

// Handle admin deletion
if (isset($_POST['deleteAdmin']) && $adminController->getUserAccessLevel() === 'super_admin') {
    $admin_id = $_POST['adminId'];
    $adminController->deleteAdmin($admin_id);
    echo "<script>alert('Admin deleted successfully!');</script>";
}

// Fetch admins for selection
$adminsResult = $adminController->getAdmins();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Public/css/aos.css">
    <link rel="stylesheet" href="../Public/css/main.css">

    <title>Admin Management</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .home {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }

        .text {
            font-size: 2.5em;
            font-weight: 700;
            color: #03045E;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-container {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            width: 100%;
            max-width: 600px;
        }

        .form-container h3 {
            font-size: 1.8em;
            color: #03045E;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input, select, button {
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #03045E;
        }

        button {
            background-color: #03045E;
            color: #fff;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #023E8A;
            transform: scale(1.02);
        }

        .btn-custom {
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #023E8A;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .text {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <section class="home">
        <div class="text">Admin Management</div>

        <!-- Add Admin Section -->
        <div class="form-container">
            <h3>Add Admin</h3>
            <form method="POST" action="">
                <select name="user_id" required>
                    <option value="">Select User</option>
                    <?php 
                    $usersResult = $conn->query("SELECT user_id, username FROM Users");
                    while ($user = $usersResult->fetch_assoc()): ?>
                        <option value="<?php echo $user['user_id']; ?>"><?php echo $user['username']; ?></option>
                    <?php endwhile; ?>
                </select>
                <select name="access_level" required>
                    <option value="">Select Access Level</option>
                    <option value="super_admin">Super Admin</option>
                    <option value="moderator">Moderator</option>
                    <option value="support">Support</option>
                </select>
                <button type="submit" name="addAdmin" class="btn-custom">Add Admin</button>
            </form>
        </div>

        <!-- Edit/Delete Admin Section (Super Admin Only) -->
        <?php if ($adminController->getUserAccessLevel() === 'super_admin'): ?>
        <div class="form-container">
            <h3>Edit or Delete Admin</h3>
            <form method="POST" action="">
                <select name="adminId" required>
                    <option value="">Select Admin</option>
                    <?php while ($admin = $adminsResult->fetch_assoc()): ?>
                        <option value="<?php echo $admin['admin_id']; ?>">
                            <?php echo $admin['username']; ?> (<?php echo $admin['access_level']; ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
                <select name="newAccessLevel" required>
                    <option value="">Select New Access Level</option>
                    <option value="super_admin">Super Admin</option>
                    <option value="moderator">Moderator</option>
                    <option value="support">Support</option>
                </select>
                <button type="submit" name="editAdmin" class="btn-custom">Edit Admin</button>
                <button type="submit" name="deleteAdmin" class="btn-custom">Delete Admin</button>
            </form>
        </div>
        <?php endif; ?>

        <!-- Back Button -->
        <div class="back-button">
            <form action="../Controller/admin.php" method="get">
                <button type="submit" class="btn-custom">Back to Admin Dashboard</button>
            </form>
        </div>
    </section>
</body>
</html>
