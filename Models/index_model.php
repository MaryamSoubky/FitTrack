<?php
// index_model.php
include_once '../Controller/config.php';

function handleSignUp($data) {
    global $conn;
    $errors = [];
    
    $username = trim($data['username']); // Changed from 'name' to 'username'
    $email = trim($data['email']);
    $password = trim($data['password']);
    $confirmPassword = trim($data['confirmPassword']);

    // Validation for username instead of name
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

    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO Users (username, email, password_hash) VALUES (?, ?, ?)"); // Changed from 'name' to 'username'
        $stmt->bind_param("sss", $username, $email, $passwordHash);

        if (!$stmt->execute()) {
            $errors[] = "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    return $errors;
}

function handleSignIn($data) {
    global $conn;
    $errors = [];
    $email = trim($data['signInEmail']);
    $password = trim($data['signInPassword']);

    // Validate email and password
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Check user credentials if no validation errors
    if (empty($errors)) {
        // Use 'username' in the SELECT query
        $stmt = $conn->prepare("SELECT user_id, username, password_hash FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if user exists
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
