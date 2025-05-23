<?php
namespace App\core;
use App\config\ProdDbConfig;
use App\controllers\BattleController;
use App\controllers\BuildingController;
use App\controllers\ClanController;
use App\controllers\ResourcesController;
use App\controllers\UnitController;
use App\controllers\UserController;
use App\repositories\BattleRepository;
use App\repositories\BuildingRepository;
use App\repositories\ClanRepository;
use App\repositories\ResourcesRepository;
use App\repositories\TokenRepository;
use App\repositories\UnitRepository;
use App\repositories\UserRepository;
use App\services\BattleService;
use App\services\BuildingService;
use App\services\ClanService;
use App\services\ResourcesService;
use App\services\UnitService;
use App\services\UserService;

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
public ResourcesController $resourcesController;
public UnitController $unitController;
public UnitService $unitService;
public BattleRepository $battleRepository;
public BattleService $battleService;
public BattleController $battleController;
public ClanRepository $clanRepository;
public ClanService $clanService;
public ClanController $clanController;
public static ?Context $instance = null;
private function __construct() {
    $this->db = Database::getInstance(new ProdDbConfig());
    $this->userRepository = new UserRepository($this->db);
    $this->tokenRepository = new TokenRepository($this->db);
    $this->userService = new UserService($this->userRepository, $this->tokenRepository);
    $this->userController = new UserController($this->userService);
    $this->unitRepository = new UnitRepository($this->db);
    $this->resourcesRepository = new ResourcesRepository($this->db);
    $this->resourcesService = new ResourcesService($this->resourcesRepository);
    $this->buildingRepository = new BuildingRepository($this->db);
    $this->unitService = new UnitService($this->unitRepository, $this->resourcesService);
    $this->buildingService = new BuildingService($this->buildingRepository, $this->resourcesService);
    $this->resourcesController = new ResourcesController($this->resourcesService, $this->buildingService);
    $this->buildingController = new BuildingController($this->buildingService);
    $this->unitController = new UnitController($this->unitService);
    $this->battleRepository = new BattleRepository($this->db);
    $this->battleService = new BattleService($this->resourcesService, $this->battleRepository, $this->userService);
    $this->battleController = new BattleController($this->battleService, $this->resourcesService, $this->unitService);
    $this->clanRepository = new ClanRepository($this->db);
    $this->clanService = new ClanService($this->clanRepository);
    $this->clanController = new ClanController($this->clanService);
}

public static function getInstance(): Context
{
    if (self::$instance === null) {
        self::$instance = new self();
    }
    return self::$instance;
}

}
