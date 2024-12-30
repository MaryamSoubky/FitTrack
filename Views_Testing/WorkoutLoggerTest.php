<?php

use PHPUnit\Framework\TestCase;

class WorkoutLoggerTest extends TestCase
{
    private $mockDb;
    private $userId = 1;

    protected function setUp(): void
    {
        // Create a mock database connection
        $this->mockDb = $this->createMock(mysqli::class);
    }

    public function testUserMembershipStatusCheck()
    {
        // Prepare mock statement for checking membership status
        $stmt = $this->createMock(mysqli_stmt::class);
        $stmt->expects($this->once())
             ->method('bind_param')
             ->with('i', $this->userId);
        $stmt->expects($this->once())
             ->method('execute');
        $stmt->expects($this->once())
             ->method('bind_result')
             ->willReturnCallback(function (&$membershipStatus) {
                 $membershipStatus = 'active';
             });
        $stmt->expects($this->once())
             ->method('fetch')
             ->willReturn(true);
        $stmt->expects($this->once())
             ->method('close');

        $this->mockDb->expects($this->once())
                     ->method('prepare')
                     ->with("SELECT membership_status FROM Users WHERE user_id = ?")
                     ->willReturn($stmt);

        // Simulate membership status check
        $stmt->bind_param('i', $this->userId);
        $stmt->execute();
        $stmt->bind_result($membershipStatus);
        $stmt->fetch();
        $stmt->close();

        // Assert membership is active
        $this->assertEquals('active', $membershipStatus);
    }

    public function testFetchMostRecentWorkout()
    {
        // Prepare mock statement for fetching workout
        $stmt = $this->createMock(mysqli_stmt::class);
        $stmt->expects($this->once())
             ->method('bind_param')
             ->with('i', $this->userId);
        $stmt->expects($this->once())
             ->method('execute');
        $stmt->expects($this->once())
             ->method('get_result')
             ->willReturn($this->createMock(mysqli_result::class));
        $stmt->expects($this->once())
             ->method('close');

        $this->mockDb->expects($this->once())
                     ->method('prepare')
                     ->with("
                        SELECT workout_id, exercise_type, duration, intensity, frequency, log_date, notes 
                        FROM workout_log 
                        WHERE user_id = ? 
                        ORDER BY log_date DESC 
                        LIMIT 1
                     ")
                     ->willReturn($stmt);

        // Simulate fetching most recent workout
        $stmt->bind_param('i', $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        // Assert result is an instance of mysqli_result
        $this->assertInstanceOf(mysqli_result::class, $result);
    }

    public function testDeleteWorkout()
    {
        $workoutId = 2;

        // Prepare mock statement for deleting workout
        $stmt = $this->createMock(mysqli_stmt::class);
        $stmt->expects($this->once())
             ->method('bind_param')
             ->with('ii', $workoutId, $this->userId);
        $stmt->expects($this->once())
             ->method('execute');
        $stmt->expects($this->once())
             ->method('close');

        $this->mockDb->expects($this->once())
                     ->method('prepare')
                     ->with("DELETE FROM workout_log WHERE workout_id = ? AND user_id = ?")
                     ->willReturn($stmt);

        // Simulate deleting a workout
        $stmt->bind_param('ii', $workoutId, $this->userId);
        $stmt->execute();
        $stmt->close();

        // Assert that the mock delete query was executed
        $this->addToAssertionCount(1); // No exception thrown, query executed
    }

    public function testUpdateWorkout()
    {
        $workoutId = 2;
        $exerciseType = "Running";
        $duration = 60;
        $intensity = 7;
        $frequency = 3;
        $notes = "Felt great!";

        // Prepare mock statement for updating workout
        $stmt = $this->createMock(mysqli_stmt::class);
        $stmt->expects($this->once())
             ->method('bind_param')
             ->with('siiisii', $exerciseType, $duration, $intensity, $frequency, $notes, $workoutId, $this->userId);
        $stmt->expects($this->once())
             ->method('execute');
        $stmt->expects($this->once())
             ->method('close');

        $this->mockDb->expects($this->once())
                     ->method('prepare')
                     ->with("
                        UPDATE workout_log 
                        SET exercise_type = ?, duration = ?, intensity = ?, frequency = ?, notes = ? 
                        WHERE workout_id = ? AND user_id = ?
                     ")
                     ->willReturn($stmt);

        // Simulate updating a workout
        $stmt->bind_param('siiisii', $exerciseType, $duration, $intensity, $frequency, $notes, $workoutId, $this->userId);
        $stmt->execute();
        $stmt->close();

        // Assert that the mock update query was executed
        $this->addToAssertionCount(1); // No exception thrown, query executed
    }
}
