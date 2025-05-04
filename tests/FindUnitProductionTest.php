<?php

namespace Test;
use App\models\ProductionKind;
use PHPUnit\Framework\TestCase;

class FindUnitProductionTest extends TestCase
{
    public function testFindMatchingBuilding()
    {
        // Przykładowe dane testowe
        $buildings = [
            (object) ['production' => (object) ['kind' => ProductionKind::Swordsman, 'amount' => 100]],
            (object) ['production' => (object) ['kind' => ProductionKind::Stone, 'amount' => 50]],
        ];

        // Sprawdź, czy znajdzie pasujący budynek do rodzaju produkcji 'barracks'
        $result = array_find($buildings, fn($building) => $building->production->kind->value === 'swordsman');
        $this->assertNotNull($result);
        $this->assertEquals(100, $result->production->amount);
    }

    public function testNoMatchingBuilding()
    {
        // Przykładowe dane testowe
        $buildings = [
            (object) ['production' => (object) ['kind' => ProductionKind::Swordsman, 'amount' => 100]],
            (object) ['production' => (object) ['kind' => 'stable', 'amount' => 50]],
        ];

        // Szukaj rodzaju produkcji, który nie istnieje ('castle')
        $result = array_find($buildings, fn($building) => $building->production->kind === 'castle');
        $this->assertNull($result); // Funkcja powinna zwrócić null
    }

    public function testFallbackToDefault()
    {
        // Przykładowe dane testowe
        $buildings = [
            (object) ['production' => (object) ['kind' => 'barracks', 'amount' => 100]],
            (object) ['production' => (object) ['kind' => 'stable', 'amount' => 50]],
        ];

        // Jeśli nie znaleziono budynku, zwróć domyślną wartość
        $result = array_find($buildings, fn($building) => $building->production->kind === 'castle');
        $productionAmount = $result->production->amount ?? 0; // domyślna wartość to 0
        $this->assertEquals(0, $productionAmount);
    }
}
