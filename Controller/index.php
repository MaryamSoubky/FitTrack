<?php 
// Include the database connection from config.php
include_once 'config.php';  // Adjust path if necessary

session_start();

// Initialize error messages
$signUpErrors = [];
$signInErrors = [];
$successMessage = "";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sign Up Validation
    if (isset($_POST['signUp'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirmPassword']);

        // Validation checks
        if (empty($name)) {
            $signUpErrors[] = "Name is required.";
        } elseif (!preg_match('/^[a-zA-Z ]+$/', $name)) {
            $signUpErrors[] = "Name can only contain letters and spaces.";
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

            // Prepare and bind SQL statement
            $stmt = $conn->prepare("INSERT INTO Users (username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $passwordHash);

            if ($stmt->execute()) {
                // Redirect to home.php after successful registration
                header('Location: ../Views/home.php');
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
            $stmt = $conn->prepare("SELECT user_id, username, password_hash FROM Users WHERE email = ?");
            $stmt->bind_param("s", $signInEmail);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Bind result variables
                $stmt->bind_result($userId, $userName, $hashedPassword);
                $stmt->fetch();

                // Verify password
                if (password_verify($signInPassword, $hashedPassword)) {
                    // Store user info in session
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['user_name'] = $userName;

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Double Slider Sign in/up Form</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="stylesheet" href="../Public/css/style_index.css">
    <style>
        .error-messages {
            color: red;
            margin-bottom: 15px;
        }

        .success-message {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="" method="POST">
                <h1>Create Account</h1>
                <?php if (!empty($signUpErrors)): ?>
                <div class="error-messages">
                    <script>
                        alert("<?php echo implode('\\n', array_map('addslashes', $signUpErrors)); ?>");
                    </script>
                </div>
                <?php endif; ?>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" name="name" placeholder="Name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" />
                <input type="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                <input type="password" name="password" placeholder="Password" />
                <input type="password" name="confirmPassword" placeholder="Confirm Password" />
                <button type="submit" name="signUp">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="" method="POST">
                <h1>Sign in</h1>
                <?php if (!empty($signInErrors)): ?>
                <div class="error-messages">
                    <script>
                        alert("<?php echo implode('\\n', array_map('addslashes', $signInErrors)); ?>");
                    </script>
                </div>
                <?php endif; ?>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your account</span>
                <input type="email" name="signInEmail" placeholder="Email" />
                <input type="password" name="signInPassword" placeholder="Password" />
                <a href="#">Forgot your password?</a>
                <button type="submit" name="signIn">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start your journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../Public/js/script_index.js"></script>
</body>
</html>
