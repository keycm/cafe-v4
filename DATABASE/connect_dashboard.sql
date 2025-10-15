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
-- Database: `connect_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `cart` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`cart`)),
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(20) DEFAULT 'COD',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `fullname`, `contact`, `address`, `cart`, `total`, `payment_method`, `created_at`, `status`) VALUES
(32, 'Kurt', '999999', 'Guagua', '[{\"name\":\"nike\",\"price\":1000,\"quantity\":1,\"size\":\"40\",\"color\":\"Blue\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/assets\\/sapsap-Picsart-BackgroundRemover.jpg\"}]', 1030.00, 'COD', '2025-09-11 13:10:13', 'Pending'),
(33, 'Kurt', '999999', 'Guagua', '[{\"name\":\"nike\",\"price\":1000,\"quantity\":1,\"size\":\"40\",\"color\":\"Blue\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/assets\\/sapsap-Picsart-BackgroundRemover.jpg\"}]', 1030.00, 'COD', '2025-09-11 13:10:13', 'Pending'),
(34, 'Kurt', '999999', 'Guagua', '[{\"name\":\"nike\",\"price\":1000,\"quantity\":1,\"size\":\"40\",\"color\":\"Blue\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/assets\\/sapsap-Picsart-BackgroundRemover.jpg\"}]', 1030.00, 'COD', '2025-09-11 13:10:13', 'Pending'),
(43, 'Kurt', '999999', 'Guagua', '[{\"name\":\"nike\",\"price\":1000,\"quantity\":1,\"size\":\"40\",\"color\":\"Blue\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/assets\\/sapsap-Picsart-BackgroundRemover.jpg\"}]', 1030.00, 'COD', '2025-09-11 14:00:53', 'Pending'),
(44, 'Kurt', '999999', 'yes', '[{\"name\":\"nike\",\"price\":1000,\"quantity\":10,\"size\":\"40\",\"color\":\"Blue\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/assets\\/sapsap-Picsart-BackgroundRemover.jpg\"}]', 10030.00, 'COD', '2025-09-13 03:16:09', 'Completed'),
(45, 'Kurt', '999999', 'yes', '[{\"name\":\"nike\",\"price\":1000,\"quantity\":2,\"size\":\"40\",\"color\":\"Black\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/assets\\/sapsap-Picsart-BackgroundRemover.jpg\"}]', 2030.00, 'COD', '2025-09-13 03:39:35', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `fullname`, `contact`, `address`, `total`, `payment_method`, `created_at`, `order_date`) VALUES
(1, 'Kurt', '999999', 'Guagua', 24530.00, 'COD', '2025-07-25 14:08:11', '2025-07-25 22:08:11'),
(2, 'Kurt', '0999999', 'Guagua', 24530.00, 'Cash on Delivery', '2025-07-25 14:11:04', '2025-07-25 22:11:04'),
(3, 'Kurt', '0999999', 'Guagua', 24530.00, 'Cash on Delivery', '2025-07-25 14:16:37', '2025-07-25 22:16:37');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stockalert`
--

CREATE TABLE `stockalert` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `stock_remaining` int(11) DEFAULT NULL,
  `alert_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stockalert`
--
ALTER TABLE `stockalert`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stockalert`
--
ALTER TABLE `stockalert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
