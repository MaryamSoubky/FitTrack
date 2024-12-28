<?php

class Reports_Model
{
    private $db;

    /**
     * Constructor to initialize the database connection.
     *
     * @param mysqli $db The database connection instance.
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Fetch total users from the Users table.
     *
     * @return int The total number of users.
     */
    public function getTotalUsers()
    {
        $query = "SELECT COUNT(*) FROM Users";
        $result = $this->db->query($query);
        return $result->fetch_row()[0];
    }

    /**
     * Fetch active goals count from the Goals table.
     *
     * @return int The count of active goals.
     */
    public function getActiveGoals()
    {
        $query = "SELECT COUNT(*) FROM Goals WHERE status = 'active'";
        $result = $this->db->query($query);
        return $result->fetch_row()[0];
    }

    /**
     * Fetch workout logs for today.
     *
     * @param string $today The current date in "Y-m-d" format.
     * @return int The count of workout logs for today.
     */
    public function getWorkoutsToday($today)
    {
        $query = "SELECT COUNT(*) FROM Workout_Log WHERE DATE(log_date) = '$today'";
        $result = $this->db->query($query);
        $data = $result->fetch_row();
        return $data[0];
    }

    /**
     * Fetch recent user activities (workout logs).
     *
     * @return mysqli_result The result set of recent activities.
     */
    public function getRecentActivities()
    {
        $query = "SELECT u.username, w.exercise_type, w.duration, w.log_date
                  FROM Workout_Log w
                  JOIN Users u ON w.user_id = u.user_id
                  ORDER BY w.log_date DESC
                  LIMIT 5";
        return $this->db->query($query);
    }

    /**
     * Fetch active goal details.
     *
     * @return array An array of active goal details.
     */
    public function getGoalDetails()
    {
        $query = "SELECT goal_type, target_value, start_date, end_date 
                  FROM goals WHERE status = 'active'";
        $result = $this->db->query($query);

        $goalDetails = [];
        while ($row = $result->fetch_assoc()) {
            $goalDetails[] = [
                'goal_type' => $row['goal_type'],
                'target_value' => $row['target_value'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
            ];
        }

        return $goalDetails;
    }
}
?>
