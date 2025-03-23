<?php

namespace App\repositories;

use App\core\Database;
use App\mappers\UserMapper;
use App\models\User;
use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct(Database $db)
    {
        // Inject the DatabaseConnection object
        $this->pdo = $db->getConnection();
    }

    // Create a new user
    public function createUser(User $user): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (login, password, email) VALUES (:login, :password, :email)");
        $login = $user->login;
        $email = $user->email;
        $password = $user->hashedPassword;
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        if ($stmt->execute()) {
            return $this->pdo->lastInsertId();
        } else {
            return 0;
        }
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

    function updateVerified(int $userId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET verified = 1 WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

}
