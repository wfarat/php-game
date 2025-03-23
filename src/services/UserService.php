<?php

namespace App\services;

use App\config\DbConfig;
use App\core\Database;
use App\models\User;
use App\repositories\UserRepository;

class UserService
{
private UserRepository $userRepository;

function __construct(Database $db) {
    $this->userRepository = new UserRepository($db);
}

public function createUser(String $login, String $email, String $password, String $token): bool {
    $user = new User($login, $password, $email);
    $user->token = $token;
    return $this->userRepository->createUser($user);
}

}
