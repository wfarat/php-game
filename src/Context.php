<?php
namespace App;
use App\config\DbConfig;
use App\controllers\BuildingController;
use App\core\Database;
use App\repositories\BuildingRepository;
use App\repositories\ResourcesRepository;
use App\repositories\TokenRepository;
use App\repositories\UnitRepository;
use App\repositories\UserRepository;
use App\services\BuildingService;
use App\services\ResourcesService;
use App\services\UserService;
use App\controllers\UserController;

class Context {

public Database $db;
public UserRepository $userRepository;
public TokenRepository $tokenRepository;
public ResourcesRepository $resourcesRepository;
public UnitRepository $unitRepository;
public BuildingRepository $buildingRepository;
public BuildingService $buildingService;
public BuildingController $buildingController;
public UserService $userService;
public ResourcesService $resourcesService;
public UserController $userController;
public static ?Context $instance = null;
private function __construct() {
    $this->db = Database::getInstance(new DbConfig());
    $this->userRepository = new UserRepository($this->db);
    $this->tokenRepository = new TokenRepository($this->db);
    $this->userService = new UserService($this->userRepository, $this->tokenRepository);
    $this->userController = new UserController($this->userService);
    $this->unitRepository = new UnitRepository($this->db);
    $this->resourcesRepository = new ResourcesRepository($this->db);
    $this->resourcesService = new ResourcesService($this->resourcesRepository);
    $this->buildingRepository = new BuildingRepository($this->db);
    $this->buildingService = new BuildingService($this->buildingRepository, $this->resourcesService);
    $this->buildingController = new BuildingController($this->buildingService);
}

public static function getInstance(): Context
{
    if (self::$instance === null) {
        self::$instance = new self();
    }
    return self::$instance;
}

}
