<?php

namespace App\mappers;

use App\models\Token;

class TokenMapper
{
    /**
     * @throws \DateMalformedStringException
     */
    public static function mapToToken(array $tokenData): Token
    {
        return new Token(
            $tokenData['token'],
            $tokenData['type'],
            $tokenData['user_id'],
            DateTimeMapper::map($tokenData['created_at']),
            DateTimeMapper::map($tokenData['expires_at'])
        );
    }
}
