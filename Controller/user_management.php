<?php 
include_once 'config.php';
include_once '../Models/userclass.php';

session_start();

// Handle user addition
if (isset($_POST['addUser'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $role_id = trim($_POST['role_id']);
    $user_type_id = trim($_POST['user_type_id']);
 
    if ($password === $confirmPassword) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO Users (username, email, password_hash, role_id, user_type_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $name, $email, $passwordHash, $role_id, $user_type_id);
        if ($stmt->execute()) {
            echo "<script>alert('User added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding user: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Passwords do not match!');</script>";
    }
}

// Handle user editing
if (isset($_POST['editUser'])) {
    $userId = $_POST['userId'];
    $editName = trim($_POST['editName']);
    $editEmail = trim($_POST['editEmail']);
    $role_id = trim($_POST['editRoleId']);
    $user_type_id = trim($_POST['editUserTypeId']);

    $stmt = $conn->prepare("UPDATE Users SET username = ?, email = ?, role_id = ?, user_type_id = ? WHERE user_id = ?");
    $stmt->bind_param("ssiii", $editName, $editEmail, $role_id, $user_type_id, $userId);
    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating user: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Handle user deletion
if (isset($_POST['deleteUser'])) {
    $userId = $_POST['userId'];

    $stmt = $conn->prepare("DELETE FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Fetch users from database for display
$usersResult = $conn->query("SELECT user_id, username, email, role_id, user_type_id FROM Users");

// Fetch roles and user types for dropdowns
$rolesResult = $conn->query("SELECT role_id, role_name FROM Roles");
$userTypesResult = $conn->query("SELECT user_type_id, user_type_name FROM User_Types");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="../Views/css/style_admin.css">
</head>
<body>
    <section class="home">
        <div class="text">User Management</div>

        <h3>Add User</h3>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirmPassword" placeholder="Confirm Password" required>

            <!-- Role Selection -->
            <select name="role_id" required>
                <option value="">Select Role</option>
                <?php while ($role = $rolesResult->fetch_assoc()): ?>
                    <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_name']; ?></option>
                <?php endwhile; ?>
            </select>

            <!-- User Type Selection -->
            <select name="user_type_id" required>
                <option value="">Select User Type</option>
                <?php while ($userType = $userTypesResult->fetch_assoc()): ?>
                    <option value="<?php echo $userType['user_type_id']; ?>"><?php echo $userType['user_type_name']; ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit" name="addUser">Add User</button>
        </form>

        <h3>Edit or Delete User</h3>
        <form method="POST" action="">
            <select name="userId" required>
                <option value="">Select User</option>
                <?php while ($row = $usersResult->fetch_assoc()): ?>
                    <option value="<?php echo $row['user_id']; ?>"><?php echo $row['username']; ?> (<?php echo $row['email']; ?>)</option>
                <?php endwhile; ?>
            </select>
            <input type="text" name="editName" placeholder="New Name">
            <input type="email" name="editEmail" placeholder="New Email">

            <!-- Edit Role Selection -->
            <select name="editRoleId">
                <option value="">Select New Role</option>
                <?php
                $rolesResult->data_seek(0); // Reset roles result pointer
                while ($role = $rolesResult->fetch_assoc()): ?>
                    <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_name']; ?></option>
                <?php endwhile; ?>
            </select>

            <!-- Edit User Type Selection -->
            <select name="editUserTypeId">
                <option value="">Select New User Type</option>
                <?php
                $userTypesResult->data_seek(0); // Reset user types result pointer
                while ($userType = $userTypesResult->fetch_assoc()): ?>
                    <option value="<?php echo $userType['user_type_id']; ?>"><?php echo $userType['user_type_name']; ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit" name="editUser">Edit User</button>
            <button type="submit" name="deleteUser">Delete User</button>
        </form>

        <!-- Back Button -->
        <form action="admin.php" method="get">
            <button type="submit">Back to Admin Dashboard</button>
        </form>
    </section>
</body>
</html>
