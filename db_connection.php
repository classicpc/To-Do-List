<?php
// Database configuration
$db_host = 'localhost'; 
$db_username = 'root'; 
$db_password = ''; 
$db_name = 'todolist'; // replace with your database name

// Create database connection
$connection = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
