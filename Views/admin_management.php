<?php
include_once 'config.php';
session_start();

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
if (isset($_POST['editAdmin'])) {
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
if (isset($_POST['deleteAdmin'])) {
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
    <link rel="stylesheet" href="../Public/css/style_admin_management.css">

    <title>Admin Management</title>
    <style>
        .section-header { font-size: 1.5em; margin-bottom: 10px; }
        form { margin-bottom: 20px; }
        select, input, button { padding: 10px; margin-top: 5px; width: 100%; }
    </style>
</head>
<body>
    <section class="home">
        <div class="text">Admin Management</div>

        <h3 class="section-header">Add Admin</h3>
        <form method="POST" action="">
            <!-- Select user to assign admin role -->
            <select name="user_id" required>
                <option value="">Select User</option>
                <?php 
                // Fetch all users to assign as admin
                $usersResult = $conn->query("SELECT user_id, username FROM Users");
                while ($user = $usersResult->fetch_assoc()): ?>
                    <option value="<?php echo $user['user_id']; ?>"><?php echo $user['username']; ?></option>
                <?php endwhile; ?>
            </select>
            <!-- Set access level -->
            <select name="access_level" required>
                <option value="">Select Access Level</option>
                <option value="super_admin">Super Admin</option>
                <option value="moderator">Moderator</option>
                <option value="support">Support</option>
            </select>
            <button type="submit" name="addAdmin">Add Admin</button>
        </form>

        <h3 class="section-header">Edit or Delete Admin</h3>
        <form method="POST" action="">
            <!-- Select admin to edit or delete -->
            <select name="adminId" required>
                <option value="">Select Admin</option>
                <?php while ($admin = $adminsResult->fetch_assoc()): ?>
                    <option value="<?php echo $admin['admin_id']; ?>">
                        <?php echo $admin['username']; ?> (<?php echo $admin['access_level']; ?>)
                    </option>
                <?php endwhile; ?>
            </select>

            <!-- Set new access level -->
            <select name="newAccessLevel">
                <option value="">Select New Access Level</option>
                <option value="super_admin">Super Admin</option>
                <option value="moderator">Moderator</option>
                <option value="support">Support</option>
            </select>

            <button type="submit" name="editAdmin">Edit Admin</button>
            <button type="submit" name="deleteAdmin">Delete Admin</button>
        </form>

        <!-- Back Button -->
        <form action="admin.php" method="get">
            <button type="submit">Back to Admin Dashboard</button>
        </form>
    </section>
</body>
</html>