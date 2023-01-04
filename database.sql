-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql104.epizy.com
-- Generation Time: Jan 03, 2023 at 10:26 PM
-- Server version: 10.3.27-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_32439584_bimta`
--

-- --------------------------------------------------------

--
-- Table structure for table `pembing`
--

CREATE TABLE `pembing` (
  `pembing_id` int(11) NOT NULL,
  `periode` int(11) NOT NULL,
  `id_mhs` int(11) NOT NULL,
  `pengajuan_id` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `dosen` int(11) NOT NULL,
  `tanggapan` text DEFAULT NULL,
  `kesediaan` varchar(30) NOT NULL DEFAULT 'new',
  `jenis` int(11) NOT NULL,
  `status_bimbingan` enum('selesai','proses','new') NOT NULL DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembing`
--

INSERT INTO `pembing` (`pembing_id`, `periode`, `id_mhs`, `pengajuan_id`, `create_at`, `dosen`, `tanggapan`, `kesediaan`, `jenis`, `status_bimbingan`) VALUES
(3, 3, 1, 1, '2022-04-01 16:53:57', 2, NULL, 'Y', 2, 'proses'),
(5, 3, 3, 3, '2022-08-30 16:11:45', 3, NULL, 'Y', 1, 'selesai');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `pengajuan_id` int(11) NOT NULL,
  `periode_id` int(11) NOT NULL,
  `id_mhs` int(11) NOT NULL,
  `tgl_pengajuan` datetime NOT NULL,
  `judul` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `revisi_judul` varchar(255) DEFAULT NULL,
  `stt_revisi` varchar(30) DEFAULT NULL,
  `masalah` text NOT NULL,
  `rekomendasi_pa` varchar(30) DEFAULT 'new',
  `tgl_rekomendasi` datetime DEFAULT NULL,
  `disetujui_kajur` varchar(30) DEFAULT 'new',
  `tgl_acc` datetime DEFAULT NULL,
  `tgl_pengajuan_sk` date DEFAULT NULL,
  `alasan_perpanjangan_sk` text DEFAULT NULL,
  `status_bimbingan` varchar(60) DEFAULT NULL,
  `status_perpanjangan_sk` varchar(30) DEFAULT NULL,
  `status_sk` varchar(30) DEFAULT 'old'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`pengajuan_id`, `periode_id`, `id_mhs`, `tgl_pengajuan`, `judul`, `jenis`, `revisi_judul`, `stt_revisi`, `masalah`, `rekomendasi_pa`, `tgl_rekomendasi`, `disetujui_kajur`, `tgl_acc`, `tgl_pengajuan_sk`, `alasan_perpanjangan_sk`, `status_bimbingan`, `status_perpanjangan_sk`, `status_sk`) VALUES
(1, 3, 1, '2022-04-01 16:52:32', 'Perancangan Aplikasi Bimbingan Skripsi Online Berbasis Web', 'Hardware/ dan Software', '', 'N', '<p>Perancangan Aplikasi Bimbingan Skripsi Online Berbasis Web<br>Perancangan Aplikasi Bimbingan Skripsi Online Berbasis Web<br>Perancangan Aplikasi Bimbingan Skripsi Online Berbasis Web<br>Perancangan Aplikasi Bimbingan Skripsi Online Berbasis Web<br>Perancangan Aplikasi Bimbingan Skripsi Online Berbasis Web<br>Perancangan Aplikasi Bimbingan Skripsi Online Berbasis Web<br>Perancangan Aplikasi Bimbingan Skripsi Online Berbasis Web<br>Perancangan Aplikasi Bimbingan Skripsi Online Berbasis Web<br></p>', 'Y', '2022-04-01 16:54:24', 'Y', '2022-04-01 16:52:47', NULL, NULL, NULL, NULL, 'old'),
(2, 3, 2, '2022-08-23 15:21:02', 'Sistem 1', 'Hardware/ dan Software', NULL, NULL, '<p>Aakak</p>', 'N', '2022-08-23 15:22:15', 'Y', '2022-08-30 15:51:04', NULL, NULL, NULL, NULL, 'old'),
(3, 3, 3, '2022-08-30 15:35:42', '', 'Studi Literatur/ Pengkajian / Analisa', 'Water Availability Analysis Of Walanae River', 'Y', '<p>Lorem ipsum</p>', 'new', NULL, 'Y', '2022-08-30 15:43:01', '2022-08-30', '', 'BAB IV', 'Y', 'New'),
(4, 3, 5, '2022-08-30 17:13:18', 'Uji Kualitas Tanah', 'Studi Literatur/ Pengkajian / Analisa', NULL, NULL, '<p>Ada deh</p>', 'Y', '2022-08-30 17:43:29', 'Y', '2022-08-30 17:15:09', NULL, NULL, NULL, NULL, 'old');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `reply_id` int(11) NOT NULL,
  `id_pesan` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_tipe` enum('mhs','dsn') DEFAULT NULL,
  `tipe_pesan` enum('R','S') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_admin` varchar(40) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `username`, `password`, `nama_admin`, `img`, `status`) VALUES
