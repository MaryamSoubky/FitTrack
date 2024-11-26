<?php
include '../Controller/config.php';

class PageAccess_Model {
    private $page_id;
    private $permission_id;

    public function __construct($page_id, $permission_id) {
        $this->page_id = $page_id;
        $this->permission_id = $permission_id;
    }

    public function getPageId() {
        return $this->page_id;
    }

    public function getPermissionId() {
        return $this->permission_id;
    }

    public static function getAccessByIds($page_id, $permission_id, $db) {
        $query = "SELECT * FROM Page_Access WHERE page_id = :page_id AND permission_id = :permission_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":page_id", $page_id);
        $stmt->bindParam(":permission_id", $permission_id);
        $stmt->execute();
        $access_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($access_data) {
            return new self($access_data['page_id'], $access_data['permission_id']);
        }
        return null;
    }

    public function save($db) {
        $query = "INSERT INTO Page_Access (page_id, permission_id) VALUES (:page_id, :permission_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":page_id", $this->page_id);
        $stmt->bindParam(":permission_id", $this->permission_id);
        return $stmt->execute();
    }

    public static function deleteAccess($page_id, $permission_id, $db) {
        $query = "DELETE FROM Page_Access WHERE page_id = :page_id AND permission_id = :permission_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":page_id", $page_id);
        $stmt->bindParam(":permission_id", $permission_id);
        return $stmt->execute();
    }
}
?>
