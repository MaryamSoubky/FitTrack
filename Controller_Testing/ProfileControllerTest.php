<?php
use PHPUnit\Framework\TestCase;

class ProfileControllerTest extends TestCase
{
    private $conn;
    private $controller;

    protected function setUp(): void
    {
        // Mock database connection
        $this->conn = $this->createMock(mysqli::class);

        // Mock Profile_Model methods
        require_once '../Models/ProfileModel.php';
        $this->controller = new Profile_Controller();
    }

    public function testGetProfileWithValidUserId()
    {
        $mockProfile = [
            'user_id' => 1,
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'is_active' => 1,
        ];

        // Mock Profile_Model::getProfileByUserId method
        Profile_Model::staticExpects($this->once())
                     ->method('getProfileByUserId')
                     ->with($this->equalTo(1), $this->equalTo($this->conn))
                     ->willReturn($mockProfile);

        // Call the method
        $result = $this->controller->getProfile(1);

        // Assert the result
        $this->assertIsArray($result);
        $this->assertEquals($mockProfile, $result);
    }

    public function testGetProfileWithInvalidUserId()
    {
        // Mock Profile_Model::getProfileByUserId method
        Profile_Model::staticExpects($this->once())
                     ->method('getProfileByUserId')
                     ->with($this->equalTo(999), $this->equalTo($this->conn))
                     ->willReturn(null);

        // Call the method
        $result = $this->controller->getProfile(999);

        // Assert the result
        $this->assertNull($result);
    }

    public function testUpdateProfileSuccess()
    {
        $mockProfile = $this->createMock(Profile_Model::class);

        // Mock the updateProfile method
        $mockProfile->expects($this->once())
                    ->method('updateProfile')
                    ->with($this->equalTo($this->conn))
                    ->willReturn(true);

        // Call the method
        $result = $this->controller->updateProfile(1, 'newuser', 'newuser@example.com', 'hashedpassword');

        // Assert the result
        $this->assertEquals("Profile updated successfully!", $result);
    }

    public function testUpdateProfileFailure()
    {
        $mockProfile = $this->createMock(Profile_Model::class);

        // Mock the updateProfile method
        $mockProfile->expects($this->once())
                    ->method('updateProfile')
                    ->with($this->equalTo($this->conn))
                    ->willReturn(false);

        // Call the method
        $result = $this->controller->updateProfile(1, 'newuser', 'newuser@example.com', 'hashedpassword');

        // Assert the result
        $this->assertEquals("Failed to update profile.", $result);
    }
}
