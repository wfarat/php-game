<?php
namespace App;
use App\config\DbConfig;
use App\core\Database;
use App\repositories\TokenRepository;
use App\repositories\UserRepository;
use App\services\UserService;
use App\controllers\UserController;

class Context {

public Database $db;
public UserRepository $userRepository;
public TokenRepository $tokenRepository;
public UserService $userService;
public UserController $userController;
public static ?Context $instance = null;
private function __construct() {
    $this->db = Database::getInstance(new DbConfig());
    $this->userRepository = new UserRepository($this->db);
    $this->tokenRepository = new TokenRepository($this->db);
    $this->userService = new UserService($this->userRepository, $this->tokenRepository);
    $this->userController = new UserController($this->userService);
}

public static function getInstance(): Context
{
    if (self::$instance === null) {
        self::$instance = new self();
    }
    return self::$instance;
}

}
