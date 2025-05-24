<?php

namespace App\mappers;

use App\models\Clan;
use App\models\ClanMember;

class ClanMapper
{

    public static function mapToClan(array $data): Clan
    {
        return new Clan(
            $data['id'],
            $data['name'],
            $data['description'] ?? '',
            $data['level'],
            $data['members_count'],
            $data['img'] ?? null,
            $data['leader_id']
        );
    }

    public static function mapToClanMember(array $data): ClanMember
    {
        return new ClanMember(
            $data['user_id'],
            $data['clan_id'],
            $data['login']
        );
    }
}
