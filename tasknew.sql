-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2025 at 01:41 PM
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
-- Database: `tasknew`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 2089.95, 'cancelled', '2025-11-30 05:11:46', '2025-11-30 05:18:48'),
(2, 10, 2089.95, 'pending', '2025-11-30 05:47:08', '2025-11-30 05:47:08'),
(3, 11, 349.95, 'cancelled', '2025-11-30 11:29:14', '2025-11-30 11:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 2, 999.99, '2025-11-30 05:11:46', '2025-11-30 05:11:46'),
(2, 1, 11, 3, 29.99, '2025-11-30 05:11:46', '2025-11-30 05:11:46'),
(3, 2, 10, 2, 999.99, '2025-11-30 05:47:08', '2025-11-30 05:47:08'),
(4, 2, 11, 3, 29.99, '2025-11-30 05:47:08', '2025-11-30 05:47:08'),
(5, 3, 11, 3, 29.99, '2025-11-30 11:29:14', '2025-11-30 11:29:14'),
(6, 3, 12, 2, 129.99, '2025-11-30 11:29:14', '2025-11-30 11:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `price`, `stock`, `created_at`, `updated_at`) VALUES
(10, 'Laptop Pro', 'LAP001', 999.99, 10, '2025-11-29 16:58:03', '2025-11-29 16:58:03'),
(11, 'Wireless Mouse', 'MOU001', 29.99, 45, '2025-11-29 16:58:03', '2025-11-29 16:58:03'),
(12, 'Mechanical Keyboard', 'KEY001', 129.99, 25, '2025-11-29 16:58:03', '2025-11-29 16:58:03'),
(13, 'Product A', 'SKU-A-001', 199.99, 5, '2025-11-30 04:18:33', '2025-11-30 04:18:33'),
(14, 'Product B', 'SKU-B-001', 49.50, 15, '2025-11-30 04:18:33', '2025-11-30 04:18:33'),
(15, 'Product C', 'SKU-C-001', 9.99, 95, '2025-11-30 04:18:33', '2025-11-30 04:18:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(6, 'Test User', 'test@example.com', '$2y$10$8aGSR0HRTdqp4hDIgf28Qud5GeuVUSty48uJS3tOZ2QcbX36A940G', '2025-11-29 16:58:02', '2025-11-29 16:58:02'),
(7, 'Katta', 'katta@example.com', '$2y$10$qa3fPZhYrzLHFSiLArkuVeTqVUGgOjWKYcX3CvdPItQ1RjTc/xZuG', '2025-11-29 18:31:50', '2025-11-29 18:31:50'),
(8, 'Ali Khan', 'ali@gmail.com', '$2y$10$mlqx5jVtJydA6uazhfOTje1OOuzoLcrUxUU3/C7IGk.9gZNrBKebu', '2025-11-30 04:29:24', '2025-11-30 04:29:24'),
(9, 'Vijay', 'Vijay@gmail.com', '$2y$10$yga9NzsIRtLe4aC30vVHL.WH5QPEL2awUz6.NFAz8aTP6qIgACSZq', '2025-11-30 04:30:18', '2025-11-30 04:30:18'),
(10, 'kirankumar', 'kiran@gmail.com', '$2y$10$57xn84XCACPc7QU4ZPwx.u8az04Dznd0pKQG3h1Bl.hI1HqYeethq', '2025-11-30 05:36:45', '2025-11-30 05:36:45'),
(11, 'bharathkiran', 'bharathkiran@gmail.com', '$2y$10$A/rW/Yb8knw8aV6aRLWRruEQkGKefIV136LMJn/Mk5vj4/k0taF/u', '2025-11-30 11:25:46', '2025-11-30 11:25:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
