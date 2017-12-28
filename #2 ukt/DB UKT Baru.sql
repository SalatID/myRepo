-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2017 at 08:47 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `katjurus`
--

CREATE TABLE `katjurus` (
  `id` int(5) NOT NULL,
  `nameKatJurus` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `katjurus`
--

INSERT INTO `katjurus` (`id`, `nameKatJurus`) VALUES
(1, 'Standar SMI'),
(2, 'Tradisional'),
(3, 'Prasetya Pesilat'),
(4, 'Beladiri Praktis'),
(5, 'Fisik Teknik'),
(6, 'Aerobik Tes'),
(7, 'Kuda-kuda Dasar'),
(8, 'Serang Hindar');

-- --------------------------------------------------------

--
-- Table structure for table `kelompok`
--

CREATE TABLE `kelompok` (
  `id` int(5) NOT NULL,
  `nameKelompok` varchar(40) NOT NULL,
  `tsId` int(5) NOT NULL,
  `penilaiId` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` int(5) NOT NULL,
  `subKatJurusId` int(5) NOT NULL,
  `nilai` float NOT NULL,
  `kelompokId` int(5) NOT NULL,
  `pesertaId` int(5) NOT NULL,
  `pengujiId` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penilai`
--

CREATE TABLE `penilai` (
  `id` int(5) NOT NULL,
  `namePenilai` varchar(40) NOT NULL,
  `tsId` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penilai`
--

INSERT INTO `penilai` (`id`, `namePenilai`, `tsId`) VALUES
(1, 'Indra Madya P', 7),
(2, 'Agam Ikhwan', 7),
(3, 'Agus Sutrisno', 7),
(4, 'Topik', 7),
(5, 'Taufik Aidan', 7),
(6, 'Ramli Alamsyah', 7),
(7, 'Juminta Ibrahim', 6),
(8, 'Eko Purwanto', 6),
(9, 'Ashabul Kahfi', 6),
(10, 'Didy Supriadi', 6),
(11, 'Aprianto Laksono', 5),
(12, 'Mursalat Asyidiq', 5),
(13, 'Catur Wulandari', 5),
(14, 'Ummul Ubaedillah', 4),
(15, 'Anna Pangestu', 4),
(16, 'Restu Nurqori''ah', 4),
(17, 'Indah Setyawati', 4),
(18, 'Ahmad Ramdhani', 4),
(19, 'Novi Jayanti ', 4),
(20, 'Ibnu Fauzan ', 4),
(21, 'Didy Eriawan', 4),
(22, 'Agung Nugroho', 4),
(23, 'M. Arief Prihantoro', 4);

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id` int(5) NOT NULL,
  `namePeserta` varchar(50) NOT NULL,
  `tsAwal` int(5) NOT NULL,
  `tsAkhir` int(5) NOT NULL,
  `tglLahir` date NOT NULL,
  `tempatLahir` varchar(40) NOT NULL,
  `unitId` int(5) NOT NULL,
  `kelompokId` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id`, `namePeserta`, `tsAwal`, `tsAkhir`, `tglLahir`, `tempatLahir`, `unitId`, `kelompokId`) VALUES
(1, 'M. Fachri Hardiansyah', 2, 0, '1999-11-27', 'Jakarta', 10, 0),
(2, 'M. Farrel Aulia', 2, 0, '2008-02-23', 'Jakarta', 2, 0),
(3, 'M. Raifan Pashya', 2, 0, '2005-12-29', 'Jakarta', 2, 0),
(4, 'Annalul Muntamah', 2, 0, '2005-04-01', 'Jakarta', 2, 0),
(5, 'Irfan Maulana', 2, 0, '2007-01-17', 'Jakarta', 2, 0),
(6, 'Irfan Pandu Winata', 2, 0, '2000-05-12', 'Jakarta', 10, 0),
(7, 'Umay Kamila', 2, 0, '1999-12-30', 'Jakarta', 12, 0),
(8, 'Asa Luthf Yuwawira', 2, 0, '2005-06-09', 'Tegal', 4, 0),
(9, 'Rafat Irawan', 2, 0, '2009-12-18', 'Bogor', 2, 0),
(10, 'Riski Nurfadilah', 2, 0, '2002-10-13', 'Boyolali', 4, 0),
(11, 'Tio Irfan Antoni', 2, 0, '2001-01-04', 'Jakarta', 10, 0),
(12, 'Dimas Bayu Nugroho', 2, 0, '2006-05-20', 'Jakarta', 2, 0),
(13, 'Ariffadhil Siraz', 2, 0, '2004-06-11', 'Jakarta', 4, 0),
(15, 'Hamdan Syah', 2, 0, '2000-06-08', 'Depok', 10, 0),
(16, 'Ardinata Romadhon Aminoro', 1, 0, '2003-10-27', 'Jakarta', 4, 0),
(18, 'Angri Adnan Alfares', 1, 0, '2010-01-05', 'Jakarta', 2, 0),
(19, 'Pedri Eka Senjaya', 1, 0, '2004-09-30', 'Jakarta', 2, 0),
(20, 'Fifianah', 1, 0, '2001-04-11', 'Jakarta', 8, 0),
(21, 'Krisna Ramdhani Wiatmaja', 1, 0, '2000-12-20', 'Jakarta', 8, 0),
(24, 'Slamet Fajri Febriyanto', 1, 0, '2004-02-03', 'Jakarta', 4, 0),
(25, 'M. Adiy Faid', 1, 0, '2004-03-24', 'Bekasi', 4, 0),
(26, 'Fahmi Aprilliansyah', 1, 0, '2002-04-04', 'Purworejo', 11, 0),
(27, 'M. Feri Al''Buni', 1, 0, '2003-11-12', 'Tangerang', 7, 0),
(28, 'Rafa Aulia Damar Gusti', 1, 0, '2004-07-24', 'Jakarta', 7, 0),
(29, 'Khainu Shyafrudin', 1, 0, '2004-03-26', 'Jakarta', 4, 0),
(30, 'M. Farhan Apriliansyah', 1, 0, '2004-04-07', 'Jakarta', 4, 0),
(31, 'Ahmad Syonhaji', 1, 0, '1999-08-18', 'Tangerang', 14, 0),
(32, 'Rasya Lutfi Efendi', 1, 0, '2007-07-30', 'Gunung Pasar Jaya', 2, 0),
(33, 'Aster Wardana', 1, 0, '2004-05-15', 'Wonogiri', 11, 0),
(35, 'Agim Nastiar', 1, 2, '2002-10-17', 'Jakarta', 11, 0),
(36, 'Rangkay Norma Hakiki', 1, 0, '1999-03-05', 'Jakarta', 11, 0),
(37, 'Virgiawan Raihansyah', 1, 0, '2003-12-16', 'Jakarta', 11, 0),
(38, 'Adam Barkah', 1, 2, '2001-12-25', 'Jakarta', 11, 0),
(39, 'Dimas Hari Sabarno', 1, 0, '2000-09-13', 'Jakarta', 10, 0),
(40, 'Faza Syahira Laksono', 1, 0, '2011-02-11', 'Tangerang', 2, 0),
(41, 'Fahden Zhafir Ramadhan L', 1, 0, '2009-09-04', 'Tangerang', 2, 0),
(42, 'Callista Lorenza Albidari H', 1, 0, '2008-08-05', 'Jakarta', 2, 0),
(43, 'Dimas Rizky Akbar', 1, 0, '2004-09-30', 'Bekasi', 4, 0),
(44, 'Ragil Restu Akbar', 1, 0, '2004-09-30', 'Bekasi', 4, 0),
(45, 'Ahmad Syarif Riswandy', 2, 0, '2005-11-19', 'Jakarta', 2, 0),
(46, 'Hari Darmawan', 1, 0, '2000-09-15', 'Cilacap', 11, 0),
(47, 'Muhammad Rifai', 1, 0, '2005-05-02', 'Jakarta', 2, 0),
(48, 'Novalessandro E.L.H', 2, 0, '2006-11-13', 'Sragen', 1, 0),
(49, 'Sheva Ananda Farizky', 1, 0, '2006-06-27', 'Tangerang', 2, 0),
(50, 'Ayu Alisya', 2, 0, '1999-08-11', 'Jakarta', 14, 0),
(51, 'Indra Gunawan', 1, 0, '2001-04-22', 'Jakarta', 11, 0),
(52, 'Sahida', 3, 0, '1983-07-16', 'Jakarta', 2, 0),
(53, 'Regita Fitra Aryaningsih', 3, 0, '2001-12-19', 'Tegal', 14, 0),
(54, 'Zidan Alfian Harits', 1, 0, '2004-08-24', 'Jakarta', 4, 0),
(55, 'Roro Mayang Maharani', 1, 0, '2003-11-13', 'Jakarta', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subkatjurus`
--

CREATE TABLE `subkatjurus` (
  `id` int(5) NOT NULL,
  `nameSubKatJurus` varchar(40) NOT NULL,
  `katJurusId` int(5) NOT NULL,
  `tsId` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subkatjurus`
--

INSERT INTO `subkatjurus` (`id`, `nameSubKatJurus`, `katJurusId`, `tsId`) VALUES
(1, 'Kaidah', 1, 1),
(2, 'Pukulan 9', 1, 1),
(3, 'Pancer', 1, 1),
(4, 'Dua Sejalan', 1, 1),
(5, 'Kombinasi 1', 1, 2),
(6, 'Kombinasi 2', 1, 3),
(7, 'Karimadi 1', 2, 1),
(8, 'Karimadi 2', 2, 1),
(9, 'Karimadi 3', 2, 1),
(10, 'Double Sabandar', 2, 2),
(11, 'Jampang ', 2, 3),
(12, 'Prasetya 1 (Taqwa)', 3, 1),
(13, 'Prasetya 2 (Pancasila)', 3, 1),
(14, 'Prasetya 3 (Cinta Tanah Air Indonesia)', 3, 1),
(15, 'Prasetya 4 (persaudaraan)', 3, 2),
(16, 'Prasetya 5 (Kepribadian Bangsa)', 3, 2),
(17, 'Prasetya 6 (Kebenaran, Kejujuran, Keadil', 3, 3),
(18, 'Prasetya 7 (Tahan Cobaan Godaan)', 3, 3),
(19, 'Sapuan Kaki Luar', 4, 1),
(20, 'Sapuan Kaki Dalam', 4, 1),
(21, 'Sapuan Tumit Dalam', 4, 1),
(22, 'Sapuan Tumit Luar', 4, 1),
(23, 'Kelit Tungkai Dalam', 4, 2),
(24, 'Kelit Tungkai Luar', 4, 2),
(25, 'Gajah Dorong', 4, 2),
(26, 'Kelit Timbang Dalam', 4, 3),
(27, 'Kelit Timbang Luar', 4, 3),
(28, 'Tangkapan Harimau', 4, 3),
(29, 'Pukulan', 5, 1),
(30, 'Tendangan', 5, 1),
(31, 'Lari', 6, 1),
(32, 'Push-UP', 6, 1),
(33, 'Sit-Up', 6, 1),
(34, 'Back-Up', 6, 1),
(35, 'Faktor Kesulitan 0', 7, 1),
(36, 'Faktor Kesulitan 1', 7, 2),
(37, 'Faktor Kesulitan2', 7, 3),
(38, 'Serang Dalam', 8, 1),
(39, 'Serang Luar', 8, 1),
(40, 'Hindar Dalam', 8, 1),
(41, 'Hindar Luar', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ts`
--

CREATE TABLE `ts` (
  `id` int(11) NOT NULL,
  `tsName` varchar(40) NOT NULL,
  `tsCode` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ts`
--

INSERT INTO `ts` (`id`, `tsName`, `tsCode`) VALUES
(1, 'Pratama Taruna', 'PT'),
(2, 'Pratama Madya', 'PM'),
(3, 'Pratama Utama', 'PU'),
(4, 'Satria Taruna', 'ST'),
(5, 'Satria Madya', 'SM'),
(6, 'Satria Utama', 'SU'),
(7, 'Pendekar Muda Taruna', 'PMT'),
(8, 'Pendekar Muda Madya', 'PMM'),
(9, 'Pendekar Muda Utama', 'PMU'),
(10, 'Dewan Guru', 'DG');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(5) NOT NULL,
  `nameUnit` varchar(40) NOT NULL,
  `tingkat` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `nameUnit`, `tingkat`) VALUES
(1, 'SD Negeri Kalideres 09 Jakarta', 'SD'),
(2, 'Pondok Kalideres', 'Umum'),
(3, 'GOR Kecamatan Kalideres', 'Umum'),
(4, 'SMP Negeri 225 Jakarta', 'SMP'),
(5, 'SMP Bangun Nusantara ', 'SMP'),
(6, 'SMP Cengkareng 1', 'SMP'),
(7, 'SMP IT Al Maka', 'SMP'),
(8, 'SMA Negeri 95 Jakarta', 'SMA'),
(9, 'SMK PGRI 5', 'SMK'),
(10, 'SMK Cengkareng 1', 'SMK'),
(11, 'SMK Cengkareng 2', 'SMK'),
(12, 'SMK Bangun Nusantara ', 'SMK'),
(13, 'SMA Cengkareng 1', 'SMA'),
(14, 'SMK Kesehatan Banten', 'SMK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `katjurus`
--
ALTER TABLE `katjurus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelompok`
--
ALTER TABLE `kelompok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penilai`
--
ALTER TABLE `penilai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subkatjurus`
--
ALTER TABLE `subkatjurus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ts`
--
ALTER TABLE `ts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `katjurus`
--
ALTER TABLE `katjurus`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `penilai`
--
ALTER TABLE `penilai`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `subkatjurus`
--
ALTER TABLE `subkatjurus`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `ts`
--
ALTER TABLE `ts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
