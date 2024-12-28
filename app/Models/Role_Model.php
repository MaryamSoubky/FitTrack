<?php
include '../Controller/config.php';

class Role_Model {
    private $role_id;
    private $role_name;

    public function __construct($role_name) {
        $this->role_name = $role_name;
    }

    public function getRoleId() {
        return $this->role_id;
    }

    public function getRoleName() {
        return $this->role_name;
    }

    public function setRoleName($role_name) {
        $this->role_name = $role_name;
    }

    public static function getRoleById($role_id, $db) {
        $query = "SELECT * FROM Roles WHERE role_id = :role_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":role_id", $role_id);
        $stmt->execute();
        $role_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($role_data) {
            $role = new self($role_data['role_name']);
            $role->role_id = $role_data['role_id'];
            return $role;
        }
        return null;
    }

    public function save($db) {
        if (isset($this->role_id)) {
            $query = "UPDATE Roles SET role_name = :role_name WHERE role_id = :role_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":role_id", $this->role_id);
        } else {
            $query = "INSERT INTO Roles (role_name) VALUES (:role_name)";
            $stmt = $db->prepare($query);
        }
        $stmt->bindParam(":role_name", $this->role_name);
        return $stmt->execute();
    }

    public static function deleteRoleById($role_id, $db) {
        $query = "DELETE FROM Roles WHERE role_id = :role_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":role_id", $role_id);
        return $stmt->execute();
    }
}
?>
