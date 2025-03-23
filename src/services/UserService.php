<?php

namespace App\services;

use App\config\DbConfig;
use App\core\Database;
use App\models\User;
use App\repositories\TokenRepository;
use App\repositories\UserRepository;

class UserService
{
private UserRepository $userRepository;
private TokenRepository $tokenRepository;
function __construct(Database $db) {
    $this->userRepository = new UserRepository($db);
    $this->tokenRepository = new TokenRepository($db);
}

public function createUser(String $login, String $email, String $password, String $token): bool {
    $user = new User($login, $password, $email);
    $id = $this->userRepository->createUser($user);
    if ($id === 0) {
        return false;
    } else {
        return $this->tokenRepository->saveToken("verify", $token, $id);
    }
}

public function verifyUser(String $token): bool
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

}
