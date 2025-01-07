<?php
// ?table=sekolah	Menampilkan daftar sekolah
// ?table=siswa	Menampilkan siswa beserta nama sekolah
// ?table=guru	Menampilkan guru beserta nama sekolah
// ?table=mata_pelajaran	Menampilkan mata pelajaran dan sekolah
// ?table=jadwal_mata_pelajaran	Menampilkan jadwal lengkap guru, mapel, dan sekolah
// ?table=absensi_harian	Menampilkan absensi harian siswa
// ?table=absensi_mapel	Menampilkan absensi per mata pelajaran
// ?table=devices	Menampilkan data IoT beserta sekolah
// Menggunakan file fungsi yang telah disediakan
require_once $_SERVER['DOCUMENT_ROOT'] . '/absensi/includes/functions.php';

// Cek apakah parameter 'table' diberikan
if (isset($_GET['table'])) {
    $table = $_GET['table'];
    $result = [];

    try {
        switch ($table) {
            case 'sekolah':
                $sql = "SELECT * FROM sekolah";
                $result = fetchAll($sql);
                break;

            case 'siswa':
                $sql = "
                    SELECT s.*, sk.nama_sekolah 
                    FROM siswa s
                    JOIN sekolah sk ON s.id_sekolah = sk.id_sekolah
                ";
                $result = fetchAll($sql);
                break;

            case 'guru':
                $sql = "
                    SELECT g.*, sk.nama_sekolah 
                    FROM guru g
                    JOIN sekolah sk ON g.id_sekolah = sk.id_sekolah
                ";
                $result = fetchAll($sql);
                break;

            case 'mata_pelajaran':
                $sql = "
                    SELECT m.*, sk.nama_sekolah 
                    FROM mata_pelajaran m
                    JOIN sekolah sk ON m.id_sekolah = sk.id_sekolah
                ";
                $result = fetchAll($sql);
                break;

            case 'jadwal_mata_pelajaran':
                $sql = "
                    SELECT j.*, g.nama_guru, m.nama_mapel, sk.nama_sekolah 
                    FROM jadwal_mata_pelajaran j
                    JOIN guru g ON j.id_guru = g.id_guru
                    JOIN mata_pelajaran m ON j.id_mapel = m.id_mapel
                    JOIN sekolah sk ON g.id_sekolah = sk.id_sekolah
                ";
                $result = fetchAll($sql);
                break;

            case 'absensi_harian':
                $sql = "
                    SELECT ah.*, s.nama_siswa, sk.nama_sekolah 
                    FROM absensi_harian ah
                    JOIN siswa s ON ah.id_siswa = s.id_siswa
                    JOIN sekolah sk ON s.id_sekolah = sk.id_sekolah
                ";
                $result = fetchAll($sql);
                break;

            case 'absensi_mapel':
                $sql = "
                    SELECT am.*, s.nama_siswa, j.hari, j.jam_masuk, j.jam_keluar, m.nama_mapel, g.nama_guru 
                    FROM absensi_mapel am
                    JOIN siswa s ON am.id_siswa = s.id_siswa
                    JOIN jadwal_mata_pelajaran j ON am.id_jadwal = j.id_jadwal
                    JOIN mata_pelajaran m ON j.id_mapel = m.id_mapel
                    JOIN guru g ON j.id_guru = g.id_guru
                ";
                $result = fetchAll($sql);
                break;

            case 'devices':
                $sql = "
                    SELECT d.*, sk.nama_sekolah 
                    FROM devices d
                    JOIN sekolah sk ON d.id_sekolah = sk.id_sekolah
                ";
                $result = fetchAll($sql);
                break;
            case 'all':
                $result = [
                    "sekolah" => fetchAll("SELECT * FROM sekolah"),
                    "siswa" => fetchAll("
                        SELECT s.*, sk.nama_sekolah 
                        FROM siswa s
                        JOIN sekolah sk ON s.id_sekolah = sk.id_sekolah
                    "),
                    "guru" => fetchAll("
                        SELECT g.*, sk.nama_sekolah 
                        FROM guru g
                        JOIN sekolah sk ON g.id_sekolah = sk.id_sekolah
                    "),
                    "mata_pelajaran" => fetchAll("
                        SELECT m.*, sk.nama_sekolah 
                        FROM mata_pelajaran m
                        JOIN sekolah sk ON m.id_sekolah = sk.id_sekolah
                    "),
                    "jadwal_mata_pelajaran" => fetchAll("
                        SELECT j.*, g.nama_guru, m.nama_mapel, sk.nama_sekolah 
                        FROM jadwal_mata_pelajaran j
                        JOIN guru g ON j.id_guru = g.id_guru
                        JOIN mata_pelajaran m ON j.id_mapel = m.id_mapel
                        JOIN sekolah sk ON g.id_sekolah = sk.id_sekolah
                    "),
                    "absensi_harian" => fetchAll("
                        SELECT ah.*, s.nama_siswa, sk.nama_sekolah 
                        FROM absensi_harian ah
                        JOIN siswa s ON ah.id_siswa = s.id_siswa
                        JOIN sekolah sk ON s.id_sekolah = sk.id_sekolah
                    "),
                    "absensi_mapel" => fetchAll("
                        SELECT am.*, s.nama_siswa, j.hari, j.jam_masuk, j.jam_keluar, m.nama_mapel, g.nama_guru 
                        FROM absensi_mapel am
                        JOIN siswa s ON am.id_siswa = s.id_siswa
                        JOIN jadwal_mata_pelajaran j ON am.id_jadwal = j.id_jadwal
                        JOIN mata_pelajaran m ON j.id_mapel = m.id_mapel
                        JOIN guru g ON j.id_guru = g.id_guru
                    "),
                    "devices" => fetchAll("
                        SELECT d.*, sk.nama_sekolah 
                        FROM devices d
                        JOIN sekolah sk ON d.id_sekolah = sk.id_sekolah
                    ")
                ];
                break;
                
            default:
                http_response_code(400);
                echo json_encode([
                    "status" => "error",
                    "message" => "Table not recognized"
                ]);
                exit;
        }

        // Mengembalikan hasil dalam format JSON
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "data" => $result
        ]);

    } catch (Exception $e) {
        // Tangani error jika terjadi
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Terjadi kesalahan: " . $e->getMessage()
        ]);
    }
} else {
    // Jika parameter 'table' tidak diberikan
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Parameter 'table' is required"
    ]);
}
?>
