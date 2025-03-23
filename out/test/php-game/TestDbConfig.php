<?php

namespace Test;

use App\config\DbConfig;

class TestDbConfig extends DbConfig
{
    public string $dsn {
    get {
        return 'sqlite::memory:'; // Use an in-memory SQLite database for tests

    }}
    public string $user {
        get {
            return "";
        }
    }
    public string $pass {
        get {
            return "";
        }
    }
}
