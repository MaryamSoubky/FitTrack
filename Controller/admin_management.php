<?php
include_once 'config.php';
session_start();

// Handle admin addition
if (isset($_POST['addAdmin'])) {
    $username = trim($_POST['adminUsername']);
    $email = trim($_POST['adminEmail']);
    $password = trim($_POST['adminPassword']);
    $confirmPassword = trim($_POST['adminConfirmPassword']);

    // Check if username or email already exists
    $checkStmt = $conn->prepare("SELECT * FROM admins WHERE username = ? OR email = ?");
    $checkStmt->bind_param("ss", $username, $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Username or email already exists! Please choose a different one.');</script>";
    } elseif ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // If everything is okay, add the new admin
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO admins (username, email, password_hash, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $username, $email, $passwordHash);
        
        if ($stmt->execute()) {
            echo "<script>alert('Admin added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding admin: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
    $checkStmt->close();
}

// Handle admin editing
if (isset($_POST['editAdmin'])) {
    $adminId = $_POST['adminId'];
    $editUsername = trim($_POST['editAdminUsername']);
    $editEmail = trim($_POST['editAdminEmail']);

    $stmt = $conn->prepare("UPDATE admins SET username = ?, email = ? WHERE admin_id = ?");
    $stmt->bind_param("ssi", $editUsername, $editEmail, $adminId);
    
    if ($stmt->execute()) {
        echo "<script>alert('Admin updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating admin: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Handle admin deletion
if (isset($_POST['deleteAdmin'])) {
    $adminId = $_POST['adminId'];

    $stmt = $conn->prepare("DELETE FROM admins WHERE admin_id = ?");
    $stmt->bind_param("i", $adminId);
    
    if ($stmt->execute()) {
        echo "<script>alert('Admin deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting admin: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Fetch admins from database for display
$adminsResult = $conn->query("SELECT admin_id, username, email FROM admins");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Management</title>
    <link rel="stylesheet" href="./style_admin.css">
</head>
<body>
    <section class="home">
        <div class="text">Admin Management</div>

        <h3>Add Admin</h3>
        <form method="POST" action="">
            <input type="text" name="adminUsername" placeholder="Admin Username" required>
            <input type="email" name="adminEmail" placeholder="Admin Email" required>
            <input type="password" name="adminPassword" placeholder="Password" required>
            <input type="password" name="adminConfirmPassword" placeholder="Confirm Password" required>
            <button type="submit" name="addAdmin">Add Admin</button>
        </form>

        <h3>Edit or Delete Admin</h3>
        <form method="POST" action="">
            <select name="adminId" required>
                <option value="">Select Admin</option>
                <?php while ($row = $adminsResult->fetch_assoc()): ?>
                    <option value="<?php echo $row['admin_id']; ?>"><?php echo $row['username']; ?> (<?php echo $row['email']; ?>)</option>
                <?php endwhile; ?>
            </select>
            <input type="text" name="editAdminUsername" placeholder="New Username">
            <input type="email" name="editAdminEmail" placeholder="New Email">
            <button type="submit" name="editAdmin">Edit Admin</button>
            <button type="submit" name="deleteAdmin">Delete Admin</button>
        </form>

        <!-- Back Button to return to admin.php -->
        <form action="admin.php" method="get">
            <button type="submit">Back to Admin Dashboard</button>
        </form>
    </section>
</body>
</html>
