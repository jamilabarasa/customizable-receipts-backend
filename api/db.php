<?php
$host = 'sql209.infinityfree.com';
$dbname = ' if0_38188415_customizable_receipts';
$username = 'if0_38188415';
$password = ' l7Rvm3OzGmYzt2'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
