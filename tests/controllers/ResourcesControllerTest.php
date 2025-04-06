<?php

namespace Test\controllers;

use App\controllers\ResourcesController;
use App\models\Resources;
use App\models\UserResources;
use App\services\BuildingService;
use App\services\ResourcesService;
use DateTime;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class ResourcesControllerTest extends TestCase
{
    private ResourcesController $resourcesController;
    private $resourcesServiceMock;
    private $buildingServiceMock;
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->resourcesServiceMock = $this->createMock(ResourcesService::class);
        $this->buildingServiceMock = $this->createMock(BuildingService::class);
        $this->resourcesController = new ResourcesController($this->resourcesServiceMock, $this->buildingServiceMock);
    }

    public function testProduceResourcesCalculatesProductionCorrectly(): void
    {
        // Arrange
        $userResources = new UserResources(100, 100, 100, 100, new DateTime('-1 hour'));
        $production = new Resources(10, 20, 30, 40);
        $_SESSION['resources'] = $userResources;

        $buildings = ['building1', 'building2']; // Mock buildings

        $this->buildingServiceMock->expects($this->once())
            ->method('countProduction')
            ->with($buildings)
            ->willReturn($production);

        $secondsPassed = 3600; // 1 hour = 3600 seconds
        $expectedProduction = new Resources(
            $production->wood * $secondsPassed,
            $production->stone * $secondsPassed,
            $production->food * $secondsPassed,
            $production->gold * $secondsPassed
        );
        $expectedResources = new UserResources(
            $userResources->wood + $expectedProduction->wood,
            $userResources->stone + $expectedProduction->stone,
            $userResources->food + $expectedProduction->food,
            $userResources->gold + $expectedProduction->gold
        );
        // Act
        $result = $this->resourcesController->produceResources($buildings);

        $this->assertInstanceOf(UserResources::class, $result);
        $this->assertTrue($result->equals($expectedResources));
        $this->assertNotNull($_SESSION['resources']->lastUpdated);
    }


    public function testProduceResourcesHandlesEmptyProduction(): void
    {
        // Arrange
        $userResources = new UserResources(100, 100, 100, 100, new DateTime('-1 hour'));
        $_SESSION['resources'] = $userResources;

        $buildings = ['building1', 'building2']; // Mock buildings


        // Act
        $result = $this->resourcesController->produceResources($buildings);

        // Assert
        $this->assertInstanceOf(UserResources::class, $result);
        $this->assertEquals($userResources, $result);
        $this->assertNotNull($_SESSION['resources']->lastUpdated);
    }

}
