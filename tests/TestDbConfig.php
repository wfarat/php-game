<?php

namespace Test;

use App\config\DbConfig;

class TestDbConfig extends DbConfig
{
    public string $dsn = 'sqlite::memory:';

    public string $user = '';
    public string $pass = '';
}
