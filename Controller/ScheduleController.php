<?php
class ScheduleController {
    private $db;

    // Constructor with dependency injection (database connection)
    public function __construct($db) {
        $this->db = $db;
    }

    // Function to fetch the current schedule
    public function getSchedule() {
        $query = "SELECT * FROM schedule"; // Assuming your table is named 'schedule'
        $result = $this->db->query($query);

        $scheduleData = [];
        while ($row = $result->fetch_assoc()) {
            $scheduleData[] = $row;
        }

        return $scheduleData;
    }

    // Function to update the schedule
    public function updateSchedule($data) {
        foreach ($data as $id => $schedule) {
            $query = "UPDATE schedule SET 
                      mon = ?, tue = ?, wed = ?, thu = ?, fri = ?, sat = ? 
                      WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssssssi", 
                $schedule['mon'], $schedule['tue'], $schedule['wed'], 
                $schedule['thu'], $schedule['fri'], $schedule['sat'], $id);
            
            $stmt->execute();
        }
    }
}
?>
