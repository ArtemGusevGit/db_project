<?php
$dsn = 'mysql:host=localhost;dbname=myfirstdatabase';
$dbusername = 'root';
$dbpassword = '';

try {
    // Connect to DB by PDO
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}