<?php
use PHPUnit\Framework\TestCase;

class ReportsControllerTest extends TestCase
{
    private $db;
    private $model;
    private $controller;

    protected function setUp(): void
    {
        // Mock the database connection
        $this->db = $this->createMock(PDO::class);

        // Mock the Reports_Model
        $this->model = $this->getMockBuilder(Reports_Model::class)
                            ->setConstructorArgs([$this->db])
                            ->onlyMethods(['getTotalUsers', 'getActiveGoals', 'getWorkoutsToday', 'getRecentActivities', 'getGoalDetails'])
                            ->getMock();

        // Inject mock model into the controller
        $this->controller = new Reports_Controller($this->db);
        $this->controller->model = $this->model;
    }

    public function testDisplayReports()
    {
        // Mock return values for model methods
        $this->model->expects($this->once())
                    ->method('getTotalUsers')
                    ->willReturn(100);

        $this->model->expects($this->once())
                    ->method('getActiveGoals')
                    ->willReturn(50);

        $this->model->expects($this->once())
                    ->method('getWorkoutsToday')
                    ->with($this->equalTo(date("Y-m-d")))
                    ->willReturn(20);

        $this->model->expects($this->once())
                    ->method('getRecentActivities')
                    ->willReturn([
                        ['activity' => 'Running', 'date' => '2024-01-01'],
                        ['activity' => 'Swimming', 'date' => '2024-01-02'],
                    ]);

        $this->model->expects($this->once())
                    ->method('getGoalDetails')
                    ->willReturn([
                        ['goal_type' => 'Weight Loss', 'target_value' => '5kg'],
                        ['goal_type' => 'Running Distance', 'target_value' => '50km'],
                    ]);

        // Capture output of the view
        ob_start();
        $this->controller->displayReports();
        $output = ob_get_clean();

        // Assert the view contains key report data
        $this->assertStringContainsString('100', $output); // Total Users
        $this->assertStringContainsString('50', $output); // Active Goals
        $this->assertStringContainsString('20', $output); // Workouts Today
        $this->assertStringContainsString('Running', $output); // Recent Activities
        $this->assertStringContainsString('Weight Loss', $output); // Goal Details
    }
}
