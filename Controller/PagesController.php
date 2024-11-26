<?php

 require_once '../config.php';
 require_once '../Models/';

// Fetch all admins
function getAdmins($db) {
    $query = "SELECT * FROM Admins";
    return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

// Add a new admin
function addAdmin($db, $userId, $accessLevel) {
    $query = "INSERT INTO Admins (user_id, access_level) VALUES (:user_id, :access_level)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':access_level', $accessLevel);
    return $stmt->execute();
}
