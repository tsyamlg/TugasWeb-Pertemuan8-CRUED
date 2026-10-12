<?php
// Koneksi PDO. Sesuaikan user/password dengan XAMPP/Laragon kamu.
$host = 'localhost';
$db   = 'db_inventaris';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // error jadi exception
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,                    // prepared statement asli
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    error_log($e->getMessage());
    die('Koneksi database gagal. Periksa config/database.php dan pastikan schema.sql sudah diimpor.');
}