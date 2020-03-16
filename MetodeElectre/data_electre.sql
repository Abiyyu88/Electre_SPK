-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2020 at 04:45 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electre_spk`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_electre`
--

CREATE TABLE `data_electre` (
  `namaAlternatif` varchar(100) NOT NULL,
  `Fasilitas` int(11) NOT NULL,
  `Harga` int(11) NOT NULL,
  `Tahun` int(11) NOT NULL,
  `Jarak` int(11) NOT NULL,
  `Keamanan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_electre`
--

INSERT INTO `data_electre` (`namaAlternatif`, `Fasilitas`, `Harga`, `Tahun`, `Jarak`, `Keamanan`) VALUES
('Apartemen_1', 2, 4, 2, 3, 3),
('Apartemen_2', 4, 1, 5, 5, 3),
('Apartemen_3\r\n', 3, 2, 1, 4, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_electre`
--
ALTER TABLE `data_electre`
  ADD PRIMARY KEY (`namaAlternatif`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
