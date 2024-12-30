<?php

use PHPUnit\Framework\TestCase;

class WorkoutSuccessTest extends TestCase
{
    private $dbMock;
    private $workoutController;

    protected function setUp(): void
    {
        // Mock the database connection
        $this->dbMock = $this->createMock(PDO::class);

        // Inject the mock into the WorkoutController
        $this->workoutController = new WorkoutController($this->dbMock);
    }

    public function testLogWorkoutSuccess()
    {
        // Mock the database query and execution
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())->method('execute')->willReturn(true);

        $this->dbMock->method('prepare')->willReturn($stmtMock);

        // Example workout data
        $workoutData = [
            'userId' => 1,
            'exercise' => 'Push-ups',
            'duration' => 30,
            'caloriesBurned' => 100,
        ];

        $result = $this->workoutController->logWorkout($workoutData);

        $this->assertTrue($result, 'Expected workout to be logged successfully');
    }

    public function testLogWorkoutFailure()
    {
        // Mock the database query and simulate failure
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())->method('execute')->willReturn(false);

        $this->dbMock->method('prepare')->willReturn($stmtMock);

        // Example workout data
        $workoutData = [
            'userId' => 1,
            'exercise' => 'Push-ups',
            'duration' => 30,
            'caloriesBurned' => 100,
        ];

        $result = $this->workoutController->logWorkout($workoutData);

        $this->assertFalse($result, 'Expected workout logging to fail');
    }
}
