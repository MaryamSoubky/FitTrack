<?php
class Profile_Model {
    private $user_id;
    private $username;
    private $email;
    private $password_hash;
    private $last_login;
    private $is_active;

    // Constructor
    public function __construct($user_id, $username, $email, $password_hash, $last_login = null, $is_active = 1) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->last_login = $last_login;
        $this->is_active = $is_active;
    }

    // Get profile by user ID
    public static function getProfileByUserId($user_id, $db) {
        $stmt = $db->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            echo "No user found with user_id: " . htmlspecialchars($user_id); // Debugging output
            return null;
        }
    }

    // Update profile
    public function updateProfile($db) {
        $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, password_hash = ?, last_login = CURRENT_TIMESTAMP, is_active = ? WHERE user_id = ?");
        $stmt->bind_param("sssii", $this->username, $this->email, $this->password_hash, $this->is_active, $this->user_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
