<?php

namespace App\config;
use Dotenv\Dotenv;
class DbConfig {
    private $dsn;
    private $user;
    private $pass;
    public function __construct() {
        $dotenv = Dotenv::createImmutable("../../");
        $dotenv->load();

        // Get DB config from .env
        $host = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $dbname = $_ENV['DB_NAME'];
        $dbport = $_ENV['DB_PORT'];
        $this->dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';port=' . $dbport;
    }

    /**
     * @return string
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

}
