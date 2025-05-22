<?php

namespace App\repositories;

use App\mappers\UnitMapper;
use DateTime;

class UnitRepository extends BaseRepository
{
    function getUnits(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM units
        LEFT JOIN user_units ON units.id = user_units.unit_id AND user_units.user_id = :userId
        LEFT JOIN unit_costs ON units.id = unit_costs.unit_id"
        );
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $unitsData = $stmt->fetchAll();
        return array_map([UnitMapper::class, 'mapToUnit'], $unitsData);
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function createQueueItem($userId, int $unitId, int $count, int $time): DateTime
    {
        $stmt = $this->pdo->prepare("INSERT INTO units_queue (user_id, unit_id, count, end_time) VALUES (:userId, :unitId, :count, :end_time)");
        $end_time = date('Y-m-d H:i:s', time() + $time);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':unitId', $unitId);
        $stmt->bindParam(':count', $count);
        $stmt->bindParam(':end_time', $end_time);
        $stmt->execute();
        return new DateTime($end_time);
    }

    public function getQueue(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT units_queue.*, units.name FROM units_queue LEFT JOIN units ON units_queue.unit_id = units.id WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return array_map([UnitMapper::class, 'mapToQueueItem'], $data);
    }

    public function addUnits($userId, int $unitId, int $amount): bool
    {
        $stmt = $this->pdo->prepare("SELECT count FROM user_units WHERE user_id = :userId AND unit_id = :unitId");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':unitId', $unitId);
        $stmt->execute();
        if ($oldCount = $stmt->fetchColumn()) {
            $stmt = $this->pdo->prepare("UPDATE user_units SET count = :count WHERE user_id = :userId AND unit_id = :unitId");
            $count = $oldCount + $amount;
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO user_units (user_id, unit_id, count) VALUES (:userId, :unitId, :count)");
            $count = $amount;
        }
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':unitId', $unitId);
        $stmt->bindParam(':count', $count);
        return $stmt->execute();
    }

    public function removeFromQueue($userId, int $unitId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM units_queue WHERE user_id = :userId AND unit_id = :unitId");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':unitId', $unitId);
        return $stmt->execute();
    }

    public function getCount($userId, int $unitId)
    {
        $stmt = $this->pdo->prepare("SELECT count FROM units_queue WHERE user_id = :userId AND unit_id = :unitId");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':unitId', $unitId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
