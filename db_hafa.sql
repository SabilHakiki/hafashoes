-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2025 at 06:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hafa`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(3) NOT NULL,
  `nkategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nkategori`) VALUES
(1, 'sandal'),
(2, 'sepatu'),
(3, 'Tas');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `gmbr` varchar(500) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id`, `id_user`, `id_produk`, `gmbr`, `nama`, `harga`, `jumlah`, `subtotal`, `created_at`, `updated_at`) VALUES
(60, 1, 46, '[\"produk_67acabb041a0a.jpeg\"]', 'Kicker semar 5', 200000, 1, 200000.00, '2025-07-07 13:46:05', '2025-07-07 13:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama_pembeli` varchar(255) NOT NULL,
  `total_harga` decimal(15,2) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `tanggal_pesanan` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_pengiriman` timestamp NULL DEFAULT current_timestamp(),
  `alamat_pengiriman` text NOT NULL,
  `kurir_id` int(11) DEFAULT NULL,
  `kurir` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `id_user`, `nama_pembeli`, `total_harga`, `status`, `tanggal_pesanan`, `tanggal_pengiriman`, `alamat_pengiriman`, `kurir_id`, `kurir`, `created_at`) VALUES
(1, 2, '', 200000.00, 'Dalam Proses', '2024-10-03 12:22:10', '2024-11-12 21:12:10', 'asd', 12, 'Fernanda', '2024-11-30 14:09:02'),
(2, 1, '', 300000.00, 'Menunggu Konfirmasi', '2024-07-16 12:30:19', '2024-11-12 21:16:28', 'Gribig 1/4, Gebog, Kudus', NULL, '', '2024-11-30 14:09:02'),
(3, 1, '', 300000.00, 'Menunggu Konfirmasi', '2024-10-03 12:32:22', '2024-11-23 21:07:43', 'hehe', NULL, '', '2024-11-30 14:09:02'),
(4, 1, '', 100000.00, 'Menunggu Konfirmasi', '2024-10-03 12:48:19', '2024-11-24 05:58:16', 'wewew', NULL, '', '2024-11-30 14:09:02'),
(9, 1, '', 300000.00, 'Menunggu Konfirmasi', '2024-10-16 14:51:08', '2024-11-12 21:29:27', 'JAWA', NULL, '', '2024-11-30 14:09:02'),
(10, 1, '', 360000.00, 'Sedang Dikirim', '2024-08-21 12:29:57', '2025-02-08 20:53:07', 'JAWA tengah', 1, 'AdminSabil', '2024-11-30 14:09:02'),
(11, 1, '', 90000.00, 'Menunggu Konfirmasi', '2024-10-21 12:30:42', '2024-11-12 21:29:39', 'JAWA', NULL, '', '2024-11-30 14:09:02'),
(12, 1, '', 200000.00, 'Menunggu Konfirmasi', '2024-09-18 12:41:44', '2024-12-02 20:34:40', 'JAWA', NULL, '', '2024-11-30 14:09:02'),
(13, 1, '', 360000.00, 'Menunggu Konfirmasi', '2023-08-10 12:29:57', '2024-11-12 21:12:36', 'JAWA tengah', NULL, '', '2024-11-30 14:09:02'),
(14, 1, '', 90000.00, 'Selesai', '2024-10-22 12:30:42', '2024-12-03 00:03:59', 'Jawa Barat', 1, 'AdminSabil', '2024-11-30 14:09:02'),
(15, 1, '', 200000.00, 'Menunggu Konfirmasi', '2024-10-22 14:06:47', '2024-12-02 20:34:29', 'Jawa Barat', NULL, '', '2024-11-30 14:09:02'),
(16, 2, '', 1750000.00, 'Selesai', '2024-10-28 11:20:13', '2024-12-02 23:54:17', 'Gribig 1/4, Gebog, Kudus', 11, 'daniel', '2024-11-30 14:09:02'),
(17, 2, '', 590000.00, 'Menunggu Konfirmasi', '2024-11-30 06:53:20', '2024-11-30 07:19:00', 'Gribig 1/4, Gebog, Kudus', NULL, '', '2024-11-30 14:09:02'),
(18, 2, '', 80000.00, 'Selesai', '2024-12-02 21:07:00', '2024-12-17 20:21:28', 'Gribig 1/4, Gebog, Kudus', 5, 'albert kurir ', '2024-12-03 04:07:00'),
(19, 2, '', 250000.00, 'Dalam Proses', '2024-12-05 06:34:21', '2024-12-05 13:34:21', 'Gribig 1/4, Gebog, Kudus', 5, 'albert kurir ', '2024-12-05 13:34:21'),
(20, 2, 'Haris Sabil', 400000.00, 'Selesai', '2024-12-07 22:26:25', '2024-12-07 22:38:36', 'Gribig 1/4, Gebog, Kudus', 12, 'Fernanda', '2024-12-08 05:26:25'),
(21, 1, 'adadc', 200000.00, 'Menunggu Konfirmasi', '2025-01-16 05:36:51', '2025-01-16 12:36:51', 'saf', NULL, '', '2025-01-16 12:36:51'),
(32, 1, 'TIAN', 50000.00, 'Menunggu Konfirmasi', '2025-01-18 06:45:32', '2025-01-18 13:45:32', 'Gribig 1/4, Gebog, Kudus', NULL, '', '2025-01-18 13:45:32'),
(33, 2, 'haris sabil', 500000.00, 'Selesai', '2025-02-08 23:46:16', '2025-02-08 23:49:59', 'Gribig 1/4, Gebog, Kudus', 5, 'albert kurir ', '2025-02-09 06:46:16'),
(34, 1, 'AdminSabil', 300000.00, 'Selesai', '2025-04-16 21:39:39', '2025-04-16 21:40:29', 'Gribig 1/4, Gebog, Kudus', 1, 'AdminSabil', '2025-04-17 04:39:39'),
(35, 2, 'Sabil Hakiki', 400000.00, 'Menunggu Konfirmasi', '2025-04-16 22:13:01', '2025-04-17 05:13:01', 'Gribig 1/4, Gebog, Kudus', NULL, '', '2025-04-17 05:13:01'),
(36, 1, 'HafaShoes', 200000.00, 'Menunggu Konfirmasi', '2025-07-07 06:44:28', '2025-07-07 13:44:28', 'Gribig 1/4, Gebog, Kudus', NULL, '', '2025-07-07 13:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `id_order` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `id_order`, `id_produk`, `jumlah`, `harga`, `subtotal`) VALUES
(1, 1, 36, 2, 100000.00, 200000.00),
(2, 2, 36, 3, 100000.00, 300000.00),
(3, 3, 36, 3, 100000.00, 300000.00),
(4, 4, 37, 2, 50000.00, 100000.00),
(9, 9, 36, 3, 100000.00, 300000.00),
(10, 10, 36, 3, 100000.00, 300000.00),
(11, 10, 38, 2, 30000.00, 600000.00),
(12, 11, 38, 3, 30000.00, 90000.00),
(13, 12, 36, 2, 100000.00, 200000.00),
(14, 15, 40, 5, 40000.00, 200000.00),
(15, 16, 37, 20, 50000.00, 1000000.00),
(16, 16, 38, 25, 30000.00, 750000.00),
(17, 14, 38, 3, 30000.00, 90000.00),
(18, 17, 40, 6, 40000.00, 240000.00),
(19, 17, 36, 2, 100000.00, 200000.00),
(20, 17, 38, 5, 30000.00, 150000.00),
(21, 18, 40, 2, 40000.00, 80000.00),
(22, 19, 38, 5, 30000.00, 150000.00),
(23, 19, 37, 2, 50000.00, 100000.00),
(24, 20, 37, 8, 50000.00, 400000.00),
(25, 21, 45, 4, 50000.00, 200000.00),
(33, 32, 45, 1, 50000.00, 50000.00),
(34, 33, 37, 10, 50000.00, 500000.00),
(35, 34, 38, 10, 30000.00, 300000.00),
(36, 35, 57, 2, 200000.00, 400000.00),
(37, 36, 56, 1, 200000.00, 200000.00);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(3) NOT NULL,
  `gmbr` varchar(500) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` int(3) DEFAULT NULL,
  `harga` int(12) NOT NULL,
  `stok` int(3) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `gmbr`, `nama`, `kategori`, `harga`, `stok`, `deskripsi`, `created_at`) VALUES
