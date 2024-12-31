<?php
include_once '../Controller/user_management.php';
include_once '../Controller/config.php';
$db = Database::getInstance();
$conn = $db->getConnection();
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Instantiate the controller
$userManagementController = new UserManagementController($conn);

// Handle adding a user
if (isset($_POST['addUser'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password_hash = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $user_type_id = $_POST['user_type_id'];
   
    
    $userManagementController->add($username, $email, $password_hash, $user_type_id);
    echo "<script>alert('User added successfully!');</script>";
}

// Handle editing a user
if (isset($_POST['editUser'])) {
    $user_id = $_POST['user_id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password_hash = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $role_id = $_POST['role_id'];
    $user_type_id = $_POST['user_type_id'];
    $membership_status = $_POST['membership_status'];
    
    $userManagementController->edit($user_id, $username, $email, $password_hash, $role_id, $user_type_id, $membership_status);
    echo "<script>alert('User edited successfully!');</script>";
}

// Handle deleting a user
if (isset($_POST['deleteUser'])) {
    $user_id = $_POST['user_id'];
    $userManagementController->delete($user_id);
    echo "<script>alert('User deleted successfully!');</script>";
}

// Fetch all users for display
$users = $userManagementController->getAll();
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
        <div class="text">
            <h1>User Management</h1>
        </div>

        <!-- Add User Section -->
        <div class="form-container">
            <h3>Add User</h3>
            <form method="POST" action="">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="user_type_id" required>
                    <option value="">Select User Type</option>
                    <option value="1">Customer</option>
                    <option value="2">Guest</option>
                </select>
            
               
                <button type="submit" name="addUser">Add User</button>
            </form>
        </div>

        <!-- Edit/Delete User Section -->
        <div class="form-container">
            <h3>Edit or Delete User</h3>
            <form method="POST" action="">
                <select name="user_id" required>
                    <option value="">Select User</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['user_id']; ?>">
                            <?php echo $user['username']; ?> (<?php echo $user['email']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="username" placeholder="New Username" >
                <input type="email" name="email" placeholder="New Email">
                <input type="password" name="password" placeholder="New Password" >
                <select name="user_type_id" >
                    <option value="">Select New User Type</option>
                    <option value="1">Customer</option>
                    <option value="2">Guest</option>
                </select>
               
                <button type="submit" name="editUser">Edit User</button>
                <button type="submit" name="deleteUser">Delete User</button>
            </form>
        </div>

        <!-- Back Button -->
        <div class="back-button">
            <form action="../Controller/admin.php" method="get">
                <button type="submit">Back to Dashboard</button>
            </form>
        </div>
    </section>
</body>
</html>
