<?php
// Start the engine
session_start();
require_once __DIR__ . '/autoload.php';

// Setup the database
$db = new DatabaseConnection();
$conn = $db->getConnection();

// Define a constant for easy paths
define('URL_ROOT', 'http://localhost/AMS');