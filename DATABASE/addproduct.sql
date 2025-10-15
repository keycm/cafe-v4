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
-- Database: `addproduct`
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `fullname`, `contact`, `address`, `cart`, `total`, `created_at`, `status`) VALUES
(37, 'Kurt', '999999', 'Guagua', '[{\"name\":\"nike\",\"price\":1000,\"quantity\":7,\"size\":\"40\",\"color\":\"Black\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/assets\\/sapsap-Picsart-BackgroundRemover.jpg\"}]', 7030.00, '2025-09-25 11:14:45', 'Completed'),
(38, 'Johnny', '999999', 'Guagua', '[{\"name\":\"curry\",\"price\":1500,\"quantity\":8,\"size\":\"40\",\"color\":\"Blue\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/uploads\\/689360e00617a_shoes3%201.png\"}]', 12030.00, '2025-09-25 11:18:38', 'Completed'),
(40, 'Pet', '123456789', 'Dampe', '[{\"name\":\"Kobe 6\",\"price\":6000,\"quantity\":1,\"size\":\"45\",\"color\":\"Blue\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/uploads\\/68c408b3aec90_Kobe-removebg-preview.png\"}]', 6030.00, '2025-09-25 12:56:03', 'Completed'),
(42, 'Noel', '88888888', 'San Antonio', '[{\"name\":\"Pet shoes\",\"price\":5000,\"quantity\":1,\"size\":\"40\",\"color\":\"Black\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/uploads\\/68c4ec028f31d_Immortality_4-removebg-preview.png\"}]', 5030.00, '2025-10-06 13:06:03', 'Cancelled'),
(43, 'Nicolai', '999999', 'San Nicolas', '[{\"name\":\"curry\",\"price\":1500,\"quantity\":2,\"size\":\"40\",\"color\":\"Blue\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/uploads\\/689360e00617a_shoes3%201.png\"}]', 3030.00, '2025-10-06 13:06:07', 'Cancelled'),
(46, 'John Joseph Lintag', '091035566626', 'Guagua', '[{\"name\":\"nike\",\"price\":1000,\"quantity\":1,\"size\":\"43\",\"color\":\"Blue\",\"image\":\"http:\\/\\/localhost\\/saplot-69\\/assets\\/sapsap-Picsart-BackgroundRemover.jpg\"}]', 1030.00, '2025-10-07 09:24:25', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'New',
  `received_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `first_name`, `last_name`, `email`, `message`, `status`, `received_at`) VALUES
(1, 'joseph_customer', 'lintag', 'joseph@gmail.com', 'Hello', 'New', '2025-10-07 08:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Completed','Cancelled') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `fullname`, `contact`, `address`, `payment_method`, `total`, `created_at`, `status`) VALUES
(1, 'Test User', '09123456789', 'Sample Address', 'COD', 1500.00, '2025-09-18 13:40:33', 'Completed'),
(2, 'Nicolai', '999999', 'Dampe', '', 25030.00, '2025-09-22 05:59:55', 'Pending'),
(3, 'Hawk', '999999', 'Guagua', '', 14030.00, '2025-09-22 06:14:46', 'Pending'),
(4, 'Nic', '0999999', 'Guagua', '', 7530.00, '2025-09-22 06:18:44', 'Pending'),
(5, 'Nic', '0999999', 'San Nicolas', '', 3030.00, '2025-09-22 06:20:04', 'Pending'),
(6, 'Jem', '999999', 'Poblacion', '', 1030.00, '2025-09-24 04:41:38', 'Pending'),
(7, 'Jem', '999999', 'Poblacion', '', 1530.00, '2025-09-24 04:43:41', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`) VALUES
(4, 1, 2, 'nike', 1, 300.00),
(5, 1, 3, 'Addidas', 4, 200.00),
(7, 3, 3, NULL, 7, 0.00),
(8, 4, 4, NULL, 5, 0.00),
(9, 5, 8, NULL, 3, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `rating`, `stock`, `category`) VALUES
(2, 'nike', 1000.00, 'assets/sapsap-Picsart-BackgroundRemover.jpg', 3, 10, ''),
(3, 'Addidas', 2000.00, 'uploads/68935df666001_sap5.jpg', 0, 10, ''),
(4, 'curry', 1500.00, 'uploads/689360e00617a_shoes3 1.png', 0, 13, ''),
(8, 'Nike P6000', 1000.00, 'uploads/689bf0970d0f4_Nike.jpg', 0, 18, 'running'),
(36, 'Jordan', 2000.00, 'uploads/689c01b0ba346_Jordan_1-removebg-preview.png', 0, 2, 'style'),
(37, 'Jordan 1 ', 1500.00, 'uploads/68c3f3786dcfc_Jordan_1-removebg-preview.png', 0, 11, 'style');

