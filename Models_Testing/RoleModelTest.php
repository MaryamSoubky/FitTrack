<?php
use PHPUnit\Framework\TestCase;

class RoleModelTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // Set up an in-memory SQLite database for testing
        $this->db = new PDO('sqlite::memory:');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create a mock Roles table
        $this->db->exec("CREATE TABLE Roles (
            role_id INTEGER PRIMARY KEY AUTOINCREMENT,
            role_name TEXT NOT NULL
        )");
    }

    public function testSaveNewRole()
    {
        $role = new Role_Model("Administrator");
        $result = $role->save($this->db);

        $this->assertTrue($result, "New role should be saved successfully.");

        // Verify the role exists in the database
        $stmt = $this->db->query("SELECT * FROM Roles WHERE role_name = 'Administrator'");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($data, "Role should exist in the database.");
        $this->assertEquals("Administrator", $data['role_name']);
    }

    public function testUpdateRole()
    {
        // Insert a record to update
        $this->db->exec("INSERT INTO Roles (role_name) VALUES ('Old Role')");
        $roleId = $this->db->lastInsertId();

        // Update the record using the model
        $role = Role_Model::getRoleById($roleId, $this->db);
        $role->setRoleName("Updated Role");
        $result = $role->save($this->db);

        $this->assertTrue($result, "Existing role should be updated successfully.");

        // Verify the updated role in the database
        $stmt = $this->db->query("SELECT * FROM Roles WHERE role_id = $roleId");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals("Updated Role", $data['role_name']);
    }

    public function testDeleteRoleById()
    {
        // Insert a record to delete
        $this->db->exec("INSERT INTO Roles (role_name) VALUES ('Delete Role')");
        $roleId = $this->db->lastInsertId();

        // Delete the record using the model
        $result = Role_Model::deleteRoleById($roleId, $this->db);

        $this->assertTrue($result, "Role should be deleted successfully.");

        // Verify the role no longer exists in the database
        $stmt = $this->db->query("SELECT * FROM Roles WHERE role_id = $roleId");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($data, "Role should no longer exist in the database.");
    }

    public function testGetRoleById()
    {
        // Insert a record to fetch
        $this->db->exec("INSERT INTO Roles (role_name) VALUES ('Fetch Role')");
        $roleId = $this->db->lastInsertId();

        // Fetch the role using the model
        $role = Role_Model::getRoleById($roleId, $this->db);

        $this->assertInstanceOf(Role_Model::class, $role, "getRoleById should return a Role_Model object.");
        $this->assertEquals("Fetch Role", $role->getRoleName());
    }
}
