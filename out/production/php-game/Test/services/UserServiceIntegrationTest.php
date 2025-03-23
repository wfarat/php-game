<?php

namespace Test\services;

use App\core\Database;
use App\repositories\TokenRepository;
use App\repositories\UserRepository;
use App\services\UserService;
use PHPUnit\Framework\TestCase;
use Test\TestDbConfig;
use function PHPUnit\Framework\assertThat;

class UserServiceIntegrationTest extends TestCase
{
    private UserRepository $userRepository;
    private TokenRepository $tokenRepository;
    private UserService $userService;
    private Database $db;
    protected function setUp(): void
    {

        $this->db = Database::getInstance(new TestDbConfig());
        $this->userRepository = new UserRepository($this->db);
        $this->tokenRepository = new TokenRepository($this->db);
        $this->userService = new UserService($this->userRepository, $this->tokenRepository);
        // Set up the database schema

        $this->db->getConnection()->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, login TEXT UNIQUE, email TEXT UNIQUE, password TEXT, verified BOOLEAN DEFAULT false)");
        $this->db->getConnection()->exec("CREATE TABLE IF NOT EXISTS user_tokens (id INTEGER PRIMARY KEY AUTOINCREMENT, type TEXT, token TEXT, user_id INTEGER, created_at TIMESTAMP, expires_at TIMESTAMP, FOREIGN KEY (user_id) REFERENCES users(id))");
    }

    public function testCreateUser() {
        $this->assertTrue($this->userService->createUser('john', 'doe@gmail.com', 'password', 'token'));
        assertThat($this->userRepository->count(), self::equalTo(1));
        assertThat($this->tokenRepository->count(), self::equalTo(1));
    }

    public function testVerifyUser() {
        $this->userService->createUser('john', 'doe@gmail.com', 'password', 'token');
        $this->assertTrue($this->userService->verifyUser('token'));
    }
    protected function tearDown(): void
    {
        $this->db->getConnection()->exec("DROP TABLE IF EXISTS user_tokens");
        $this->db->getConnection()->exec("DROP TABLE IF EXISTS users");
    }
}
