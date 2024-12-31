<?php
// AdminController.php
include_once '../Models/designpattern.php';

class AdminController {
    private $adminModel;
    private $userId;
    private $userAccessLevel;

    public function __construct($conn, $userId) {
        $this->adminModel = new AdminModel($conn);
        $this->userId = $userId;
        $this->userAccessLevel = $this->adminModel->getAccessLevel($userId);
    }

   
    public function addAdmin($user_id, $access_level) {
        $this->adminModel->addAdmin($user_id, $access_level);
    }

    public function updateAdmin($admin_id, $new_access_level) {
        $this->adminModel->updateAdmin($admin_id, $new_access_level);
    }

    public function deleteAdmin($admin_id) {
        $this->adminModel->deleteAdmin($admin_id);
    }

    public function getAdmins() {
        return $this->adminModel->fetchAdmins();
    }

    public function getUserAccessLevel() {
        return $this->userAccessLevel;
    }
}
?>
