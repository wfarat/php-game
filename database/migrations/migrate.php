<?php

use App\core\Database;

require_once "../../src/core/Database.php";

$db = Database::getInstance();
$conn = $db->getConnection();

$sqlFile = '../database.sql';
$sqlContent = file_get_contents($sqlFile);
if ($sqlContent === false) {
    die("Error reading SQL file.");
}

// Split SQL statements and execute them
$sqlStatements = explode(";", $sqlContent);

foreach ($sqlStatements as $query) {
    $trimmedQuery = trim($query);
    if (!empty($trimmedQuery)) {
        if ($conn->query($trimmedQuery) === false) {
            echo "Error executing query \n";
        }
    }
}

echo "SQL file executed successfully!";
