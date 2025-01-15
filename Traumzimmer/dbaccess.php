<?php
// Database connection settings
$host = "localhost";
$dbname = "traumzimmerdb";
$username = "root";
$password = "";

// Verbindung mit MySQLi herstellen
$mysqli = new mysqli($host, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich ist
if ($mysqli->connect_error) {
    die("Datenbankverbindung fehlgeschlagen: " . $mysqli->connect_error);
}

// Charset auf UTF-8 setzen
if (!$mysqli->set_charset("utf8mb4")) {
    die("Fehler beim Setzen des Zeichensatzes: " . $mysqli->error);
}
?>