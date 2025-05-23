<?php

namespace App\repositories;

use PDO;

class ClanRepository extends BaseRepository
{

    public function create($level, $name, $description, $members_count, $img, $leader_id): false|string
    {
        $sql = "INSERT INTO clans (level, name, description, members_count, img, leader_id)
                VALUES (:level, :name, :description, :members_count, :img, :leader_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':level' => $level,
            ':name' => $name,
            ':description' => $description,
            ':members_count' => $members_count,
            ':img' => $img,
            ':leader_id' => $leader_id
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM clans WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        $stmt = $this->pdo->prepare("DELETE FROM clans WHERE id = :id");
        return $stmt->execute([':id' => $id]);
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
        $stmt = $this->pdo->prepare("SELECT user_id FROM clan_members WHERE clan_id = :clan_id");
        $stmt->execute([':clan_id' => $clan_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
