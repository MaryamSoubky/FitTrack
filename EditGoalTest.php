<?php
use PHPUnit\Framework\TestCase;

class EditGoalTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Mock database connection
        $this->conn = $this->createMock(mysqli::class);
    }

    public function testFetchGoalDetailsWithValidId()
    {
        // Mock the prepared statement
        $stmt = $this->createMock(mysqli_stmt::class);

        // Simulate fetching goal details
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        $stmt->expects($this->once())
             ->method('store_result');

        $stmt->expects($this->once())
             ->method('num_rows')
             ->willReturn(1);

        $stmt->expects($this->once())
             ->method('bind_result')
             ->with(
                 $this->anything(),
                 $this->anything(),
                 $this->anything(),
                 $this->anything()
             );

        $stmt->expects($this->once())
             ->method('fetch')
             ->willReturn(true);

        // Simulate prepared statement creation
        $this->conn->expects($this->once())
                   ->method('prepare')
                   ->with($this->equalTo("SELECT goal_type, target_value, start_date, end_date FROM Goals WHERE id = ?"))
                   ->willReturn($stmt);

        // Include the file being tested
        $_GET['id'] = 1; // Simulate valid ID
        ob_start();
        include 'edit_goal.php';
        $output = ob_get_clean();

        // Assert that the HTML form is rendered
        $this->assertStringContainsString('<form method="POST"', $output);
    }

    public function testUpdateGoalWithValidData()
    {
        // Mock the prepared statement for the update
        $updateStmt = $this->createMock(mysqli_stmt::class);

        // Simulate successful update
        $updateStmt->expects($this->once())
                   ->method('execute')
                   ->willReturn(true);

        // Simulate prepared statement creation for update
        $this->conn->expects($this->once())
                   ->method('prepare')
                   ->with($this->equalTo("UPDATE Goals SET goal_type = ?, target_value = ?, start_date = ?, end_date = ? WHERE id = ?"))
                   ->willReturn($updateStmt);

        // Simulate POST data
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_GET['id'] = 1;
        $_POST['goal_type'] = 'Run 10km';
        $_POST['target_value'] = '10km';
        $_POST['start_date'] = '2024-01-01';
        $_POST['end_date'] = '2024-01-31';

        // Include the file being tested
        ob_start();
        include 'edit_goal.php';
        $output = ob_get_clean();

        // Assert that redirection happens
        $this->assertTrue(headers_sent());
        $this->assertStringContainsString('Location: admin.php', xdebug_get_headers()[0]);
    }

    public function testFetchGoalDetailsWithInvalidId()
    {
        // Mock the prepared statement
        $stmt = $this->createMock(mysqli_stmt::class);

        // Simulate no rows found
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        $stmt->expects($this->once())
             ->method('store_result');

        $stmt->expects($this->once())
             ->method('num_rows')
             ->willReturn(0);

        // Simulate prepared statement creation
        $this->conn->expects($this->once())
                   ->method('prepare')
                   ->with($this->equalTo("SELECT goal_type, target_value, start_date, end_date FROM Goals WHERE id = ?"))
                   ->willReturn($stmt);

        // Simulate invalid ID
        $_GET['id'] = 999;

        // Include the file being tested
        ob_start();
        include 'edit_goal.php';
        $output = ob_get_clean();

        // Assert that the error message is displayed
        $this->assertStringContainsString('Goal not found.', $output);
    }
}
