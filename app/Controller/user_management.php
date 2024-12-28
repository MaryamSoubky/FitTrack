<?php
include_once 'config.php';

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

// Handle user addition
if (isset($_POST['addUser'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $role_id = trim($_POST['role_id']);

    if ($password === $confirmPassword) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO Users (username, email, password_hash, role_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $email, $passwordHash, $role_id);
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

    $stmt = $conn->prepare("UPDATE Users SET username = ?, email = ?, role_id = ? WHERE user_id = ?");
    $stmt->bind_param("ssii", $editName, $editEmail, $role_id, $userId);
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

// Fetch users, roles, and pages
$usersResult = $conn->query("SELECT user_id, username, email FROM Users WHERE user_id NOT IN (SELECT user_id FROM Admins)");
$rolesResult = $conn->query("SELECT role_id, role_name FROM Roles");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Public/css/aos.css">
    <link rel="stylesheet" href="../Public/css/main.css">
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
        <div class="text">User Management</div>

        <!-- Add User Section -->
        <div class="form-container">
            <h3>Add User</h3>
            <form method="POST" action="">
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
                <select name="role_id" required>
                    <option value="">Select Role</option>
                    <?php while ($role = $rolesResult->fetch_assoc()): ?>
                        <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_name']; ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" name="addUser" class="btn-custom">Add User</button>
            </form>
        </div>

        <!-- Edit/Delete User Section -->
        <div class="form-container">
            <h3>Edit or Delete User</h3>
            <form method="POST" action="">
                <select name="userId" required>
                    <option value="">Select User</option>
                    <?php while ($row = $usersResult->fetch_assoc()): ?>
                        <option value="<?php echo $row['user_id']; ?>">
                            <?php echo htmlspecialchars($row['username']); ?> (<?php echo htmlspecialchars($row['email']); ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
                <input type="text" name="editName" placeholder="New Name">
                <input type="email" name="editEmail" placeholder="New Email">
                <select name="editRoleId">
                    <option value="">Select New Role</option>
                    <?php $rolesResult->data_seek(0); ?>
                    <?php while ($role = $rolesResult->fetch_assoc()): ?>
                        <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_name']; ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" name="editUser" class="btn-custom">Edit User</button>
                <button type="submit" name="deleteUser" class="btn-custom">Delete User</button>
            </form>
        </div>

        <!-- Back Button -->
        <form action="admin.php" method="get">
            <button type="submit" class="btn-custom">Back to Admin Dashboard</button>
        </form>
    </section>
</body>
</html>
