-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Waktu pembuatan: 10 Apr 2026 pada 03.51
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
-- Database: `db_parktrack`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `area`
--

CREATE TABLE `area` (
  `id_kapasitas` int(11) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `terisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `area`
--

INSERT INTO `area` (`id_kapasitas`, `kapasitas`, `terisi`) VALUES
(1, 100, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kartu` char(10) NOT NULL,
  `plat_nomor` varchar(225) NOT NULL,
  `pemilik` varchar(225) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kendaraan`
--

INSERT INTO `kendaraan` (`id_kartu`, `plat_nomor`, `pemilik`, `status_aktif`) VALUES
('361027', 'D 5678 GH', 'Rizky Aprizal', 1),
('4756F06', 'B 1234 CD', 'Wanda Puspa Meycila', 1),
('E7DD6A6', 'F 9012 GH', 'Sandy Artha Wiguna', 1),
('E9BF686', 'AB 3456 IJ', 'Dhea Revalina Putri', 1),
('TEST1', 'B 9236 DH', 'Revianti Nur Aisyah', 0),
('TEST2', 'L 7890 KL', 'Ade Wahyu Ramdani', 0),
('TEST3', 'Z 1122 MN', 'Gio Fadly', 0),
('TEST4', 'B 2365 GH', 'Ayla Pratiwi Mulyakin', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_kartu` char(10) NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `waktu_keluar` datetime DEFAULT NULL,
  `durasi` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `status` enum('Masuk','Keluar','Selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_kartu`, `waktu_masuk`, `waktu_keluar`, `durasi`, `total`, `status`) VALUES
(21, '4756F06', '2026-02-08 08:58:55', '2026-02-08 15:26:06', 7, 14000, 'Selesai'),
(22, '361027', '2026-02-08 09:24:06', '2026-02-08 17:04:47', 8, 16000, 'Selesai'),
(23, 'E7DD6A6', '2026-02-08 11:33:53', '2026-02-08 17:05:24', 6, 12000, 'Selesai'),
(24, 'TEST3', '2026-02-08 11:41:57', '2026-02-08 17:06:09', 6, 12000, 'Selesai'),
(25, 'E7DD6A6', '2026-02-08 15:14:55', '2026-02-08 15:25:24', 1, 2000, 'Selesai'),
(26, '4756F06', '2026-02-08 15:53:58', '2026-02-08 17:05:55', 2, 4000, 'Selesai'),
(28, '4756F06', '2026-02-11 08:04:58', '2026-02-11 08:05:06', 1, 2000, 'Selesai'),
(29, '4756F06', '2026-02-11 08:05:21', '2026-02-11 08:47:49', 1, 2000, 'Selesai'),
(36, '4756F06', '2026-02-13 08:01:08', '2026-02-13 08:01:22', 1, 2000, 'Selesai'),
(42, '361027', '2026-02-21 05:02:33', '2026-02-21 06:35:57', 1, 2000, 'Selesai'),
(43, 'E9BF686', '2026-02-21 05:02:37', '2026-02-21 06:36:06', 1, 2000, 'Selesai'),
(44, 'E9BF686', '2026-02-21 05:02:50', '2026-02-21 06:36:19', 1, 2000, 'Selesai'),
(45, 'TEST2', '2026-02-21 05:03:00', '2026-02-21 06:36:30', 1, 2000, 'Selesai'),
(46, '4756F06', '2026-02-23 09:31:57', '2026-02-23 09:32:26', 1, 2000, 'Selesai'),
(47, '4756F06', '2026-02-23 09:33:25', '2026-02-23 09:33:30', 1, 2000, 'Selesai'),
(48, 'E9BF686', '2026-02-24 10:44:47', '2026-02-24 10:44:56', 1, 2000, 'Selesai'),
(49, '4756F06', '2026-02-24 12:58:23', '2026-02-24 15:08:55', 3, 6000, 'Selesai'),
(50, '361027', '2026-02-24 12:58:43', '2026-02-24 15:09:00', 3, 6000, 'Selesai'),
(51, 'E9BF686', '2026-02-24 12:58:59', '2026-02-24 15:09:05', 3, 6000, 'Selesai'),
(52, 'E9BF686', '2026-02-24 13:01:15', '2026-02-24 13:01:32', 1, 2000, 'Selesai'),
(53, '361027', '2026-02-25 11:54:31', '2026-02-25 11:54:41', 1, 2000, 'Selesai'),
(54, '4756F06', '2026-02-25 11:54:53', '2026-02-25 11:55:00', 1, 2000, 'Selesai'),
(55, 'E7DD6A6', '2026-03-30 11:43:58', '2026-03-30 11:49:08', 1, 2000, 'Selesai'),
(56, '361027', '2026-03-30 11:44:28', '2026-03-30 11:46:04', 1, 2000, 'Selesai'),
(57, '4756F06', '2026-03-30 11:45:05', '2026-03-30 11:45:51', 1, 2000, 'Selesai'),
(58, 'E9BF686', '2026-03-30 11:45:42', '2026-03-30 11:49:00', 1, 2000, 'Selesai'),
(59, '4756F06', '2026-03-30 11:48:24', '2026-03-30 11:48:35', 1, 2000, 'Selesai'),
(60, '4756F06', '2026-03-30 11:54:38', '2026-03-30 11:54:47', 1, 2000, 'Selesai'),
(61, '4756F06', '2026-03-30 11:56:16', '2026-03-30 11:56:29', 1, 2000, 'Selesai'),
(62, 'E7DD6A6', '2026-03-30 11:56:50', '2026-03-30 11:58:57', 1, 2000, 'Selesai'),
(63, 'E7DD6A6', '2026-03-30 12:02:51', '2026-03-30 12:03:02', 1, 2000, 'Selesai'),
(64, 'E9BF686', '2026-03-30 12:33:39', '2026-03-30 12:33:52', 1, 2000, 'Selesai'),
(65, 'E9BF686', '2026-03-30 12:41:28', '2026-03-30 12:41:36', 1, 2000, 'Selesai'),
(66, 'E7DD6A6', '2026-03-30 13:04:24', '2026-03-30 13:04:41', 1, 2000, 'Selesai'),
(67, 'E7DD6A6', '2026-03-30 13:18:48', '2026-03-30 13:19:02', 1, 2000, 'Selesai'),
(68, '361027', '2026-03-30 13:19:37', '2026-03-30 13:27:33', 1, 2000, 'Selesai'),
(69, 'E9BF686', '2026-03-30 13:19:42', '2026-03-30 13:22:31', 1, 2000, 'Selesai'),
(70, '4756F06', '2026-03-30 13:19:48', '2026-03-30 13:20:27', 1, 2000, 'Selesai'),
(71, 'E7DD6A6', '2026-03-30 13:19:52', '2026-03-30 15:22:03', 2, 4000, 'Selesai'),
(72, 'E9BF686', '2026-03-30 13:26:27', '2026-03-30 13:26:42', 1, 2000, 'Selesai'),
(73, '361027', '2026-03-30 13:32:55', '2026-03-30 13:33:07', 1, 2000, 'Selesai'),
(74, '361027', '2026-03-30 13:34:02', '2026-03-30 13:34:26', 1, 2000, 'Selesai'),
(75, '361027', '2026-03-30 13:40:55', '2026-03-30 13:41:40', 1, 2000, 'Selesai'),
(76, '361027', '2026-03-30 13:43:37', '2026-03-30 13:44:00', 1, 2000, 'Selesai'),
(77, '361027', '2026-03-30 15:20:22', '2026-03-30 15:20:45', 1, 2000, 'Selesai'),
(78, '361027', '2026-03-30 15:21:08', '2026-03-30 15:21:09', 1, 2000, 'Selesai'),
(79, 'E7DD6A6', '2026-03-31 07:11:18', '2026-03-31 07:11:30', 1, 2000, 'Selesai'),
(80, 'E7DD6A6', '2026-03-31 07:14:19', '2026-03-31 07:14:21', 1, 2000, 'Selesai'),
(82, 'E9BF686', '2026-03-31 07:24:18', '2026-03-31 07:24:27', 1, 2000, 'Selesai'),
(83, 'E9BF686', '2026-03-31 07:24:54', '2026-03-31 07:25:05', 1, 2000, 'Selesai'),
(84, 'E9BF686', '2026-03-31 07:27:32', '2026-03-31 07:27:41', 1, 2000, 'Selesai'),
(85, 'E9BF686', '2026-03-31 07:29:55', '2026-03-31 07:30:00', 1, 2000, 'Selesai'),
(86, 'E9BF686', '2026-03-31 07:31:48', '2026-03-31 07:32:11', 1, 2000, 'Selesai'),
(87, 'E9BF686', '2026-03-31 07:32:55', '2026-03-31 07:33:10', 1, 2000, 'Selesai'),
(88, 'E9BF686', '2026-03-31 07:33:54', '2026-03-31 07:35:22', 1, 2000, 'Selesai'),
(89, 'E9BF686', '2026-03-31 07:36:22', '2026-03-31 07:36:34', 1, 2000, 'Selesai'),
(90, 'E9BF686', '2026-03-31 07:39:24', '2026-03-31 07:39:41', 1, 2000, 'Selesai'),
(91, 'E9BF686', '2026-03-31 07:41:22', '2026-03-31 07:41:37', 1, 2000, 'Selesai'),
(92, 'E9BF686', '2026-03-31 07:42:47', '2026-03-31 07:42:58', 1, 2000, 'Selesai'),
(93, 'E9BF686', '2026-03-31 07:45:07', '2026-03-31 07:45:17', 1, 2000, 'Selesai'),
(94, 'E9BF686', '2026-03-31 07:46:14', '2026-03-31 07:46:25', 1, 2000, 'Selesai'),
(95, 'E9BF686', '2026-03-31 07:47:04', '2026-03-31 07:47:10', 1, 2000, 'Selesai'),
(96, 'E9BF686', '2026-03-31 08:00:10', '2026-03-31 08:05:16', 1, 2000, 'Selesai'),
(97, '361027', '2026-03-31 08:01:53', '2026-03-31 08:02:08', 1, 2000, 'Selesai'),
(98, 'E9BF686', '2026-03-31 08:05:30', '2026-03-31 08:05:45', 1, 2000, 'Selesai'),
(99, '4756F06', '2026-03-31 08:14:17', '2026-03-31 08:14:27', 1, 2000, 'Selesai'),
(100, '4756F06', '2026-03-31 08:15:09', '2026-03-31 08:15:25', 1, 2000, 'Selesai'),
(101, '4756F06', '2026-03-31 08:15:56', '2026-03-31 08:16:31', 1, 2000, 'Selesai'),
(102, '4756F06', '2026-03-31 08:17:25', '2026-03-31 08:17:40', 1, 2000, 'Selesai'),
(103, '4756F06', '2026-03-31 08:18:18', '2026-03-31 08:18:28', 1, 2000, 'Selesai'),
(104, '4756F06', '2026-03-31 08:19:08', '2026-03-31 08:19:21', 1, 2000, 'Selesai'),
(105, '4756F06', '2026-03-31 08:19:49', '2026-03-31 08:20:10', 1, 2000, 'Selesai'),
(109, 'E9BF686', '2026-04-01 15:28:56', '2026-04-01 15:29:09', 1, 2000, 'Selesai'),
(110, 'E9BF686', '2026-04-01 15:29:53', '2026-04-01 15:30:04', 1, 2000, 'Selesai'),
(111, 'E7DD6A6', '2026-04-01 15:30:15', '2026-04-01 15:30:24', 1, 2000, 'Selesai'),
(112, 'E7DD6A6', '2026-04-01 15:30:32', '2026-04-01 15:33:45', 1, 2000, 'Selesai'),
(113, 'E9BF686', '2026-04-01 15:30:42', '2026-04-01 15:30:52', 1, 2000, 'Selesai'),
(114, 'E9BF686', '2026-04-01 15:33:02', '2026-04-01 15:33:16', 1, 2000, 'Selesai'),
(115, 'E9BF686', '2026-04-01 15:35:52', '2026-04-01 15:43:54', 1, 2000, 'Selesai'),
(116, '4756F06', '2026-04-01 15:48:34', '2026-04-01 15:49:32', 1, 2000, 'Selesai'),
(117, 'E9BF686', '2026-04-02 07:19:29', '2026-04-02 07:19:41', 1, 2000, 'Selesai'),
(118, '361027', '2026-04-02 07:21:02', '2026-04-02 07:21:12', 1, 2000, 'Selesai'),
(121, '4756F06', '2026-04-02 07:57:33', '2026-04-02 07:57:44', 1, 2000, 'Selesai');

--
-- Trigger `transaksi`
--
DELIMITER $$
CREATE TRIGGER `tambah` AFTER INSERT ON `transaksi` FOR EACH ROW BEGIN
	UPDATE area
    SET terisi = terisi + 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `nama_lengkap` varchar(25) NOT NULL,
  `role` enum('Petugas','Admin','Owner') NOT NULL,
  `status_aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_lengkap`, `role`, `status_aktif`) VALUES
(1, 'hisan', '$2y$10$R9e6NWRgT05OTsRmdkDdL.R3fLNArrwwr5caFrc2E6tdyIqdQaAOq', 'Hisan Ramadhan Putra', 'Admin', 1),
(2, 'adit', '$2y$10$xdT0dcalSNFilLIEO4k3hOfsMBeFfPkNDwGxf4SQA7D7WdZQoflYa', 'Adhitya Arip Ramadhan', 'Petugas', 1),
(3, 'yudi', '$2y$10$chwK7m9vGjvJyDRmMPk/HePQ1xku9t3eBQIYW/HmncIo5tL9X/KhO', 'Yudi Kurniawan', 'Owner', 1),
(10, 'dira', '$2y$10$wZRhQC90AWRn9UgkMAfhQ.nVUNihh/f4p94W2j09YydQnoyzZQtQa', 'Andira Althaf Aryaga', 'Admin', 1),
(12, 'iki', '$2y$10$aYC30.8ZAwWRcZZij89gPeDwvvkavf6uy5E3NDZsyNjONW.GLOEiG', 'Rizki Aprizal', 'Petugas', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_kapasitas`);

--
-- Indeks untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kartu`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_kartu` (`id_kartu`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `area`
--
ALTER TABLE `area`
  MODIFY `id_kapasitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_kartu`) REFERENCES `kendaraan` (`id_kartu`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
