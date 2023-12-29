-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2021 at 02:02 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vsga_shendy`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_pendaftaran`
--

CREATE TABLE `data_pendaftaran` (
  `pendaftaran_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pendidikan_terakhir` varchar(255) DEFAULT NULL,
  `pas_foto` varchar(255) DEFAULT NULL,
  `ijazah` varchar(255) DEFAULT NULL,
  `surat_pernyataan` varchar(255) DEFAULT NULL,
  `status_pendaftaran` enum('Diterima','Cadangan','Tidak Diterima','Menunggu') NOT NULL DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_pendaftaran`
--

INSERT INTO `data_pendaftaran` (`pendaftaran_id`, `user_id`, `pendidikan_terakhir`, `pas_foto`, `ijazah`, `surat_pernyataan`, `status_pendaftaran`) VALUES
(19, 7, 'SMP / MTs', 'pas_foto_19.jpg', 'ijazah_19.pdf', 'surat_pernyataan_19.pdf', 'Diterima');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nisn` varchar(16) DEFAULT NULL,
  `email` varchar(16) NOT NULL,
  `jenis_kelamin` enum('P','L') DEFAULT NULL,
  `no_telepon` int(11) NOT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `agama` varchar(11) DEFAULT NULL,
  `nama_ortu` varchar(255) DEFAULT NULL,
  `no_telepon_ortu` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 0,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `nama`, `nisn`, `email`, `jenis_kelamin`, `no_telepon`, `tempat_lahir`, `tgl_lahir`, `agama`, `nama_ortu`, `no_telepon_ortu`, `password`, `role`, `alamat`) VALUES
(4, 'aaaa', '12345', 'admin@admin.com', 'P', 81910278, '', '0000-00-00', '', '', 0, '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 0, NULL),
(6, 'xxxx', '12345', 'admin@pladi.com', 'P', 122222, '', '0000-00-00', '', '', 0, '$2y$10$Rwjd/SxRz3ION8A47a3e2O/5YVSI24Um830piRChY8TI7DDHclEgW', 1, NULL),
(7, 'aaaa', '12345', 'test@test.com', 'L', 22222, 'Bandung', '2004-12-08', 'Islam', 'paldi', 2222, '$2y$10$rJIJ/3YwiNKeFMm.KOSZ0.dSE70pcVXH5lUq2b19DRIi8yiOiKeWO', 0, 'JALAN GARU 8 NO 17 BABAKANSARI KIARACONDONG BANDUNG KOTA BANDUNG JAWA BARAT'),
(8, 'Aku Siapa', '112223333', 'aku.siapa@coba.c', NULL, 12344551, NULL, NULL, NULL, NULL, NULL, '$2y$10$cMZBhYJ4MinjPvASv3m0Uu6CC3Vvt4stEzlqTCu6iis8FB6XwFtP6', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_pendaftaran`
--
ALTER TABLE `data_pendaftaran`
  ADD PRIMARY KEY (`pendaftaran_id`),
  ADD KEY `user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_pendaftaran`
--
ALTER TABLE `data_pendaftaran`
  MODIFY `pendaftaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_pendaftaran`
--
ALTER TABLE `data_pendaftaran`
  ADD CONSTRAINT `user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
