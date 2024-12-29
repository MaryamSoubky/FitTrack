<?php
use PHPUnit\Framework\TestCase;

class DeleteGoalTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Mock database connection
        $this->conn = $this->createMock(mysqli::class);
    }

    public function testDeleteGoalWithValidId()
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
                   ->with($this->equalTo("DELETE FROM Goals WHERE id = ?"))
                   ->willReturn($stmt);

        // Mock the GET request
        $_GET['id'] = 1;

        // Include the code being tested
        include 'deleteGoal.php';

        // Assertions to confirm proper redirection
        $this->assertTrue(headers_sent());
        $this->assertStringContainsString('admin.php', xdebug_get_headers()[0]);
    }

    public function testDeleteGoalWithMissingId()
    {
        // Mock the GET request without an ID
        unset($_GET['id']);

        // Include the code being tested
        include 'deleteGoal.php';

        // Assertions to confirm proper error redirection
        $this->assertTrue(headers_sent());
        $this->assertStringContainsString('admin.php?error=missing_id', xdebug_get_headers()[0]);
    }
}
