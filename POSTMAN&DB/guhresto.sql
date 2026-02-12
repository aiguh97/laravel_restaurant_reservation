-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 12, 2026 at 10:00 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_pos2`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Minuman', NULL, '1770624623.svg', '2026-02-07 08:59:30', '2026-02-09 08:10:24'),
(3, 'Snack', NULL, '1770624600.svg', '2026-02-07 08:59:53', '2026-02-09 08:10:01'),
(20, 'Makanan', NULL, '1770800508.svg', '2026-02-11 09:01:48', '2026-02-11 09:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_12_13_144216_create_products_table', 1),
(7, '2023_12_14_134344_add_roles_phone_at_users', 1),
(8, '2023_12_27_135124_add_favorite_at_products', 1),
(9, '2024_01_03_145442_create_orders_table', 1),
(10, '2024_01_03_145447_create_order_items_table', 1),
(11, '2024_09_08_025520_create_categories_table', 1),
(12, '2024_09_08_030550_alter_category_products', 1),
(13, '2026_02_07_072331_create_tables_table', 2),
(15, '2026_02_07_082359_create_table_reservations_table', 3),
(16, '2026_02_07_122207_add_order_id_to_table_reservations_table', 3),
(19, '2026_02_07_150822_alter_categories_add_title_and_image', 4),
(20, '2026_02_07_203258_add_is_favorite_to_products_table', 5),
(21, '2026_02_07_230718_remove_two_factor_columns_from_users_table', 6),
(22, '2026_02_07_231002_add_two_factor_columns_to_users_table', 7),
(23, '2026_02_08_002236_make_two_factor_columns_nullable_on_users_table', 8),
(24, '2026_02_08_040742_add_google_fields_to_users_table', 9),
(25, '2026_02_11_052012_add_status_to_orders_table', 10),
(26, '2026_02_12_100611_add_two_factor_login_token_to_users', 11);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_price` int(11) NOT NULL,
  `total_item` int(11) NOT NULL,
  `kasir_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','processing','done') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `transaction_time`, `total_price`, `total_item`, `kasir_id`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(2, '2026-02-11 00:38:57', 75000, 3, 1, 'CASH', 'done', '2026-02-08 00:27:04', '2026-02-11 00:38:57'),
(3, '2026-02-11 00:42:17', 75000, 3, 1, 'CASH', 'done', '2026-02-08 00:29:31', '2026-02-11 00:42:17'),
(4, '2026-02-08 07:41:00', 25000, 1, 12, 'CASH', 'pending', '2026-02-08 00:41:03', '2026-02-08 00:41:03'),
(5, '2026-02-08 07:44:48', 25000, 1, 12, 'CASH', 'pending', '2026-02-08 00:44:51', '2026-02-08 00:44:51'),
(6, '2026-02-08 08:17:32', 25000, 1, 12, 'CASH', 'pending', '2026-02-08 08:17:34', '2026-02-08 08:17:34'),
(7, '2026-02-08 08:36:17', 16000, 2, 12, 'CASH', 'pending', '2026-02-08 08:36:19', '2026-02-08 08:36:19'),
(8, '2026-02-11 00:38:49', 25000, 1, 12, 'CASH', 'done', '2026-02-08 10:13:07', '2026-02-11 00:38:49'),
(9, '2026-02-08 10:18:40', 25000, 1, 12, 'CASH', 'pending', '2026-02-08 10:18:42', '2026-02-08 10:18:42'),
(10, '2026-02-08 10:28:43', 90000, 2, 12, 'CASH', 'pending', '2026-02-08 10:28:45', '2026-02-08 10:28:45'),
(11, '2026-02-08 11:51:05', 50000, 2, 25, 'CASH', 'pending', '2026-02-08 11:51:07', '2026-02-08 11:51:07'),
(12, '2026-02-08 07:13:00', 75000, 3, 1, 'CASH', 'pending', '2026-02-09 01:22:52', '2026-02-09 01:22:52'),
(13, '2026-02-09 20:27:27', 25000, 1, 26, 'CASH', 'pending', '2026-02-09 20:27:29', '2026-02-09 20:27:29'),
(14, '2026-02-09 20:27:58', 25000, 1, 26, 'CASH', 'pending', '2026-02-09 20:28:00', '2026-02-09 20:28:00'),
(15, '2026-02-09 20:28:32', 90000, 2, 26, 'CASH', 'pending', '2026-02-09 20:28:35', '2026-02-09 20:28:35'),
(16, '2026-02-09 20:32:42', 25000, 1, 26, 'CASH', 'pending', '2026-02-09 20:32:45', '2026-02-09 20:32:45'),
(17, '2026-02-09 20:36:16', 25000, 1, 26, 'CASH', 'pending', '2026-02-09 20:36:19', '2026-02-09 20:36:19'),
(18, '2026-02-09 21:38:24', 25000, 1, 26, 'CASH', 'pending', '2026-02-09 21:38:27', '2026-02-09 21:38:27'),
(19, '2026-02-09 23:39:23', 25000, 1, 26, 'CASH', 'pending', '2026-02-09 23:39:25', '2026-02-09 23:39:25'),
(20, '2026-02-09 23:45:49', 30000, 1, 26, 'CASH', 'pending', '2026-02-09 23:45:52', '2026-02-09 23:45:52'),
(21, '2026-02-08 07:13:00', 75000, 3, 1, 'CASH', 'pending', '2026-02-10 22:29:59', '2026-02-10 22:29:59'),
(22, '2026-02-10 22:41:26', 17000, 1, 26, 'CASH', 'pending', '2026-02-10 22:41:28', '2026-02-10 22:41:28'),
(23, '2026-02-10 22:42:26', 17000, 1, 26, 'CASH', 'pending', '2026-02-10 22:42:28', '2026-02-10 22:42:28'),
(24, '2026-02-10 22:42:35', 17000, 1, 26, 'CASH', 'pending', '2026-02-10 22:42:37', '2026-02-10 22:42:37'),
(25, '2026-02-10 22:43:46', 17000, 1, 26, 'CASH', 'pending', '2026-02-10 22:43:48', '2026-02-10 22:43:48'),
(26, '2026-02-10 23:09:20', 25000, 1, 26, 'CASH', 'pending', '2026-02-10 23:09:22', '2026-02-10 23:09:22'),
(27, '2026-02-10 23:10:19', 25000, 1, 26, 'CASH', 'pending', '2026-02-10 23:10:21', '2026-02-10 23:10:21'),
(28, '2026-02-08 07:13:00', 75000, 3, 1, 'CASH', 'pending', '2026-02-10 23:11:43', '2026-02-10 23:11:43'),
(29, '2026-02-10 23:15:02', 17000, 1, 26, 'CASH', 'pending', '2026-02-10 23:15:05', '2026-02-10 23:15:05'),
(30, '2026-02-10 23:16:13', 17000, 1, 26, 'CASH', 'pending', '2026-02-10 23:16:14', '2026-02-10 23:16:14'),
(31, '2026-02-10 23:21:01', 17000, 1, 26, 'CASH', 'pending', '2026-02-10 23:21:04', '2026-02-10 23:21:04'),
(32, '2026-02-10 23:22:24', 25000, 1, 26, 'CASH', 'pending', '2026-02-10 23:22:27', '2026-02-10 23:22:27'),
(33, '2026-02-10 23:28:55', 17000, 1, 26, 'CASH', 'pending', '2026-02-10 23:28:59', '2026-02-10 23:28:59'),
(34, '2026-02-10 23:30:55', 120000, 1, 26, 'CASH', 'pending', '2026-02-10 23:30:57', '2026-02-10 23:30:57'),
(35, '2026-02-10 23:33:03', 120000, 1, 26, 'CASH', 'pending', '2026-02-10 23:33:05', '2026-02-10 23:33:05'),
(36, '2026-02-10 23:50:04', 17000, 1, 26, 'CASH', 'pending', '2026-02-10 23:50:06', '2026-02-10 23:50:06'),
(37, '2026-02-10 23:50:10', 17000, 1, 26, 'CASH', 'pending', '2026-02-10 23:50:12', '2026-02-10 23:50:12'),
(38, '2026-02-10 23:51:33', 17000, 1, 26, 'CASH', 'pending', '2026-02-10 23:51:35', '2026-02-10 23:51:35'),
(39, '2026-02-11 00:54:33', 17000, 1, 26, 'CASH', 'done', '2026-02-11 00:04:59', '2026-02-11 00:54:33'),
(40, '2026-02-11 09:39:02', 17000, 1, 26, 'CASH', 'done', '2026-02-11 00:05:13', '2026-02-11 09:39:02'),
(41, '2026-02-11 00:49:41', 17000, 1, 26, 'CASH', 'done', '2026-02-11 00:05:21', '2026-02-11 00:49:41'),
(42, '2026-02-11 00:46:06', 17000, 1, 26, 'CASH', 'done', '2026-02-11 00:06:31', '2026-02-11 00:46:06'),
(43, '2026-02-11 08:45:36', 25000, 1, 26, 'CASH', 'pending', '2026-02-11 08:45:38', '2026-02-11 08:45:38'),
(44, '2026-02-11 09:18:15', 225000, 2, 29, 'CASH', 'pending', '2026-02-11 09:18:17', '2026-02-11 09:18:17'),
(45, '2026-02-11 09:38:55', 42000, 2, 29, 'CASH', 'done', '2026-02-11 09:31:25', '2026-02-11 09:38:55'),
(46, '2026-02-11 09:40:17', 17000, 1, 28, 'CASH', 'pending', '2026-02-11 09:40:19', '2026-02-11 09:40:19'),
(47, '2026-02-12 07:53:27', 120000, 1, 28, 'CASH', 'pending', '2026-02-12 07:53:31', '2026-02-12 07:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 2, 58, 1, 25000, '2026-02-08 00:27:04', '2026-02-08 00:27:04'),
(2, 3, 58, 1, 25000, '2026-02-08 00:29:31', '2026-02-08 00:29:31'),
(3, 4, 58, 1, 25000, '2026-02-08 00:41:03', '2026-02-08 00:41:03'),
(4, 5, 58, 1, 25000, '2026-02-08 00:44:51', '2026-02-08 00:44:51'),
(5, 6, 41, 1, 25000, '2026-02-08 08:17:34', '2026-02-08 08:17:34'),
(6, 7, 46, 2, 16000, '2026-02-08 08:36:19', '2026-02-08 08:36:19'),
(7, 8, 58, 1, 25000, '2026-02-08 10:13:07', '2026-02-08 10:13:07'),
(8, 9, 41, 1, 25000, '2026-02-08 10:18:42', '2026-02-08 10:18:42'),
(9, 10, 43, 2, 90000, '2026-02-08 10:28:45', '2026-02-08 10:28:45'),
(10, 11, 58, 2, 50000, '2026-02-08 11:51:07', '2026-02-08 11:51:07'),
(11, 12, 58, 1, 25000, '2026-02-09 01:22:52', '2026-02-09 01:22:52'),
(12, 13, 58, 1, 25000, '2026-02-09 20:27:29', '2026-02-09 20:27:29'),
(13, 14, 41, 1, 25000, '2026-02-09 20:28:00', '2026-02-09 20:28:00'),
(14, 15, 43, 2, 90000, '2026-02-09 20:28:35', '2026-02-09 20:28:35'),
(15, 16, 58, 1, 25000, '2026-02-09 20:32:45', '2026-02-09 20:32:45'),
(16, 17, 41, 1, 25000, '2026-02-09 20:36:19', '2026-02-09 20:36:19'),
(17, 18, 41, 1, 25000, '2026-02-09 21:38:27', '2026-02-09 21:38:27'),
(18, 19, 41, 1, 25000, '2026-02-09 23:39:25', '2026-02-09 23:39:25'),
(19, 20, 42, 1, 30000, '2026-02-09 23:45:52', '2026-02-09 23:45:52'),
(20, 21, 58, 1, 25000, '2026-02-10 22:29:59', '2026-02-10 22:29:59'),
(21, 22, 56, 1, 17000, '2026-02-10 22:41:28', '2026-02-10 22:41:28'),
(22, 23, 56, 1, 17000, '2026-02-10 22:42:28', '2026-02-10 22:42:28'),
(23, 24, 56, 1, 17000, '2026-02-10 22:42:37', '2026-02-10 22:42:37'),
(24, 25, 56, 1, 17000, '2026-02-10 22:43:48', '2026-02-10 22:43:48'),
(25, 26, 58, 1, 25000, '2026-02-10 23:09:22', '2026-02-10 23:09:22'),
(26, 27, 58, 1, 25000, '2026-02-10 23:10:21', '2026-02-10 23:10:21'),
(27, 28, 58, 1, 25000, '2026-02-10 23:11:43', '2026-02-10 23:11:43'),
(28, 29, 56, 1, 17000, '2026-02-10 23:15:05', '2026-02-10 23:15:05'),
(29, 30, 56, 1, 17000, '2026-02-10 23:16:14', '2026-02-10 23:16:14'),
(30, 31, 56, 1, 17000, '2026-02-10 23:21:04', '2026-02-10 23:21:04'),
(31, 32, 58, 1, 25000, '2026-02-10 23:22:27', '2026-02-10 23:22:27'),
(32, 33, 56, 1, 17000, '2026-02-10 23:28:59', '2026-02-10 23:28:59'),
(33, 34, 60, 1, 120000, '2026-02-10 23:30:57', '2026-02-10 23:30:57'),
(34, 35, 60, 1, 120000, '2026-02-10 23:33:05', '2026-02-10 23:33:05'),
(35, 36, 56, 1, 17000, '2026-02-10 23:50:06', '2026-02-10 23:50:06'),
(36, 37, 56, 1, 17000, '2026-02-10 23:50:12', '2026-02-10 23:50:12'),
(37, 38, 56, 1, 17000, '2026-02-10 23:51:35', '2026-02-10 23:51:35'),
(38, 39, 56, 1, 17000, '2026-02-11 00:04:59', '2026-02-11 00:04:59'),
(39, 40, 56, 1, 17000, '2026-02-11 00:05:13', '2026-02-11 00:05:13'),
(40, 41, 56, 1, 17000, '2026-02-11 00:05:21', '2026-02-11 00:05:21'),
(41, 42, 56, 1, 17000, '2026-02-11 00:06:31', '2026-02-11 00:06:31'),
(42, 43, 58, 1, 25000, '2026-02-11 08:45:38', '2026-02-11 08:45:38'),
(43, 44, 61, 1, 200000, '2026-02-11 09:18:17', '2026-02-11 09:18:17'),
(44, 44, 58, 1, 25000, '2026-02-11 09:18:17', '2026-02-11 09:18:17'),
(45, 45, 58, 1, 25000, '2026-02-11 09:31:25', '2026-02-11 09:31:25'),
(46, 45, 56, 1, 17000, '2026-02-11 09:31:25', '2026-02-11 09:31:25'),
(47, 46, 56, 1, 17000, '2026-02-11 09:40:19', '2026-02-11 09:40:19'),
(48, 47, 60, 1, 120000, '2026-02-12 07:53:31', '2026-02-12 07:53:31');

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 11, 'auth_token', '926b0300a0f27e2e458553ec83032621e01f1c6b0a9ecc46214035c07061f806', '[\"*\"]', '2026-02-07 06:01:31', NULL, '2026-02-06 20:47:17', '2026-02-07 06:01:31'),
(3, 'App\\Models\\User', 11, 'auth_token', 'a1b57956c78af3f9cfffc1122cd03760f9fbf8e8c6bf4273bbba1d3f35853943', '[\"*\"]', '2026-02-12 06:46:26', NULL, '2026-02-06 22:31:31', '2026-02-12 06:46:26'),
(5, 'App\\Models\\User', 12, 'auth_token', '9f31af772c47dc827aeca661c4cffe9270f51547de11cfe1a45628ce8f163704', '[\"*\"]', '2026-02-07 05:51:06', NULL, '2026-02-07 04:21:50', '2026-02-07 05:51:06'),
(7, 'App\\Models\\User', 11, 'auth_token', 'adc662fdf448eb7173c66676ea99d99a480b27e850b136c0853f392444432e41', '[\"*\"]', '2026-02-07 07:04:44', NULL, '2026-02-07 06:05:46', '2026-02-07 07:04:44'),
(10, 'App\\Models\\User', 11, 'auth_token', '253e49397917aa25cab6921d30e95f15ea02626ba4eacaa3e46699bffef6e9b4', '[\"*\"]', '2026-02-07 12:11:26', NULL, '2026-02-07 07:38:52', '2026-02-07 12:11:26'),
(12, 'App\\Models\\User', 11, 'auth_token', 'bfd406fd766696ca1e9c4fc50ac197ffd8a4f8b136dc62a012b4b438a2c53f72', '[\"*\"]', '2026-02-07 18:51:16', NULL, '2026-02-07 18:51:02', '2026-02-07 18:51:16'),
(13, 'App\\Models\\User', 11, 'auth_token', '08c744994072211ef2f2dfc81caeba4d44fc014eda084f3496542163567b284b', '[\"*\"]', '2026-02-07 19:20:22', NULL, '2026-02-07 19:20:05', '2026-02-07 19:20:22'),
(14, 'App\\Models\\User', 11, 'auth_token', '30e1809cbbc55353492ad39d998289060846beadaf180a17eb4dbd6b489a0aa7', '[\"*\"]', '2026-02-07 19:25:00', NULL, '2026-02-07 19:24:38', '2026-02-07 19:25:00'),
(15, 'App\\Models\\User', 11, 'auth_token', '62f5b2e8ab032fac8289fe056f81cc1f3770b03b2e799530fcd6634be7a293e3', '[\"*\"]', '2026-02-07 19:27:22', NULL, '2026-02-07 19:27:16', '2026-02-07 19:27:22'),
(16, 'App\\Models\\User', 11, 'auth_token', '0e16cdc20e2c6efd2941885eecfd3398baf50270c7c1e350a1c93d5b0044c1ea', '[\"*\"]', '2026-02-07 19:32:52', NULL, '2026-02-07 19:32:28', '2026-02-07 19:32:52'),
(17, 'App\\Models\\User', 11, 'auth_token', '675f912664204bdd4a9e7ed3b8397db5759e90ce8867c29cc31558730a4174a4', '[\"*\"]', '2026-02-07 19:38:00', NULL, '2026-02-07 19:37:28', '2026-02-07 19:38:00'),
(18, 'App\\Models\\User', 11, 'auth_token', '7c84227f9b9b596a0898e527401cd606640697136f1fddd8b1ee805a3bc8bc4c', '[\"*\"]', '2026-02-07 19:41:16', NULL, '2026-02-07 19:41:14', '2026-02-07 19:41:16'),
(19, 'App\\Models\\User', 11, 'auth_token', '0f2826feff90dcb203c43ad00e2ad2588435b813bfad0f120bc0504f0f6be636', '[\"*\"]', '2026-02-07 19:44:40', NULL, '2026-02-07 19:44:38', '2026-02-07 19:44:40'),
(22, 'App\\Models\\User', 23, 'auth_token', 'ea6e8c618d5c32556f3ac525b9656e76cb150d4ee3281480734c5aa6c9fa1441', '[\"*\"]', NULL, NULL, '2026-02-07 20:41:17', '2026-02-07 20:41:17'),
(23, 'App\\Models\\User', 24, 'auth_token', 'd90961f9b557739b695b41d40656f667ffb256db7468ae6b6172709e8a2871f6', '[\"*\"]', NULL, NULL, '2026-02-07 21:00:31', '2026-02-07 21:00:31'),
(25, 'App\\Models\\User', 12, 'auth_token', 'cd18cbb570f9834c188b65b6443de989a4612c75c3acec265e311c185c25c6d5', '[\"*\"]', NULL, NULL, '2026-02-07 22:30:04', '2026-02-07 22:30:04'),
(26, 'App\\Models\\User', 12, 'auth_token', '475d91dafa8f977fbb4e458eb0819a8f480d803b010d9550ef35df38e93f0678', '[\"*\"]', NULL, NULL, '2026-02-07 22:30:14', '2026-02-07 22:30:14'),
(27, 'App\\Models\\User', 12, 'auth_token', '64053909b8b77bb5dd057e1b0552d4546af1412d99712318ea3a2e002b259ba7', '[\"*\"]', NULL, NULL, '2026-02-07 22:30:18', '2026-02-07 22:30:18'),
(28, 'App\\Models\\User', 12, 'auth_token', 'd55d1afcb126ceed59085338d291f3686ad93a49408458a61b045e4fb40c429c', '[\"*\"]', NULL, NULL, '2026-02-07 22:30:27', '2026-02-07 22:30:27'),
(30, 'App\\Models\\User', 12, 'auth_token', '18792bb71cb5cc739781d4e16f329cdec02fd6c3dc09cdaa9eebd266559867d4', '[\"*\"]', NULL, NULL, '2026-02-07 22:37:08', '2026-02-07 22:37:08'),
(31, 'App\\Models\\User', 12, 'auth_token', '17f7f54bf4669f0220c0323279e70dcf088cad294c1c72e5fe6a7a0da6a12c8c', '[\"*\"]', NULL, NULL, '2026-02-07 22:37:20', '2026-02-07 22:37:20'),
(32, 'App\\Models\\User', 12, 'auth_token', '2491cf023375e0a65ad6476cb0418b114df13b23abe0c36ca69ab693784d71f0', '[\"*\"]', NULL, NULL, '2026-02-07 22:38:41', '2026-02-07 22:38:41'),
(33, 'App\\Models\\User', 12, 'auth_token', 'f363938186592c46dd2517c90a0fe4c77c4c7e52575249c9c9fbafbcfe957b28', '[\"*\"]', NULL, NULL, '2026-02-07 22:39:18', '2026-02-07 22:39:18'),
(36, 'App\\Models\\User', 12, 'auth_token', '2ab71cd750790abd49c6492dafc89feb17b6737e8053832b9672da640d1c0abb', '[\"*\"]', '2026-02-11 01:16:25', NULL, '2026-02-08 00:20:07', '2026-02-11 01:16:25'),
(40, 'App\\Models\\User', 25, 'auth_token', 'fd91da860ee233c2bd19cea8fbc05ecd149ade9bad321d16e5bad56c8a3269bd', '[\"*\"]', NULL, NULL, '2026-02-08 10:38:19', '2026-02-08 10:38:19'),
(41, 'App\\Models\\User', 25, 'auth_token', 'dcc64101e53c366dae408ab7d3ca6c0364c49ea55374252283afb50c5a7d8abd', '[\"*\"]', NULL, NULL, '2026-02-08 10:38:44', '2026-02-08 10:38:44'),
(42, 'App\\Models\\User', 25, 'auth_token', '3e207f92eaaeec7afa7ccae21ff6cf4aea369bcd8eb6b3262cf31ff3f833af76', '[\"*\"]', NULL, NULL, '2026-02-08 10:40:40', '2026-02-08 10:40:40'),
(50, 'App\\Models\\User', 26, 'auth_token', '4a6c3731d140b1b4b46531b965ab1f97cc9fc72aa3a37b451064d8118cd927d6', '[\"*\"]', '2026-02-09 07:03:36', NULL, '2026-02-09 06:57:31', '2026-02-09 07:03:36'),
(51, 'App\\Models\\User', 26, 'auth_token', 'c7de75a70aab6d5bdb86f82a8c0e5d82dc6db19fdd29da0f3284406d9499ca80', '[\"*\"]', '2026-02-09 07:08:13', NULL, '2026-02-09 07:07:04', '2026-02-09 07:08:13'),
(55, 'App\\Models\\User', 12, 'auth_token', '985000c6c883e538d33dd8b6cc467db01a4659da3f309e2eeb29a89e887a0ed7', '[\"*\"]', NULL, NULL, '2026-02-09 08:18:59', '2026-02-09 08:18:59'),
(60, 'App\\Models\\User', 26, 'auth_token', '71f578fcb7a60e201f33c2f84accb292f3ca0c82077ba46ab28e402d9552fe9e', '[\"*\"]', '2026-02-11 01:42:23', NULL, '2026-02-11 01:07:36', '2026-02-11 01:42:23'),
(61, 'App\\Models\\User', 26, 'auth_token', 'af53eabcacb00e8b2738f1e00fbf0856de9acdb7fa51e0bd34a67d56028f479f', '[\"*\"]', NULL, NULL, '2026-02-11 07:20:43', '2026-02-11 07:20:43'),
(62, 'App\\Models\\User', 26, 'auth_token', '7f20f88008a1eda6f207ef6e518ef93eda6b649fe5a1a4bf3a54f56af01243c1', '[\"*\"]', NULL, NULL, '2026-02-11 07:20:57', '2026-02-11 07:20:57'),
(77, 'App\\Models\\User', 29, 'auth_token', '777ce7d057f85301b796cdca7abeafea19e2f5182e902865ff1b2e069c743b2d', '[\"*\"]', '2026-02-11 09:20:58', NULL, '2026-02-11 09:20:52', '2026-02-11 09:20:58'),
(86, 'App\\Models\\User', 28, 'auth_token', '20acecc9bdc102c1a112fb4b1879072ce3d3bfe5ba15ef2f332992874f88ad08', '[\"*\"]', '2026-02-11 09:41:53', NULL, '2026-02-11 09:37:06', '2026-02-11 09:41:53'),
(88, 'App\\Models\\User', 28, 'auth_token', '5a83dfd88718fdfc4e51eff4bd8505f7c5acaeab725dac97c019ddb2e380c8c9', '[\"*\"]', '2026-02-12 04:11:03', NULL, '2026-02-12 04:07:32', '2026-02-12 04:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_best_seller` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_favorite` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`, `is_best_seller`, `category_id`, `is_favorite`) VALUES
(41, 'Nasi Goreng Spesial', 'Nasi goreng dengan bumbu khas Indonesia.', 25000, 50, '698baa66d9f3d.png', '2026-02-07 11:43:54', '2026-02-11 22:45:00', 1, 20, 0),
(42, 'Sate Ayam', 'Sate ayam dengan bumbu kacang manis.', 30000, 40, '698baa7480323.jpg', '2026-02-07 11:43:54', '2026-02-11 22:45:07', 0, 20, 0),
(43, 'Rendang Daging', 'Rendang daging khas Padang.', 45000, 30, '698baa7f7ef3d.jpg', '2026-02-07 11:43:54', '2026-02-11 22:45:17', 1, 20, 0),
(44, 'Gado-Gado', 'Salad khas Indonesia dengan saus kacang.', 20000, 60, '698baa8dd5bc0.jpg', '2026-02-07 11:43:54', '2026-02-11 22:45:27', 0, 20, 0),
(45, 'Bakso Sapi', 'Bakso sapi kenyal dengan kuah hangat.', 22000, 55, '698baa989d2ad.jpg', '2026-02-07 11:43:54', '2026-02-11 22:45:34', 0, 20, 0),
(46, 'Es Teh Manis', 'Teh manis segar dengan es batu.', 8000, 100, '698baadb67f1a.jpg', '2026-02-07 11:43:54', '2026-02-10 22:02:03', 0, 2, 0),
(47, 'Jus Jeruk', 'Jus jeruk segar tanpa gula tambahan.', 12000, 80, '698bab0e8ec63.jpg', '2026-02-07 11:43:54', '2026-02-10 22:02:54', 1, 2, 0),
(48, 'Kopi Tubruk', 'Kopi tradisional khas Indonesia.', 10000, 70, '698bab17c3b5a.jpg', '2026-02-07 11:43:54', '2026-02-10 22:03:03', 1, 2, 0),
(50, 'Air Mineral', 'Air mineral segar kemasan botol.', 5000, 200, '698bab6b6390a.jpg', '2026-02-07 11:43:54', '2026-02-10 22:04:27', 0, 2, 0),
(51, 'Kue Lapis', 'Kue lapis tradisional Indonesia.', 20000, 40, '698bab3d81cf4.jpg', '2026-02-07 11:43:54', '2026-02-10 22:03:41', 0, 3, 0),
(52, 'Keripik Singkong', 'Keripik singkong renyah dan gurih.', 15000, 50, '698bab7cc758c.jpg', '2026-02-07 11:43:54', '2026-02-10 22:04:44', 0, 3, 0),
(53, 'Pisang Goreng', 'Pisang goreng hangat dan manis.', 18000, 60, '698bab4b94953.jpg', '2026-02-07 11:43:54', '2026-02-10 22:03:55', 1, 3, 0),
(54, 'Onde-Onde', 'Cemilan tradisional berisi kacang hijau.', 15000, 45, '698bab2ac2939.jpg', '2026-02-07 11:43:54', '2026-02-10 22:03:23', 0, 3, 0),
(56, 'Soto Ayam', NULL, 17000, 21, '698baa26dd36d.jpg', '2026-02-07 13:25:43', '2026-02-11 22:43:46', 0, 20, 0),
(58, 'Es kapuchino', 'Mantap', 25000, 211, '698ba9dcb9bf8.jpg', '2026-02-07 13:30:40', '2026-02-11 22:43:30', 0, 2, 0),
(60, 'Edit12212', NULL, 120000, 21, '698d060265436.png', '2026-02-10 22:13:35', '2026-02-11 22:43:18', 0, 2, 0),
(61, 'Product 1', NULL, 200000, 100, '698d063397fe4.png', '2026-02-11 08:42:30', '2026-02-11 22:44:05', 0, 3, 0),
(62, 'vvg', NULL, 856, 11, '698d795ad8ad2.jpg', '2026-02-12 06:55:23', '2026-02-12 06:55:23', 0, 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_x` int(11) DEFAULT NULL,
  `position_y` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `name`, `capacity`, `type`, `position_x`, `position_y`, `created_at`, `updated_at`) VALUES
(1, 'Main Table', 8, 'main', 50, 50, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(2, 'Table - 1', 4, '4-seat', 10, 10, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(3, 'Table - 2', 4, '4-seat', 40, 10, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(4, 'Table - 3', 4, '4-seat', 70, 10, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(5, 'Table - 4', 4, '4-seat', 10, 40, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(6, 'Table - 5', 4, '4-seat', 70, 40, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(7, 'Table - 6', 4, '4-seat', 10, 70, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(8, 'Table - 7', 4, '4-seat', 70, 70, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(9, 'Table - 8', 4, '4-seat', 10, 90, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(10, 'Table - 9', 4, '4-seat', 40, 90, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(11, 'Table - 10', 4, '4-seat', 70, 90, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(12, 'Table - 11', 2, '2-seat', 10, 120, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(13, 'Table - 12', 2, '2-seat', 40, 120, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(14, 'Table - 13', 2, '2-seat', 70, 120, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(15, 'Table - 14', 2, '2-seat', 10, 140, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(16, 'Table - 15', 2, '2-seat', 40, 140, '2026-02-07 00:29:37', '2026-02-07 00:29:37'),
(17, 'Table - 16', 2, '2-seat', 70, 140, '2026-02-07 00:29:37', '2026-02-07 00:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `table_reservations`
--

CREATE TABLE `table_reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `table_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('reserved','occupied','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'reserved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_reservations`
--

INSERT INTO `table_reservations` (`id`, `table_id`, `order_id`, `date`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 11, NULL, '2026-02-07', '10:00:00', '11:00:00', 'reserved', '2026-02-07 05:26:57', '2026-02-07 05:26:57'),
(7, 9, 3, '2026-02-08', '14:00:00', '16:00:00', 'reserved', '2026-02-08 00:48:26', '2026-02-08 00:48:26'),
(14, 2, 3, '2026-02-07', '14:00:00', '16:00:00', 'reserved', '2026-02-08 08:29:50', '2026-02-08 08:29:50'),
(15, 12, 7, '2026-02-08', '15:36:18', '17:36:18', 'reserved', '2026-02-08 08:36:20', '2026-02-08 08:36:20'),
(16, 7, 8, '2026-02-08', '17:13:06', '19:13:06', 'reserved', '2026-02-08 10:13:08', '2026-02-08 10:13:08'),
(17, 3, 9, '2026-02-08', '17:18:42', '19:18:42', 'reserved', '2026-02-08 10:18:44', '2026-02-08 10:18:44'),
(18, 1, 11, '2026-02-08', '18:51:06', '20:51:06', 'reserved', '2026-02-08 11:51:09', '2026-02-08 11:51:09'),
(19, 7, 15, '2026-02-10', '03:28:33', '05:28:33', 'reserved', '2026-02-09 20:28:36', '2026-02-09 20:28:36'),
(20, 9, 16, '2026-02-10', '03:32:43', '05:32:43', 'reserved', '2026-02-09 20:32:46', '2026-02-09 20:32:46'),
(21, 10, 17, '2026-02-10', '03:36:18', '05:36:18', 'reserved', '2026-02-09 20:36:20', '2026-02-09 20:36:20'),
(22, 12, 18, '2026-02-10', '04:38:26', '06:38:26', 'reserved', '2026-02-09 21:38:30', '2026-02-09 21:38:30'),
(23, 7, 42, '2026-02-11', '07:06:30', '09:06:30', 'reserved', '2026-02-11 00:06:32', '2026-02-11 00:06:32'),
(24, 7, 43, '2026-02-11', '15:45:37', '17:45:37', 'reserved', '2026-02-11 08:45:39', '2026-02-11 08:45:39'),
(25, 1, 44, '2026-02-11', '16:18:16', '18:18:16', 'reserved', '2026-02-11 09:18:18', '2026-02-11 09:18:18'),
(26, 10, 45, '2026-02-11', '16:31:24', '18:31:24', 'reserved', '2026-02-11 09:31:26', '2026-02-11 09:31:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` enum('admin','staff','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `roles`, `email_verified_at`, `password`, `two_factor_enabled`, `two_factor_type`, `remember_token`, `created_at`, `updated_at`, `two_factor_secret`, `google_id`, `avatar`) VALUES
(1, 'Ford Koss', 'phettinger@example.net', NULL, 'user', '2026-02-06 20:38:38', '$2y$12$yQy2GMNl0udhtXYZZzqBAeMPQnytH2zRq/Lubj.5IUg/M5pQvjdFG', 0, 'authenticator', 'gC1hVZ2MZ2', '2026-02-06 20:38:38', '2026-02-06 20:38:38', NULL, NULL, NULL),
(2, 'Myriam Boyle', 'ahalvorson@example.com', NULL, 'user', '2026-02-06 20:38:38', '$2y$12$yQy2GMNl0udhtXYZZzqBAeMPQnytH2zRq/Lubj.5IUg/M5pQvjdFG', 0, 'authenticator', 'mH5VD3COTS', '2026-02-06 20:38:38', '2026-02-06 20:38:38', NULL, NULL, NULL),
(3, 'Jasen Pouros', 'aris@gmail.com', NULL, 'user', '2026-02-06 20:38:38', '$2y$12$/qjyQ3RzwraceWuuPSrl1.N99wTggNsmfbpK3DOB0QNVHjzTMAj6y', 0, 'authenticator', 'Q9v4gq5znE', '2026-02-06 20:38:38', '2026-02-06 20:38:38', NULL, NULL, NULL),
(4, 'Alessandro Nienow', 'wilderman.olin@example.net', NULL, 'user', '2026-02-06 20:38:38', '$2y$12$yQy2GMNl0udhtXYZZzqBAeMPQnytH2zRq/Lubj.5IUg/M5pQvjdFG', 0, 'authenticator', 'Oa5gnde2lp', '2026-02-06 20:38:38', '2026-02-06 20:38:38', NULL, NULL, NULL),
(5, 'Mr. Josiah Bayer', 'rodriguez.willa@example.net', NULL, 'user', '2026-02-06 20:38:38', '$2y$12$yQy2GMNl0udhtXYZZzqBAeMPQnytH2zRq/Lubj.5IUg/M5pQvjdFG', 0, 'authenticator', 'YpuWx7x6pf', '2026-02-06 20:38:38', '2026-02-06 20:38:38', NULL, NULL, NULL),
(6, 'Prof. Darius Sauer III', 'schmitt.brice@example.org', NULL, 'user', '2026-02-06 20:38:38', '$2y$12$yQy2GMNl0udhtXYZZzqBAeMPQnytH2zRq/Lubj.5IUg/M5pQvjdFG', 0, 'authenticator', 'cnufuLed0j', '2026-02-06 20:38:38', '2026-02-06 20:38:38', NULL, NULL, NULL),
(7, 'Prof. Tatyana Schmeler II', 'nathanael.metz@example.net', NULL, 'user', '2026-02-06 20:38:38', '$2y$12$yQy2GMNl0udhtXYZZzqBAeMPQnytH2zRq/Lubj.5IUg/M5pQvjdFG', 0, 'authenticator', 'sWWlc3YDoV', '2026-02-06 20:38:38', '2026-02-06 20:38:38', NULL, NULL, NULL),
(8, 'Prof. Marty Wiza', 'mohr.deja@example.com', NULL, 'user', '2026-02-06 20:38:38', '$2y$12$yQy2GMNl0udhtXYZZzqBAeMPQnytH2zRq/Lubj.5IUg/M5pQvjdFG', 0, 'authenticator', '54UkQiV193', '2026-02-06 20:38:38', '2026-02-06 20:38:38', NULL, NULL, NULL),
(9, 'Mr. Hershel Wunsch', 'mariane37@example.net', NULL, 'user', '2026-02-06 20:38:38', '$2y$12$yQy2GMNl0udhtXYZZzqBAeMPQnytH2zRq/Lubj.5IUg/M5pQvjdFG', 0, 'authenticator', 'phJg5tHvIU', '2026-02-06 20:38:38', '2026-02-06 20:38:38', NULL, NULL, NULL),
(10, 'Winston Breitenberg', 'logan04@example.net', NULL, 'user', '2026-02-06 20:38:38', '$2y$12$yQy2GMNl0udhtXYZZzqBAeMPQnytH2zRq/Lubj.5IUg/M5pQvjdFG', 0, 'authenticator', 'lGdOm6cD7o', '2026-02-06 20:38:38', '2026-02-06 20:38:38', NULL, NULL, NULL),
(11, 'Teguh Admin', 'aiguh971@gmail.com', NULL, 'admin', '2026-02-06 20:38:38', '$2y$12$/qjyQ3RzwraceWuuPSrl1.N99wTggNsmfbpK3DOB0QNVHjzTMAj6y', 1, '', '', '2026-02-06 20:38:38', '2026-02-07 20:06:06', '', NULL, NULL),
(12, 'Aris Teguh', 'teguh@gmail.com', NULL, 'admin', '2026-02-06 22:32:49', '$2y$12$/qjyQ3RzwraceWuuPSrl1.N99wTggNsmfbpK3DOB0QNVHjzTMAj6y', 1, 'authenticator', 'ZBlpzsexkHBJzssjZntrPbTJ0zOvtOIzDebM51aUwqXLsI4kc9pV8GnITbsA', '2026-02-06 22:32:50', '2026-02-11 05:58:45', 'eyJpdiI6ImFVY3BONCs3TE9HbkVQTml4T3hDSnc9PSIsInZhbHVlIjoiTnltMSthL2FPeUpaRzY1b2paSHh0Mmt6dWdzL09pU2htZldMMlVQVHNtQkFaaFpBNktaOU9MR0NmTEZxYzdTcnQybnBmSGlwVkpxeFZ5VzQyZ21zakhkUVpjZXhvWlZVV29aZlljQXQ3WkVkN1g2ZnJvOVd0eFIrZDRUNktnMExoY2I4Y2V4d0xCVFBVUmpSNnNJa1pKbHNjRTNuNEVmeGdlK0tmVFNjWFJtcllyVEh5Nm1GMVlSKzl2QlVDczQyVURHUy9uKzJib09UemZlcFFpOExQZVNwMEtEeStzRWZXbHkzNFlPdlpsUkpUdXBaclRWMmtTdnRlMkJHcVlYdy9PRWpHUXJlSGJTVSt2cjlzQ2NQcUpBWmhyWXYvU2dvM0F5MzNNREt1V3ZTRHZIMStlbjY3NUw4QUxER2ErOWkiLCJtYWMiOiI4MTE4ZWNlN2U3NTU2ZmU2MjNmODFjMTZlZTA2N2QzYTlkYWI1YmRhYTdmZTBjNWU4MmNiNjkxN2ZkYzcwYmZlIiwidGFnIjoiIn0=', NULL, NULL),
(13, 'Retha Labadie', 'lonnie51@example.com', NULL, 'user', '2026-02-06 22:32:50', '$2y$12$Mf5VWMqTd4EfdsQDO4AmkuGvgbsCgHCmdhJptJOQyCJfCeCxZd.Cm', 0, 'authenticator', 'fdyeUD52ai', '2026-02-06 22:32:50', '2026-02-06 22:32:50', NULL, NULL, NULL),
(14, 'Christophe Schulist', 'nkoss@example.net', NULL, 'user', '2026-02-06 22:32:50', '$2y$12$Mf5VWMqTd4EfdsQDO4AmkuGvgbsCgHCmdhJptJOQyCJfCeCxZd.Cm', 0, 'authenticator', 'cqisnX3aor', '2026-02-06 22:32:50', '2026-02-06 22:32:50', NULL, NULL, NULL),
(15, 'Antonina Pacocha III', 'owelch@example.net', NULL, 'user', '2026-02-06 22:32:50', '$2y$12$Mf5VWMqTd4EfdsQDO4AmkuGvgbsCgHCmdhJptJOQyCJfCeCxZd.Cm', 0, 'authenticator', 'Qfd8DzJg2S', '2026-02-06 22:32:50', '2026-02-06 22:32:50', NULL, NULL, NULL),
(16, 'Geovanny McLaughlin', 'sandra64@example.org', NULL, 'user', '2026-02-06 22:32:50', '$2y$12$Mf5VWMqTd4EfdsQDO4AmkuGvgbsCgHCmdhJptJOQyCJfCeCxZd.Cm', 0, 'authenticator', 'SjLaWhh7AU', '2026-02-06 22:32:50', '2026-02-06 22:32:50', NULL, NULL, NULL),
(17, 'Ms. Irma Thiel Sr.', 'fern.bahringer@example.com', NULL, 'user', '2026-02-06 22:32:50', '$2y$12$Mf5VWMqTd4EfdsQDO4AmkuGvgbsCgHCmdhJptJOQyCJfCeCxZd.Cm', 0, 'authenticator', 'Yvv0UK05oy', '2026-02-06 22:32:50', '2026-02-06 22:32:50', NULL, NULL, NULL),
(18, 'Dr. Hazle Torp', 'ymann@example.org', NULL, 'user', '2026-02-06 22:32:50', '$2y$12$Mf5VWMqTd4EfdsQDO4AmkuGvgbsCgHCmdhJptJOQyCJfCeCxZd.Cm', 0, 'authenticator', '47v1CAvYSx', '2026-02-06 22:32:50', '2026-02-06 22:32:50', NULL, NULL, NULL),
(19, 'Madelyn Romaguera', 'ratke.alvis@example.com', NULL, 'user', '2026-02-06 22:32:50', '$2y$12$Mf5VWMqTd4EfdsQDO4AmkuGvgbsCgHCmdhJptJOQyCJfCeCxZd.Cm', 0, 'authenticator', 'x8Y1gQ2Aiq', '2026-02-06 22:32:50', '2026-02-06 22:32:50', NULL, NULL, NULL),
(20, 'Dannie Rodriguez', 'arjun.kunze@example.net', NULL, 'user', '2026-02-06 22:32:50', '$2y$12$Mf5VWMqTd4EfdsQDO4AmkuGvgbsCgHCmdhJptJOQyCJfCeCxZd.Cm', 0, 'authenticator', 'FD0rfqxIuO', '2026-02-06 22:32:50', '2026-02-06 22:32:50', NULL, NULL, NULL),
(21, 'Annetta Zemlak II', 'hgreenholt@example.com', NULL, 'user', '2026-02-06 22:32:50', '$2y$12$Mf5VWMqTd4EfdsQDO4AmkuGvgbsCgHCmdhJptJOQyCJfCeCxZd.Cm', 0, 'authenticator', 'mFICGqXrZr', '2026-02-06 22:32:50', '2026-02-06 22:32:50', NULL, NULL, NULL),
(23, 'Budi', 'budi@email.com', NULL, 'user', NULL, '$2y$12$8edkeN5TshaYVZtMmr1pPOiRN540/TH3Cl6L07epnEI/08uoYYFOy', 0, NULL, NULL, '2026-02-07 20:41:17', '2026-02-07 20:41:17', NULL, NULL, NULL),
(24, 'ana', 'aristeguh2129@gmail.com', NULL, 'user', NULL, '$2y$12$CqiAK75lmGTY1i6fU2nb8e1tnpVfCYjWk1sbiSySrgECcfrhx9q.W', 1, 'authenticator', NULL, '2026-02-07 21:00:31', '2026-02-12 00:40:51', 'eyJpdiI6IjhDQno1TWFhTHNiSnlScTZadjR1a3c9PSIsInZhbHVlIjoiajlyRFkxeUlIVGJZMHNLcVJMdE5uL0ZIenNyVG5FcHUvNS9RMzgrOXZzS3JJZGlNZ2x0MGZmbE0zZmU4bm1yWU5Ld3llNmpDeHlHb0hMZ1pEMWtDQWYvQThqbXZqSStxdUNuSEp2bnJFTGdQYTN0ZGNldlFZa1RxVzRaK2ZyaUc3VWU1WmY0Y2FocTdDSUhCZ1VPYS9pcUpGbHk3NzVZc3lkOGxmOWU2eGhrMDFnRjFMOC9WaEk5VUE1bkNTdzlIQVRDOEJPWG5oKzROdVEzWGs4K0pZekRHVGgvK3R6aGtudGdEdGRqbUZScTBYWUV2b0pmanVsRTZnZVVVWW5pVE9PTVFtVTVqRDA4NFV6STBpTkpZVFowK0FCdHRyS3dWTzREMHZ1K1BOZno0QVFGdllzZ1htRi91bE1YSnZMbm4iLCJtYWMiOiI0ZDdjZjM4YWI1YWE5YjQ4MmU5Y2E2YmE4YTZiMGQwNmRmNmJhNzdhMWJiY2NjMDM1MWM5YmM0OWQ3ODVjNWFjIiwidGFnIjoiIn0=', NULL, NULL),
(25, 'teguh dev', 'teguhcodedev3@gmail.com', NULL, 'user', NULL, '$2y$12$qA8kMKuEqyxaMcojNygKx.Ko6BqFZb7A.oRxTnXUW/NXFMhZ14xkO', 0, NULL, NULL, '2026-02-08 10:38:19', '2026-02-08 11:21:48', 'eyJpdiI6ImVEallLcHdNRWxLUFhTaEVRZ2tDSmc9PSIsInZhbHVlIjoiVE1PMlNVTkl1WUMzK3k0M3dtQkM5M2RHY0l5ditOQjVGcmZwdVdhbG11VGcrY1JNSTJ5aER4SDlYZ1V5S0F3ODBTeVF1QkhhWEpBQXNNbUZnKzBPdmwxU252d2o0bGtCcTRGSGtRYzQwbFZzOXdRb3VSczNFaU1YeU9BaU5nKzk5emJCY3R1cmtLSDdWckpPNDhFMFhkVDlrVlJoTWZUTkFqUW1iZ29wTjAyRzN6TkhlcGdaWEtYVHpEdmMreEE5N1dVNk0ySkdYdW9xMlkwcWZiZ2xiM3BFbTUwQWhkejM4ck5VV3JnakRRbER5Y0hKZ0wzM1JMejNkVElKbnRpVm5mK09COUpSOUdSZ0pwcDJGck5PSW5nOXpmeDRNMmk4ZUR0cmU2TDh1RS8xcUg0bHh6TXhpRVBIS05VNmNPTW0iLCJtYWMiOiIzNWM5OWIwMDJlMjY3NmM2NzJkMzMzNGM0NzJiNmExM2U2MzcyNGMwYWQ0YjlmMDE5ZDU5ZTI0YTc1MTIwMWUzIiwidGFnIjoiIn0=', '110638755356686458882', 'https://lh3.googleusercontent.com/a/ACg8ocIbLDGk2vQmR_cwXsRh3JF1Em-dBvSbvScP9sictAgx-6Tp-4U=s96-c'),
(26, 'Teguh', 'codingguh@gmail.com', NULL, 'user', NULL, '$2y$12$GQhWWtiqtXXyrDXbaTX4pujVpRCH2tW4ZMkvBVV1eouWHhAEYcMWq', 1, 'authenticator', NULL, '2026-02-09 06:57:31', '2026-02-11 07:24:27', 'eyJpdiI6IlN0dDZpcDJ2WE1KZDlrbXpoOGFlRGc9PSIsInZhbHVlIjoib0JFZlRuNW50TjdDL0kxWFlzczF5L1U1Yk5KVlJqZlNoWFAvZ25ncTMxekFmUFpDWUFURWIrSTVKN2JOclM0N1A0d2M4K1Z0bXB2Q3VVZUUyMEpsUWN2cUhVOENYMjVWVW1ENWNadzh1cXhlZ0hidjg2RElLVWlPaWI0MHlESGVGU1k4eWVsTmVNR0hhZmJyRkR1SFg0V1QyUDlGaEZJZkJYanVzMXRIT2orTWU1L1RJSzJQU0gzVENlOVRTTVE3dTNrM0FYdzROc09NbnVmNHpSQm5IdlR5eDBCeWMraUJHQm5YMDVucURwdDZkb3pzTmZlcCtRY3FXZ3kwSjZCK005WHE2cUVqeGRVUHVzRDNoT1hxcEhhK2tFVzE2RjR6bitpc1FScWpVVDUxSjV1elFKSkU5V1h4dkNleW5LNW0iLCJtYWMiOiIyNmFkY2YwOGZhNzIwMjAxMTgyNjliNzQyOGEyOWU1YjMwODU2YzY0N2QzNzdmYjg1OTNiOGI0MTBkODIwZDlhIiwidGFnIjoiIn0=', '117892134598948703719', NULL),
(27, 'teguh muhammad Harits', 'teguhmuhammadharits@gmail.com', NULL, 'user', NULL, '$2y$12$UKGA6T20hPylBD4Wc90JOOC/Hys5zgNOi3L4SYQmWle8pQa4sARrm', 0, NULL, NULL, '2026-02-11 07:22:22', '2026-02-11 07:22:22', NULL, '111049655612063638150', 'https://lh3.googleusercontent.com/a/ACg8ocK_-mecqpP9KJYCNx4jk9ic1dQKFHw5mqwM2E-rLQX07BzLGc5l=s96-c'),
(28, 'ai guh', 'aiguh97@gmail.com', NULL, 'admin', NULL, '$2y$12$/qjyQ3RzwraceWuuPSrl1.N99wTggNsmfbpK3DOB0QNVHjzTMAj6y', 1, 'authenticator', NULL, '2026-02-11 08:48:17', '2026-02-12 07:12:31', 'eyJpdiI6IjMyQ3dBbGQ5VHBHOU4wRnlqU1M0K3c9PSIsInZhbHVlIjoia1BYNC9qZXdYd1JNWUJZTmk4emZUSDNSUGM2RDVUOGNMK2xHU0gyUkN1T2ZhdkJQWGI3VnJZT1ZiaWhTdHZlY2JLa0lPZnkySW9JMFdHNjZZeWlsMU5FOFlUcnZqR3dUck1EMGxoaDVoMmdmYStEdEJiNWNEWFRwcXlGTkRJRmF6bDBKRjRDdDVBSjNTa0dkU3MvV0VCUTFEMmM2V3JYR204UWhLN24vWS8xVnZET1F4aHBzVWlHYUZvbUNldFY4TmVMVnBYNWdzR2wvSkZsT0hQN05wN0phTW9uOUNFWDVLMGtVZGFDTUYxRzdFTnd5L2phQVN2TWp5Vkh2Sk0wMjc2dWFpbGFSdEgxSEs0bXhHaDZSS21YZElpVDNCRXo5cGlzZkswM0U1T0Z3STZjOEgyeStxaVYwNDMxemtBdnciLCJtYWMiOiJhN2RkMmI3NTYwYjEzMGUwZmY5YzViZGVlZDNhODA0NDQyYTBhZWU4MWJlYThlYmQ4MDUxNmQxYzNjMjI0N2JkIiwidGFnIjoiIn0=', '106757749080661034437', 'https://lh3.googleusercontent.com/a/ACg8ocIsGA1o1sAmGuF3bzohN4rvGELdSpsqUMsPzwr9qXTEgBF01sI=s96-c'),
(29, 'Teguh Harits', 'teguhharits91@gmail.com', NULL, 'user', NULL, '$2y$12$/qjyQ3RzwraceWuuPSrl1.N99wTggNsmfbpK3DOB0QNVHjzTMAj6y', 1, 'authenticator', NULL, '2026-02-11 09:08:49', '2026-02-11 09:33:27', 'eyJpdiI6Ino4K3hSSGMybDFQVVZhUFlzYm1KMnc9PSIsInZhbHVlIjoiZk1uNUtnbjd5UFlzbUczWC9zVG5pM1BPS2ZNbHpvVitpb1czZk1RY0hwcGNROVMvLzVlU25XZkJ1aks1ZnZpanNqM29keXcyclpZNHlRS3FIdmtISVczZytqVUpZa1V6N3dRMnFWSVhNdHJMczA0MWtoRzZRMXZxTVp2SUYveng5UzJBSkIxMGFtRDMzZzZnZlpZbGlPZjZQMVJlekpmQ29RZHpLZjJSMlB1bWpjN1FhazlHOFYzSUZnOVpuQmE2T0RjZ285YndSbXFyTG9MM041Yyt2MXMyZWF3eVlqd1RZOUE3dzNwN0ovSXFtNnU5cC9SbGJHWTVLZytUa3Y2di91WHROcllBRUFNclBpaFNiZ0tnWS9uQlVacUl1dmN5bGlRenlianVoVU5nejlxQ1dxRkIrNndLdSt3dHdMdjEiLCJtYWMiOiI1YzE0N2RmNjRlY2Y2ODM2OWI3ZjU5NDk2ZThlMzViYmRlMWRmMjE3YzM1YTI1YzYwMTY3NjdiY2YzNDU5ZTUxIiwidGFnIjoiIn0=', '112984878402204512755', 'https://lh3.googleusercontent.com/a/ACg8ocJju2MBKiAUF89-OEcca1HgYk0qKouAGf2ci2RDyYfqAE3su4Q=s96-c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
  ADD KEY `orders_kasir_id_foreign` (`kasir_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_reservations`
--
ALTER TABLE `table_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `table_reservations_table_id_foreign` (`table_id`),
  ADD KEY `table_reservations_date_start_time_end_time_index` (`date`,`start_time`,`end_time`),
  ADD KEY `table_reservations_order_id_foreign` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `table_reservations`
--
ALTER TABLE `table_reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_kasir_id_foreign` FOREIGN KEY (`kasir_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `table_reservations`
--
ALTER TABLE `table_reservations`
  ADD CONSTRAINT `table_reservations_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `table_reservations_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
