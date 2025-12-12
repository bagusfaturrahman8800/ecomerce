-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 29 Mei 2025 pada 17.51
-- Versi Server: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tirta`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(6, 'admin', '$2y$10$syQ.4BaDSzJFViABwq5d3eBKampBzf3fP66BgdzimgcBsRUoVdFcC', 'Admin Master', 'admin'),
(7, 'Albert', '$2y$10$NW58aJLMrvTD1DnZHUiA6uuGewx87okzpEZVKaZxD3KwB/0x2MaMO', 'Albert Ensteint', 'user'),
(9, 'tirta', '$2y$10$MNJ7/E8GvVmYEBvv7McgtupLkWV6OXiKMDwKMMl0uwpsdVjCP0hFm', 'Tirta Adjie', 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `price_list`
--

CREATE TABLE `price_list` (
  `id` int(11) NOT NULL,
  `jenis_mobil` varchar(100) NOT NULL,
  `tipe_mobil` varchar(100) NOT NULL,
  `harga` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `price_list`
--

INSERT INTO `price_list` (`id`, `jenis_mobil`, `tipe_mobil`, `harga`) VALUES
(6, 'Agya', '1.2 G M/T', '193400000'),
(7, 'Agya', '1.2 G CVT', '209100000'),
(8, 'Agya', '1.2 GR M/T (ONE TONE)', '255000000'),
(9, 'Agya', '1.2 GR M/T (TWO TONE)', '257500000'),
(10, 'Agya', '1.2 GR CVT (ONE TONE)', '270700000'),
(11, 'Alphard', '2.5 G A/T (NON PREMIUM COLOR)', '1385600000'),
(12, 'Alphard', '2.5 G A/T (PREMIUM COLOR)', '1388700000'),
(13, 'Alphard', 'NEW ALPHARD 2.5 G CVT', '1576400000'),
(15, 'Alphard', 'NEW ALPHARD 2.5 HYBRID CVT', '1654100000'),
(16, 'Yaris', 'CROSS 1.5 G M/T', '358300000'),
(17, 'Yaris', 'CROSS 1.5 G CVT', '371300000'),
(18, 'Yaris', 'CROSS 1.5 S CVT TSS', '414800000'),
(19, 'Yaris', 'CROSS 1.5 GR CVT TSS', '424200000'),
(20, 'Yaris', 'CROSS 1.5 S CVT TSS (PREMIUM COLOR)', '417300000'),
(21, 'Avanza Veloz', '1.5 M/T', '310500000'),
(22, 'Avanza Veloz', '1.5 M/T (PREMIUM COLOR)', '312000000'),
(23, 'Avanza Veloz', '1.5 CVT', '325700000'),
(24, 'Avanza Veloz', '1.5 CVT (PREMIUM COLOR)', '327200000'),
(25, 'Avanza Veloz', ' 1.5 Q CVT', '334500000'),
(26, 'Inova Zenix', '2.0 G CVT', '429700000'),
(27, 'Inova Zenix', '2.0 G CVT COMPACT PACKAGE', '432434000'),
(28, 'Inova Zenix', '2.0 G CVT (PREMIUM COLOR)', '432700000'),
(29, 'Inova Zenix', 'ZENIX 2.0 G CVT (PREMIUM COLOR) COMPACT', '435434000'),
(30, 'Fortuner', '2.7 SRZ 4X2 A/T BENSIN GR SPORT', '605450000'),
(31, 'Fortuner', '2.4 G 4X2 M/T DSL', '564450000'),
(32, 'Fortuner', '2.4 G 4X2 A/T DSL', '582150000'),
(33, 'Fortuner', '2.8 VRZ 4X2 A/T', '620200000'),
(34, 'Fortuner', '2.8 VRZ GR-S 4X2 A/T', '639100000'),
(35, 'Raize', '1.2 G M/T (ONE TONE COLOR)', '252300000'),
(36, 'Raize', '1.2 G CVT (ONE TONE COLOR)', '266800000'),
(37, 'Raize', '1.0T G M/T (ONE TONE COLOR)', '271200000'),
(38, 'Raize', '1.0T G M/T (TWO TONE COLOR)', '273800000'),
(39, 'Hilux', 'SINGLE CABIN 2.0 M/T', '288400000'),
(40, 'Hilux', 'CABIN 2.4 M/T DIESEL', '310800000'),
(41, 'Hilux', 'SINGLE CABIN 2.4 M/T (4X4) DIESEL', '411800000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama_mobil` varchar(100) NOT NULL,
  `gambar` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama_mobil`, `gambar`, `created_at`) VALUES
(22, 'Agya', 'Assets/img/katalog/agya_.png', '2025-05-26 09:35:30'),
(23, 'Agya', 'Assets/img/katalog/agya_black.png', '2025-05-26 09:37:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price_list`
--
ALTER TABLE `price_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `price_list`
--
ALTER TABLE `price_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
