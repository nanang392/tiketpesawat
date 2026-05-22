-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2026 at 06:25 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tiket_pesawat`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pajak_asal`
--

CREATE TABLE `tbl_pajak_asal` (
  `id` int NOT NULL,
  `bandara` varchar(100) NOT NULL,
  `pajak` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_pajak_asal`
--

INSERT INTO `tbl_pajak_asal` (`id`, `bandara`, `pajak`) VALUES
(1, 'Soekarno-Hatta (CGK)', 50000),
(2, 'Husein Sastranegara (BDO)', 30000),
(3, 'Abdul Rachman Saleh (MLG)', 40000),
(4, 'Juanda (SUB)', 40000),
(5, 'Kualanamu (KNO)', 45000),
(6, 'Sultan Hasanuddin (UPG)', 60000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pajak_tujuan`
--

CREATE TABLE `tbl_pajak_tujuan` (
  `id` int NOT NULL,
  `bandara` varchar(100) NOT NULL,
  `pajak` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_pajak_tujuan`
--

INSERT INTO `tbl_pajak_tujuan` (`id`, `bandara`, `pajak`) VALUES
(1, 'Ngurah Rai (DPS)', 80000),
(2, 'Hasanuddin (UPG)', 70000),
(3, 'Inanwatan (INX)', 90000),
(4, 'Sultan Iskandarmuda (BTJ)', 70000),
(5, 'Juanda (SUB)', 65000),
(6, 'Soekarno-Hatta (CGK)', 75000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rute`
--

CREATE TABLE `tbl_rute` (
  `id` int NOT NULL,
  `maskapai` varchar(100) NOT NULL,
  `bandara_asal` varchar(100) NOT NULL,
  `bandara_tujuan` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  `pajak` int NOT NULL,
  `total` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_rute`
--

INSERT INTO `tbl_rute` (`id`, `maskapai`, `bandara_asal`, `bandara_tujuan`, `harga`, `pajak`, `total`, `created_at`) VALUES
(1, 'Garuda Indonesia', 'Abdul Rachman Saleh (MLG)', 'Hasanuddin (UPG)', 500000, 110000, 610000, '2026-05-22 03:12:26'),
(2, 'Lion Air', 'Abdul Rachman Saleh (MLG)', 'Inanwatan (INX)', 450000, 130000, 580000, '2026-05-22 04:03:17'),
(3, 'Garuda Indonesia', 'Husein Sastranegara (BDO)', 'Hasanuddin (UPG)', 400000, 100000, 500000, '2026-05-22 04:06:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_pajak_asal`
--
ALTER TABLE `tbl_pajak_asal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bandara` (`bandara`);

--
-- Indexes for table `tbl_pajak_tujuan`
--
ALTER TABLE `tbl_pajak_tujuan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bandara` (`bandara`);

--
-- Indexes for table `tbl_rute`
--
ALTER TABLE `tbl_rute`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_pajak_asal`
--
ALTER TABLE `tbl_pajak_asal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_pajak_tujuan`
--
ALTER TABLE `tbl_pajak_tujuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_rute`
--
ALTER TABLE `tbl_rute`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