(36, '[\"produk_1739078244_780e1d29ff532a019baa.jpg\"]', 'nike', 2, 100000, 50, '1 box berisi 10 pasang sepatu\r\nukuran 39-49\r\nwarna seperti digambar', '2025-02-09 07:01:54'),
(37, '[\"produk_1739078227_1f951d35159ba8a14a3a.jpg\"]', 'Bata', 2, 250000, 160, '1 box berisi 10 pasang sepatu\r\nukuran 39-49\r\nwarna seperti digambar', '2025-05-19 01:45:09'),
(38, '[\"produk_1739084540_3d79aae78bd512c25a7e.webp\"]', 'ventela', 2, 230000, 250, '1 box berisi 10 pasang sepatu\r\nukuran 39-49\r\nwarna seperti digambar', '2025-05-19 01:45:28'),
(40, '[\"produk_1739078190_36a9fc8a4924da0e0852.jpg\"]', 'ardiles', 2, 250000, 300, '1 box berisi 10 pasang sepatu\r\nukuran 39-49\r\nwarna seperti digambar', '2025-05-19 01:45:21'),
(44, '[\"produk_1739078442_3f09b5e5fb1037f9b154.webp\"]', 'rebook', 1, 220000, 5, '1 box berisi 10 pasang sepatu\r\nukuran 39-49\r\nwarna seperti digambar\r\n                                    ', '2025-05-19 01:45:43'),
(45, '[\"produk_1739079136_1c57d904c99ea97d8a0e.webp\"]', 'porto', 1, 250000, 5, '1 box berisi 10 pasang sepatu\r\nukuran 39-49\r\nwarna seperti digambar\r\n                                    ', '2025-05-19 01:45:15'),
(46, '[\"produk_67acabb041a0a.jpeg\"]', 'Kicker semar 5', 1, 200000, 8, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-02-22 15:24:39'),
(47, '[\"produk_67acad341955a.jpeg\"]', 'Kicker selop', 1, 200000, 8, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-02-22 15:25:13'),
(48, '[\"produk_67acada738eec.jpeg\"]', 'cirellie 01', 1, 200000, 8, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-02-22 15:25:33'),
(49, '[\"produk_67acae095cc3f.jpeg\"]', 'cirellie 02', 1, 200000, 8, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-02-22 15:27:28'),
(50, '[\"produk_67acae6b8639b.jpeg\"]', 'cirellie 03', 1, 200000, 8, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-02-22 15:27:28'),
(51, '[\"produk_67acaf4767679.jpeg\"]', 'cirellie 04', 1, 200000, 8, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-02-22 15:27:28'),
(52, '[\"produk_67acafea0e16c.jpeg\"]', 'cirellie 05', 1, 200000, 8, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-02-22 15:27:28'),
(53, '[\"produk_67acb036bad69.jpeg\"]', 'cirellie 06', 1, 200000, 8, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-02-22 15:27:28'),
(54, '[\"produk_67acb0630a913.jpeg\"]', 'cirellie 07', 1, 200000, 8, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-02-22 15:27:28'),
(55, '[\"produk_68007233a6e60.jpeg\"]', 'Kicker selop 03', 1, 200000, 8, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-04-17 03:14:59'),
(56, '[\"produk_680072d812c32.jpeg\"]', 'Kicker aerox 2', 1, 200000, 7, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-07-07 13:44:28'),
(57, '[\"produk_680073097c0a6.jpeg\"]', 'Kicker aerox 3', 1, 200000, 6, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-04-17 05:13:01'),
(58, '[\"produk_6800732308419.jpeg\"]', 'Kicker aerox 4', 1, 200000, 8, '1 box berisi 5 pasang sepatu\r\nukuran 39-43\r\nwarna seperti digambar\r\n                                    ', '2025-04-17 03:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(15) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `foto` varchar(500) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nohp` varchar(13) NOT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('admin','customer','kurir') NOT NULL DEFAULT 'customer',
  `destination_id` varchar(10) DEFAULT NULL,
  `destination_label` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `foto`, `email`, `nohp`, `alamat`, `password`, `role`, `destination_id`, `destination_label`) VALUES
(1, 'HafaShoes', 'profil_67a836e592a87.png', 'admin@gmail.com', '085173314620', 'selatan lap. Gribig 1/4, Gebog, Kudus', 'admin', 'admin', '65364', 'GRIBIG, GEBOG, KUDUS, JAWA TENGAH (59333)'),
(2, 'Sabil Hakiki', 'profil_678b9fc7081e8.png', 'sabil@gmail.com', '085173314620', 'Gribig 1/4, Gebog, Kudus', 'sabil', 'customer', NULL, NULL),
(5, 'albertus Reinaldo', '', 'kurir@gmail.com', '081229847531', 'Jl. Museum Kretek No.10, Getas Pejaten, Jati, Kudus', 'kurir', 'kurir', NULL, NULL),
(11, 'daniel', '', 'daniel@gmail.com', '089523326575', NULL, 'kurir', 'kurir', NULL, NULL),
(12, 'Fernanda', '', 'fernanda@gmail.com', '085713154151', NULL, 'fernanda', 'kurir', NULL, NULL),
(13, 'faishal', '', 'faishal@gmail.com', '123456', NULL, 'faishal', 'customer', NULL, NULL),
(14, 'khadafi', '', 'khadafi@gmail.com', '123456', NULL, 'khadafi', 'customer', NULL, NULL),
(15, 'risky', '', 'risky@gmail.com', '123654', NULL, 'risky', 'customer', NULL, NULL),
(16, 'shalalala', '', 'shalalala@gmail.com', '08977052793', 'Kudus', 'sembarang127', 'customer', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_keranjang_produk` (`id_produk`),
  ADD KEY `fk_keranjang_user` (`id_user`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `fk_keranjang_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`),
  ADD CONSTRAINT `fk_keranjang_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
