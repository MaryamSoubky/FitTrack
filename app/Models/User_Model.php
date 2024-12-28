<?php
include '../Controller/config.php';

class User_Model {
    private $user_id;
    private $username;
    private $email;
    private $password_hash;
    private $registration_date;
    private $last_login;
    private $is_active;
    private $role_id;
    private $user_type_id;

    public function __construct($username, $email, $password_hash, $role_id, $user_type_id) {
        $this->username = $username;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->registration_date = date("Y-m-d H:i:s");
        $this->is_active = true;
        $this->role_id = $role_id;
        $this->user_type_id = $user_type_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function isActive() {
        return $this->is_active;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setIsActive($is_active) {
        $this->is_active = $is_active;
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password_hash);
    }

    public function updateLastLogin() {
        $this->last_login = date("Y-m-d H:i:s");
    }

    public static function getUserById($user_id, $db) {
        $query = "SELECT * FROM Users WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            $user = new self(
                $user_data['username'],
                $user_data['email'],
                $user_data['password_hash'],
                $user_data['role_id'],
                $user_data['user_type_id']
            );
            $user->user_id = $user_data['user_id'];
            $user->registration_date = $user_data['registration_date'];
            $user->last_login = $user_data['last_login'];
            $user->is_active = $user_data['is_active'];
            return $user;
        }
        return null;
    }

    public function save($db) {
        if (isset($this->user_id)) {
            $query = "UPDATE Users SET username = :username, email = :email, password_hash = :password_hash, role_id = :role_id, user_type_id = :user_type_id, is_active = :is_active WHERE user_id = :user_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":user_id", $this->user_id);
        } else {
            $query = "INSERT INTO Users (username, email, password_hash, role_id, user_type_id, is_active) VALUES (:username, :email, :password_hash, :role_id, :user_type_id, :is_active)";
            $stmt = $db->prepare($query);
        }
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password_hash", $this->password_hash);
        $stmt->bindParam(":role_id", $this->role_id);
        $stmt->bindParam(":user_type_id", $this->user_type_id);
        $stmt->bindParam(":is_active", $this->is_active, PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    public static function deleteUserById($user_id, $db) {
        $query = "DELETE FROM Users WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        return $stmt->execute();
    }
}
?>
