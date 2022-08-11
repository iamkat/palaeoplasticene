<?php
// Database login
$user = 'u69400'; // Your username
$pass = 'yDZDpPyUMFkj754X'; // Your password
$host = 'mysql04.manitu.net'; // Your MYSQL Host
$dbname = 'db69400'; // Your database name
$dbConnection = new PDO(sprintf('mysql:host=%s;dbname=%s;', $host, $dbname) . 'charset=utf8', $user, $pass); // Your database connection
// Activate error messages
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>