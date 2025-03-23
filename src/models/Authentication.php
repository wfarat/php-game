<?php

namespace App\models;

class Authentication
{
    public User $user;
    public bool $isAuthenticated;

    public function __construct(User $user, bool $isAuthenticated)
    {
        $this->user = $user;
        $this->isAuthenticated = $isAuthenticated;
    }
}
