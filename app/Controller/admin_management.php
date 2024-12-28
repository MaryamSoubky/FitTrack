<?php
include_once 'config.php';

// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../View/index.php");
    exit();
}

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
} else {
    $userId = $_SESSION['user_id'];

    // Check if the user_id exists in the Admins table
    $stmt = $conn->prepare("SELECT COUNT(*) FROM Admins WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($adminCount);
    $stmt->fetch();
    $stmt->close();

    // If user_id does not exist in Admins table, redirect to home.php
    if ($adminCount == 0) {
        echo "<script>
            alert('Unauthorized access. You are not an admin.');
            window.location.href = '../Views/home.php';
        </script>";
        exit();
    }
}

// Fetch the logged-in user's access level
$user_id = $_SESSION['user_id'] ?? null;
if ($user_id) {
    $stmt = $conn->prepare("SELECT a.access_level FROM Admins a WHERE a.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_access_level = $result->fetch_assoc()['access_level'] ?? null;
    $stmt->close();
} else {
    // Redirect to login if user is not logged in
    header("Location: login.php");
    exit;
}

// Handle admin addition
if (isset($_POST['addAdmin'])) {
    $user_id = trim($_POST['user_id']);
    $access_level = trim($_POST['access_level']);

    $stmt = $conn->prepare("INSERT INTO Admins (user_id, access_level) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $access_level);
    if ($stmt->execute()) {
        echo "<script>alert('Admin added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding admin: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Handle admin editing
if (isset($_POST['editAdmin']) && $user_access_level === 'super_admin') {
    $admin_id = $_POST['adminId'];
    $new_access_level = trim($_POST['newAccessLevel']);

    $stmt = $conn->prepare("UPDATE Admins SET access_level = ? WHERE admin_id = ?");
    $stmt->bind_param("si", $new_access_level, $admin_id);
    if ($stmt->execute()) {
        echo "<script>alert('Admin access level updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating admin: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Handle admin deletion
if (isset($_POST['deleteAdmin']) && $user_access_level === 'super_admin') {
    $admin_id = $_POST['adminId'];

    $stmt = $conn->prepare("DELETE FROM Admins WHERE admin_id = ?");
    $stmt->bind_param("i", $admin_id);
    if ($stmt->execute()) {
        echo "<script>alert('Admin deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting admin: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Fetch admins for selection
$adminsResult = $conn->query("SELECT admin_id, u.username, u.email, a.access_level, a.created_at 
                              FROM Admins a JOIN Users u ON a.user_id = u.user_id");
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
            height: 100%;
            padding: 20px;
            text-align: center;
        }

        .text {
            font-size: 2.5em;
            font-weight: 700;
            color: #03045E;
            margin-bottom: 30px;
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
        }

        form {
            display: flex;
            flex-direction: column;
        }

        select, input, button {
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }

        select:focus, input:focus {
            outline: none;
            border-color: #03045E;
        }

        button {
            background-color: #03045E;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #023E8A;
            transform: scale(1.02);
        }

        .btn-custom {
            padding: 12px 25px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #023E8A;
        }

        .back-button button {
            background-color: #0096C7;
        }

        .back-button button:hover {
            background-color: #0077B6;
        }

        .alert {
            margin-top: 15px;
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            font-weight: bold;
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
        <?php if ($user_access_level === 'super_admin'): ?>
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
            <form action="admin.php" method="get">
                <button type="submit" class="btn-custom">Back to Admin Dashboard</button>
            </form>
        </div>
    </section>
</body>
</html>
