<?php
$host = "localhost"; // Sesuaikan dengan host database Anda
$user = "root"; // Username database
$password = ""; // Password database
$dbname = "brainz_db"; // Nama database

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
