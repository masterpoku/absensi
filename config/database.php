<?php
// File: config/database.php
$host = 'localhost'; // Ganti dengan host database Anda
$user = 'root';      // Ganti dengan username database Anda
$password = '';      // Ganti dengan password database Anda
$dbname = 'absensi_mandatera'; // Ganti dengan nama database Anda

// Membuat koneksi
$db = new mysqli($host, $user, $password, $dbname);

// Memeriksa koneksi
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}
?>