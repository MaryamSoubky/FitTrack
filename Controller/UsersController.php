<?php

require_once '../config.php';

// Fetch all user types
function getUserTypes($db) {
    $query = "SELECT * FROM User_Types";
    return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

// Add a new user type
function addUserType($db, $userTypeName) {
    $query = "INSERT INTO User_Types (user_type_name) VALUES (:user_type_name)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_type_name', $userTypeName);
    return $stmt->execute();
}