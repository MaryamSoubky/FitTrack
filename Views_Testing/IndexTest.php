<?php

use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    private $dbMock;
    private $pageAccessController;

    protected function setUp(): void
    {
        // Create a mock for the database connection
        $this->dbMock = $this->createMock(PDO::class);

        // Inject the mock into PageAccessController
        $this->pageAccessController = new PageAccessController($this->dbMock);
    }

    public function testValidateSignUp()
    {
        // Example valid input
        $inputData = [
            'username' => 'TestUser',
            'email' => 'testuser@example.com',
            'password' => 'Password123!',
            'confirmPassword' => 'Password123!'
        ];

        $result = $this->pageAccessController->validateSignUp($inputData);

        $this->assertEmpty($result, 'Expected no errors for valid input');

        // Example invalid input
        $invalidInput = [
            'username' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'confirmPassword' => '456'
        ];

        $errors = $this->pageAccessController->validateSignUp($invalidInput);

        $this->assertNotEmpty($errors, 'Expected errors for invalid input');
        $this->assertContains('Username is required', $errors);
        $this->assertContains('Invalid email format', $errors);
        $this->assertContains('Passwords do not match', $errors);
    }

    public function testValidateSignIn()
    {
        // Mock the database query and expected result
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('fetch')->willReturn([
            'id' => 1,
            'email' => 'testuser@example.com',
            'password' => password_hash('Password123!', PASSWORD_DEFAULT)
        ]);

        $this->dbMock->method('prepare')->willReturn($stmtMock);
        $stmtMock->expects($this->once())->method('execute');

        // Example valid credentials
        $credentials = [
            'email' => 'testuser@example.com',
            'password' => 'Password123!'
        ];

        $result = $this->pageAccessController->validateSignIn($credentials);

        $this->assertTrue($result, 'Expected valid sign-in to return true');

        // Example invalid credentials
        $invalidCredentials = [
            'email' => 'testuser@example.com',
            'password' => 'WrongPassword'
        ];

        $result = $this->pageAccessController->validateSignIn($invalidCredentials);

        $this->assertFalse($result, 'Expected invalid sign-in to return false');
    }
}
