<?php

namespace services;

use App\repositories\TokenRepository;
use App\repositories\UserRepository;
use App\services\UserService;
use App\models\User;
use PDOException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    public UserService $userService;
    public UserRepository&MockObject $userRepositoryMock;
    public TokenRepository&MockObject $tokenRepositoryMock;
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->tokenRepositoryMock = $this->createMock(TokenRepository::class);
        $this->userService = new UserService($this->userRepositoryMock, $this->tokenRepositoryMock);
    }

    /**
     * Test the createUser method.
     */
    public function testCreateUser()
    {
        $login = 'testuser';
        $email = 'testuser@example.com';
        $password = 'password';
        $token = 'token123';

        // Set up the mock for createUser to return a user ID
        $this->userRepositoryMock->expects($this->once())
            ->method('createUser')
            ->with($this->isInstanceOf(User::class)) // Ensures it's called with a User instance
            ->willReturn(1); // Simulating the creation of a user and returning an ID

        // Set up the mock for saveToken to return true (indicating token was saved)
        $this->tokenRepositoryMock->expects($this->once())
            ->method('saveToken')
            ->with('verify', $token, 1) // Verify it was called with the right arguments
            ->willReturn(true); // Simulating that the token was saved successfully

        // Call the createUser method
        $result = $this->userService->createUser($login, $email, $password, $token);

        // Assert the result is true, since both user creation and token saving succeed
        $this->assertTrue($result);
    }

    /**
     * Test the createUser method when user creation fails.
     */
    public function testCreateUserFailsWhenUserCreationFails()
    {
        $login = 'testuser';
        $email = 'testuser@example.com';
        $password = 'password';
        $token = 'token123';

        // Set up the mock for createUser to return 0, indicating failure
        $this->userRepositoryMock->expects($this->once())
            ->method('createUser')
            ->with($this->isInstanceOf(User::class))
            ->willThrowException(new PDOException("User already exists!", 23000));

        // Call the createUser method

        $this->expectException(PDOException::class);
        $this->expectExceptionMessage('User already exists!');
        $this->userService->createUser($login, $email, $password, $token);
    }

    /**
     * Test the createUser method when token saving fails.
     */
    public function testCreateUserFailsWhenTokenSavingFails()
    {
        $login = 'testuser';
        $email = 'testuser@example.com';
        $password = 'password';
        $token = 'token123';

        // Set up the mock for createUser to return a valid user ID
        $this->userRepositoryMock->expects($this->once())
            ->method('createUser')
            ->with($this->isInstanceOf(User::class))
            ->willReturn(1); // Simulating successful user creation

        // Set up the mock for saveToken to return false, indicating failure to save token
        $this->tokenRepositoryMock->expects($this->once())
            ->method('saveToken')
            ->with('verify', $token, 1)
            ->willReturn(false); // Simulating failure to save the token

        // Call the createUser method
        $this->expectException(PDOException::class);
        $this->expectExceptionMessage('Failed to save token!');
        $this->userService->createUser($login, $email, $password, $token);
    }
}
