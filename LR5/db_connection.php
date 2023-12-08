<?php
session_start();
try {
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jewelry";

    $dsn = "mysql:host=$hostname;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);

    // Настройка PDO для выброса исключений при ошибке
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}