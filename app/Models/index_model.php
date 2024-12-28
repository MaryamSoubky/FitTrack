<?php
// Include the config.php to use the $conn database connection
include_once '../Config/config.php';  // Ensure the path is correct

// Handle user sign-up
function handleSignUp($data) {
    global $conn;
    $errors = [];

    // Collect user input
    $username = trim($data['username']);
    $email = trim($data['email']);
    $password = trim($data['password']);
    $confirmPassword = trim($data['confirmPassword']);

    // Validation
    if (empty($username) || !preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors[] = "Username is required and can only contain letters, numbers, and underscores.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }
    if (empty($password) || !preg_match('/[A-Z]/', $password) || !preg_match('/[\W_]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter and one special character.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // If no errors, insert the new user into the database
    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO Users (username, email, password_hash, membership_status) VALUES (?, ?, ?, 'none')");
        $stmt->bind_param("sss", $username, $email, $passwordHash);

        if (!$stmt->execute()) {
            $errors[] = "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    return $errors;
}

// Handle user sign-in
function handleSignIn($data) {
    global $conn;
    $errors = [];
    $email = trim($data['signInEmail']);
    $password = trim($data['signInPassword']);

    // Validate input
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Check user credentials
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT user_id, username, password_hash FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userId, $userName, $hashedPassword);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $userName;

                // Redirect based on role and membership status
                handleUserAccess($userId);
            } else {
                $errors[] = "Invalid password.";
            }
        } else {
            $errors[] = "No account found with that email.";
        }
        $stmt->close();
    }

    return $errors;
}

// Handle user access based on membership status and admin role
function handleUserAccess($userId) {
    global $conn;

    // Fetch admin and membership status
    $stmt = $conn->prepare("
        SELECT 
            (SELECT COUNT(*) FROM Admins WHERE user_id = ?) AS isAdmin,
            (SELECT membership_status FROM Users WHERE user_id = ?) AS membershipStatus
    ");
    $stmt->bind_param("ii", $userId, $userId);
    $stmt->execute();
    $stmt->bind_result($isAdmin, $membershipStatus);
    $stmt->fetch();
    $stmt->close();

    // Set session variables
    $_SESSION['is_admin'] = $isAdmin;
    $_SESSION['membership_status'] = $membershipStatus;

    // Redirect based on user type and membership
    if ($isAdmin && $membershipStatus !== 'none') {
        // Admin and member: Access all pages, but open admin.php first
        header('Location: ../Controller/admin.php');
    } elseif (!$isAdmin && $membershipStatus !== 'none') {
        // Member but not admin: Can access home, workouts, contact, goals
        header('Location: ../Views/home.php');
    } elseif ($isAdmin && $membershipStatus === 'none') {
        // Admin but not member: Access admin pages only
        header('Location: ../Controller/admin.php');
    } else {
        // Neither admin nor member: Can only access home.php
        header('Location: ../Views/home.php');
    }
    exit();
}

// Check if the user is a member
function isUserMember($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT membership_status FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($membershipStatus);
    $stmt->fetch();
    $stmt->close();

    return $membershipStatus; // Returns membership status (e.g., 'none', 'basic', 'premium')
}
?>
