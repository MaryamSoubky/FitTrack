<?php 
// Include the database connection from config.php
include_once 'config.php';  // Adjust path if necessary

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize error messages
$signUpErrors = [];
$signInErrors = [];
$successMessage = "";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sign Up Validation
    if (isset($_POST['signUp'])) {
        $username = isset($_POST['username']) ? trim($_POST['username']) : null; // Use username instead of name
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirmPassword']);

        // Validation checks
        if (empty($username)) {
            $signUpErrors[] = "Username is required.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $signUpErrors[] = "Username can only contain letters, numbers, and underscores.";
        }

        if (empty($email)) {
            $signUpErrors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $signUpErrors[] = "Email must be a valid email address.";
        }

        if (empty($password)) {
            $signUpErrors[] = "Password is required.";
        } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[\W_]/', $password)) {
            $signUpErrors[] = "Password must contain at least one uppercase letter and one special character.";
        }

        if ($password !== $confirmPassword) {
            $signUpErrors[] = "Passwords do not match.";
        }

        // If there are no errors, process the registration
        if (empty($signUpErrors)) {
            // Hash the password
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            // Set default membership status to 'inactive'
            $membershipStatus = 'inactive';

            // Prepare and bind SQL statement
            $stmt = $conn->prepare("INSERT INTO Users (username, email, password_hash, membership_status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $passwordHash, $membershipStatus);

            if ($stmt->execute()) {
                // Redirect to home.php after successful registration
                header('Location: home.php');
                exit();
            } else {
                $signUpErrors[] = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }

    // Sign In Validation
    if (isset($_POST['signIn'])) {
        $signInEmail = trim($_POST['signInEmail']);
        $signInPassword = trim($_POST['signInPassword']);

        if (empty($signInEmail)) {
            $signInErrors[] = "Email is required.";
        }

        if (empty($signInPassword)) {
            $signInErrors[] = "Password is required.";
        }

        // If there are no errors, process the login
        if (empty($signInErrors)) {
            // Prepare and bind SQL statement for user login
            $stmt = $conn->prepare("SELECT user_id, username, password_hash, membership_status FROM Users WHERE email = ?");
            $stmt->bind_param("s", $signInEmail);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Bind result variables
                $stmt->bind_result($userId, $userName, $hashedPassword, $membershipStatus);
                $stmt->fetch();

                // Verify password
                if (password_verify($signInPassword, $hashedPassword)) {
                    // Store user info in session
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['user_name'] = $userName;
                    $_SESSION['membership_status'] = $membershipStatus; // Store membership status in session

                    // Check if the user is an admin by looking up their user_id in the Admins table
                    $adminCheckStmt = $conn->prepare("SELECT admin_id FROM Admins WHERE user_id = ?");
                    $adminCheckStmt->bind_param("i", $userId);
                    $adminCheckStmt->execute();
                    $adminCheckStmt->store_result();

                    if ($adminCheckStmt->num_rows > 0) {
                        // User is an admin, redirect to admin.php
                        header('Location: ../Controller/admin.php');
                    } else {
                        // User is not an admin, redirect to the regular home page
                        header('Location: ../Views/home.php');
                    }
                    exit(); // Make sure to exit after redirect
                } else {
                    $signInErrors[] = "Invalid password.";
                }
            } else {
                $signInErrors[] = "No account found with that email.";
            }

            $stmt->close();
        }
    }
}
