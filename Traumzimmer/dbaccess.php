<?php
// Database connection settings
$host = "localhost";
$dbname = "traumzimmerdb";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}
?>