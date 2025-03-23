<?php

namespace App\services;

use App\exceptions\UserNotFoundException;
use App\models\Authentication;
use App\models\User;
use App\repositories\TokenRepository;
use App\repositories\UserRepository;
use PDOException;

class UserService
{
    private UserRepository $userRepository;
    private TokenRepository $tokenRepository;

    function __construct(UserRepository $userRepository, TokenRepository $tokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
    }

    public function createUser(string $login, string $email, string $password, string $token): bool
    {
        $user = new User($login, $password, $email);
        $this->userRepository->beginTransaction();

        try {
            $userId = $this->saveUser($user);
            $this->saveTokenForUser($token, $userId);
            $this->userRepository->commit();
            return true;
        } catch (PDOException $e) {
            $this->userRepository->rollback();

            if ($this->isUniqueConstraintViolation($e)) {
                throw new PDOException("User already exists!");
            }

            throw $e;
        }
    }

    private function saveUser(User $user): int
    {
        return $this->userRepository->createUser($user);
    }

    private function saveTokenForUser(string $token, int $userId): void
    {
        $isTokenSaved = $this->tokenRepository->saveToken("verify", $token, $userId);
        if (!$isTokenSaved) {
            throw new PDOException("Failed to save token!");
        }
    }

    private function isUniqueConstraintViolation(PDOException $e): bool
    {
        return $e->getCode() === '23000';
    }

    public function verifyUser(string $token): bool
    {
        $tokenInDb = $this->tokenRepository->getToken($token);
        if ($tokenInDb) {
            if ($tokenInDb->type !== "verify") {
                return false;
            }
            $updated = $this->userRepository->updateVerified($tokenInDb->userId);
            if ($updated) {
                $this->tokenRepository->deleteToken($token);
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * @throws UserNotFoundException
     */
    public function login(string $login, string $password): Authentication
    {
        $user = $this->userRepository->getUserByLogin($login);
        $isAuthenticated = password_verify($password, $user->hashedPassword);
        return new Authentication($user, $isAuthenticated);
    }
}
