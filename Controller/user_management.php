<?php
include_once 'config.php';
session_start();

// Handle user addition
if (isset($_POST['addUser'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $age = trim($_POST['age']);

    if ($password === $confirmPassword) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash, age) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $email, $passwordHash, $age);
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
    $editAge = trim($_POST['editAge']);

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, age = ? WHERE id = ?");
    $stmt->bind_param("ssii", $editName, $editEmail, $editAge, $userId);
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

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Fetch users from database for display
$usersResult = $conn->query("SELECT id, name, email, age FROM users");
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
            <input type="number" name="age" placeholder="Age" required>
            <button type="submit" name="addUser">Add User</button>
        </form>

        <h3>Edit or Delete User</h3>
        <form method="POST" action="">
            <select name="userId" required>
                <option value="">Select User</option>
                <?php while ($row = $usersResult->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> (<?php echo $row['email']; ?>)</option>
                <?php endwhile; ?>
            </select>
            <input type="text" name="editName" placeholder="New Name">
            <input type="email" name="editEmail" placeholder="New Email">
            <input type="number" name="editAge" placeholder="New Age">
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
