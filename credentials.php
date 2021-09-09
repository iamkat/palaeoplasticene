<?php
// Database login
$user = ''; // Your username
$pass = ''; // Your password
$host = ''; // Your MYSQL Host
$dbname = ''; // Your database name
$ppcDBLogin = new PDO(sprintf('mysql:host=%s;dbname=%s;', $host, $dbname) . 'charset=utf8', $user, $pass); // Your database connection
?>