(1, 'admin@bimta', '4ec41ba09f61c69df5655095987c8246b237cde3', 'Fahad Abdul Aziz', 'user.png', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tb_dsn`
--

CREATE TABLE `tb_dsn` (
  `id_dsn` int(11) NOT NULL,
  `nip` varchar(21) NOT NULL,
  `nama_dosen` varchar(50) NOT NULL,
  `jabatan` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `foto` varchar(225) NOT NULL DEFAULT 'user.png',
  `stt_akun` varchar(12) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_dsn`
--

INSERT INTO `tb_dsn` (`id_dsn`, `nip`, `nama_dosen`, `jabatan`, `password`, `foto`, `stt_akun`) VALUES
(1, '123', 'Dr. Poppy Yendriani, M.Pd', 'Dosen', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'user.png', 'Y'),
(2, '456', 'Prof, Dr. Adam El-Fathan, M.Sc', 'Rektor', '51eac6b471a284d3341d8c0c63d0f1a286262a18', '456_1648821591.png', 'Y'),
(3, '0011128502', 'Nurfitriana, S.Pd', 'Lektor', '4983cb3bc94f219c4984224371387ad029ede47d', 'user.png', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tb_fileskripsi`
--

CREATE TABLE `tb_fileskripsi` (
  `id_file` int(11) NOT NULL,
  `id_mhs` int(11) NOT NULL,
  `pengajuan_id` int(11) NOT NULL,
  `nama_file` varchar(225) NOT NULL,
  `tgl_upload` datetime NOT NULL,
  `tipe_file` varchar(10) NOT NULL,
  `ukuran_file` varchar(20) NOT NULL,
  `file` varchar(255) NOT NULL,
  `doc` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_fileskripsi`
--

INSERT INTO `tb_fileskripsi` (`id_file`, `id_mhs`, `pengajuan_id`, `nama_file`, `tgl_upload`, `tipe_file`, `ukuran_file`, `file`, `doc`) VALUES
(1, 1, 1, 'SK DOSEN', '2022-04-01 16:57:35', 'doc', '0', 'nofile', 'https://docs.google.com/document/d/1hDZRSOr8B5X7FPvf5teM-NGYl7ucQJuE6rS5bhegaOc/edit?usp=sharing');

-- --------------------------------------------------------

--
-- Table structure for table `tb_forum`
--

CREATE TABLE `tb_forum` (
  `id` int(11) NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_id_to` int(11) DEFAULT NULL,
  `user_type` varchar(30) DEFAULT NULL COMMENT 'mhs,dsn',
  `pesan` longtext DEFAULT NULL,
  `reply_to` varchar(11) DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `wkt` datetime DEFAULT current_timestamp(),
  `pesan_status` varchar(30) DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_forum`
--

INSERT INTO `tb_forum` (`id`, `kode`, `user_id`, `user_id_to`, `user_type`, `pesan`, `reply_to`, `document`, `wkt`, `pesan_status`) VALUES
(1, 'DSN-1648806536', 2, 1, 'dsn', '&lt;p&gt;Hai &lt;b&gt;Hamiatul&lt;/b&gt; ?&lt;/p&gt;', '', 'nofile', '2022-04-01 16:49:13', 'Y'),
(2, 'DSN-1648806536', 1, 2, 'mhs', '&lt;p&gt;Halo pak, selamat siang ?&lt;/p&gt;', '1', 'nofile', '2022-04-01 16:49:50', 'Y'),
(3, 'DSN-1648806536', 2, 1, 'dsn', '&lt;p&gt;Siang&lt;/p&gt;', '2', 'nofile', '2022-04-01 16:51:09', 'Y'),
(4, 'DSN-1661854626', 3, 5, 'dsn', '&lt;p&gt;Cek&lt;/p&gt;', '', 'nofile', '2022-08-30 06:18:40', 'Y'),
(5, 'DSN-1661854626', 3, 5, 'dsn', '&lt;p&gt;Hai&lt;br&gt;&lt;/p&gt;', '', 'nofile', '2022-09-01 02:59:56', 'Y'),
(6, 'DSN-1661854626', 3, 5, 'dsn', '&lt;p&gt;Cek&lt;/p&gt;', '', 'nofile', '2022-12-26 08:00:21', 'new');

-- --------------------------------------------------------

--
-- Table structure for table `tb_info`
--

CREATE TABLE `tb_info` (
  `info_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_info`
--

INSERT INTO `tb_info` (`info_id`, `judul`, `isi`) VALUES
(1, 'Jumlah SKS', 'Minimal 140 SKS');

-- --------------------------------------------------------

--
-- Table structure for table `tb_mhs`
--

CREATE TABLE `tb_mhs` (
  `id_mhs` int(11) NOT NULL,
  `nim` varchar(12) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tmp_lahir` varchar(60) DEFAULT NULL,
  `tg_lahir` date DEFAULT NULL,
  `password` varchar(60) NOT NULL,
  `fotomhs` varchar(225) NOT NULL DEFAULT 'user.png',
  `tahun_angkatan` int(30) NOT NULL,
  `prodi_id` int(11) NOT NULL,
  `dosen_pa` int(11) NOT NULL DEFAULT 0,
  `status_akun` varchar(12) NOT NULL DEFAULT 'new',
  `status_skripsi` varchar(30) NOT NULL DEFAULT 'N',
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_mhs`
--

INSERT INTO `tb_mhs` (`id_mhs`, `nim`, `nama`, `tmp_lahir`, `tg_lahir`, `password`, `fotomhs`, `tahun_angkatan`, `prodi_id`, `dosen_pa`, `status_akun`, `status_skripsi`, `create_at`) VALUES
(1, '001', 'Hamiatul Asmawati', NULL, NULL, 'e193a01ecf8d30ad0affefd332ce934e32ffce72', 'user.png', 2013, 2, 2, 'Y', 'N', '2022-04-01 16:46:36'),
(2, '009', 'hufgweyg', NULL, NULL, '19b3f0ed02e60c8bae808b496b3cce99dc8f9e69', 'user.png', 2013, 1, 1, 'Y', 'N', '2022-06-13 17:57:35'),
(3, '123', 'ITS', 'Wotu', '1970-01-01', '7c222fb2927d828af22f592134e8932480637c0d', 'user.png', 2017, 2, 2, 'Y', 'N', '2022-08-30 15:19:32'),
(4, '12345', 'Andi', NULL, NULL, '8cb2237d0679ca88db6464eac60da96345513964', 'user.png', 2018, 2, 0, 'N', 'N', '2022-08-30 17:04:08'),
(5, '123456', 'Asis', NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'user.png', 2018, 2, 3, 'Y', 'N', '2022-08-30 17:07:15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pesan`
--

CREATE TABLE `tb_pesan` (
  `id_pesan` int(11) NOT NULL,
  `pengajuan_id` int(11) NOT NULL,
  `pengirim_id` int(11) NOT NULL,
  `user_pengirim` enum('mhs','dsn') NOT NULL,
  `penerima_id` int(11) NOT NULL,
  `user_penerima` enum('mhs','dsn') NOT NULL,
  `topik` varchar(255) NOT NULL,
  `subyek` text NOT NULL,
  `isi_pesan` longtext DEFAULT NULL,
  `document` varchar(255) NOT NULL DEFAULT 'nofile',
  `pembing_id` int(11) DEFAULT NULL,
  `jenis_pemb` int(11) DEFAULT NULL,
  `wkt` datetime DEFAULT NULL,
  `status_pesan` varchar(15) NOT NULL DEFAULT 'new',
  `reply_to` int(11) DEFAULT NULL COMMENT 'Untuk menampung id pesan yg dibalas, jika ada',
  `tahun_bimbingan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pesan`
--

INSERT INTO `tb_pesan` (`id_pesan`, `pengajuan_id`, `pengirim_id`, `user_pengirim`, `penerima_id`, `user_penerima`, `topik`, `subyek`, `isi_pesan`, `document`, `pembing_id`, `jenis_pemb`, `wkt`, `status_pesan`, `reply_to`, `tahun_bimbingan`) VALUES
(1, 1, 2, 'dsn', 1, 'mhs', 'DSN-TOPIK-1648806979', 'Bimbingan 1', '&lt;p&gt;Harap Lampirkan Dokumen pendukung&lt;/p&gt;', 'nofile', 3, 2, '2022-04-01 16:56:19', 'Y', NULL, 3),
(2, 1, 2, 'dsn', 1, 'mhs', 'DSN-TOPIK-1648821173', 'BIMBINGAN 2', '&lt;p&gt;BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2BIMBINGAN 2&lt;br&gt;&lt;/p&gt;', 'nofile', 3, 2, '2022-04-01 20:52:53', 'Y', NULL, 3),
(3, 1, 2, 'dsn', 1, 'mhs', 'DSN-TOPIK-1648821188', 'BIMBINGAN 3', '&lt;p&gt;BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3&lt;br&gt;&lt;/p&gt;', 'nofile', 3, 2, '2022-04-01 20:53:08', 'Y', NULL, 3),
(4, 1, 1, 'mhs', 1, 'dsn', 'DSN-TOPIK-1648806979', 'Bimbingan 1', '&lt;p&gt;Baik Prof&lt;/p&gt;', 'nofile', 3, 2, '2022-04-01 20:55:11', 'new', 1, 3),
(5, 1, 1, 'mhs', 1, 'dsn', 'DSN-TOPIK-1648821173', 'BIMBINGAN 2', '&lt;p&gt;Oke&lt;/p&gt;', 'nofile', 3, 2, '2022-04-01 20:55:24', 'new', 2, 3),
(6, 1, 1, 'mhs', 1, 'dsn', 'DSN-TOPIK-1648821188', 'BIMBINGAN 3', '&lt;p&gt;&lt;span style=&quot;color: rgba(0, 0, 0, 0.5);&quot;&gt;BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3BIMBINGAN 3&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 'nofile', 3, 2, '2022-04-01 20:55:37', 'new', 3, 3),
(7, 3, 3, 'dsn', 3, 'mhs', 'DSN-TOPIK-1661850941', 'Revisi', '&lt;p&gt;Latar belakang masih belum menggambarkan masalahnutama yang ingin diteliti.&lt;/p&gt;', 'nofile', 5, 1, '2022-08-30 16:15:41', 'Y', NULL, 3),
(8, 3, 3, 'dsn', 3, 'mhs', 'DSN-TOPIK-1661850941', 'Revisi', '&lt;p&gt;Kok blm direvisi jg?&lt;/p&gt;', 'nofile', 5, 1, '2022-08-30 16:38:28', 'new', 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tm_doc`
--

CREATE TABLE `tm_doc` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tm_doc`
--

INSERT INTO `tm_doc` (`id`, `file_name`) VALUES
(1, 'Tess'),
(2, 'tmuhdywq');

-- --------------------------------------------------------

--
-- Table structure for table `tm_fakultas`
--

CREATE TABLE `tm_fakultas` (
  `fakultas_id` int(11) NOT NULL,
  `fakultas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tm_fakultas`
--

INSERT INTO `tm_fakultas` (`fakultas_id`, `fakultas`) VALUES
(1, 'ILMU KOMPUTER'),
(2, 'ILMU PENDIDIKAN');

-- --------------------------------------------------------

--
-- Table structure for table `tm_jenis`
--

CREATE TABLE `tm_jenis` (
  `id` int(11) NOT NULL,
  `jenis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tm_jenis`
--

INSERT INTO `tm_jenis` (`id`, `jenis`) VALUES
(1, 'Hardware/ dan Software'),
(2, 'Studi Literatur/ Pengkajian / Analisa');

-- --------------------------------------------------------

--
-- Table structure for table `tm_periode`
--

CREATE TABLE `tm_periode` (
  `periode_id` int(11) NOT NULL,
  `th_periode` varchar(20) DEFAULT NULL,
  `stt_periode` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tm_periode`
--

INSERT INTO `tm_periode` (`periode_id`, `th_periode`, `stt_periode`) VALUES
(3, '2021/2022', 'on'),
(4, '2022/2023', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tm_prodi`
--

CREATE TABLE `tm_prodi` (
  `prodi_id` int(11) NOT NULL,
  `fakultas_id` int(11) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `konsen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tm_prodi`
--

INSERT INTO `tm_prodi` (`prodi_id`, `fakultas_id`, `prodi`, `konsen`) VALUES
(1, 1, 'Teknik Informatika', 'Webprogramming'),
(2, 1, 'Teknik Lingkungan Hidup', 'Teknik Lingkungan Hidup');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pembing`
--
ALTER TABLE `pembing`
  ADD PRIMARY KEY (`pembing_id`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`pengajuan_id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`reply_id`);

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_dsn`
--
ALTER TABLE `tb_dsn`
  ADD PRIMARY KEY (`id_dsn`);

--
-- Indexes for table `tb_fileskripsi`
--
ALTER TABLE `tb_fileskripsi`
  ADD PRIMARY KEY (`id_file`);

--
-- Indexes for table `tb_forum`
--
ALTER TABLE `tb_forum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_info`
--
ALTER TABLE `tb_info`
  ADD PRIMARY KEY (`info_id`);

--
-- Indexes for table `tb_mhs`
--
ALTER TABLE `tb_mhs`
  ADD PRIMARY KEY (`id_mhs`);

--
-- Indexes for table `tb_pesan`
--
ALTER TABLE `tb_pesan`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indexes for table `tm_doc`
--
ALTER TABLE `tm_doc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tm_fakultas`
--
ALTER TABLE `tm_fakultas`
  ADD PRIMARY KEY (`fakultas_id`);

--
-- Indexes for table `tm_jenis`
--
ALTER TABLE `tm_jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tm_periode`
--
ALTER TABLE `tm_periode`
  ADD PRIMARY KEY (`periode_id`);

--
-- Indexes for table `tm_prodi`
--
ALTER TABLE `tm_prodi`
  ADD PRIMARY KEY (`prodi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pembing`
--
ALTER TABLE `pembing`
  MODIFY `pembing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `pengajuan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_dsn`
--
ALTER TABLE `tb_dsn`
  MODIFY `id_dsn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_fileskripsi`
--
ALTER TABLE `tb_fileskripsi`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_forum`
--
ALTER TABLE `tb_forum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_info`
--
ALTER TABLE `tb_info`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_mhs`
--
ALTER TABLE `tb_mhs`
  MODIFY `id_mhs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_pesan`
--
ALTER TABLE `tb_pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tm_doc`
--
ALTER TABLE `tm_doc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tm_fakultas`
--
ALTER TABLE `tm_fakultas`
  MODIFY `fakultas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tm_jenis`
--
ALTER TABLE `tm_jenis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tm_periode`
--
ALTER TABLE `tm_periode`
  MODIFY `periode_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tm_prodi`
--
ALTER TABLE `tm_prodi`
  MODIFY `prodi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
