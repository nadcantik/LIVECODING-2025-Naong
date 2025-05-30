-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2025 at 02:32 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `macok`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorit`
--

CREATE TABLE `favorit` (
  `id_favorit` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_resep` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategory`
--

CREATE TABLE `kategory` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategory`
--

INSERT INTO `kategory` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Masakan Rumahan'),
(2, 'Kue'),
(3, 'Minuman'),
(4, 'Camilan');

-- --------------------------------------------------------

--
-- Table structure for table `resep`
--

CREATE TABLE `resep` (
  `id_resep` int(11) NOT NULL,
  `gambar_resep` varchar(255) NOT NULL,
  `nama_resep` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `porsi` enum('1 to 2','5 to 10') NOT NULL,
  `waktu_memasak` enum('15','30','45','60') NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `bahan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`bahan`)),
  `cara_memasak` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resep`
--

INSERT INTO `resep` (`id_resep`, `gambar_resep`, `nama_resep`, `deskripsi`, `porsi`, `waktu_memasak`, `id_user`, `id_kategori`, `bahan`, `cara_memasak`) VALUES
(1, 'uploads/DSC07022.JPG', 'tahu bulat', 'sjnjkabjanklmknklxnsajkbxghabhj', '1 to 2', '15', 1, 1, '[\"tahu 5 butir\"]', '[]'),
(2, 'uploads/DSC07022.JPG', 'gorengan', 'amaxnjknajhxnkamxl,al/', '1 to 2', '15', 1, 1, '[\"jkmknkj nb bbn 6\"]', '[]'),
(3, 'uploads/DSC07022.JPG', 'kajknajknlkaml;', 'lsklmlkMLlkajjnslmls;l', '1 to 2', '15', 1, 1, '[\"ldasklmcalsjakmkla\"]', '[]'),
(4, 'uploads/DSC07022.JPG', 'ijpu huu8uuou', 'ooo,o,,o,o,oo,o,o,jjj', '1 to 2', '15', 1, 2, '[\"oo,,,ooo,o,o,o,o,o,o,o\"]', '[]');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `profil_user` varchar(255) DEFAULT NULL,
  `deskripsi_diri` text DEFAULT NULL,
  `no_telp` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `profil_user`, `deskripsi_diri`, `no_telp`, `email`, `username`, `password`) VALUES
(1, 'Abiyyu Syafwan', 'naong.jpg', '', '89682248714', 'abiyyu@gmail.com', 'abiyyuxjr', '$2y$10$6IvlKMs40CTY0qPe6uTO9.B.5s6gpLwcfaghoOldiJ6k6asQRBL7G'),
(2, 'Moch. Arya Hidayah Putra', '', '', '1234567800', 'arya@gmail.com', 'aryaxjr', '$2y$10$p2s84HqYkMjEQX4z3C3HFuUcRagxePF3a20plVWA.HbN9L8/7L1l.'),
(3, 'Abiyyu Syafwan', '', '', '1234509', 'arya@gmail.com', 'oii123', '$2y$10$AkKq5Kk1YB1I2C1SrYMy/uA0Abv7XBNj9WaXcyiDrvsLeNXDTwZ6y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favorit`
--
ALTER TABLE `favorit`
  ADD PRIMARY KEY (`id_favorit`),
  ADD KEY `id_user_fav` (`id_user`),
  ADD KEY `id_resep_fav` (`id_resep`);

--
-- Indexes for table `kategory`
--
ALTER TABLE `kategory`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `resep`
--
ALTER TABLE `resep`
  ADD PRIMARY KEY (`id_resep`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorit`
--
ALTER TABLE `favorit`
  MODIFY `id_favorit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategory`
--
ALTER TABLE `kategory`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `resep`
--
ALTER TABLE `resep`
  MODIFY `id_resep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorit`
--
ALTER TABLE `favorit`
  ADD CONSTRAINT `id_resep_fav` FOREIGN KEY (`id_resep`) REFERENCES `resep` (`id_resep`),
  ADD CONSTRAINT `id_user_fav` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `resep`
--
ALTER TABLE `resep`
  ADD CONSTRAINT `id_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategory` (`id_kategori`),
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
