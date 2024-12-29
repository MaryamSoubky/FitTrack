<?php
use PHPUnit\Framework\TestCase;

class DeleteActivityTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Mock database connection
        $this->conn = $this->createMock(mysqli::class);
    }

    public function testDeleteActivityWithValidId()
    {
        // Mock prepared statement
        $stmt = $this->createMock(mysqli_stmt::class);

        // Simulate successful deletion
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        $stmt->expects($this->once())
             ->method('close');

        // Simulate prepared statement creation
        $this->conn->expects($this->once())
                   ->method('prepare')
                   ->with($this->equalTo("DELETE FROM Workout_Log WHERE workout_id = ?"))
                   ->willReturn($stmt);

        // Mock GET request with a valid ID
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['id'] = 1;

        // Include the code being tested
        include 'deleteActivity.php';

        // Assertions to confirm proper redirection
        $this->assertTrue(headers_sent());
        $this->assertStringContainsString('admin.php', xdebug_get_headers()[0]);
    }

    public function testDeleteActivityWithInvalidRequest()
    {
        // Mock GET request with no ID
        $_SERVER['REQUEST_METHOD'] = 'GET';
        unset($_GET['id']);

        // Capture the output
        ob_start();
        include 'deleteActivity.php';
        $output = ob_get_clean();

        // Assertions to confirm error message
        $this->assertStringContainsString('Invalid request.', $output);
    }

    public function testDeleteActivityQueryFails()
    {
        // Mock prepared statement
        $stmt = $this->createMock(mysqli_stmt::class);

        // Simulate query failure
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(false);

        $stmt->expects($this->once())
             ->method('close');

        // Simulate prepared statement creation
        $this->conn->expects($this->once())
                   ->method('prepare')
                   ->with($this->equalTo("DELETE FROM Workout_Log WHERE workout_id = ?"))
                   ->willReturn($stmt);

        // Mock GET request with a valid ID
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['id'] = 1;

        // Capture the output
        ob_start();
        include 'deleteActivity.php';
        $output = ob_get_clean();

        // Assertions to confirm error message
        $this->assertStringContainsString('Error deleting activity.', $output);
    }
}
