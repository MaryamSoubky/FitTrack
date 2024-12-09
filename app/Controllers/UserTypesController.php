<?php

require_once '../config.php';

// Assign permission to a role
function assignPermission($db, $roleId, $permissionId) {
    $query = "INSERT INTO Role_Permissions (role_id, permission_id) VALUES (:role_id, :permission_id)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':role_id', $roleId);
    $stmt->bindParam(':permission_id', $permissionId);
    return $stmt->execute();
}
