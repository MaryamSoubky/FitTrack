<?php
include '../config.php';

class Permission_Model {
    private $permission_id;
    private $permission_name;
    private $description;

    public function __construct($permission_name, $description) {
        $this->permission_name = $permission_name;
        $this->description = $description;
    }

    public function getPermissionId() {
        return $this->permission_id;
    }

    public function getPermissionName() {
        return $this->permission_name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setPermissionName($permission_name) {
        $this->permission_name = $permission_name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public static function getPermissionById($permission_id, $db) {
        $query = "SELECT * FROM Permissions WHERE permission_id = :permission_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":permission_id", $permission_id);
        $stmt->execute();
        $permission_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($permission_data) {
            $permission = new self($permission_data['permission_name'], $permission_data['description']);
            $permission->permission_id = $permission_data['permission_id'];
            return $permission;
        }
        return null;
    }

    public function save($db) {
        if (isset($this->permission_id)) {
            $query = "UPDATE Permissions SET permission_name = :permission_name, description = :description WHERE permission_id = :permission_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":permission_id", $this->permission_id);
        } else {
            $query = "INSERT INTO Permissions (permission_name, description) VALUES (:permission_name, :description)";
            $stmt = $db->prepare($query);
        }
        $stmt->bindParam(":permission_name", $this->permission_name);
        $stmt->bindParam(":description", $this->description);
        return $stmt->execute();
    }

    public static function deletePermissionById($permission_id, $db) {
        $query = "DELETE FROM Permissions WHERE permission_id = :permission_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":permission_id", $permission_id);
        return $stmt->execute();
    }
}
?>
