<?php

namespace App\repositories;

use App\mappers\ClanMapper;
use App\models\Clan;
use PDO;

class ClanRepository extends BaseRepository
{

    public function create($name, $description, $leader_id): false|string
    {
        $sql = "INSERT INTO clans (name, description, leader_id)
                VALUES (:name, :description, :leader_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':leader_id' => $leader_id
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getById($id): ?Clan
    {
        $stmt = $this->pdo->prepare("
            SELECT clans.*
            FROM clan_members
            LEFT JOIN clans ON clan_members.clan_id = clans.id
            WHERE clan_members.user_id = :id
        ");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }
        return ClanMapper::mapToClan($data);
    }

    public function update($id, $level, $name, $description, $members_count, $img, $leader_id): bool
    {
        $sql = "UPDATE clans SET level = :level, name = :name, description = :description,
                members_count = :members_count, img = :img, leader_id = :leader_id WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':level' => $level,
            ':name' => $name,
            ':description' => $description,
            ':members_count' => $members_count,
            ':img' => $img,
            ':leader_id' => $leader_id
        ]);
    }

    public function delete($id): bool
    {
        $this->removeAllMembers($id);
        $this->removeAllRequests($id);
        $stmt = $this->pdo->prepare("DELETE FROM clans WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function removeAllMembers($clan_id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM clan_members WHERE clan_id = :clan_id");
        return $stmt->execute([':clan_id' => $clan_id]);
    }
    public function removeAllRequests($clan_id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM clan_requests WHERE clan_id = :clan_id");
        return $stmt->execute([':clan_id' => $clan_id]);
    }
    public function addMember($clan_id, $user_id): bool
    {
        $sql = "INSERT INTO clan_members (clan_id, user_id) VALUES (:clan_id, :user_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':clan_id' => $clan_id,
            ':user_id' => $user_id
        ]);
    }

    public function removeMember($clan_id, $user_id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM clan_members WHERE clan_id = :clan_id AND user_id = :user_id");
        return $stmt->execute([
            ':clan_id' => $clan_id,
            ':user_id' => $user_id
        ]);
    }

    public function getMembers($clan_id): array
    {
        $stmt = $this->pdo->prepare("SELECT user_id, clan_id, users.login FROM clan_members LEFT JOIN users ON users.id = clan_members.user_id WHERE clan_id = :clan_id");
        $stmt->execute([':clan_id' => $clan_id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([ClanMapper::class, 'mapToClanMember'], $data);
    }

    public function saveImage(string $name, int $clanId)
    {
        $stmt = $this->pdo->prepare("UPDATE clans SET img = :img WHERE id = :clan_id");
        $stmt->execute([':clan_id' => $clanId, ':img' => $name]);
    }

    public function createRequest($userId, int $clanId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO clan_requests (user_id, clan_id) VALUES (:user_id, :clan_id)");
        $stmt->execute([':user_id' => $userId, ':clan_id' => $clanId]);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM clans");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([ClanMapper::class, 'mapToClan'], $data);
    }

    public function getRequests(int $clanId): array
    {
        $stmt = $this->pdo->prepare("SELECT clan_requests.*, users.login FROM clan_requests LEFT JOIN users ON users.id = clan_requests.user_id WHERE clan_id = :clan_id");
        $stmt->execute([':clan_id' => $clanId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([ClanMapper::class, 'mapToClanRequest'], $data);
    }

    public function removeRequest($userId, int $clanId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM clan_requests WHERE user_id = :user_id AND clan_id = :clan_id");
        $stmt->execute([':user_id' => $userId, ':clan_id' => $clanId]);
    }
}
