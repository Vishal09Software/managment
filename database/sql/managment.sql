-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 12, 2025 at 08:36 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `managment`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('0196dc8f53b8ce0c26c1cd79cc2a7954', 's:3122:\"data:image/png;base64,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\";', 2054707882),
('10628cc83238e1be7742515b921115c0', 's:3246:\"data:image/png;base64,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\";', 2054707824),
('183523be9401cd3ba86b7ead7a2b574b', 's:2370:\"data:image/png;base64,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\";', 2054707824),
('2a531b6e8ebe6145e90a61ca88a7d3fa', 's:2674:\"data:image/png;base64,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\";', 2054707805),
('52f58e2be74f8378696c271a9ae303e0', 's:2674:\"data:image/png;base64,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\";', 2054707811),
('ada66518cc0d9c6437b1998fce0ea244', 's:3246:\"data:image/png;base64,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\";', 2054707819),
('f530f95e655c6ed1667a27ff0aa758d4', 's:3810:\"data:image/png;base64,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\";', 2054707811);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `mobile`, `address`, `gender`, `dob`, `image`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Kibo Cantrell', 'taxuqy@mailinator.com', '+1 (147) 547-5689', 'Maiores et ipsam vol', 'female', '1996-04-24', NULL, 1, NULL, '2025-02-12 02:40:05', '2025-02-12 02:40:05'),
(2, 'Quinn Melton', 'pomyhodyma@mailinator.com', '+1 (152) 961-6021', 'In harum labore ut s', 'female', '1992-11-21', NULL, 1, NULL, '2025-02-12 02:40:10', '2025-02-12 02:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(11, '0001_01_01_000000_create_users_table', 1),
(12, '0001_01_01_000001_create_cache_table', 1),
(13, '0001_01_01_000002_create_jobs_table', 1),
(14, '2025_02_10_111002_create_customers_table', 1),
(15, '2025_02_10_115143_create_vendors_table', 1),
(16, '2025_02_11_044534_create_taxes_table', 1),
(17, '2025_02_11_055302_create_products_table', 1),
(18, '2025_02_11_063419_create_vehicles_table', 1),
(19, '2025_02_11_090049_create_sales_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hsn_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `tax_id` bigint UNSIGNED DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `hsn_code`, `grade`, `price`, `tax_id`, `image`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Cement', 'cement101', 'A', 420.00, 1, NULL, 1, NULL, '2025-02-12 02:41:22', '2025-02-12 02:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint UNSIGNED NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eway_bill_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `r_weight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `k_weight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `v_total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `date`, `vendor_id`, `vendor_name`, `vendor_mobile`, `customer_id`, `customer_name`, `customer_mobile`, `eway_bill_number`, `vehicle_id`, `vehicle_number`, `driver_name`, `driver_phone`, `vehicle_rate`, `image`, `r_weight`, `k_weight`, `product_id`, `p_price`, `s_price`, `tax_id`, `tax_name`, `tax_rate`, `remark`, `p_total`, `s_total`, `v_total`, `created_at`, `updated_at`) VALUES
(1, '1975-12-17', '2', 'Powell and Faulkner Traders', '+1 (213) 774-3308', '2', 'Quinn Melton', '+1 (152) 961-6021', '845', '1', '451', 'Cora Webb', '+1 (251) 239-7785', '86', '1739349101.png', '7', '88', '1', '420.00', '57', '4', 'GST 18%', '18.00', 'Non sed quisquam pos', '43612.80', '5918.88', '8930.24', '2025-02-12 02:59:18', '2025-02-12 03:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('iYWBItghelhB16u0VebbwgaW0kRsFZpRm0ty37fq', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS1VpdWNSSVhHZVFFN2lBVDNTNzJ0WjJEQm80UlVnSEZYRTBMZWd1NyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MzoiaHR0cDovL2xvY2FsaG9zdC9tYW5hZ21lbnQvcHVibGljL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vbG9jYWxob3N0L21hbmFnbWVudC9wdWJsaWMvc2FsZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1739349339);

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint UNSIGNED NOT NULL,
  `tax_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rate` decimal(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `tax_name`, `tax_rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 'GST 5%', 5.00, 1, '2025-02-12 02:40:45', '2025-02-12 02:40:45'),
(2, 'GST 8%', 8.00, 1, '2025-02-12 02:40:51', '2025-02-12 02:40:51'),
(3, 'GST 12%', 12.00, 1, '2025-02-12 02:40:58', '2025-02-12 02:40:58'),
(4, 'GST 18%', 18.00, 1, '2025-02-12 02:41:06', '2025-02-12 02:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `email_verified_at`, `password`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '2025-02-12 02:38:55', '$2y$12$nI3mGpKOct6YCVuFE58/h.92X3.D83Sxk75L4DY3kd5hoynvyR2zC', 'JPOccygzrC', NULL, '2025-02-12 02:38:55', '2025-02-12 02:38:55');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicle_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_name`, `vehicle_number`, `owner_name`, `owner_phone`, `owner_address`, `driver_name`, `driver_phone`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Kelly Wilkerson', '402', 'Kiona Flowers', '+1 (533) 145-4858', 'Dolore voluptas aper', 'Marah Hawkins', '+1 (792) 906-6519', '2025-02-12 02:42:00', '2025-02-12 03:05:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gst_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `email`, `mobile`, `gender`, `gst_number`, `dob`, `address`, `city`, `state`, `country`, `zip_code`, `image`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Mccall and Dillard Inc', 'megofe@mailinator.com', '+1 (824) 373-8429', 'female', '353', '1972-08-18', 'Enim ducimus distin', 'Nulla commodo tempor', 'Distinctio Est vol', 'Voluptatem beatae d', '52675', NULL, 1, NULL, '2025-02-12 02:40:19', '2025-02-12 02:40:19'),
(2, 'Powell and Faulkner Traders', 'lediq@mailinator.com', '+1 (213) 774-3308', 'female', '400', '2006-01-03', 'Commodo officiis imp', 'Temporibus autem pra', 'Nam ipsa odio omnis', 'Dolorem placeat ea', '28452', NULL, 1, NULL, '2025-02-12 02:40:24', '2025-02-12 02:40:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_vendor_id_index` (`vendor_id`),
  ADD KEY `sales_customer_id_index` (`customer_id`),
  ADD KEY `sales_vehicle_id_index` (`vehicle_id`),
  ADD KEY `sales_tax_id_index` (`tax_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
