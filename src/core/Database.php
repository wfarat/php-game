<?php

namespace App\core;

use App\config\DbConfig;
use PDO;
use PDOException;

class Database {
    private static ?Database $instance = null;

    private PDO $pdo;

    private function __construct(DbConfig $dbConfig)
    {
        $dsn = $dbConfig->getDsn();
        $username = $dbConfig->getUser();
        $password = $dbConfig->getPass();
        try {
            $options = array(
                PDO::MYSQL_ATTR_SSL_CA => '/var/www/html/DigiCertGlobalRootCA.crt.pem'
            );
            $this->pdo = new PDO($dsn, $username, $password, $options);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("Database Connection Failed: . $dsn");
            error_log("Database Connection Failed: " . $e->getMessage()); // Log the error
            die("Database connection failed. Check logs for details.");
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
    public static function getInstance(DbConfig $config): ?Database
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    // Prevent cloning
    private function __clone() {}

    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
}

?>
