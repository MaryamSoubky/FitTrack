<?php
require_once '../Models/ProfileModel.php';
require_once 'config.php';

class Profile_Controller {
    // Get profile by user ID
    public function getProfile($user_id) {
        global $conn; // Use global $conn from config.php
        $profile = Profile_Model::getProfileByUserId($user_id, $conn);

        if ($profile) {
            return $profile;
        } else {
            echo "Profile not found for user_id: " . htmlspecialchars($user_id); // Debugging output
            return null;
        }
    }

    // Update profile details
    public function updateProfile($user_id, $username, $email, $password_hash, $is_active = 1) {
        global $conn; // Use global $conn from config.php

        $profile = new Profile_Model($user_id, $username, $email, $password_hash, null, $is_active);

        if ($profile->updateProfile($conn)) {
            return "Profile updated successfully!";
        }
        return "Failed to update profile.";
    }
}
?>
