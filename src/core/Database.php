<?php

namespace core;

require_once '../../vendor/autoload.php';

use Dotenv\Dotenv;
use mysqli;

class Database {
    private $connection;
    private static $instance = null;

    private function __construct() {
        // Load .env variables
        $dotenv = Dotenv::createImmutable("../../");
        $dotenv->load();

        // Get DB config from .env
        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $dbname = $_ENV['DB_NAME'];
        $dbport = $_ENV['DB_PORT'];

        // Create a new MySQLi connection
        $this->connection = new mysqli($host, $user, $pass, $dbname, $dbport);

        // Check for connection errors
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    // Get the connection
    public function getConnection() {
        return $this->connection;
    }

    // Close the connection
    public function closeConnection() {
        $this->connection->close();
        $this->connection = null;
    }

    // Prevent cloning
    private function __clone() {}

    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
}

?>
