<?php

namespace controllers;

use App\controllers\BuildingController;
use App\models\Cost;
use App\models\Resources;
use App\models\User;
use App\services\BuildingService;
use PHPUnit\Framework\TestCase;

class BuildingControllerTest extends TestCase
{
    private $buildingServiceMock;
    private $controller;

    protected function setUp(): void
    {
        $this->buildingServiceMock = $this->createMock(BuildingService::class);
        $this->controller = new BuildingController($this->buildingServiceMock);
        $_SESSION['user'] = new User('test', '123', 'test@test.com');
        $_SESSION['user']->id = 1;
    }

    public function testUpgradeBuildingSuccess()
    {
        $data = [
            'building_id' => 100,
            'production' => 50,
            'cost' => [
                'resources' => ['wood' => 100, 'stone' => 50],
                'time' => 300
            ],
            'level' => 2
        ];

        // Mock expected behavior
        $mappedResource = new Resources(100, 50, 0, 0);
        $mappedCost = new Cost($mappedResource, 300);

        $this->buildingServiceMock
            ->expects($this->once())
            ->method('upgradeBuilding')
            ->with(1, 100, 2, $mappedCost, 50)
            ->willReturn(1);

        $result = $this->controller->upgradeBuilding($data);

        // Assertions
        $this->assertEquals(1, $result);
    }

    public function testUpgradeBuildingFailsWithMissingBuildingId()
    {
        $data = [
            'production' => 50,
            'cost' => ['resources' => ['wood' => 100], 'time' => 300],
            'level' => 2
        ];

       $result = $this->controller->upgradeBuilding($data);

       $this->assertEquals(0, $result);
    }

    public function testUpgradeBuildingFailsWithMissingCost()
    {
        $data = [
            'building_id' => 100,
            'production' => 50,
            'level' => 2
        ];

        $result = $this->controller->upgradeBuilding($data);

        $this->assertEquals(0, $result);
    }
}
