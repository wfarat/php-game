<?php

namespace Test;

use App\config\DbConfig;

class TestDbConfig implements DbConfig
{
    private string $dsn;
    private string $user;
    private string $pass;

    public function __construct()
    {
        $this->dsn = 'sqlite::memory:';
        $this->user = '';
        $this->pass = '';
    }

    public function getDsn(): string
    {
        return $this->dsn;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPass(): string
    {
        return $this->pass;
    }
}
