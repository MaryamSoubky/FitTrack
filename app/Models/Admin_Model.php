<?php
include '../config.php';
include_once'../Controller/admin_controller.php';

class Admin_Model {
    private $admin_id;
    private $user_id;
    private $access_level;
    private $created_at;

    public function __construct($user_id, $access_level = 'support') {
        $this->user_id = $user_id;
        $this->access_level = $access_level;
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function getAdminId() {
        return $this->admin_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getAccessLevel() {
        return $this->access_level;
    }

    public function setAccessLevel($access_level) {
        $this->access_level = $access_level;
    }

    public static function getAdminById($admin_id, $db) {
        $query = "SELECT * FROM Admins WHERE admin_id = :admin_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":admin_id", $admin_id);
        $stmt->execute();
        $admin_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin_data) {
            $admin = new self($admin_data['user_id'], $admin_data['access_level']);
            $admin->admin_id = $admin_data['admin_id'];
            $admin->created_at = $admin_data['created_at'];
            return $admin;
        }
        return null;
    }

    public function save($db) {
        if (isset($this->admin_id)) {
            $query = "UPDATE Admins SET user_id = :user_id, access_level = :access_level WHERE admin_id = :admin_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":admin_id", $this->admin_id);
        } else {
            $query = "INSERT INTO Admins (user_id, access_level) VALUES (:user_id, :access_level)";
            $stmt = $db->prepare($query);
        }
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":access_level", $this->access_level);
        return $stmt->execute();
    }

    public static function deleteAdminById($admin_id, $db) {
        $query = "DELETE FROM Admins WHERE admin_id = :admin_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":admin_id", $admin_id);
        return $stmt->execute();
    }
}
?>
