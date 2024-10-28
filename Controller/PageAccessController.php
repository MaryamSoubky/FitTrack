<?php

 require_once 'config.php';
 require_once '../Models/PageAccess_Model.php';

// Fetch all pages
function getPages($db) {
    $query = "SELECT * FROM Pages";
    return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

// Add a new page
function addPage($db, $pageName, $urlPath) {
    $query = "INSERT INTO Pages (page_name, url_path) VALUES (:page_name, :url_path)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':page_name', $pageName);
    $stmt->bindParam(':url_path', $urlPath);
    return $stmt->execute();
}