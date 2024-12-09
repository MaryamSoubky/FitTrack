<?php
// index_model.php
include_once '../config.php';

function handleSignUp($data) {
    global $conn;
    $errors = [];
    
    $name = trim($data['name']);
    $email = trim($data['email']);
    $password = trim($data['password']);
    $confirmPassword = trim($data['confirmPassword']);

    if (empty($name) || !preg_match('/^[a-zA-Z ]+$/', $name)) {
        $errors[] = "Name is required and can only contain letters and spaces.";
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
        $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $passwordHash);

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

    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, name, password_hash FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userId, $userName, $hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $userName;

                $adminCheckStmt = $conn->prepare("SELECT admin_id FROM admins WHERE email = ?");
                $adminCheckStmt->bind_param("s", $email);
                $adminCheckStmt->execute();
                $adminCheckStmt->store_result();

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
