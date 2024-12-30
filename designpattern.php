<?php
include_once '../Controller/config.php'; // Ensure this path is correct

// UserAdminFactory Class - Factory to create User or Admin objects
class UserAdminFactory {
    public static function create($type) {
        if ($type === 'user') {
            return new User();
        } elseif ($type === 'admin') {
            return new Admin();
        } else {
            throw new Exception("Invalid user type: $type");
        }
    }
}

// Admin_Model Class - Handles admin-related database operations
// AdminModel.php
class AdminModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAccessLevel($user_id) {
        $stmt = $this->conn->prepare("SELECT access_level FROM Admins WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $accessLevel = $result->fetch_assoc()['access_level'] ?? null;
        $stmt->close();
        return $accessLevel;
    }

    public function addAdmin($user_id, $access_level) {
        $stmt = $this->conn->prepare("INSERT INTO Admins (user_id, access_level) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $access_level);
        $stmt->execute();
        $stmt->close();
    }

    public function updateAdmin($admin_id, $new_access_level) {
        $stmt = $this->conn->prepare("UPDATE Admins SET access_level = ? WHERE admin_id = ?");
        $stmt->bind_param("si", $new_access_level, $admin_id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteAdmin($admin_id) {
        $stmt = $this->conn->prepare("DELETE FROM Admins WHERE admin_id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $stmt->close();
    }

    public function fetchAdmins() {
        $stmt = $this->conn->query("SELECT admin_id, u.username, u.email, a.access_level, a.created_at 
                                    FROM Admins a JOIN Users u ON a.user_id = u.user_id");
        return $stmt;
    }
}

// User Class - Handles user-related database operations
class User {
    private $con;

    public function __construct() {
        // Assuming you have a Database class that provides the connection
        $db = Database::getInstance();
        $this->con = $db->getConnection();
    }

    // Add a new user
    // Add a new user
public function add($username, $email, $password_hash, $user_type_id) {
    // Validate inputs to prevent SQL injection and ensure data integrity
    if (!$this->isValidEmail($email)) {
        return $this->generateMessage("Invalid email format.", "error");
    }

    // Prepare the SQL query (including user_type_id)
    $sql = "INSERT INTO users (username, email, password_hash, user_type_id) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $this->con->prepare($sql);
    
    if ($stmt) {
        // Bind the parameters to the prepared statement
        $stmt->bind_param("sssi", $username, $email, $password_hash, $user_type_id);
        
        // Execute the statement
        if ($stmt->execute()) {
            return $this->generateMessage("User added successfully!", "success");
        } else {
            return $this->generateMessage("Error: " . $stmt->error, "error");
        }
    } else {
        return $this->generateMessage("Error preparing statement: " . $this->con->error, "error");
    }
}

    
    // Edit an existing user
    public function edit($user_id, $username, $email, $password_hash, $role_id, $user_type_id, $membership_status) {
        // Validate inputs
        if (!$this->isValidEmail($email)) {
            return $this->generateMessage("Invalid email format.", "error");
        }

        $sql = "UPDATE users SET username = ?, email = ?, password_hash = ?, role_id = ?, user_type_id = ?, membership_status = ? WHERE user_id = ?";
        
        $stmt = $this->con->prepare($sql);
        
        if ($stmt) {
            // Bind the parameters to the prepared statement
            $stmt->bind_param("ssssssi", $username, $email, $password_hash, $role_id, $user_type_id, $membership_status, $user_id);
            
            // Execute the statement
            if ($stmt->execute()) {
                return $this->generateMessage("User updated successfully!", "success");
            } else {
                return $this->generateMessage("Error: " . $stmt->error, "error");
            }
            
            
        } else {
            return $this->generateMessage("Error preparing statement: " . $this->con->error, "error");
        }
    }

    // Delete a user
    public function delete($user_id) {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->con->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            if ($stmt->execute()) {
                return $this->generateMessage("User deleted successfully!", "success");
            } else {
                return $this->generateMessage("Error deleting user: " . $stmt->error, "error");
            }
        } else {
            return $this->generateMessage("Error preparing statement: " . $this->con->error, "error");
        }
       
    }

    // Get all users
    public function getAll() {
        $sql = "SELECT * FROM users"; // Change the condition as needed
        $result = $this->con->query($sql);
        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    // Fetch user by ID
    public function getById($user_id) {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->con->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return $this->generateMessage("Error preparing statement: " . $this->con->error, "error");
        }
    }

    // Generate a message for the operation
    private function generateMessage($message, $type) {
        return "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showPopupMessage('$message', '$type');
                showSection('user');
            });
        </script>";
    }

    // Email validation
    private function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
?>
