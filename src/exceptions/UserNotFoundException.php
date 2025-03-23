<?php

namespace App\exceptions;


use Exception;

class UserNotFoundException extends Exception
{
    public function __construct($message = "User not found", $code = 404) {
        parent::__construct($message, $code);
    }
}
