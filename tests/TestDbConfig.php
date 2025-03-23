<?php

namespace Test;

use App\config\DbConfig;

class TestDbConfig extends DbConfig
{
    public function getDsn(): string
    {
        return 'sqlite::memory:'; // Use an in-memory SQLite database for tests
    }

    public function getUsername(): string
    {
        return ''; // No username required for SQLite
    }

    public function getPassword(): string
    {
        return ''; // No password required for SQLite
    }
}
