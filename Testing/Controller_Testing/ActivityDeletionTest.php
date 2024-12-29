use PHPUnit\Framework\TestCase;

class ActivityDeletionTest extends TestCase
{
    protected $conn;
    protected $stmt;

    protected function setUp(): void
    {
        // Mocking the database connection
        $this->conn = $this->createMock(mysqli::class);

        // Mocking the statement
        $this->stmt = $this->createMock(mysqli_stmt::class);

        // Stubbing the prepare method to return the mocked statement
        $this->conn->method('prepare')->willReturn($this->stmt);
    }

    public function testDeleteActivitySuccess()
    {
        // Simulate that execute() returns true (successful deletion)
        $this->stmt->method('execute')->willReturn(true);

        // Mocking the GET request with an 'id' parameter
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['id'] = 1;

        // Output buffering to capture echo messages
        ob_start();

        include 'path/to/your/deletion_script.php';

        $output = ob_get_clean();

        // Assert that the success message is echoed
        $this->assertStringContainsString('Activity deleted successfully!', $output);
    }

    public function testDeleteActivityFailure()
    {
        // Simulate that execute() returns false (deletion failure)
        $this->stmt->method('execute')->willReturn(false);

        // Mocking the GET request with an 'id' parameter
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['id'] = 1;

        // Output buffering to capture echo messages
        ob_start();

        include 'path/to/your/deletion_script.php';

        $output = ob_get_clean();

        // Assert that the error message is echoed
        $this->assertStringContainsString('Error deleting activity.', $output);
    }

    public function testInvalidRequest()
    {
        // Simulate an invalid GET request (no 'id' parameter)
        $_SERVER['REQUEST_METHOD'] = 'GET';

        // Output buffering to capture echo messages
        ob_start();

        include 'path/to/your/deletion_script.php';

        $output = ob_get_clean();

        // Assert that the invalid request message is echoed
        $this->assertStringContainsString('Invalid request.', $output);
    }
}
