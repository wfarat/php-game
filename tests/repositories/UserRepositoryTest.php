<?php

namespace Test\repositories;


use App\core\Database;
use App\models\User;
use App\repositories\UserRepository;
use PHPUnit\Framework\TestCase;
use Test\TestDbConfig;

class UserRepositoryTest extends TestCase
{
private UserRepository $userRepository;
private Database $db;
    protected function setUp(): void
    {

        $this->db = Database::getInstance(new TestDbConfig());
        $this->userRepository = new UserRepository($this->db);

        // Set up the database schema
        $this->db->getConnection()->exec("CREATE TABLE users (id INTEGER PRIMARY KEY AUTO_INCREMENT, login TEXT UNIQUE, email TEXT UNIQUE, password TEXT, verified BOOLEAN DEFAULT false)");
    }
    public function testCreateUser()
    {
        $user = new User('john', 'password' , 'doe@gmail.com');
        $this->userRepository->createUser($user);

        // Fetch the user and assert that it exists
        $userInDb = $this->userRepository->getUserById(1);
        $this->assertEquals($user->email, $userInDb->email);
        $this->assertEquals($user->hashedPassword, $userInDb->hashedPassword);
    }

    public function testGetAllUsers()
    {
        $this->userRepository->createUser(new User('john', 'password' , 'doe@gmail.com'));
        $this->userRepository->createUser(new User('doe', 'password', 'john@gmail.com'));

        $users = $this->userRepository->getAllUsers();
        $this->assertCount(2, $users);
        $this->assertEquals('john', $users[0]->login);
    }

    protected function tearDown(): void
    {
        // Clean up the database
        $this->db->getConnection()->exec("DROP TABLE IF EXISTS users");
    }
}
