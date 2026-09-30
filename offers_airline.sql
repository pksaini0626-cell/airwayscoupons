-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2026 at 02:58 PM
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
-- Database: `offers_airline`
--

-- --------------------------------------------------------

--
-- Table structure for table `airlines`
--

CREATE TABLE `airlines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `airlines`
--

INSERT INTO `airlines` (`id`, `name`, `slug`, `code`, `logo`, `is_popular`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Delta Air Lines', 'delta-air-lines', 'DL', 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=120&auto=format&fit=crop&q=80', 1, 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(2, 'United Airlines', 'united-airlines', 'UA', 'https://images.unsplash.com/photo-1542296332-2e4473faf563?w=120&auto=format&fit=crop&q=80', 1, 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(3, 'American Airlines', 'american-airlines', 'AA', 'https://images.unsplash.com/photo-1506015391300-4802dc74de2e?w=120&auto=format&fit=crop&q=80', 1, 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(4, 'Southwest Airlines', 'southwest-airlines', 'WN', 'https://images.unsplash.com/photo-1519074069444-1ba4eff56024?w=120&auto=format&fit=crop&q=80', 1, 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(5, 'Qatar Airways', 'qatar-airways', 'QR', 'https://images.unsplash.com/photo-1524592714635-d77511a4834d?w=120&auto=format&fit=crop&q=80', 1, 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(6, 'Emirates', 'emirates', 'EK', 'https://images.unsplash.com/photo-1570710891163-6d3b5c47248b?w=120&auto=format&fit=crop&q=80', 1, 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(7, 'British Airways', 'british-airways', 'BA', 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=120&auto=format&fit=crop&q=80', 0, 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(8, 'Lufthansa', 'lufthansa', 'LH', 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=120&auto=format&fit=crop&q=80', 0, 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(9, 'JetBlue Airways', 'jetblue-airways', 'B6', 'https://images.unsplash.com/photo-1569154941061-e231b4725ef1?w=120&auto=format&fit=crop&q=80', 0, 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(10, 'Alaska Airlines', 'alaska-airlines', 'AS', 'https://images.unsplash.com/photo-1583508915901-b5f84c1dcde1?w=120&auto=format&fit=crop&q=80', 0, 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `airline_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_label` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `clicks_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `airline_id`, `coupon_category_id`, `title`, `code`, `discount_label`, `description`, `terms`, `phone_number`, `expiry_date`, `is_featured`, `is_active`, `clicks_count`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Exclusive $150 OFF USA Roundtrip Delta Flights', 'DELTA150USA', '$150 INSTANT OFF', 'Save up to $150 on roundtrip domestic travel with Delta Air Lines. Valid when booking through our live telephone booking desk.', 'Must be redeemed by phone with an agent. Minimum 2 passengers or roundtrip booking required.', '+1 (800) 555-0199', '2026-10-04', 1, 1, 343, '2026-08-20 15:45:49', '2026-08-20 15:56:20'),
(2, 2, 2, 'Save Up to 25% OFF Transatlantic & Global United Routes', 'UNITED25INTL', '25% OFF GLOBAL', 'Unlock unadvertised telephone agent discounts for international flights across Europe, Asia, and Latin America.', 'Available on select economy and premium economy routes. Call agent with promo code to redeem.', '+1 (800) 555-0199', '2026-09-19', 1, 1, 520, '2026-08-20 15:45:49', '2026-08-21 11:48:54'),
(3, 3, 4, 'Emergency & Same-Week Flight Rebate: $120 Voucher', 'AA120FAST', '$120 REBATE', 'Need to fly today or within 7 days? Claim your emergency phone booking credit on American Airlines.', 'Applies to bookings departing within 7 days. Phone redemption only.', '+1 (800) 555-0199', '2026-09-04', 1, 1, 289, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(4, 5, 3, 'Luxury Cabin Special: $300 OFF Qatar Business Class', 'QATAR300BIZ', '$300 BIZ OFF', 'Fly world-class Qsuite with $300 instant discount per ticket when reserving via phone agent.', 'Valid for Business and First Class reservations. One code per itinerary.', '+1 (800) 555-0199', '2026-10-19', 1, 1, 412, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(5, 4, 5, 'Family & Group Travel Special: Free 2nd Bag + $80 Off', 'SW80FAMILY', '$80 OFF + BAGS', 'Get $80 instant phone discount plus priority family boarding assistance on Southwest Airlines.', 'Phone booking exclusive. Valid for 2 or more travelers.', '+1 (800) 555-0199', '2026-09-09', 0, 1, 195, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(6, 6, 2, '$200 Discount on Emirates Long-Haul Trips', 'EK200GLOBAL', '$200 OFF FLY', 'Fly to Dubai, Asia, or Africa with Emirates and enjoy $200 phone agent discount.', 'Valid on round-trip international itineraries. Call desk to apply code.', '+1 (800) 555-0199', '2026-09-29', 1, 1, 376, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(7, 7, 2, 'London & Europe Special: $100 OFF BA Flights', 'BA100LONDON', '$100 SAVINGS', 'Planning a trip to London or Europe? Mention this code to your booking agent for $100 off.', 'Valid for flights originating in North America to UK/Europe.', '+1 (800) 555-0199', '2026-09-14', 0, 1, 143, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(8, 9, 1, 'Coast-to-Coast JetBlue Deal: $60 Instant Coupon', 'JET60COAST', '$60 INSTANT', 'Enjoy Mint or even core economy seats with $60 off per seat on non-stop cross-country flights.', 'Agent booking hotline exclusive voucher.', '+1 (800) 555-0199', '2026-09-24', 0, 1, 210, '2026-08-20 15:45:49', '2026-08-20 15:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_categories`
--

CREATE TABLE `coupon_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupon_categories`
--

INSERT INTO `coupon_categories` (`id`, `name`, `slug`, `icon`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Domestic Flights', 'domestic-flights', '🇺🇸', 'Discounts on roundtrip and one-way flights within the United States & Canada.', 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(2, 'International Deals', 'international-deals', '✈️', 'Save big on transatlantic, transpacific, and global overseas flights.', 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(3, 'Business & First Class', 'business-first-class', '👑', 'Premium cabin upgrades, lie-flat seat vouchers, and luxury flight deals.', 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(4, 'Last Minute Offers', 'last-minute-offers', '⚡', 'Exclusive emergency and same-week travel coupon codes.', 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(5, 'Holiday & Vacation Sales', 'holiday-vacation-sales', '🏖️', 'Seasonal holiday promo codes for family & group travel.', 1, '2026-08-20 15:45:49', '2026-08-20 15:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_20_000001_add_is_admin_to_users_table', 1),
(5, '2026_08_21_000001_create_airlines_table', 1),
(6, '2026_08_21_000002_create_coupon_categories_table', 1),
(7, '2026_08_21_000003_create_coupons_table', 1),
(8, '2026_08_21_000004_create_site_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('hVoBrNxRzt1wYZR0Lu9j9HSD8RsNskTxoU8OZuvW', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMjJCOFQxamQ3N3JCbWs1cm5hcnRPbjdGQXRwVG13YTNWVXBNd3JzcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9haXJsaW5lcyI7czo1OiJyb3V0ZSI7czoxNDoiYWRtaW4uYWlybGluZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1787261513),
('kChOtBko1HCk6dQa6UzgdHsYsPZ48Uqa9ZoqdCAR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZklpZmNjbUZvUG91V0NMNzR1cVBWN3RCaHJwa1JTZmFrRTZGVXJmZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787332734);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Airways Coupons', '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(2, 'agent_phone', '+1 (800) 555-0199', '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(3, 'agent_phone_display', '+1 (800) 555-0199', '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(4, 'header_announcement', '🇺🇸 USA Exclusive Unadvertised Phone Deals - Save Up to $150 per ticket!', '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(5, 'support_hours', '24/7 Live Booking Support', '2026-08-20 15:45:49', '2026-08-20 15:45:49'),
(6, 'footer_disclaimer', 'AirwaysCoupons is an independent travel voucher and phone assistance service. We assist customers in redeeming private agent-only airline promotional vouchers over the phone.', '2026-08-20 15:45:49', '2026-08-20 15:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Specialist', 'admin@airwayscoupons.com', '2026-08-20 15:45:49', '$2y$12$CiE1lncYmA4A8PAVM6isouEg1XGGH/BmQ5Yq4qWQTmvGtNhIShrtC', 0, NULL, '2026-08-20 15:45:49', '2026-08-20 15:45:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airlines`
--
ALTER TABLE `airlines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `airlines_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupons_airline_id_foreign` (`airline_id`),
  ADD KEY `coupons_coupon_category_id_foreign` (`coupon_category_id`);

--
-- Indexes for table `coupon_categories`
--
ALTER TABLE `coupon_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_categories_slug_unique` (`slug`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airlines`
--
ALTER TABLE `airlines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `coupon_categories`
--
ALTER TABLE `coupon_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_airline_id_foreign` FOREIGN KEY (`airline_id`) REFERENCES `airlines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupons_coupon_category_id_foreign` FOREIGN KEY (`coupon_category_id`) REFERENCES `coupon_categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