-- --------------------------------------------------------

--
-- Table structure for table `recently_deleted`
--

CREATE TABLE `recently_deleted` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cart` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`cart`)),
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recently_deleted`
--

INSERT INTO `recently_deleted` (`id`, `order_id`, `fullname`, `contact`, `address`, `cart`, `total`, `created_at`, `status`, `deleted_at`) VALUES
(21, 32, 'James', '999999', 'Guagua', '[{\"name\":\"nike\",\"price\":1000,\"quantity\":1,\"size\":\"40\",\"color\":\"Black\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/assets\\/sapsap-Picsart-BackgroundRemover.jpg\"}]', 1030.00, '2025-09-25 10:46:35', 'Cancelled', '2025-09-25 12:26:12'),
(22, 25, 'Nicolai', '123456789', 'Basa ', '[{\"name\":\"Jordan\",\"price\":2000,\"quantity\":7,\"size\":\"40\",\"color\":\"Blue\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/uploads\\/689c01b0ba346_Jordan_1-removebg-preview.png\"}]', 14030.00, '2025-09-25 09:22:59', 'Cancelled', '2025-09-25 12:26:18'),
(24, 41, 'Pet', '123456789', 'San Nicolas', '[{\"name\":\"Kobe 6\",\"price\":6000,\"quantity\":2,\"size\":\"45\",\"color\":\"Blue\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/uploads\\/68c408b3aec90_Kobe-removebg-preview.png\"}]', 12030.00, '2025-09-25 12:57:53', 'Completed', '2025-10-06 13:55:26'),
(25, 45, 'James', '999999', 'Guagua', '[{\"name\":\"nike\",\"price\":1000,\"quantity\":1,\"size\":\"40\",\"color\":\"Black\",\"image\":\"http:\\/\\/localhost\\/saplot-69%201\\/saplot-69\\/assets\\/sapsap-Picsart-BackgroundRemover.jpg\"}]', 1030.00, '2025-10-06 13:31:09', 'Cancelled', '2025-10-06 13:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `recently_deleted_products`
--

CREATE TABLE `recently_deleted_products` (
  `id` int(11) NOT NULL,
  `original_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `rating` int(11) DEFAULT 5,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recently_deleted_products`
--

INSERT INTO `recently_deleted_products` (`id`, `original_id`, `name`, `price`, `stock`, `image`, `category`, `rating`, `deleted_at`) VALUES
(1, 32, 'Kobe 6', 6000.00, 2, 'uploads/68c408b3aec90_Kobe-removebg-preview.png', 'basketball', 0, '2025-10-06 13:25:42'),
(4, 5, 'curry', 1500.00, 5, 'uploads/6893631b58869_saplot.jpg', '', 0, '2025-10-06 15:17:12'),
(5, 6, 'Immortality', 1500.00, 2, 'uploads/689bebb16a614_Immortality_4-removebg-preview.png', 'basketball', 0, '2025-10-06 15:17:31');

-- --------------------------------------------------------

--
-- Table structure for table `revenue`
--

CREATE TABLE `revenue` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revenue`
--

INSERT INTO `revenue` (`id`, `order_id`, `amount`, `date_created`) VALUES
(5, 37, 7030.00, '2025-09-25 12:26:22'),
(6, 38, 12030.00, '2025-09-25 12:40:14'),
(7, 40, 6030.00, '2025-09-25 12:56:42'),
(8, 41, 12030.00, '2025-09-25 12:58:21'),
(9, 46, 1030.00, '2025-10-07 09:25:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
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
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recently_deleted`
--
ALTER TABLE `recently_deleted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recently_deleted_products`
--
ALTER TABLE `recently_deleted_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `revenue`
--
ALTER TABLE `revenue`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `recently_deleted`
--
ALTER TABLE `recently_deleted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `recently_deleted_products`
--
ALTER TABLE `recently_deleted_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `revenue`
--
ALTER TABLE `revenue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
