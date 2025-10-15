-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2025 at 02:25 PM
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
-- Database: `login_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `recently_deleted_users`
--

CREATE TABLE `recently_deleted_users` (
  `id` int(11) NOT NULL,
  `original_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recently_deleted_users`
--

INSERT INTO `recently_deleted_users` (`id`, `original_id`, `fullname`, `username`, `email`, `role`, `deleted_at`) VALUES
(1, 15, 'Vincent paul D Pena', 'vince', 'keycm109@gmail.com', 'user', '2025-10-06 14:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `role`) VALUES
(10, 'Kurt', '$2y$10$OHt4dtZLglMi.yWuaq4Jt.43R4ztFWU4HFAjpnGVw1fFfWUw1hN12', 'Kurt Mariano', 'kurt@gmail.com', 'user'),
(11, 'Kurt', '$2y$10$Im4RjfVjTVaRBAI2A6rfX.OxCQCdv2BhMjQu.C0yrKByit7gM/F0u', 'Kurt Mariano', 'GNCkurtbryan@gmail.com', 'user'),
(12, 'admin', '$2y$10$IpINxi0ujglvkWFgvggk8.So8u3mb3sWjLy0D7xbAqGfl./np8Hwm', 'Administrator', 'admin@gmail.com', 'admin'),
(13, 'Kurt', '$2y$10$AQb/eXRt8tZaYHPR1aj9Lez1xwL58Ebe0wVBGdt5p7WT4YM6Q17NS', 'Kurt Mariano', 'GNCkurtbryan@email.com', 'user'),
(14, 'Joseph', '$2y$10$iNpd8NeCvSiTU2bIBDucmOvLFBzCV8zJdSWvBzmWeIV1pTw7KEBNq', 'Joseph Lintag', 'Joseph@gmail.com', 'user'),
(16, 'John Joseph Lintag', '$2y$10$FUKiaV8B5iqySJcetZ7aXOarlIDZmHwCpDHpRI.fw1qgSV2AepcBu', 'John Joseph Lintag', 'Joseph@gmail.com', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recently_deleted_users`
--
ALTER TABLE `recently_deleted_users`
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
-- AUTO_INCREMENT for table `recently_deleted_users`
--
ALTER TABLE `recently_deleted_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
