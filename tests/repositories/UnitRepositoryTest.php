<?php

namespace Test\repositories;

use App\core\Database;
use App\mappers\UnitMapper;
use App\models\User;
use App\repositories\UnitRepository;
use PDO;
use PHPUnit\Framework\TestCase;
use Test\TestDbConfig;

class UnitRepositoryTest extends TestCase
{
    private UnitRepository $unitRepository;
    private Database $db;

    protected function setUp(): void
    {
        $this->db = Database::getInstance(new TestDbConfig());
        $this->createTestTables();
        $this->seedTestData();
        $_SESSION['user'] = new User('test', '123', 'test@test.com');
        $_SESSION['user']->id = 1;
        $this->unitRepository = new UnitRepository($this->db);
    }

    protected function tearDown(): void
    {
        $this->dropTestTables();
    }

    private function getTestDatabaseConnection(): PDO
    {
        return new PDO('sqlite::memory:');
    }

    private function createTestTables(): void
    {
        $this->db->getConnection()->exec("
            CREATE TABLE IF NOT EXISTS units (
                id INTEGER PRIMARY KEY, 
                name TEXT NOT NULL,  
                description TEXT NOT NULL,
                attack INTEGER NOT NULL,
                defense INTEGER NOT NULL,
                speed INTEGER NOT NULL,
                img TEXT NOT NULL
            );
            
            CREATE TABLE IF NOT EXISTS unit_costs (
                unit_id INTEGER PRIMARY KEY,       
                time INTEGER NOT NULL,
                wood INTEGER NOT NULL,
                stone INTEGER NOT NULL,
                food INTEGER NOT NULL,
                gold INTEGER NOT NULL,
                FOREIGN KEY (unit_id) REFERENCES units (id)
            );
            
            CREATE TABLE IF NOT EXISTS user_units (
                user_id INTEGER NOT NULL,
                unit_id INTEGER NOT NULL,
                count INTEGER NOT NULL,
                PRIMARY KEY (user_id, unit_id),
                FOREIGN KEY (user_id) REFERENCES users (id),
                FOREIGN KEY (unit_id) REFERENCES units (id)
            );
        ");
    }

    private function dropTestTables(): void
    {
        $this->db->getConnection()->exec("
            DROP TABLE IF EXISTS unit_costs;
            DROP TABLE IF EXISTS user_units;
            DROP TABLE IF EXISTS units;
        ");
    }

    private function seedTestData(): void
    {
        $this->db->getConnection()->exec("
        INSERT INTO units (id, name, description, attack, defense, speed, img)
        VALUES
            (1, 'Swordman', 'A basic melee unit with balanced stats', 10, 5, 2, 'swordman.png'),
            (2, 'Archer', 'Ranged unit that can attack from a distance', 8, 3, 3, 'archer.png'),
            (3, 'Cavalry', 'Fast moving unit with high attack', 15, 10, 5, 'cavalry.png'),
            (4, 'Catapult', 'Siege unit used to break walls', 25, 20, 1, 'catapult.png');
        
        INSERT INTO unit_costs (unit_id, time, wood, stone, food, gold)
        VALUES
            (1, 30, 50, 20, 30, 10),  -- Swordman
            (2, 40, 30, 10, 40, 20),  -- Archer
            (3, 60, 100, 50, 80, 40), -- Cavalry
            (4, 120, 200, 100, 150, 80); -- Catapult
        ");
    }

    public function testGetUnitsReturnsMappedUnits(): void
    {
        $userId = 1;

        $result = $this->unitRepository->getUnits($userId);

        $this->assertIsArray($result);
        $this->assertCount(4, $result);
    }

}
