<?php
// model/database.php - This basically connects to our database

$host = 'localhost';
$db   = 'weather_app';
$user = 'root';
$pass = ''; // Our current setup does not have a password so we don't need this UNLESS we wanna password protect it.
//Below the code is designed to catch errors if the connection to the database is unsuccessful.
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>