<?php

namespace App\mappers;

use DateMalformedStringException;
use DateTime;

class DateTimeMapper
{
    /**
     * Maps a string to a DateTime object or returns null if the input is empty.
     *
     * @param string|null $date
     * @return DateTime|null
     * @throws DateMalformedStringException
     */
    public static function map(?string $date): ?DateTime
    {
        return $date ? new DateTime($date) : null;
    }

}
