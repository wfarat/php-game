<?php

namespace App\mappers;

use App\models\Token;
use DateTime;

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
            new DateTime($tokenData['created_at']),
            new DateTime($tokenData['expires_at'])
        );
    }
}
