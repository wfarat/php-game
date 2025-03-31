<?php
require_once '../../vendor/autoload.php';

use App\core\Context;


$db = Context::getInstance()->db;
$conn = $db->getConnection();

$sqlFile = '../data.sql';
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
