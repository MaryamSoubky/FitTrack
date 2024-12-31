<?php
require_once '../Controller/profileController.php';

session_start();

// Replace with actual logic to get logged-in user's ID
if (!isset($_SESSION['user_id'])) {
    echo "Access denied. Please log in.";
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID dynamically

if ($user_id == 1) {
    echo "Access denied for this user.";
    exit;
}

$profileController = new Profile_Controller();
$profile = $profileController->getProfile($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $message = $profileController->updateProfile($user_id, $username, $email, $password_hash, $is_active);
    echo "<p>$message</p>";

    // Refresh profile data
    $profile = $profileController->getProfile($user_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="../Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Public/css/main.css" rel="stylesheet">
</head>
<body>

<?php include 'Partials/navbar.php';?>

    <div class="container mt-5">
        <h2>User Profile</h2>
        <?php if ($profile): ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($profile['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($profile['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" <?php echo $profile['is_active'] ? 'checked' : ''; ?>>
                <label for="is_active" class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
        <?php else: ?>
        <p>Profile not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
