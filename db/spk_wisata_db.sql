-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2021 at 04:49 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_wisata_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', '1234admin');

-- --------------------------------------------------------

--
-- Table structure for table `daftar_kriteria`
--

CREATE TABLE `daftar_kriteria` (
  `id` int(10) NOT NULL,
  `kriteria` varchar(20) NOT NULL,
  `sub1` varchar(20) NOT NULL,
  `sub2` varchar(20) NOT NULL,
  `sub3` varchar(20) NOT NULL,
  `sub4` varchar(30) NOT NULL,
  `sub5` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_kriteria_static`
--

CREATE TABLE `daftar_kriteria_static` (
  `id` int(20) NOT NULL,
  `kriteria` varchar(30) NOT NULL,
  `sub1` varchar(30) NOT NULL,
  `sub2` varchar(30) NOT NULL,
  `sub3` varchar(30) NOT NULL,
  `batas1` varchar(20) NOT NULL,
  `batas2` varchar(20) NOT NULL,
  `batas3` varchar(20) NOT NULL,
  `kategori` varchar(10) NOT NULL,
  `sub4` varchar(30) NOT NULL,
  `sub5` varchar(30) NOT NULL,
  `batas4` varchar(20) NOT NULL,
  `batas5` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_kriteria_static`
--

INSERT INTO `daftar_kriteria_static` (`id`, `kriteria`, `sub1`, `sub2`, `sub3`, `batas1`, `batas2`, `batas3`, `kategori`, `sub4`, `sub5`, `batas4`, `batas5`) VALUES
(68, 'Harga', 'Murah', 'Mahal', '', '10000', '20000', '0', 'fuzzy', '', '', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `input_user_tb`
--

CREATE TABLE `input_user_tb` (
  `id` int(20) NOT NULL,
  `kriteria` varchar(20) NOT NULL,
  `sub1` varchar(20) NOT NULL,
  `sub2` varchar(20) NOT NULL,
  `sub3` varchar(20) NOT NULL,
  `sub4` varchar(20) NOT NULL,
  `sub5` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `setting_tampilan`
--

CREATE TABLE `setting_tampilan` (
  `link_gambar` varchar(500) NOT NULL,
  `warna_bg` varchar(30) NOT NULL,
  `nama_wilayah` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_tampilan`
--

INSERT INTO `setting_tampilan` (`link_gambar`, `warna_bg`, `nama_wilayah`) VALUES
('https://kamini.id/wp-content/uploads/2020/12/macam-macam-warna-biru_thumbnail-Copy.jpg', 'white', 'by HDM Vision');

-- --------------------------------------------------------

--
-- Table structure for table `tempat_wisata_tb`
--

CREATE TABLE `tempat_wisata_tb` (
  `obyek_wisata` varchar(30) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_kriteria`
--
ALTER TABLE `daftar_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daftar_kriteria_static`
--
ALTER TABLE `daftar_kriteria_static`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `input_user_tb`
--
ALTER TABLE `input_user_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempat_wisata_tb`
--
ALTER TABLE `tempat_wisata_tb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_kriteria`
--
ALTER TABLE `daftar_kriteria`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `daftar_kriteria_static`
--
ALTER TABLE `daftar_kriteria_static`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `input_user_tb`
--
ALTER TABLE `input_user_tb`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT for table `tempat_wisata_tb`
--
ALTER TABLE `tempat_wisata_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
