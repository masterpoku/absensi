-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Des 2024 pada 18.08
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_mandatera`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_harian`
--

CREATE TABLE `absensi_harian` (
  `id_absensi_harian` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Tidak Hadir','Izin','Sakit','Terlambat') NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi_harian`
--

INSERT INTO `absensi_harian` (`id_absensi_harian`, `id_siswa`, `tanggal`, `status`, `keterangan`) VALUES
(1, 1, '2024-12-25', 'Hadir', ''),
(2, 2, '2024-12-25', 'Sakit', 'Demam tinggi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_mapel`
--

CREATE TABLE `absensi_mapel` (
  `id_absensi_mapel` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Tidak Hadir','Izin','Sakit','Terlambat') NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi_mapel`
--

INSERT INTO `absensi_mapel` (`id_absensi_mapel`, `id_jadwal`, `id_siswa`, `tanggal`, `status`, `keterangan`) VALUES
(1, 1, 1, '2024-12-25', 'Hadir', ''),
(2, 2, 2, '2024-12-25', 'Tidak Hadir', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `devices`
--

CREATE TABLE `devices` (
  `id_device` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `nama_device` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `status` enum('Aktif','Non-Aktif') NOT NULL DEFAULT 'Non-Aktif',
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `devices`
--

INSERT INTO `devices` (`id_device`, `id_sekolah`, `nama_device`, `api_key`, `status`, `last_updated`) VALUES
(1, 1, 'ABSEN1', 'abcd1234', 'Aktif', '2024-12-25 22:10:07'),
(2, 1, 'ABSEN2', 'efgh5678', 'Non-Aktif', '2024-12-25 22:10:13'),
(3, 2, 'ABSEN3', 'ijkl9012', 'Aktif', '2024-12-25 22:10:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `nama_guru` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id_guru`, `id_sekolah`, `nama_guru`) VALUES
(1, 1, 'Pak Rahmat'),
(2, 2, 'Bu Siti');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_mata_pelajaran`
--

CREATE TABLE `jadwal_mata_pelajaran` (
  `id_jadwal` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat') NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_mata_pelajaran`
--

INSERT INTO `jadwal_mata_pelajaran` (`id_jadwal`, `id_mapel`, `id_guru`, `kelas`, `hari`, `jam_masuk`, `jam_keluar`) VALUES
(1, 1, 1, '10A', 'Senin', '08:00:00', '09:30:00'),
(2, 2, 1, '10B', 'Selasa', '10:00:00', '11:30:00'),
(3, 3, 2, '11A', 'Rabu', '13:00:00', '14:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id_mapel` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `nama_mapel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id_mapel`, `id_sekolah`, `nama_mapel`) VALUES
(1, 1, 'Matematika'),
(2, 1, 'Fisika'),
(3, 2, 'Biologi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `package`
--

CREATE TABLE `package` (
  `id_package` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `masa_aktif` int(11) NOT NULL COMMENT 'Durasi masa aktif dalam hari',
  `status` tinyint(1) DEFAULT 1 COMMENT '1: Aktif, 0: Tidak Aktif',
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sekolah`
--

CREATE TABLE `sekolah` (
  `id_sekolah` int(11) NOT NULL,
  `nama_sekolah` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `id_subscription` int(11) DEFAULT NULL COMMENT 'ID dari tabel subscription',
  `status` tinyint(1) DEFAULT 1 COMMENT '1: Aktif, 0: Tidak Aktif',
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Waktu terakhir diperbarui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sekolah`
--

INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `alamat`, `id_subscription`, `status`, `last_updated`) VALUES
(1, 'Sekolah ABC', 'Jl. Merdeka No. 123', NULL, 1, '2024-12-25 17:08:06'),
(2, 'Sekolah XYZ', 'Jl. Sudirman No. 456', NULL, 1, '2024-12-25 17:08:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `kelas` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `id_sekolah`, `nama_siswa`, `kelas`) VALUES
(1, 1, 'Budi Santoso', '10A'),
(2, 1, 'Ani Wijaya', '10B'),
(3, 2, 'Citra Larasati', '11A');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subscription`
--

CREATE TABLE `subscription` (
  `id_subscription` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL COMMENT 'ID sekolah yang berlangganan',
  `id_user` int(11) NOT NULL COMMENT 'ID user yang mengelola langganan',
  `id_package` int(11) NOT NULL COMMENT 'ID paket langganan',
  `valid_until` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Tanggal berakhirnya langganan',
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Waktu terakhir diperbarui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'ID dari user',
  `package_id` int(11) NOT NULL COMMENT 'ID dari package',
  `order_id` varchar(100) NOT NULL COMMENT 'ID order dari payment gateway',
  `total_amount` decimal(10,2) NOT NULL COMMENT 'Jumlah total transaksi',
  `status` varchar(50) NOT NULL COMMENT 'Status transaksi (pending, sukses, gagal, dll.)',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Waktu transaksi dibuat',
  `expiry_time` datetime DEFAULT NULL COMMENT 'Waktu kadaluwarsa transaksi',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Waktu terakhir transaksi diperbarui',
  `payment_type` varchar(50) DEFAULT NULL COMMENT 'Tipe pembayaran (bank_transfer, e-wallet, dll.)',
  `transaction_id` varchar(100) DEFAULT NULL COMMENT 'ID transaksi dari payment gateway',
  `signature_key` varchar(255) DEFAULT NULL COMMENT 'Key untuk validasi transaksi',
  `snap_token` varchar(255) DEFAULT NULL COMMENT 'Token untuk Snap Midtrans'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `level` enum('admin','sekolah','guru') NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `login_ip` varchar(45) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `nama`, `level`, `status`, `login_ip`, `last_login`, `last_updated`, `created_date`) VALUES
(1, 'admin', 'hashed_password_1', 'admin@example.com', 'Administrator', 'admin', 1, '192.168.1.1', '2024-12-26 00:02:03', '2024-12-25 17:02:03', '2024-12-25 17:02:03'),
(2, 'guru1', 'hashed_password_2', 'guru1@example.com', 'Guru 1', 'guru', 1, '192.168.1.2', '2024-12-26 00:02:03', '2024-12-25 17:02:03', '2024-12-25 17:02:03'),
(3, 'sekolah1', 'hashed_password_3', 'sekolah1@example.com', 'Sekolah 1', 'sekolah', 1, '192.168.1.3', '2024-12-26 00:02:03', '2024-12-25 17:02:03', '2024-12-25 17:02:03');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi_harian`
--
ALTER TABLE `absensi_harian`
  ADD PRIMARY KEY (`id_absensi_harian`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `absensi_mapel`
--
ALTER TABLE `absensi_mapel`
  ADD PRIMARY KEY (`id_absensi_mapel`),
  ADD KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id_device`),
  ADD UNIQUE KEY `api_key` (`api_key`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indeks untuk tabel `jadwal_mata_pelajaran`
--
ALTER TABLE `jadwal_mata_pelajaran`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id_mapel`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indeks untuk tabel `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id_package`);

--
-- Indeks untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id_sekolah`),
  ADD KEY `id_subscription` (`id_subscription`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indeks untuk tabel `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id_subscription`),
  ADD KEY `id_sekolah` (`id_sekolah`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_package` (`id_package`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi_harian`
--
ALTER TABLE `absensi_harian`
  MODIFY `id_absensi_harian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `absensi_mapel`
--
ALTER TABLE `absensi_mapel`
  MODIFY `id_absensi_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `devices`
--
ALTER TABLE `devices`
  MODIFY `id_device` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jadwal_mata_pelajaran`
--
ALTER TABLE `jadwal_mata_pelajaran`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `package`
--
ALTER TABLE `package`
  MODIFY `id_package` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id_sekolah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id_subscription` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi_harian`
--
ALTER TABLE `absensi_harian`
  ADD CONSTRAINT `absensi_harian_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);

--
-- Ketidakleluasaan untuk tabel `absensi_mapel`
--
ALTER TABLE `absensi_mapel`
  ADD CONSTRAINT `absensi_mapel_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_mata_pelajaran` (`id_jadwal`),
  ADD CONSTRAINT `absensi_mapel_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);

--
-- Ketidakleluasaan untuk tabel `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`);

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`);

--
-- Ketidakleluasaan untuk tabel `jadwal_mata_pelajaran`
--
ALTER TABLE `jadwal_mata_pelajaran`
  ADD CONSTRAINT `jadwal_mata_pelajaran_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id_mapel`),
  ADD CONSTRAINT `jadwal_mata_pelajaran_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`);

--
-- Ketidakleluasaan untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD CONSTRAINT `mata_pelajaran_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`);

--
-- Ketidakleluasaan untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD CONSTRAINT `sekolah_ibfk_1` FOREIGN KEY (`id_subscription`) REFERENCES `subscription` (`id_subscription`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`);

--
-- Ketidakleluasaan untuk tabel `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscription_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscription_ibfk_3` FOREIGN KEY (`id_package`) REFERENCES `package` (`id_package`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `package` (`id_package`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
