<?php

namespace App\repositories;

use App\core\Database;
use App\exceptions\UserNotFoundException;
use App\mappers\UserMapper;
use App\models\User;
use PDO;

class UserRepository extends BaseRepository
{

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

        $usersData = $stmt->fetchAll();

        // Map each row of data to a User object using the UserMapper
        return array_map([UserMapper::class, 'mapToUser'], $usersData);
    }

    // Get a user by ID
    public function getUserById($id): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $userData = $stmt->fetch();

        if (!$userData) {
            return null;
        }

        return UserMapper::mapToUser($userData);
    }

    /**
     * @throws UserNotFoundException
     */
    public function getUserByLogin(string $login): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $userData = $stmt->fetch();

        if (!$userData) {
            throw new UserNotFoundException();
        }

        return UserMapper::mapToUser($userData);
    }
    function updateVerified(int $userId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET verified = 1 WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    public function count(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getAttackableUsers(): array
    {
        $stmt = $this->pdo->query("SELECT id, login, battles_won FROM users WHERE verified = 1 AND role != 'admin'");

        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([UserMapper::class, 'mapToAttackableUser'], $usersData);
    }

    /**
     * @throws UserNotFoundException
     */
    public function getUserByEmail($email): User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $userData = $stmt->fetch();

        if (!$userData) {
            throw new UserNotFoundException();
        }

        return UserMapper::mapToUser($userData);
    }

    public function changePassword(int $userId, string $newPassword): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $password = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    public function updateBattlesWon(int $userId): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET battles_won = battles_won + 1 WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }

    public function banUser(int $targetId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET banned = 1 WHERE id = :id");
        $stmt->bindParam(':id', $targetId);
        $stmt->execute();
    }

    public function unbanUser(int $targetId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET banned = 0 WHERE id = :id");
        $stmt->bindParam(':id', $targetId);
        $stmt->execute();
    }
}
