<?php

$db = 'ams_db';
$host = 'localhost';
$user = 'root';
$password = '';


$conn = new mysqli ($host, $user, $password, $db);

if($conn-> connect_errno){
    echo "Failed to connect to DB: " . $conn -> connect_error;
    exit();
}