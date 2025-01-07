<?php
// backend/data/fetch_schools_with_users.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/absensi/includes/functions.php';

// Fetch data sekolah beserta informasi user yang terkait
function fetchSchoolsWithUsers($limit = null, $offset = null, $search = null) {
    $sql = "
        SELECT 
            s.id_sekolah,
            s.nama_sekolah,
            s.alamat,
            s.status,
            s.last_updated,
            u.id_user,
            u.username,
            u.nama AS user_nama,
            u.email
        FROM sekolah s
        LEFT JOIN subscription sub ON s.id_subscription = sub.id_subscription
        LEFT JOIN user u ON sub.id_user = u.id_user
        WHERE 1 = 1
    ";

    $params = [];
    
    // Tambahkan kondisi pencarian jika ada
    if (!empty($search)) {
        $sql .= " AND (s.nama_sekolah LIKE ? OR s.alamat LIKE ?)";
        $params[] = '%' . $search . '%';
        $params[] = '%' . $search . '%';
    }

    // Tambahkan pagination jika $limit tidak null
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

// Ambil parameter dari query string
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : null;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;

// Ambil data sekolah dengan informasi user terkait
$data = fetchSchoolsWithUsers($limit, $offset, $search);

// Output data dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);