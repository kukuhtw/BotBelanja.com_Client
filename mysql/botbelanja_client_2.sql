-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 31, 2022 at 06:19 AM
-- Server version: 8.0.31-0ubuntu0.22.04.1
-- PHP Version: 8.0.24

/*
============ PERHATIAN =======================

bila mysql di server tidak support utf8mb4_0900_ai_ci
gunakan utf8mb4_general_ci


*/
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `botbelanja_client`
--

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` bigint NOT NULL,
  `orderdate` datetime DEFAULT NULL,
  `namapembeli` varchar(255) DEFAULT NULL,
  `emailpembeli` varchar(255) DEFAULT NULL,
  `wapembeli` varchar(255) DEFAULT NULL,
  `alamatkirim` text,
  `telegramid` varchar(255) DEFAULT NULL,
  `telegramusername` varchar(255) DEFAULT NULL,
  `json_item` text,
  `apps_id` bigint DEFAULT NULL,
  `owner_id` bigint DEFAULT NULL,
  `grandtotal` int DEFAULT NULL,
  `is_paid` tinyint(1) DEFAULT '0',
  `paid_date` text,
  `catatan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` bigint NOT NULL,
  `order_id` bigint DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `cartid` bigint DEFAULT NULL,
  `cartdate` varchar(255) DEFAULT NULL,
  `score` int DEFAULT NULL,
  `user_command` text,
  `hargasatuan` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `totalharga` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `telegram_user`
--

CREATE TABLE `telegram_user` (
  `id` bigint NOT NULL,
  `telegramid` varchar(255) DEFAULT NULL,
  `telegramusername` varchar(255) DEFAULT NULL,
  `lastmessages` text,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `alamat_kirim` text,
  `mode_isidata` char(12) DEFAULT NULL,
  `mode_order` tinyint(1) DEFAULT '0',
  `lastupdatedate` datetime DEFAULT NULL,
  `regdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wa_user`
--

CREATE TABLE `wa_user` (
  `id` bigint NOT NULL,
  `senderid` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sendername` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastmessages` text COLLATE utf8mb4_general_ci,
  `nama` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat_kirim` text COLLATE utf8mb4_general_ci,
  `mode_isidata` char(12) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mode_order` tinyint(1) DEFAULT '0',
  `lastupdatedate` datetime DEFAULT NULL,
  `regdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `telegram_user`
--
ALTER TABLE `telegram_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_user`
--
ALTER TABLE `wa_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `telegram_user`
--
ALTER TABLE `telegram_user`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wa_user`
--
ALTER TABLE `wa_user`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
