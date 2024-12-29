<?php
use PHPUnit\Framework\TestCase;

class PermissionsTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // Mock database connection
        $this->db = $this->createMock(PDO::class);
    }

    public function testGetPermissions()
    {
        // Mock the query result
        $mockStatement = $this->createMock(PDOStatement::class);
        $mockStatement->expects($this->once())
                      ->method('fetchAll')
                      ->with(PDO::FETCH_ASSOC)
                      ->willReturn([
                          ['id' => 1, 'permission_name' => 'Edit', 'description' => 'Edit permissions'],
                          ['id' => 2, 'permission_name' => 'Delete', 'description' => 'Delete permissions']
                      ]);

        $this->db->expects($this->once())
                 ->method('query')
                 ->with($this->equalTo("SELECT * FROM Permissions"))
                 ->willReturn($mockStatement);

        // Call the function
        $result = getPermissions($this->db);

        // Assert the result
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals('Edit', $result[0]['permission_name']);
    }

    public function testAddPermission()
    {
        // Mock the prepared statement
        $mockStatement = $this->createMock(PDOStatement::class);
        $mockStatement->expects($this->once())
                      ->method('execute')
                      ->willReturn(true);

        $mockStatement->expects($this->once())
                      ->method('bindParam')
                      ->withConsecutive(
                          [':permission_name', $this->equalTo('Manage Users')],
                          [':description', $this->equalTo('Allows managing user accounts')]
                      );

        $this->db->expects($this->once())
                 ->method('prepare')
                 ->with($this->equalTo("INSERT INTO Permissions (permission_name, description) VALUES (:permission_name, :description)"))
                 ->willReturn($mockStatement);

        // Call the function
        $result = addPermission($this->db, 'Manage Users', 'Allows managing user accounts');

        // Assert the result
        $this->assertTrue($result);
    }
}
