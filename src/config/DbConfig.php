<?php

namespace App\config;
use Dotenv\Dotenv;
class DbConfig {
    public string $dsn {
        get {
            return $this->dsn;
        }
    }
    public string $user {
        get {
            return $this->user;
        }
    }
    public string $pass {
        get {
            return $this->pass;
        }
    }

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();

        // Get DB config from .env
        $host = getenv('DB_HOST') ?: $_ENV['DB_HOST'];
        $this->user = getenv('DB_HOST') ?: $_ENV['DB_USER'];
        $this->pass = getenv('DB_HOST') ?: $_ENV['DB_PASS'];
        $dbname = getenv('DB_HOST') ?: $_ENV['DB_NAME'];
        $dbport = getenv('DB_HOST') ?: ['DB_PORT'];
        $this->dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';port=' . $dbport . ';ssl-mode=require';
    }

}
