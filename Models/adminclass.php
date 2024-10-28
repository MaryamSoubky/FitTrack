<?php
// Include the admin management controller
include_once '../Controller/admin_management.php'; // Add a semicolon here

class AdminManagement {

    public function getAllUsers() {
        global $db; // Access global database connection
        $query = "SELECT u.user_id, u.username, u.email, u.is_active, r.role_name
                  FROM Users u
                  LEFT JOIN Roles r ON u.role_id = r.role_id";
        $statement = $db->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $users;
    }

    public function toggleUserStatus($user_id) {
        global $db;
        $query = "UPDATE Users SET is_active = NOT is_active WHERE user_id = :user_id";
        $statement = $db->prepare($query);
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();
        $statement->closeCursor();
    }

    public function assignRoleToUser($user_id, $role_id) {
        global $db;
        $query = "UPDATE Users SET role_id = :role_id WHERE user_id = :user_id";
        $statement = $db->prepare($query);
        $statement->bindParam(':role_id', $role_id);
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();
        $statement->closeCursor();
    }

    public function getAllRoles() {
        global $db;
        $query = "SELECT role_id, role_name FROM Roles";
        $statement = $db->prepare($query);
        $statement->execute();
        $roles = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $roles;
    }

    public function addPermissionToRole($role_id, $permission_id) {
        global $db;
        $query = "INSERT INTO Role_Permissions (role_id, permission_id) VALUES (:role_id, :permission_id)";
        $statement = $db->prepare($query);
        $statement->bindParam(':role_id', $role_id);
        $statement->bindParam(':permission_id', $permission_id);
        $statement->execute();
        $statement->closeCursor();
    }

    public function getRolePermissions($role_id) {
        global $db;
        $query = "SELECT p.permission_name
                  FROM Permissions p
                  JOIN Role_Permissions rp ON p.permission_id = rp.permission_id
                  WHERE rp.role_id = :role_id";
        $statement = $db->prepare($query);
        $statement->bindParam(':role_id', $role_id);
        $statement->execute();
        $permissions = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $permissions;
    }
}
