<?php
include '../Controller/config.php';

class UserProfile_Model {
    private $profile_id;
    private $user_id;
    private $full_name;
    private $date_of_birth;
    private $weight;
    private $height;
    private $gender;

    public function __construct($user_id, $full_name, $date_of_birth, $weight, $height, $gender) {
        $this->user_id = $user_id;
        $this->full_name = $full_name;
        $this->date_of_birth = $date_of_birth;
        $this->weight = $weight;
        $this->height = $height;
        $this->gender = $gender;
    }

    public function getProfileId() {
        return $this->profile_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getFullName() {
        return $this->full_name;
    }

    public function getDateOfBirth() {
        return $this->date_of_birth;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getGender() {
        return $this->gender;
    }

    public static function getProfileByUserId($user_id, $db) {
        $query = "SELECT * FROM User_Profiles WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $profile_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($profile_data) {
            $profile = new self(
                $profile_data['user_id'],
                $profile_data['full_name'],
                $profile_data['date_of_birth'],
                $profile_data['weight'],
                $profile_data['height'],
                $profile_data['gender']
            );
            $profile->profile_id = $profile_data['profile_id'];
            return $profile;
        }
        return null;
    }

    public function save($db) {
        if (isset($this->profile_id)) {
            $query = "UPDATE User_Profiles SET full_name = :full_name, date_of_birth = :date_of_birth, weight = :weight, height = :height, gender = :gender WHERE profile_id = :profile_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":profile_id", $this->profile_id);
        } else {
            $query = "INSERT INTO User_Profiles (user_id, full_name, date_of_birth, weight, height, gender) VALUES (:user_id, :full_name, :date_of_birth, :weight, :height, :gender)";
            $stmt = $db->prepare($query);
        }
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":date_of_birth", $this->date_of_birth);
        $stmt->bindParam(":weight", $this->weight);
        $stmt->bindParam(":height", $this->height);
        $stmt->bindParam(":gender", $this->gender);
        return $stmt->execute();
    }

    public static function deleteProfileByUserId($user_id, $db) {
        $query = "DELETE FROM User_Profiles WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        return $stmt->execute();
    }
}
?>
