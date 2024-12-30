<?php
include_once '../Models/designpattern.php';

class UserManagementController {
    private $user;

    public function __construct($con) {
        $this->user = new User($con);
    }

    public function add($username, $email, $password_hash, $user_type_id) {
        return $this->user->add($username, $email, $password_hash, $user_type_id);
    }

    public function edit($user_id, $username, $email, $password_hash, $role_id, $user_type_id, $membership_status) {
        return $this->user->edit($user_id, $username, $email, $password_hash, $role_id, $user_type_id, $membership_status);
    }

    public function delete($user_id) {
        return $this->user->delete($user_id);
    }

    public function getAll() {
        return $this->user->getAll();
    }
}
?>
