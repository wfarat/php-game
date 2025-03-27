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
        $host = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $dbname = $_ENV['DB_NAME'];
        $dbport = $_ENV['DB_PORT'];
        $this->dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';port=' . $dbport . ';ssl-mode=require';
    }

}
