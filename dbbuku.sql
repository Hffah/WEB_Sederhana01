-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2026 at 02:17 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbbuku`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_hp`, `email`, `tanggal_daftar`, `status`) VALUES
('AG001', 'Rahmat Hidayat', 'Laki-laki', 'Banda Aceh', '2005-05-10', 'Jl. Darussalam', '081234567890', 'rahmat@gmail.com', '2024-01-10', 'Aktif'),
('AG002', 'Siti Aisyah', 'Perempuan', 'Sigli', '2001-08-15', 'Jl. T. Nyak Arief', '082345678901', 'siti@gmail.com', '2024-02-12', 'Aktif'),
('AG003', 'M. Iqbal', 'Laki-laki', 'Lhokseumawe', '1999-03-22', 'Jl. Medan ? Banda Aceh', '083456789012', 'iqbal@gmail.com', '2024-01-20', 'Aktif'),
('AG004', 'Nurul Huda', 'Perempuan', 'Langsa', '2002-11-05', 'Jl. Ahmad Yani', '084567890123', 'nurul@gmail.com', '2024-03-01', 'Aktif'),
('AG005', 'Fauzan', 'Laki-laki', 'Meulaboh', '1998-07-18', 'Jl. Nasional', '085678901234', 'fauzan@gmail.com', '2024-01-25', 'Nonaktif'),
('AG006', 'Dewi Sartika', 'Perempuan', 'Bireuen', '2001-12-09', 'Jl. Banda Aceh ? Medan', '086789012345', 'dewi@gmail.com', '2024-02-18', 'Aktif'),
('AG007', 'Andi Saputra', 'Laki-laki', 'Medan', '2000-09-30', 'Jl. Setia Budi', '087890123456', 'andi@gmail.com', '2024-03-05', 'Aktif'),
('AG008', 'Cut Intan', 'Perempuan', 'Banda Aceh', '2002-04-14', 'Jl. Sultan Iskandar Muda', '088901234567', 'intan@gmail.com', '2024-03-10', 'Aktif'),
('AG009', 'Zulkifli', 'Laki-laki', 'Pidie', '1997-06-27', 'Jl. Raya Pidie', '089012345678', 'zulkifli@gmail.com', '2024-01-15', 'Nonaktif'),
('AG010', '', 'Laki-laki', 'Sabang', '2026-05-04', '', '082288224894', 'gentap121@gmail.com', '2026-05-05', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `buku_id` char(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `buku_judul` varchar(75) DEFAULT NULL,
  `penerbit_id` char(4) DEFAULT NULL,
  `buku_tglterbit` date DEFAULT NULL,
  `buku_jmlhalaman` int DEFAULT NULL,
  `buku_deskripsi` text,
  `buku_harga` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`buku_id`, `buku_judul`, `penerbit_id`, `buku_tglterbit`, `buku_jmlhalaman`, `buku_deskripsi`, `buku_harga`) VALUES
('222-34222-1-0', 'Mudah Belajar Photoshop', 'PB01', '2003-07-02', 300, NULL, '42000'),
('222-34222-1-1', 'Panduan Praktis Menggunakan Corel Draw', 'PB02', '2004-03-12', 400, NULL, '55000'),
('666-96771-2-0', 'Panduan Membangun Jaringan TCP/IP', 'PB08', '2006-08-02', 200, NULL, '60000'),
('666-96771-2-1', 'Implementasi TCP/IP di Linux', 'PB08', '2008-11-21', 230, NULL, '35000'),
('777-76723-5-0', 'Cara Belajar Cepat PHP 6', 'PB07', '2010-05-02', 600, NULL, '95000'),
('777-76723-5-1', 'Membuat Aplikasi WEB dengan ASP', 'PB07', '2004-08-01', 180, NULL, '30000'),
('777-76723-5-2', 'Belajar Sendiri Internet Marketing', 'PB07', '2007-01-24', 150, NULL, '38500'),
('777-76723-5-3', 'Panduan Menggunakan Yahoo dan Google', 'PB07', '2007-01-24', 243, NULL, '38500'),
('888-96771-3-0', 'Pemrograman Pascal', 'PB08', '2004-11-01', 350, NULL, '50000'),
('888-96771-3-1', 'Pemrograman Java', 'PB06', '2007-01-23', 450, NULL, '72000'),
('888-96771-3-2', 'Pemrograman C Untuk Hardware', 'PB05', '2006-12-25', 398, NULL, '47000'),
('888-96771-3-3', 'Menjadi Master C++', 'PB06', '2005-07-15', 490, NULL, '65000'),
('888-96771-3-4', 'Mudah Belajar Delphi', 'PB05', '2008-08-11', 328, NULL, '50000'),
('888-96771-3-5', 'Visual Basic', 'PB02', '2007-10-14', 250, NULL, '50000'),
('979-96446-9-0', 'Menguasai SQL', 'PB06', '2009-10-12', 346, NULL, '45000'),
('979-96446-9-1', 'Panduan Basis Data', 'PB01', '2007-03-02', 257, NULL, '37000'),
('979-96446-9-2', 'Perancangan Sistem', 'PB03', '2003-09-20', 403, NULL, '37000'),
('979-96446-9-3', 'Membuat Database dengan Microsoft Access', 'PB06', '2005-07-13', 400, NULL, '48500'),
('999-11555-2-0', 'Teknik Presentasi', 'PB06', '2008-11-23', 300, NULL, '57500'),
('999-11555-2-1', 'Tuntunan Praktis Microsoft Word 2010', 'PB02', '2010-12-01', 270, NULL, '60000');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_baru`
--

CREATE TABLE `kategori_baru` (
  `kategori_id` int NOT NULL,
  `kategori_nama` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori_baru`
--

INSERT INTO `kategori_baru` (`kategori_id`, `kategori_nama`) VALUES
(1, 'Basis Data'),
(2, 'Desain Grafis'),
(3, 'Jaringan Komputer'),
(4, 'Pemrograman'),
(5, 'Web dan Internet'),
(6, 'Office Application');

-- --------------------------------------------------------

--
-- Table structure for table `link_buku_kategori`
--

CREATE TABLE `link_buku_kategori` (
  `buku_id` char(13) NOT NULL,
  `kategori_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `link_buku_kategori`
--

INSERT INTO `link_buku_kategori` (`buku_id`, `kategori_id`) VALUES
('979-96446-9-0', 1),
('979-96446-9-1', 1),
('979-96446-9-2', 1),
('979-96446-9-3', 1),
('222-34222-1-0', 2),
('222-34222-1-1', 2),
('666-96771-2-0', 3),
('666-96771-2-1', 3),
('777-76723-5-0', 4),
('777-76723-5-1', 4),
('888-96771-3-0', 4),
('888-96771-3-1', 4),
('888-96771-3-2', 4),
('888-96771-3-3', 4),
('888-96771-3-4', 4),
('888-96771-3-5', 4),
('979-96446-9-2', 4),
('777-76723-5-0', 5),
('777-76723-5-1', 5),
('777-76723-5-2', 5),
('777-76723-5-3', 5),
('999-11555-2-0', 6),
('999-11555-2-1', 6);

-- --------------------------------------------------------

--
-- Table structure for table `link_buku_pengarang`
--

CREATE TABLE `link_buku_pengarang` (
  `buku_id` char(13) NOT NULL,
  `pengarang_id` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `link_buku_pengarang`
--

INSERT INTO `link_buku_pengarang` (`buku_id`, `pengarang_id`) VALUES
('222-34222-1-0', 'ASW'),
('666-96771-2-1', 'ASW'),
('888-96771-3-2', 'ASW'),
('777-76723-5-0', 'BRH'),
('888-96771-3-1', 'BRH'),
('888-96771-3-3', 'BRH'),
('979-96446-9-0', 'BRH'),
('777-76723-5-1', 'BTO'),
('979-96446-9-2', 'BTO'),
('222-34222-1-1', 'DAR'),
('666-96771-2-1', 'DAR'),
('777-76723-5-0', 'DAR'),
('888-96771-3-0', 'DAR'),
('888-96771-3-5', 'DAR'),
('666-96771-2-0', 'ERD'),
('999-11555-2-1', 'ERD'),
('666-96771-2-0', 'ERK'),
('888-96771-3-2', 'ERK'),
('666-96771-2-0', 'FDY'),
('979-96446-9-1', 'FDY'),
('777-76723-5-1', 'GZL'),
('979-96446-9-2', 'GZL'),
('777-76723-5-3', 'HND'),
('999-11555-2-1', 'HND'),
('777-76723-5-3', 'HNF'),
('888-96771-3-4', 'HNF'),
('999-11555-2-1', 'HNF'),
('777-76723-5-1', 'IGN'),
('888-96771-3-4', 'IGN'),
('979-96446-9-2', 'IGN'),
('999-11555-2-1', 'IGN'),
('888-96771-3-1', 'IHR'),
('979-96446-9-0', 'IHR'),
('979-96446-9-3', 'IHR'),
('999-11555-2-0', 'IHR'),
('777-76723-5-2', 'TTK'),
('979-96446-9-2', 'TTK'),
('999-11555-2-0', 'TTK');

-- --------------------------------------------------------

--
-- Table structure for table `penerbit`
--

CREATE TABLE `penerbit` (
  `penerbit_id` char(4) NOT NULL,
  `penerbit_nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penerbit`
--

INSERT INTO `penerbit` (`penerbit_id`, `penerbit_nama`) VALUES
('PB01', 'ANGKASA RAYA'),
('PB02', 'CAHAYA ILMU PERSADA'),
('PB03', 'SINAR ILMU PERKASA'),
('PB04', 'INTAN'),
('PB05', 'SINAR RAYA'),
('PB06', 'INFORMATIKA BANDUNG'),
('PB07', 'TIGA SEKAWAN'),
('PB08', 'CIPTA ILMU'),
('PB09', 'GAVA MEDIA');

-- --------------------------------------------------------

--
-- Table structure for table `pengarang`
--

CREATE TABLE `pengarang` (
  `pengarang_id` char(3) NOT NULL,
  `pengarang_nama` varchar(30) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengarang`
--

INSERT INTO `pengarang` (`pengarang_id`, `pengarang_nama`, `email`) VALUES
('ASW', 'Andi Setiawan', 'andi.s@gmail.com'),
('BRH', 'Budi Raharjo', 'raharjo.b@gmail.com'),
('BTO', 'Beni Tito', 'beni.t@gmail.com'),
('DAR', 'Dewi Aulia Raharjo', 'dewi.ar@gmail.com'),
('ERD', 'Erik Rusdianto', 'rusdianto.erik@gmail.com'),
('ERK', 'E Rosdiana K', 'rosdiana@gmail.com'),
('FDY', 'Fredi Hidayat', 'fredi.h@gmail.com'),
('GZL', 'Abdul Ghozali', 'abdul.ghozali@gmail.com'),
('HND', 'Hasanuddin', 'hasanuddin@gmail.com'),
('HNF', 'Ahmad Hanafi', 'ahmad.hanafi@gmail.com'),
('IGN', 'Iwan Gunardi', 'gunardi.iwan@gmail.com'),
('IHR', 'Imam Heryanto', 'imam.her@gmail.com'),
('NAZ', 'Nazruddin Ahmad', 'nazar.ahmadnb@gmail.com'),
('RNM', 'Rinaldi Munir', 'munir.rinaldi@gmail.com'),
('TTK', 'Totok Triwibowo', 'totok.tri@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`buku_id`),
  ADD KEY `penerbit_id` (`penerbit_id`);

--
-- Indexes for table `kategori_baru`
--
ALTER TABLE `kategori_baru`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `link_buku_kategori`
--
ALTER TABLE `link_buku_kategori`
  ADD PRIMARY KEY (`buku_id`,`kategori_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `link_buku_pengarang`
--
ALTER TABLE `link_buku_pengarang`
  ADD PRIMARY KEY (`buku_id`,`pengarang_id`),
  ADD KEY `pengarang_id` (`pengarang_id`);

--
-- Indexes for table `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`penerbit_id`);

--
-- Indexes for table `pengarang`
--
ALTER TABLE `pengarang`
  ADD PRIMARY KEY (`pengarang_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori_baru`
--
ALTER TABLE `kategori_baru`
  MODIFY `kategori_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`penerbit_id`) REFERENCES `penerbit` (`penerbit_id`);

--
-- Constraints for table `link_buku_kategori`
--
ALTER TABLE `link_buku_kategori`
  ADD CONSTRAINT `link_buku_kategori_ibfk_1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`buku_id`),
  ADD CONSTRAINT `link_buku_kategori_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_baru` (`kategori_id`);

--
-- Constraints for table `link_buku_pengarang`
--
ALTER TABLE `link_buku_pengarang`
  ADD CONSTRAINT `link_buku_pengarang_ibfk_1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`buku_id`),
  ADD CONSTRAINT `link_buku_pengarang_ibfk_2` FOREIGN KEY (`pengarang_id`) REFERENCES `pengarang` (`pengarang_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
