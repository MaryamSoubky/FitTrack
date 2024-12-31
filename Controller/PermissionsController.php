
<?php
require_once '../config.php';
include_once '../Models/Permission_Model.php';

// Fetch all permissions
function getPermissions($db) {
    $query = "SELECT * FROM Permissions";
    return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

// Add a new permission
function addPermission($db, $permissionName, $description) {
    $query = "INSERT INTO Permissions (permission_name, description) VALUES (:permission_name, :description)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':permission_name', $permissionName);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}