<?php
//---------------
// Database login
//---------------

// General database information
$dbname = 'db'; // Your database name
$host = 'db'; // Your MySQL host
$port = '3306'; // Your port

// Databasse login information
$dsn = sprintf('mysql:dbname=%s;host=%s;port=%s', $dbname, $host, $port); // Your database connection information
$user = 'db'; // Your username
$pass = 'db'; // Your password

try {
    $dbConnection = new PDO($dsn, $user, $pass); // Your database connection

    // Activate error messages
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo($error->getMessage());
}
?>