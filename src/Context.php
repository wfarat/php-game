<?php
namespace App;
use App\config\DbConfig;
use App\core\Database;
use App\services\UserService;
use App\controllers\RegisterController;

class Context {

public Database $db;
public UserService $userService;
public RegisterController $registerController;
public static ?Context $instance = null;
private function __construct() {
    $this->db = Database::getInstance(new DbConfig());
    $this->userService = new UserService($this->db);
    $this->registerController = new RegisterController($this->userService);
}

public static function getInstance(): Context
{
    if (self::$instance === null) {
        self::$instance = new self();
    }
    return self::$instance;
}

}
