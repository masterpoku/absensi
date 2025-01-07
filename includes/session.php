<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php"; 

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: " . $base_url . "auth"); // Alihkan ke halaman login jika belum login
    exit();
}

// Ambil ID pengguna dari session
$user_id = $_SESSION['user_id'];

// Query untuk mengambil informasi pengguna dari database berdasarkan user_id
$sql = "SELECT * FROM users WHERE id = ?";
$params = [$user_id];
$user = fetchAll($sql, $params);

// Cek apakah pengguna ditemukan
if (!$user) {
    // Jika pengguna tidak ditemukan, hapus session dan alihkan ke halaman login
    session_destroy();
    header("Location: " . $base_url . "auth");
    exit();
}

// Ambil informasi pengguna dari hasil query
$username = $user[0]['username'];
$name = $user[0]['name'];
$level = $user[0]['level'];
$status = $user[0]['status'];
$id_user_login = $user[0]['id'];
$last_login_time = $user[0]['last_login_time'] ?? 'Belum ada';
$last_login_ip = $user[0]['last_login_ip'] ?? 'Belum ada';

?>