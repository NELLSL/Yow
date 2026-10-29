<?php
// Update these values if your local MySQL credentials are different.
$host = 'localhost';
$dbname = 'slms_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
         PDO::ATTR_EMULATE_PREPARES => false]
    );
} catch (PDOException $e) {
    exit('Database connection failed. Check config/database.php and import database.sql. Details: ' .
         htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
