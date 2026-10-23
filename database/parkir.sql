-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2026 at 02:49 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_area_parkir`
--

CREATE TABLE `tb_area_parkir` (
  `id_area` int NOT NULL,
  `nama_area` varchar(50) NOT NULL,
  `kapasitas` int NOT NULL,
  `terisi` int DEFAULT '0',
  `status_area` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_area_parkir`
--

INSERT INTO `tb_area_parkir` (`id_area`, `nama_area`, `kapasitas`, `terisi`, `status_area`) VALUES
(1, 'Area A', 5, 0, 'aktif'),
(2, 'Area B', 5, 0, 'aktif'),
(3, 'Area C', 5, 0, 'aktif'),
(4, 'Area D', 5, 0, 'aktif'),
(5, 'Area E', 5, 0, 'aktif'),
(6, 'Area F', 5, 1, 'aktif'),
(7, 'Area G', 5, 2, 'aktif'),
(8, 'Area H', 5, 0, 'aktif'),
(9, 'Area I', 5, 0, 'nonaktif'),
(10, 'Area z', 5, 0, 'nonaktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kendaraan`
--

CREATE TABLE `tb_kendaraan` (
  `id_kendaraan` int NOT NULL,
  `plat_nomor` varchar(15) NOT NULL,
  `jenis_kendaraan` varchar(20) NOT NULL,
  `warna` varchar(20) NOT NULL,
  `pemilik` varchar(100) NOT NULL,
  `id_user` int NOT NULL,
  `status_kendaraan` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_kendaraan`
--

INSERT INTO `tb_kendaraan` (`id_kendaraan`, `plat_nomor`, `jenis_kendaraan`, `warna`, `pemilik`, `id_user`, `status_kendaraan`) VALUES
(1, 'B 1234 ABC', 'motor', 'Hitam', 'fitrip', 2, 'nonaktif'),
(2, 'B 5678 DEF', 'mobil', 'Putih', 'zahra', 3, 'aktif'),
(3, 'D 1122 GHI', 'motor', 'Merah', 'wijaya', 4, 'aktif'),
(4, 'D 3344 JKL', 'mobil', 'Hitam', 'Rina', 5, 'aktif'),
(5, 'B 7788 MNO', 'motor', 'Biru', 'Fajar ', 7, 'aktif'),
(6, 'F 9900 PQR', 'mobil', 'Silver', 'Dimas P', 8, 'aktif'),
(7, 'B 2468 STU', 'motor', 'Putih', 'Nanda Putri', 9, 'aktif'),
(8, 'D 1357 VWX', 'mobil', 'Merah', 'Rizky Maulana', 10, 'aktif'),
(9, 'B 4321 YZA', 'motor', 'Abu-abu', 'Budi Santoso', 2, 'aktif'),
(10, 'F 8642 BCD', 'mobil', 'Hitam', 'Siti Aminah', 3, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_aktivitas`
--

CREATE TABLE `tb_log_aktivitas` (
  `id_log` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `aktivitas` varchar(100) NOT NULL,
  `waktu_aktivitas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_log_aktivitas`
--

INSERT INTO `tb_log_aktivitas` (`id_log`, `id_user`, `aktivitas`, `waktu_aktivitas`) VALUES
(1, 2, 'Login ke sistem', '2026-09-01 06:55:00'),
(2, 3, 'Input transaksi parkir', '2026-09-01 07:25:00'),
(3, 4, 'Input transaksi parkir', '2026-09-01 07:55:00'),
(4, 5, 'Input transaksi parkir', '2026-09-01 08:25:00'),
(5, NULL, 'Input kendaraan', '2026-09-01 08:55:00'),
(6, NULL, 'Input transaksi parkir', '2026-09-01 09:25:00'),
(7, NULL, 'Input transaksi parkir', '2026-09-01 09:55:00'),
(8, NULL, 'Input kendaraan', '2026-09-01 10:25:00'),
(9, 2, 'Kendaraan keluar', '2026-09-01 10:55:00'),
(10, 3, 'Kendaraan masuk', '2026-09-01 11:25:00'),
(11, 3, 'Login ke sistem', '2026-10-09 07:33:46'),
(12, 3, 'Logout sebagai Petugas', '2026-10-09 07:34:51'),
(13, 3, 'Login ke sistem', '2026-10-09 07:34:58'),
(14, 3, 'Logout sebagai Petugas', '2026-10-09 07:35:00'),
(15, 3, 'Login ke sistem', '2026-10-09 08:31:28'),
(16, 3, 'Logout sebagai Petugas', '2026-10-09 08:44:06'),
(17, 3, 'Login ke sistem', '2026-10-09 08:51:54'),
(18, 3, 'Logout sebagai Petugas', '2026-10-09 09:18:24'),
(19, 1, 'Login ke sistem', '2026-10-09 09:18:50'),
(20, 3, 'Login ke sistem', '2026-10-09 09:23:18'),
(21, 3, 'Logout sebagai Petugas', '2026-10-09 09:31:52'),
(22, 1, 'Login ke sistem', '2026-10-10 19:02:26'),
(23, 3, 'Login ke sistem', '2026-10-10 19:02:52'),
(24, 3, 'Logout sebagai Petugas', '2026-10-10 19:10:58'),
(25, 1, 'Login ke sistem', '2026-10-10 19:11:45'),
(26, 1, 'Login ke sistem', '2026-10-19 10:19:28'),
(27, 3, 'Login ke sistem', '2026-10-19 11:19:43'),
(28, 3, 'Logout sebagai Petugas', '2026-10-19 11:26:33'),
(29, 1, 'Login ke sistem', '2026-10-19 11:26:51');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tarif`
--

CREATE TABLE `tb_tarif` (
  `id_tarif` int NOT NULL,
  `jenis_kendaraan` enum('motor','mobil','lainnya') NOT NULL,
  `tarif_per_jam` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_tarif`
--

INSERT INTO `tb_tarif` (`id_tarif`, `jenis_kendaraan`, `tarif_per_jam`) VALUES
(1, 'motor', 1500),
(2, 'mobil', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_parkir` int NOT NULL,
  `id_kendaraan` int NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `waktu_keluar` datetime DEFAULT NULL,
  `id_tarif` int NOT NULL,
  `durasi_jam` int DEFAULT '0',
  `biaya_total` decimal(10,0) DEFAULT '0',
  `status` enum('masuk','keluar') DEFAULT 'masuk',
  `id_user` int DEFAULT NULL,
  `id_area` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_parkir`, `id_kendaraan`, `waktu_masuk`, `waktu_keluar`, `id_tarif`, `durasi_jam`, `biaya_total`, `status`, `id_user`, `id_area`) VALUES
(1, 1, '2026-09-01 07:00:00', '2026-09-30 08:57:18', 1, 698, 1047000, 'keluar', 2, 1),
(2, 2, '2026-09-01 07:30:00', '2026-10-02 07:57:42', 2, 745, 3725000, 'keluar', 3, 2),
(3, 3, '2026-09-01 08:00:00', '2026-09-01 11:00:00', 1, 3, 9000, 'keluar', 4, 3),
(4, 4, '2026-09-01 08:30:00', '2026-09-01 12:30:00', 2, 4, 20000, 'keluar', 5, 4),
(5, 5, '2026-09-01 09:00:00', '2026-09-01 11:00:00', 1, 2, 6000, 'keluar', NULL, 5),
(6, 6, '2026-09-01 09:30:00', '2026-09-01 14:30:00', 2, 5, 25000, 'keluar', NULL, 6),
(7, 7, '2026-09-01 10:00:00', '2026-09-01 13:00:00', 1, 3, 9000, 'keluar', NULL, 7),
(8, 8, '2026-09-01 10:30:00', '2026-09-01 14:30:00', 2, 4, 20000, 'keluar', NULL, 8),
(9, 9, '2026-09-01 11:00:00', '2026-09-29 05:19:45', 1, 667, 1000500, 'keluar', 2, 9),
(10, 10, '2026-09-01 11:30:00', '2026-09-29 05:19:53', 2, 666, 3330000, 'keluar', 3, 10),
(11, 5, '2026-09-25 00:18:57', '2026-09-29 05:26:51', 1, 102, 153000, 'keluar', 5, 3),
(12, 5, '2026-09-29 12:50:40', '2026-09-29 12:51:15', 1, 1, 1500, 'keluar', 3, 2),
(13, 1, '2026-09-29 12:51:42', '2026-09-29 12:51:48', 1, 1, 1500, 'keluar', 4, 8),
(14, 7, '2026-10-01 11:29:47', '2026-10-01 11:29:58', 1, 1, 1500, 'keluar', NULL, 7),
(15, 1, '2026-10-02 06:55:31', '2026-10-07 07:05:37', 1, 121, 181500, 'keluar', 4, 3),
(16, 7, '2026-10-02 07:17:29', '2026-10-09 08:43:54', 1, 170, 255000, 'keluar', NULL, 6),
(17, 4, '2026-10-02 07:55:53', '2026-10-09 08:51:59', 2, 169, 845000, 'keluar', 5, 6),
(18, 2, '2026-10-07 07:05:30', '2026-10-09 09:32:04', 2, 51, 255000, 'keluar', 5, 10),
(19, 10, '2026-10-09 08:43:42', '2026-10-09 09:35:48', 2, 1, 5000, 'keluar', 4, 10),
(20, 9, '2026-10-09 09:23:39', '2026-10-09 09:36:13', 1, 1, 1500, 'keluar', 5, 5),
(21, 7, '2026-10-09 09:38:10', '2026-10-09 20:40:02', 1, 12, 18000, 'keluar', 5, 9),
(22, 6, '2026-10-09 09:38:38', '2026-10-10 19:09:31', 2, 34, 170000, 'keluar', 4, 10),
(23, 3, '2026-10-09 20:39:51', NULL, 1, 0, 0, 'masuk', 4, 6),
(24, 2, '2026-10-10 19:03:05', NULL, 2, 0, 0, 'masuk', 4, 7),
(25, 10, '2026-10-10 19:03:34', NULL, 2, 0, 0, 'masuk', 5, 7),
(26, 9, '2026-10-19 11:20:09', '2026-10-19 11:24:01', 1, 1, 1500, 'keluar', 4, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','petugas','owner') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status_aktif` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_lengkap`, `username`, `password`, `role`, `status_aktif`) VALUES
(1, 'zahra alia', 'zahra', 'admin123', 'admin', 1),
(2, 'Budi Santoso', 'budi', 'budi123', 'owner', 1),
(3, 'Siti ropeah', 'siti', 'siti123', 'petugas', 1),
(4, 'Andi Wijayaanto', 'andi', 'andi123', 'petugas', 1),
(5, 'Rina Lestari', 'rina', 'rina123', 'petugas', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_area_parkir`
--
ALTER TABLE `tb_area_parkir`
  ADD PRIMARY KEY (`id_area`);

--
-- Indexes for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `tb_log_aktivitas_ibfk_1` (`id_user`);

--
-- Indexes for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_parkir`),
  ADD KEY `id_kendaraan` (`id_kendaraan`),
  ADD KEY `id_tarif` (`id_tarif`),
  ADD KEY `id_area` (`id_area`),
  ADD KEY `tb_transaksi_ibfk_3` (`id_user`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_area_parkir`
--
ALTER TABLE `tb_area_parkir`
  MODIFY `id_area` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  MODIFY `id_kendaraan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  MODIFY `id_log` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  MODIFY `id_tarif` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id_parkir` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD CONSTRAINT `tb_log_aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `tb_transaksi_ibfk_1` FOREIGN KEY (`id_kendaraan`) REFERENCES `tb_kendaraan` (`id_kendaraan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_ibfk_2` FOREIGN KEY (`id_tarif`) REFERENCES `tb_tarif` (`id_tarif`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_ibfk_4` FOREIGN KEY (`id_area`) REFERENCES `tb_area_parkir` (`id_area`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
