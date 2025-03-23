<?php

namespace App\repositories;

use App\core\Database;
use App\mappers\UserMapper;
use App\models\User;
use PDO;

class UserRepository
{
    private $pdo;

    public function __construct(Database $db)
    {
        // Inject the DatabaseConnection object
        $this->pdo = $db->getConnection();
    }

    // Create a new user
    public function createUser(User $user): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (login, password, email) VALUES (:login, :password, :email)");
        $login = $user->getLogin();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

    // Get all users
    public function getAllUsers(): array
    {
        // Execute the query to fetch all users
        $stmt = $this->pdo->query("SELECT * FROM users");

        // Fetch all results as an associative array
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Map each row of data to a User object using the UserMapper
        return array_map([UserMapper::class, 'mapToUser'], $usersData);
    }

    // Get a user by ID
    public function getUserById($id): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        // If no user is found, return null
        if (!$userData) {
            return null;
        }

        // Use the UserMapper to map the data to a User object
        return UserMapper::mapToUser($userData);
    }
}
