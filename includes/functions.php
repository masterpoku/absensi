<?php
// session_start();
// File: includes/functions.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/absensi/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/absensi/config/siteconfig.php';
function fetchOne($sql, $params = []) {
    global $db; // Tambahkan ini untuk mengakses variabel $db
    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        return handleError("Prepare Error: " . $db->error);
    }
    $stmt->execute($params);
    return $stmt->fetch_column(); // Mengambil satu kolom dari hasil
}
function fetchAll($sql, $params = []) {
    global $db;

    // Siapkan statement
    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        return handleError("Prepare Error: " . $db->error);
    }

    // Mengikat parameter jika ada
    if ($params) {
        $types = ''; // Awal tanpa tipe
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i'; // Integer
            } elseif (is_float($param)) {
                $types .= 'd'; // Double
            } elseif (is_string($param)) {
                $types .= 's'; // String
            } else {
                $types .= 'b'; // Blob (default)
            }
        }
        $stmt->bind_param($types, ...$params);
    }

    // Eksekusi statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek hasil
    if ($result === false) {
        return handleError("Query Error: " . $db->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi tambahan untuk menambahkan limit dan offset
function fetchWithLimit($sql, $params = [], $limit = null, $offset = null) {
    if ($limit !== null) {
        $sql .= " LIMIT ?";
        $params[] = $limit;

        if ($offset !== null) {
            $sql .= " OFFSET ?";
            $params[] = $offset;
        }
    }
    
    return fetchAll($sql, $params);
}

function executePrepared($sql, $params = []) {
    global $db;
    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        return handleError("Prepare Error: " . $db->error);
    }

    if ($params) {
        // Tentukan tipe parameter
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }

    return $stmt->execute();
}

function sanitizeInput($input) {
    global $db;
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }
    return htmlspecialchars($db->real_escape_string($input));
}

function validateInput($input, $type) {
    switch ($type) {
        case 'string':
            return filter_var($input, FILTER_SANITIZE_STRING);
        case 'email':
            return filter_var($input, FILTER_SANITIZE_EMAIL);
        case 'url':
            return filter_var($input, FILTER_SANITIZE_URL);
        default:
            return $input;
    }
}

function handleError($message) {
    error_log($message);
    return "Terjadi kesalahan. Silakan coba lagi.";
}

function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function getTotalPages($sql, $params = [], $limit) {
    global $db;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        return handleError("Prepare Error: " . $db->error);
    }

    // Mengikat parameter jika ada
    if ($params) {
        $types = str_repeat('s', count($params)); // Asumsi semua parameter adalah string
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $totalItems = $result->fetch_row()[0]; // Ambil total item

    return ceil($totalItems / $limit); // Hitung total halaman
}
?>