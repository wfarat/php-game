<?php

namespace App\config;

use Dotenv\Dotenv;

class ProdDbConfig implements DbConfig
{
    private string $dsn;
    private string $user;
    private string $pass;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->safeLoad();

        // Get DB config from .env
        $host = getenv('DB_HOST') ?: $_ENV['DB_HOST'];
        $this->user = getenv('DB_USER') ?: $_ENV['DB_USER'];
        $this->pass = getenv('DB_PASS') ?: $_ENV['DB_PASS'];
        $dbname = getenv('DB_NAME') ?: $_ENV['DB_NAME'];
        $dbport = getenv('DB_PORT') ?: $_ENV['DB_PORT'];

        $this->dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';port=' . $dbport;
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
