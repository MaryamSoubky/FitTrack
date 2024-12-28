<?php
session_start();
include '../config.php';  // Include your DB connection file

// Assuming the user is logged in and their ID is stored in the session
$userId = $_SESSION['user_id'] ?? null;
$membershipStatus = 'inactive';  // Default membership status

// Fetch the user's membership status if logged in
if ($userId) {
    $stmt = $conn->prepare("SELECT membership_status FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($membershipStatus);
    $stmt->fetch();
    $stmt->close();
}

// Fetch active menu items based on membership status
$stmt = $conn->prepare("SELECT id, menu_name, link, parent_id FROM menu_items WHERE membership_status = ? AND active = 1 ORDER BY parent_id, id");
$stmt->bind_param("s", $membershipStatus);
$stmt->execute();
$result = $stmt->get_result();

// Build the menu array
$menuItems = [];
while ($row = $result->fetch_assoc()) {
    $menuItems[] = $row;
}
$stmt->close();

// Close the connection
$conn->close();

// Function to generate the dynamic menu with submenus
function generateMenu($menuItems) {
    $menu = [];
    
    foreach ($menuItems as $item) {
        if ($item['parent_id'] === null) {
            // Main menu item
            $menu[$item['id']] = [
                'menu_name' => $item['menu_name'],
                'link' => $item['link'],
                'submenus' => []
            ];
        } else {
            // Submenu item
            $menu[$item['parent_id']]['submenus'][] = [
                'menu_name' => $item['menu_name'],
                'link' => $item['link']
            ];
        }
    }
    
    return $menu;
}

$dynamicMenu = generateMenu($menuItems);

?>