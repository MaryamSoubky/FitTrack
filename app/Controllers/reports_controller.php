<?php
include_once '../config.php';
include_once '../Models/reports_model.php';

class ReportsController {
    private $reportsModel;

    public function __construct($conn) {
        $this->reportsModel = new ReportsModel($conn);
    }

    // Fetch all users' workout and goal data
    public function getAllUsersData() {
        $data = $this->reportsModel->getAllUsersReportData();

        // Debugging: Check the data structure
        // var_dump($data);

        // Return the data as JSON
        echo json_encode($data);
    }
}

// Controller Usage
$controller = new ReportsController($conn);

// Check if "fetch" action is requested
if (isset($_GET['action']) && $_GET['action'] === 'fetchAll') {
    $controller->getAllUsersData();
}
?>
