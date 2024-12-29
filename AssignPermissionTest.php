<?php
use PHPUnit\Framework\TestCase;

class AssignPermissionTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // Mock the database connection
        $this->db = $this->createMock(PDO::class);
    }

    public function testAssignPermissionSuccess()
    {
        // Mock the prepared statement
        $stmt = $this->createMock(PDOStatement::class);

        // Simulate successful execution
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        $stmt->expects($this->once())
             ->method('bindParam')
             ->withConsecutive(
                 [':role_id', $this->equalTo(1)],
                 [':permission_id', $this->equalTo(2)]
             );

        // Simulate preparation of the query
        $this->db->expects($this->once())
                 ->method('prepare')
                 ->with($this->equalTo("INSERT INTO Role_Permissions (role_id, permission_id) VALUES (:role_id, :permission_id)"))
                 ->willReturn($stmt);

        // Call the function and assert success
        $result = assignPermission($this->db, 1, 2);
        $this->assertTrue($result);
    }

    public function testAssignPermissionFailure()
    {
        // Mock the prepared statement
        $stmt = $this->createMock(PDOStatement::class);

        // Simulate failed execution
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(false);

        $stmt->expects($this->once())
             ->method('bindParam')
             ->withConsecutive(
                 [':role_id', $this->equalTo(1)],
                 [':permission_id', $this->equalTo(999)]
             );

        // Simulate preparation of the query
        $this->db->expects($this->once())
                 ->method('prepare')
                 ->with($this->equalTo("INSERT INTO Role_Permissions (role_id, permission_id) VALUES (:role_id, :permission_id)"))
                 ->willReturn($stmt);

        // Call the function and assert failure
        $result = assignPermission($this->db, 1, 999);
        $this->assertFalse($result);
    }
}
