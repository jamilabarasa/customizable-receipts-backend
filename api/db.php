<?php
$host = '165.22.66.209';
$dbname = 'customizable';
$username = 'root';
$password = 'customizable2025'; 

try {
    $pdo = new PDO("mysql:host=$host;port=25306;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
