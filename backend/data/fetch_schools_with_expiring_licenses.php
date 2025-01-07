<?php
// backend/data/fetch_schools_with_expiring_licenses.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/absensi/includes/functions.php';

// Fungsi untuk mendapatkan sekolah dengan lisensi yang akan expired dalam 30 hari
function fetchSchoolsWithExpiringLicenses($limit = null, $offset = null) {
    $sql = "
        SELECT 
            s.id_sekolah,
            s.nama_sekolah,
            s.alamat,
            s.status,
            s.last_updated,
            sub.valid_until,
            DATEDIFF(sub.valid_until, NOW()) AS days_until_expiration
        FROM sekolah s
        JOIN subscription sub ON s.id_sekolah = sub.id_sekolah
        WHERE sub.valid_until BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)
        ORDER BY sub.valid_until ASC
    ";

    $params = [];

    // Pagination jika ada
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

// Ambil data sekolah yang lisensinya akan expired dalam 30 hari
$data = fetchSchoolsWithExpiringLicenses(10, 0); // Ambil 10 data pertama
echo json_encode($data);
?>