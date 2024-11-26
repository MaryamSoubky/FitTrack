<?php
include '../Controller/config.php';

class Page_Model {
    private $page_id;
    private $page_name;
    private $url_path;

    public function __construct($page_name, $url_path) {
        $this->page_name = $page_name;
        $this->url_path = $url_path;
    }

    public function getPageId() {
        return $this->page_id;
    }

    public function getPageName() {
        return $this->page_name;
    }

    public function getUrlPath() {
        return $this->url_path;
    }

    public function setPageName($page_name) {
        $this->page_name = $page_name;
    }

    public function setUrlPath($url_path) {
        $this->url_path = $url_path;
    }

    public static function getPageById($page_id, $db) {
        $query = "SELECT * FROM Pages WHERE page_id = :page_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":page_id", $page_id);
        $stmt->execute();
        $page_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($page_data) {
            $page = new self($page_data['page_name'], $page_data['url_path']);
            $page->page_id = $page_data['page_id'];
            return $page;
        }
        return null;
    }

    public function save($db) {
        if (isset($this->page_id)) {
            $query = "UPDATE Pages SET page_name = :page_name, url_path = :url_path WHERE page_id = :page_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":page_id", $this->page_id);
        } else {
            $query = "INSERT INTO Pages (page_name, url_path) VALUES (:page_name, :url_path)";
            $stmt = $db->prepare($query);
        }
        $stmt->bindParam(":page_name", $this->page_name);
        $stmt->bindParam(":url_path", $this->url_path);
        return $stmt->execute();
    }

    public static function deletePageById($page_id, $db) {
        $query = "DELETE FROM Pages WHERE page_id = :page_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":page_id", $page_id);
        return $stmt->execute();
    }
}
?>
