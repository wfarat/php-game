<?php

namespace Test\services;

use App\models\Building;
use App\models\Production;
use App\models\ProductionKind;
use App\models\ProductionType;
use App\models\Resources;
use App\repositories\BuildingRepository;
use App\services\BuildingService;
use App\services\ResourcesService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;

class BuildingServiceTest extends TestCase
{
    private BuildingService $buildingService;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $buildingRepositoryMock = $this->createMock(BuildingRepository::class);
        $resourcesServiceMock = $this->createMock(ResourcesService::class);
        $this->buildingService = new BuildingService($buildingRepositoryMock, $resourcesServiceMock);
    }

    /**
     * @throws Exception
     */
    public function testCountProductionWithValidBuildings()
    {
        $building1 = $this->getMockedBuilding(ProductionKind::Wood, 10);
        $building2 = $this->getMockedBuilding(ProductionKind::Stone, 20);
        $building3 = $this->getMockedBuilding(ProductionKind::Food, 30);
        $building4 = $this->getMockedBuilding(ProductionKind::Gold, 40);

        $result = $this->buildingService->countProduction([$building1, $building2, $building3, $building4]);

        $expectedResources = new Resources(10, 20, 30, 40);
        $this->assertEquals($expectedResources, $result);
    }

    public function testCountProductionWithNoBuildings()
    {
        $result = $this->buildingService->countProduction([]);

        $expectedResources = new Resources(0, 0, 0, 0);
        $this->assertEquals($expectedResources, $result);
    }

    /**
     * @throws Exception
     */
    public function testCountProductionWithMixedProductionTypes()
    {
        $building1 = $this->getMockedBuilding(ProductionKind::Wood, 10);
        $building2 = $this->getMockedBuilding(ProductionKind::Food, 20, ProductionType::Military);
        $building3 = $this->getMockedBuilding(ProductionKind::Stone, 30);
        $building4 = $this->getMockedBuilding(ProductionKind::Gold, 40, ProductionType::Administrative);

        $result = $this->buildingService->countProduction([$building1, $building3]);

        $expectedResources = new Resources(10, 30, 0, 0);
        $this->assertEquals($expectedResources, $result);
    }

    /**
     * @throws Exception
     */
    public function testCountProductionWithBuildingHavingNoProduction()
    {
        $building1 = $this->getMockedBuilding(ProductionKind::None, 0);
        $building2 = $this->getMockedBuilding(ProductionKind::None, 0);
        $building3 = $this->getMockedBuilding(ProductionKind::None, 0);

        $result = $this->buildingService->countProduction([$building1, $building2, $building3]);

        $expectedResources = new Resources(0, 0, 0, 0);
        $this->assertEquals($expectedResources, $result);
    }

    /**
     * @throws Exception
     */
    private function getMockedBuilding(ProductionKind $kind, int $amount, ProductionType $type = ProductionType::Resource): Building&MockObject
    {
        $building = $this->createMock(Building::class);

        $production = $this->createMock(Production::class);
        $production->type = $type;
        $production->kind = $kind;
        $production->amount = $amount;

        $building->production = $production;

        return $building;
    }
}
