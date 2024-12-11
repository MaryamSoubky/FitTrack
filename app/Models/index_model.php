<?php
// Include the config.php to use the $conn database connection
include_once '../Config/config.php';  // Make sure the path is correct

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
        $stmt = $conn->prepare("INSERT INTO Users (username, email, password_hash) VALUES (?, ?, ?)");
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

                // Check if the user is an admin
                $adminCheckStmt = $conn->prepare("SELECT admin_id FROM Admins WHERE user_id = ?");
                $adminCheckStmt->bind_param("i", $userId);
                $adminCheckStmt->execute();
                $adminCheckStmt->store_result();

                // Redirect based on admin status
                if ($adminCheckStmt->num_rows > 0) {
                    header('Location: ../Controller/admin.php');
                } else {
                    header('Location: ../Views/home.php');
                }
                exit();
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
?>
