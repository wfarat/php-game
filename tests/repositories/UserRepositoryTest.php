<?php

namespace repositories;


use App\config\DbConfig;
use App\core\Database;
use App\models\User;
use App\repositories\UserRepository;
use PHPUnit\Framework\TestCase;
class TestDbConfig extends DbConfig
{
    public function getDsn(): string
    {
        return 'sqlite::memory:'; // Use an in-memory SQLite database for tests
    }

    public function getUsername(): string
    {
        return ''; // No username required for SQLite
    }

    public function getPassword(): string
    {
        return ''; // No password required for SQLite
    }
}
class UserRepositoryTest extends TestCase
{
private UserRepository $userRepository;
private Database $db;
    protected function setUp(): void
    {

        $this->db = Database::getInstance(new TestDbConfig());
        $this->userRepository = new UserRepository($this->db);

        // Set up the database schema
        $this->db->getConnection()->exec("CREATE TABLE users (id INTEGER PRIMARY KEY, login TEXT, email TEXT, password TEXT)");
    }
    public function testCreateUser()
    {
        $user = new User('John Doe', 'johndoe@gmail.com', 'password');
        $this->userRepository->createUser($user);

        // Fetch the user and assert that it exists
        $userInDb = $this->userRepository->getUserById(1);
        $this->assertEquals($user->getEmail(), $userInDb->getEmail());
    }

    public function testGetAllUsers()
    {
        $this->userRepository->createUser(new User('John Doe', 'johndoe@gmail.com', 'password'));
        $this->userRepository->createUser(new User('John Doe', 'johndoe@gmail.com', 'password'));

        $users = $this->userRepository->getAllUsers();
        $this->assertCount(2, $users);
        $this->assertEquals('John Doe', $users[0]->getLogin());
    }

    protected function tearDown(): void
    {
        // Clean up the database
        $this->db->getConnection()->exec("DROP TABLE IF EXISTS users");
    }
}
