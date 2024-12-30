<?php

use PHPUnit\Framework\TestCase;

class ScheduleControllerTest extends TestCase
{
    private $dbMock;
    private $scheduleController;

    protected function setUp(): void
    {
        // Create a mock for the database connection
        $this->dbMock = $this->createMock(PDO::class);

        // Inject the mock into ScheduleController
        $this->scheduleController = new ScheduleController($this->dbMock);
    }

    public function testGetSchedule()
    {
        // Mock the database query and expected result
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('fetchAll')->willReturn([
            ['id' => 1, 'time' => '09:00-10:00', 'mon' => 'Cardio', 'tue' => '', 'wed' => '', 'thu' => '', 'fri' => '', 'sat' => ''],
            ['id' => 2, 'time' => '10:00-11:00', 'mon' => 'Yoga', 'tue' => '', 'wed' => '', 'thu' => '', 'fri' => '', 'sat' => '']
        ]);

        $this->dbMock->method('prepare')->willReturn($stmtMock);

        $stmtMock->expects($this->once())->method('execute');

        $result = $this->scheduleController->getSchedule();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals('Cardio', $result[0]['mon']);
    }

    public function testUpdateSchedule()
    {
        // Example schedule data
        $scheduleData = [
            ['id' => 1, 'mon' => 'Cardio Updated', 'tue' => 'Strength Training', 'wed' => '', 'thu' => '', 'fri' => '', 'sat' => '']
        ];

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->exactly(count($scheduleData)))->method('execute')->willReturn(true);

        $this->dbMock->method('prepare')->willReturn($stmtMock);

        $result = $this->scheduleController->updateSchedule($scheduleData);

        $this->assertTrue($result);
    }
}
