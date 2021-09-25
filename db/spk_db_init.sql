-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2021 at 04:45 PM
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

--
-- Dumping data for table `daftar_kriteria`
--

INSERT INTO `daftar_kriteria` (`id`, `kriteria`, `sub1`, `sub2`, `sub3`, `sub4`, `sub5`) VALUES
(149, 'Jenis', 'Alam', 'Sosial_Budaya', 'Religi_Sejarah', '', ''),
(150, 'Harga', 'Murah', 'Sedang', 'Mahal', '', ''),
(151, 'Jarak', 'Dekat', 'Sedang', 'Jauh', '', ''),
(152, 'Fasilitas', 'Sedikit', 'Cukup', 'Banyak', '', ''),
(164, 'Pengunjung', 'Sepi', 'Biasa', 'Ramai', '', '');

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
(82, 'Jenis', 'Alam', 'Sosial_Budaya', 'Religi_Sejarah', '0', '0', '0', 'non_fuzzy', '', '', '0', '0'),
(83, 'Harga', 'Murah', 'Sedang', 'Mahal', '10000', '25000', '50000', 'fuzzy', '', '', '0', '0'),
(84, 'Jarak', 'Dekat', 'Sedang', 'Jauh', '5', '10', '20', 'fuzzy', '', '', '0', '0'),
(85, 'Fasilitas', 'Sedikit', 'Cukup', 'Banyak', '5', '10', '20', 'fuzzy', '', '', '0', '0'),
(86, 'Pengunjung', 'Sepi', 'Biasa', 'Ramai', '1000', '4500', '10000', 'fuzzy', '', '', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `fuzzy_fasilitas`
--

CREATE TABLE `fuzzy_fasilitas` (
  `id` int(11) NOT NULL,
  `obyek_wisata` varchar(30) NOT NULL,
  `fasilitas` float NOT NULL,
  `sedikit` float NOT NULL,
  `cukup` float NOT NULL,
  `banyak` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fuzzy_fasilitas`
--

INSERT INTO `fuzzy_fasilitas` (`id`, `obyek_wisata`, `fasilitas`, `sedikit`, `cukup`, `banyak`) VALUES
(136, 'Waduk Gadjah Mada', 6, 0.8, 0.2, 0),
(138, 'Ancol', 10, 0, 1, 0),
(146, 'Alun Alun Pasar Senin', 2, 1, 0, 0),
(158, 'Kolam Renang', 7, 0.6, 0.4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fuzzy_harga`
--

CREATE TABLE `fuzzy_harga` (
  `id` int(11) NOT NULL,
  `obyek_wisata` varchar(30) NOT NULL,
  `harga` float NOT NULL,
  `murah` float NOT NULL,
  `sedang` float NOT NULL,
  `mahal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fuzzy_harga`
--

INSERT INTO `fuzzy_harga` (`id`, `obyek_wisata`, `harga`, `murah`, `sedang`, `mahal`) VALUES
(136, 'Waduk Gadjah Mada', 4000, 1, 0, 0),
(138, 'Ancol', 15000, 0.666667, 0.333333, 0),
(146, 'Alun Alun Pasar Senin', 0, 1, 0, 0),
(158, 'Kolam Renang', 2300, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fuzzy_jarak`
--

CREATE TABLE `fuzzy_jarak` (
  `id` int(11) NOT NULL,
  `obyek_wisata` varchar(30) NOT NULL,
  `jarak` float NOT NULL,
  `dekat` float NOT NULL,
  `sedang` float NOT NULL,
  `jauh` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fuzzy_jarak`
--

INSERT INTO `fuzzy_jarak` (`id`, `obyek_wisata`, `jarak`, `dekat`, `sedang`, `jauh`) VALUES
(136, 'Waduk Gadjah Mada', 22, 0, 0, 1),
(138, 'Ancol', 4, 1, 0, 0),
(146, 'Alun Alun Pasar Senin', 34, 0, 0, 1),
(158, 'Kolam Renang', 3, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fuzzy_jenis`
--

CREATE TABLE `fuzzy_jenis` (
  `id` int(11) NOT NULL,
  `obyek_wisata` varchar(30) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `alam` float NOT NULL,
  `sosial_budaya` float NOT NULL,
  `religi_sejarah` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fuzzy_jenis`
--

INSERT INTO `fuzzy_jenis` (`id`, `obyek_wisata`, `jenis`, `alam`, `sosial_budaya`, `religi_sejarah`) VALUES
(136, 'Waduk Gadjah Mada', 'Alam', 1, 0, 0),
(138, 'Ancol', 'Sosial_Budaya', 0, 1, 0),
(146, 'Alun Alun Pasar Senin', 'Alam', 1, 0, 0),
(158, 'Kolam Renang', 'Religi_Sejarah', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fuzzy_pengunjung`
--

CREATE TABLE `fuzzy_pengunjung` (
  `id` int(11) NOT NULL,
  `obyek_wisata` varchar(30) NOT NULL,
  `pengunjung` float NOT NULL,
  `sepi` float NOT NULL,
  `biasa` float NOT NULL,
  `ramai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fuzzy_pengunjung`
--

INSERT INTO `fuzzy_pengunjung` (`id`, `obyek_wisata`, `pengunjung`, `sepi`, `biasa`, `ramai`) VALUES
(136, 'Waduk Gadjah Mada', 3833, 0.190571, 0.809429, 0),
(138, 'Ancol', 4644, 0, 0.973818, 0.0261818),
(146, 'Alun Alun Pasar Senin', 243, 1, 0, 0),
(158, 'Kolam Renang', 1300, 0.914286, 0.0857143, 0);

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
  `nama_wilayah` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_tampilan`
--

INSERT INTO `setting_tampilan` (`link_gambar`, `warna_bg`, `nama_wilayah`) VALUES
('https://kamini.id/wp-content/uploads/2020/12/macam-macam-warna-biru_thumbnail-Copy.jpg', 'white', 'Pemilihan Objek Pariwisata by HDM-Vision');

-- --------------------------------------------------------

--
-- Table structure for table `tempat_wisata_tb`
--

CREATE TABLE `tempat_wisata_tb` (
  `obyek_wisata` varchar(30) NOT NULL,
  `id` int(10) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `harga` float DEFAULT NULL,
  `jarak` float DEFAULT NULL,
  `fasilitas` float DEFAULT NULL,
  `info` varchar(50) NOT NULL,
  `pengunjung` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tempat_wisata_tb`
--

INSERT INTO `tempat_wisata_tb` (`obyek_wisata`, `id`, `jenis`, `harga`, `jarak`, `fasilitas`, `info`, `pengunjung`) VALUES
('Waduk Gadjah Mada', 136, 'Alam', 4000, 22, 6, 'https://www.google.com/', 3833),
('Ancol', 138, 'Sosial_Budaya', 15000, 4, 10, 'https://www.google.com/', 4644),
('Alun Alun Pasar Senin', 146, 'Alam', 0, 34, 2, 'https://www.google.com/', 243),
('Kolam Renang', 158, 'Religi_Sejarah', 2300, 3, 7, '', 1300);

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
-- Indexes for table `fuzzy_fasilitas`
--
ALTER TABLE `fuzzy_fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fuzzy_harga`
--
ALTER TABLE `fuzzy_harga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fuzzy_jarak`
--
ALTER TABLE `fuzzy_jarak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fuzzy_jenis`
--
ALTER TABLE `fuzzy_jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fuzzy_pengunjung`
--
ALTER TABLE `fuzzy_pengunjung`
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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `daftar_kriteria_static`
--
ALTER TABLE `daftar_kriteria_static`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `fuzzy_fasilitas`
--
ALTER TABLE `fuzzy_fasilitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `fuzzy_harga`
--
ALTER TABLE `fuzzy_harga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `fuzzy_jarak`
--
ALTER TABLE `fuzzy_jarak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `fuzzy_jenis`
--
ALTER TABLE `fuzzy_jenis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `fuzzy_pengunjung`
--
ALTER TABLE `fuzzy_pengunjung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `input_user_tb`
--
ALTER TABLE `input_user_tb`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1235;

--
-- AUTO_INCREMENT for table `tempat_wisata_tb`
--
ALTER TABLE `tempat_wisata_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
