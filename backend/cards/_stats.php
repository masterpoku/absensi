<?php
// backend/cards/_stats.php
function getDashboardStats() {
    $sql = "
        SELECT 
            (SELECT COUNT(*) FROM user) AS total_users,
            (SELECT COUNT(*) FROM sekolah) AS total_sekolah,
            (SELECT COUNT(*) FROM devices) AS total_devices,
            (SELECT COUNT(*) FROM transaksi) AS total_transaksi,
            (SELECT COUNT(*) FROM guru) AS total_guru,             -- Count of Teachers
            (SELECT COUNT(*) FROM siswa) AS total_siswa,           -- Count of Students
            (SELECT COUNT(*) FROM mata_pelajaran) AS total_mapel  -- Count of Subjects
    ";

    return fetchAll($sql);
}
// backend/cards/_stats.php
$data = getDashboardStats();

// Periksa apakah ada hasil
if (count($data) > 0) {
    $total_users = $data[0]['total_users'];
    $total_sekolah = $data[0]['total_sekolah'];
    $total_devices = $data[0]['total_devices'];
    $total_transaksi = $data[0]['total_transaksi'];
    $total_guru = $data[0]['total_guru'];  // New variable for Teachers count
    $total_siswa = $data[0]['total_siswa']; // New variable for Students count
    $total_mapel = $data[0]['total_mapel']; // New variable for Subjects count
} else {
    // Tangani error jika tidak ada data
    $total_users = $total_sekolah = $total_devices = $total_transaksi = 0;
    $total_guru = $total_siswa = $total_mapel = 0;
}
?>
<!-- HTML -->
<div class="row">
    <div class="col-lg-12 col-12">
        <div class="row">

            <!-- CARD - Users -->
            <div class="col-lg-3 col-md-3 col-12">
                <div class="card">
                    <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                    <i class="fa fa-users text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    <?php echo $total_users; ?>
                                </h5>
                                <span class="text-white text-sm">Users</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD - Sekolah -->
            <div class="col-lg-3 col-md-3 col-12 mt-4 mt-md-0">
                <div class="card">
                    <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                    <i class="fa fa-school text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    <?php echo $total_sekolah; ?>
                                </h5>
                                <span class="text-white text-sm">Sekolah</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD - Devices -->
            <div class="col-lg-3 col-md-3 col-12 mt-4 mt-md-0">
                <div class="card">
                    <span class="mask bg-danger opacity-10 border-radius-lg"></span>
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                    <i class="fa fa-server text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    <?php echo $total_devices; ?>
                                </h5>
                                <span class="text-white text-sm">Devices</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD - Transaksi -->
            <div class="col-lg-3 col-md-3 col-12 mt-4 mt-md-0">
                <div class="card">
                    <span class="mask bg-secondary opacity-10 border-radius-lg"></span>
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                    <i class="fa fa-exchange text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    <?php echo $total_transaksi; ?>
                                </h5>
                                <span class="text-white text-sm">Transaksi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 mt-4">
            <!-- CARD - Guru (Teachers) -->
            <div class="col-lg-4 col-md-4 col-12">
                <div class="card">
                    <span class="mask bg-danger opacity-10 border-radius-lg"></span>
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                    <i class="fa fa-chalkboard-teacher text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    <?php echo $total_guru; ?>
                                </h5>
                                <span class="text-white text-sm">Guru</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD - Siswa (Students) -->
            <div class="col-lg-4 col-md-4 col-12 mt-4 mt-md-0">
                <div class="card">
                    <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                    <i class="fa fa-graduation-cap text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    <?php echo $total_siswa; ?>
                                </h5>
                                <span class="text-white text-sm">Siswa</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD - Mata Pelajaran (Subjects) -->
            <div class="col-lg-4 col-md-4 col-12 mt-4 mt-md-0">
                <div class="card">
                    <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                    <i class="fa fa-book-open text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    <?php echo $total_mapel; ?>
                                </h5>
                                <span class="text-white text-sm">Mata Pelajaran</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>