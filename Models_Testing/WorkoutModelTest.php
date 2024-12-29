<?php
use PHPUnit\Framework\TestCase;

class WorkoutModelTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // Set up an in-memory SQLite database for testing
        $this->db = new SQLite3(':memory:');

        // Create a mock workout_log table
        $this->db->exec("CREATE TABLE workout_log (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            exercise_type TEXT NOT NULL,
            duration INTEGER NOT NULL,
            intensity INTEGER NOT NULL,
            frequency INTEGER NOT NULL,
            notes TEXT,
            log_date TEXT DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function testAddWorkout()
    {
        // Create an instance of the WorkoutModel with the test database
        $model = new WorkoutModel($this->db);

        // Add a workout
        $result = $model->addWorkout(1, 'Running', 30, 3, 5, 'Morning run');

        // Verify the result
        $this->assertTrue($result, "Workout should be added successfully.");

        // Check the database for the workout
        $stmt = $this->db->query("SELECT * FROM workout_log WHERE user_id = 1");
        $data = $stmt->fetchArray(SQLITE3_ASSOC);

        $this->assertNotEmpty($data, "Workout should exist in the database.");
        $this->assertEquals('Running', $data['exercise_type']);
        $this->assertEquals(30, $data['duration']);
        $this->assertEquals(3, $data['intensity']);
        $this->assertEquals(5, $data['frequency']);
        $this->assertEquals('Morning run', $data['notes']);
    }

    public function testGetWorkouts()
    {
        // Create an instance of the WorkoutModel with the test database
        $model = new WorkoutModel($this->db);

        // Insert some mock data
        $this->db->exec("INSERT INTO workout_log (user_id, exercise_type, duration, intensity, frequency, notes)
                         VALUES (1, 'Swimming', 45, 4, 3, 'Evening swim')");
        $this->db->exec("INSERT INTO workout_log (user_id, exercise_type, duration, intensity, frequency, notes)
                         VALUES (1, 'Cycling', 60, 5, 2, 'Long ride')");

        // Retrieve workouts for user_id = 1
        $workouts = $model->getWorkouts(1);

        // Verify the result
        $this->assertCount(2, $workouts, "User should have 2 workouts.");
        $this->assertEquals('Cycling', $workouts[0]['exercise_type'], "Latest workout should be 'Cycling'.");
        $this->assertEquals('Swimming', $workouts[1]['exercise_type'], "Older workout should be 'Swimming'.");
    }

    public function testGetWorkoutsWithNoData()
    {
        // Create an instance of the WorkoutModel with the test database
        $model = new WorkoutModel($this->db);

        // Retrieve workouts for a user with no data
        $workouts = $model->getWorkouts(2);

        // Verify the result
        $this->assertEmpty($workouts, "No workouts should be returned for a user with no data.");
    }
}
