-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3309
-- Generation Time: Mar 06, 2024 at 03:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking_futsal`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_lapangan`
--

CREATE TABLE `tb_lapangan` (
  `id_lapangan` varchar(50) NOT NULL,
  `nm_lapangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_lapangan`
--

INSERT INTO `tb_lapangan` (`id_lapangan`, `nm_lapangan`) VALUES
('L01', 'Lapangan A'),
('L02', 'Lapangan B');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` varchar(50) NOT NULL,
  `id_waktu` varchar(50) NOT NULL,
  `id_lapangan` varchar(50) NOT NULL,
  `nm_produk` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `ketersediaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id_produk`, `id_waktu`, `id_lapangan`, `nm_produk`, `harga`, `ketersediaan`) VALUES
('P001', 'W01', 'L01', 'Lapangan A 00:00-01:00', 60000, '0'),
('P002', 'W02', 'L01', 'Lapangan A 01:00-02:00', 60000, '0'),
('P003', 'W03', 'L01', 'Lapangan A 02:00-03:00', 60000, '0'),
('P004', 'W04', 'L01', 'Lapangan A 03:00-04:00', 60000, '0'),
('P005', 'W05', 'L01', 'Lapangan A 04:00-05:00', 60000, '0'),
('P006', 'W06', 'L01', 'Lapangan A 05:00-06:00', 60000, '0'),
('P007', 'W07', 'L01', 'Lapangan A 06:00-07:00', 60000, '1'),
('P008', 'W08', 'L01', 'Lapangan A 07:00-08:00', 60000, '1'),
('P009', 'W09', 'L01', 'Lapangan A 08:00-09:00', 60000, '1'),
('P010', 'W10', 'L01', 'Lapangan A 09:00-10:00', 60000, '1'),
('P011', 'W11', 'L01', 'Lapangan A 10:00-11:00', 60000, '1'),
('P012', 'W12', 'L01', 'Lapangan A 11:00-12:00', 60000, '1'),
('P013', 'W13', 'L01', 'Lapangan A 12:00-13:00', 60000, '1'),
('P014', 'W14', 'L01', 'Lapangan A 13:00-14:00', 60000, '1'),
('P015', 'W15', 'L01', 'Lapangan A 14:00-15:00', 60000, '1'),
('P016', 'W16', 'L01', 'Lapangan A 15:00-16:00', 60000, '1'),
('P017', 'W17', 'L01', 'Lapangan A 16:00-17:00', 60000, '1'),
('P018', 'W18', 'L01', 'Lapangan A 17:00-18:00', 60000, '1'),
('P019', 'W19', 'L01', 'Lapangan A 18:00-19:00', 60000, '1'),
('P020', 'W20', 'L01', 'Lapangan A 19:00-20:00', 60000, '1'),
('P021', 'W21', 'L01', 'Lapangan A 20:00-21:00', 60000, '1'),
('P022', 'W22', 'L01', 'Lapangan A 21:00-22:00', 60000, '1'),
('P023', 'W23', 'L01', 'Lapangan A 22:00-23:00', 60000, '1'),
('P024', 'W24', 'L01', 'Lapangan A 23:00-00:00', 60000, '1'),
('P025', 'W01', 'L02', 'Lapangan B 00:00-01:00', 60000, '1'),
('P026', 'W02', 'L02', 'Lapangan B 01:00-02:00', 60000, '1'),
('P027', 'W03', 'L02', 'Lapangan B 02:00-03:00', 60000, '1'),
('P028', 'W04', 'L02', 'Lapangan B 03:00-04:00', 60000, '1'),
('P029', 'W05', 'L02', 'Lapangan B 04:00-05:00', 60000, '1'),
('P030', 'W06', 'L02', 'Lapangan B 05:00-06:00', 60000, '1'),
('P031', 'W07', 'L02', 'Lapangan B 06:00-07:00', 60000, '1'),
('P032', 'W08', 'L02', 'Lapangan B 07:00-08:00', 60000, '1'),
('P033', 'W09', 'L02', 'Lapangan B 08:00-09:00', 60000, '1'),
('P034', 'W10', 'L02', 'Lapangan B 09:00-10:00', 60000, '1'),
('P035', 'W11', 'L02', 'Lapangan B 10:00-11:00', 60000, '1'),
('P036', 'W12', 'L02', 'Lapangan B 11:00-12:00', 60000, '1'),
('P037', 'W13', 'L02', 'Lapangan B 12:00-13:00', 60000, '1'),
('P038', 'W14', 'L02', 'Lapangan B 13:00-14:00', 60000, '1'),
('P039', 'W15', 'L02', 'Lapangan B 14:00-15:00', 60000, '1'),
('P040', 'W16', 'L02', 'Lapangan B 15:00-16:00', 60000, '1'),
('P041', 'W17', 'L02', 'Lapangan B 16:00-17:00', 60000, '1'),
('P042', 'W18', 'L02', 'Lapangan B 17:00-18:00', 60000, '1'),
('P043', 'W19', 'L02', 'Lapangan B 18:00-19:00', 60000, '1'),
('P044', 'W20', 'L02', 'Lapangan B 19:00-20:00', 60000, '1'),
('P045', 'W21', 'L02', 'Lapangan B 20:00-21:00', 60000, '1'),
('P046', 'W22', 'L02', 'Lapangan B 21:00-22:00', 60000, '1'),
('P047', 'W23', 'L02', 'Lapangan B 22:00-23:00', 60000, '1'),
('P048', 'W24', 'L02', 'Lapangan B 23:00-00:00', 60000, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_user` int(11) DEFAULT NULL,
  `id_produk` varchar(50) DEFAULT NULL,
  `ttg_datang` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_user`, `id_produk`, `ttg_datang`) VALUES
(5, 'P001', '0000-00-00'),
(5, 'P001', '0000-00-00'),
(5, 'P001', '0000-00-00'),
(5, 'P001', '0000-00-00'),
(5, 'P001', '2024-01-10'),
(5, 'P001', '2024-01-10'),
(5, 'P002', '2024-01-10'),
(5, 'P003', '2024-01-10'),
(5, 'P004', '2024-01-10'),
(4, 'P007', '2024-01-16'),
(4, 'P008', '2024-01-16');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `no_telp` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `nickname`, `status`, `no_telp`) VALUES
(1, 'admin', '123', 'admin1', 'admin', '089611514897'),
(2, 'admin2', '123', 'admin2', 'admin', '089611514897'),
(3, 'costumer1', '123', 'costumer1', 'customer', '089611514897'),
(4, 'muhammad.irgi.fajri@gmail.com', '$2y$10$bvSuaTjGKbhc1RQ6vT9BaeZ2UKxxrUatFbNWVM1TXLVvmbcktLaom', 'irgi and team', 'customer', '089611112222'),
(5, 'satrioteguhhutomo@gmail.com', '$2y$10$ptI4zd6uqLrzLWPMtoMQeuNZwYWpGHHTCGkayNiQbPjrQrO99fuHS', 'teguh team', 'customer', '089611524394'),
(6, '', '$2y$10$fa5CqMAIVvmHMpPcwZlar.QlaYUtrPHukyEwqvWf0fg0vUXNPdtBi', NULL, 'customer', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_waktu`
--

CREATE TABLE `tb_waktu` (
  `id_waktu` varchar(50) NOT NULL,
  `nm_waktu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_waktu`
--

INSERT INTO `tb_waktu` (`id_waktu`, `nm_waktu`) VALUES
('W01', '00:00-01:00'),
('W02', '01:00-02:00'),
('W03', '02:00-03:00'),
('W04', '03:00-04:00'),
('W05', '04:00-05:00'),
('W06', '05:00-06:00'),
('W07', '06:00-07:00'),
('W08', '07:00-08:00'),
('W09', '08:00-09:00'),
('W10', '09:00-10:00'),
('W11', '10:00-11:00'),
('W12', '11:00-12:00'),
('W13', '12:00-13:00'),
('W14', '13:00-14:00'),
('W15', '14:00-15:00'),
('W16', '15:00-16:00'),
('W17', '16:00-17:00'),
('W18', '17:00-18:00'),
('W19', '18:00-19:00'),
('W20', '19:00-20:00'),
('W21', '20:00-21:00'),
('W22', '21:00-22:00'),
('W23', '22:00-23:00'),
('W24', '23:00-00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_lapangan`
--
ALTER TABLE `tb_lapangan`
  ADD PRIMARY KEY (`id_lapangan`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_waktu` (`id_waktu`),
  ADD KEY `id_lapangan` (`id_lapangan`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tb_waktu`
--
ALTER TABLE `tb_waktu`
  ADD PRIMARY KEY (`id_waktu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD CONSTRAINT `tb_produk_ibfk_1` FOREIGN KEY (`id_waktu`) REFERENCES `tb_waktu` (`id_waktu`),
  ADD CONSTRAINT `tb_produk_ibfk_2` FOREIGN KEY (`id_lapangan`) REFERENCES `tb_lapangan` (`id_lapangan`);

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `tb_transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`),
  ADD CONSTRAINT `tb_transaksi_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `tb_produk` (`id_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
