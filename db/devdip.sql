-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2023 at 02:53 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `devdip`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT 1,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Purifier', 1, NULL, '2023-03-08 21:50:32', '2023-03-08 17:19:48'),
(3, 'chiemny', 1, NULL, '2023-03-08 20:00:26', '2023-03-14 20:56:31'),
(4, 'Spare parts', 1, NULL, '2023-07-12 12:48:01', '2023-07-12 09:17:18'),
(5, 'AMC Product', 1, NULL, '2023-07-12 12:48:01', '2023-07-12 09:17:18');

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
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `phone`, `name`, `email`, `address`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '768899664', 'dddd', 'abc@abc.com', 'Birati, Kolkata', '2023-07-31 10:03:13', '2023-03-09 20:14:19', '2023-07-31 10:03:13'),
(2, '7355366667', NULL, 'sunny@sunny.com', 'Birati, Kolkata', '2023-03-11 17:37:53', '2023-03-09 20:14:19', '2023-03-11 17:37:53'),
(3, '6335566778', 'abc', 'abc@test.com', 'Birati, Kolkata', '2023-07-31 10:02:34', '2023-03-11 16:14:30', '2023-07-31 10:02:34'),
(4, '688019332', 'dda', 'dda@test.com', 'Birati, Kolkata', '2023-07-31 10:02:57', '2023-03-13 17:11:36', '2023-07-31 10:02:57'),
(5, '874777778', 'X', NULL, NULL, '2023-07-31 10:03:01', '2023-07-03 11:58:25', '2023-07-31 10:03:01'),
(12, '766664666', 'anup', NULL, 'kalyani', '2023-07-31 10:03:23', '2023-07-06 10:16:03', '2023-07-31 10:03:23'),
(13, '353355667', 'pronab', NULL, 'birati', '2023-08-01 19:48:48', '2023-07-06 10:16:03', '2023-08-01 19:48:48'),
(14, '766664666', 'anup', NULL, 'kalyani', NULL, '2023-08-01 19:49:05', '2023-08-01 19:49:05'),
(15, '353355667', 'pronab', NULL, 'birati', NULL, '2023-08-01 19:49:05', '2023-08-01 19:49:05'),
(16, '877575778', 'suman', NULL, 'laketown', NULL, '2023-08-01 19:49:05', '2023-08-01 19:49:05');

-- --------------------------------------------------------

--
-- Table structure for table `lead_assignment`
--

CREATE TABLE `lead_assignment` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assign_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `follow_up_date` date DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lead_assignment`
--

INSERT INTO `lead_assignment` (`id`, `lead_id`, `user_id`, `assign_date`, `status`, `follow_up_date`, `added_by`, `comment`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2023-03-08', 'Assigned', NULL, NULL, 'comment 1', NULL, '2023-03-11 21:57:07', '2023-03-11 17:26:53'),
(3, 4, 3, '2023-03-13', 'Assigned', NULL, NULL, NULL, NULL, '2023-03-13 19:36:25', '2023-03-13 19:36:25'),
(4, 15, 2, '2023-06-29', 'Assigned', NULL, NULL, 'commment 2', NULL, '2023-06-29 20:31:49', '2023-06-29 20:31:49');

-- --------------------------------------------------------

--
-- Table structure for table `lead_report`
--

CREATE TABLE `lead_report` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `has_water_purifier` varchar(10) DEFAULT NULL,
  `in_use_water_purifier` varchar(10) DEFAULT NULL,
  `has_chimney` varchar(10) DEFAULT NULL,
  `in_use_chimney` varchar(10) DEFAULT NULL,
  `chimney_status` varchar(30) DEFAULT NULL,
  `waterpurifier_status` varchar(30) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lead_report`
--

INSERT INTO `lead_report` (`id`, `lead_id`, `has_water_purifier`, `in_use_water_purifier`, `has_chimney`, `in_use_chimney`, `chimney_status`, `waterpurifier_status`, `added_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 15, 'true', 'false', 'true', 'false', 'AMC With Us', 'Paid With Other', NULL, NULL, '2023-07-08 12:28:02', '2023-07-08 08:56:43'),
(2, 14, 'true', 'false', 'true', 'false', 'Paid With Us', 'AMC With Us', NULL, NULL, '2023-07-08 12:28:02', '2023-07-08 08:56:43');

-- --------------------------------------------------------

--
-- Table structure for table `master_popup_messages`
--

CREATE TABLE `master_popup_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_value_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_value_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_id` int(11) NOT NULL,
  `request_member_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `receiver_member_id` int(11) NOT NULL,
  `message_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message_image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message_audio_video` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(33, '2014_10_12_000000_create_users_table', 1),
(34, '2014_10_12_100000_create_password_resets_table', 1),
(35, '2019_08_19_000000_create_failed_jobs_table', 1),
(36, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(37, '2022_06_26_132301_create_permission_tables', 1),
(38, '2022_06_27_114959_create_otp_models_table', 1),
(39, '2022_07_25_142622_create_master_popup_messages_table', 1),
(40, '2022_07_26_063547_create_messages_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amt` varchar(30) DEFAULT NULL,
  `order_status` enum('pending','dispatch','denied','completed') NOT NULL DEFAULT 'pending',
  `payment_mode` enum('cod','online') NOT NULL DEFAULT 'cod',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `user_id`, `total_amt`, `order_status`, `payment_mode`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '090323-001', 2, '5800', 'denied', 'cod', NULL, '2023-03-09 19:03:55', '2023-03-09 14:32:51'),
(2, '090323-002', 1, '6900', 'pending', 'cod', NULL, '2023-03-09 19:03:55', '2023-03-09 14:32:51'),
(6, '25-03-2023-6', 7, '1900', 'pending', 'cod', NULL, '2023-03-25 08:42:40', '2023-03-25 08:42:40'),
(7, '25032023-007', 7, '1900', 'dispatch', 'cod', NULL, '2023-03-25 08:56:04', '2023-03-25 11:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_qty` int(11) NOT NULL DEFAULT 1,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `product_qty`, `order_date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2023-03-09 19:04:31', NULL, '2023-03-09 19:04:31', '2023-03-09 14:34:12'),
(2, 2, 2, 1, '2023-03-09 19:04:31', NULL, '2023-03-09 19:04:31', '2023-03-09 14:34:12'),
(3, 2, 3, 1, '2023-03-09 19:04:42', NULL, '2023-03-09 19:04:42', '2023-03-09 14:34:35'),
(4, 5, 1, 2, '2023-03-25 11:10:58', NULL, '2023-03-25 08:40:58', '2023-03-25 08:40:58'),
(5, 5, 2, 1, '2023-03-25 11:10:58', NULL, '2023-03-25 08:40:58', '2023-03-25 08:40:58'),
(6, 6, 1, 2, '2023-03-25 11:12:40', NULL, '2023-03-25 08:42:40', '2023-03-25 08:42:40'),
(7, 6, 2, 1, '2023-03-25 11:12:40', NULL, '2023-03-25 08:42:40', '2023-03-25 08:42:40'),
(8, 7, 1, 2, '2023-03-25 11:26:04', NULL, '2023-03-25 08:56:04', '2023-03-25 08:56:04'),
(9, 7, 2, 1, '2023-03-25 11:26:04', NULL, '2023-03-25 08:56:04', '2023-03-25 08:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `otp_models`
--

CREATE TABLE `otp_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `try_count` int(11) NOT NULL DEFAULT 0,
  `expired_at` timestamp NULL DEFAULT NULL,
  `validated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_name` varchar(100) DEFAULT NULL,
  `page_heading` varchar(150) DEFAULT NULL,
  `page_content` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_name`, `page_heading`, `page_content`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'About Us Edit', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed mollitia eligendi perferendis repellat nesciunt accusantium ab dolorem voluptatum eaque amet modi odio omnis itaque ipsum ut delectus quisquam, quaerat temporibus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed mollitia eligendi perferendis repellat nesciunt accusantium ab dolorem voluptatum eaque amet modi odio omnis itaque ipsum ut delectus quisquam, quaerat temporibus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed mollitia eligendi perferendis repellat nesciunt accusantium ab dolorem voluptatum eaque amet modi odio omnis itaque ipsum ut delectus quisquam, quaerat temporibus?\r\n\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Sed mollitia eligendi perferendis repellat nesciunt accusantium ab dolorem voluptatum eaque amet modi odio omnis itaque ipsum ut delectus quisquam, quaerat temporibus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed mollitia eligendi perferendis repellat nesciunt accusantium ab dolorem voluptatum eaque amet modi odio omnis itaque ipsum ut delectus quisquam, quaerat temporibus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed mollitia eligendi perferendis repellat nesciunt accusantium ab dolorem voluptatum eaque amet modi odio omnis itaque ipsum ut delectus quisquam, quaerat temporibus?', '2023-06-07 01:42:17', '2023-06-06 23:18:52', NULL),
(2, 'Contact Us', 'Send Us A Message', 'Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within a matter of hours to help you.', '2023-06-07 01:42:17', '2023-06-06 22:11:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 6, 'user_token', 'fdc538595b7aff4e58acf5940c018ecc14b3770e5f829dc9dc8896c86881c05c', '[\"*\"]', NULL, '2023-03-14 16:27:48', '2023-03-14 16:27:48'),
(2, 'App\\Models\\User', 6, 'user_token', 'c8d5fd75f1652284868abf5d69177762ce4a7c242672a2a87b16e942dccbdad8', '[\"*\"]', NULL, '2023-03-14 16:28:55', '2023-03-14 16:28:55'),
(3, 'App\\Models\\User', 6, 'user_token', '593a8e1f09886730829d71e540b9e6af68f3a49e9907c44f20b8546ec62d0044', '[\"*\"]', NULL, '2023-03-14 16:31:32', '2023-03-14 16:31:32'),
(4, 'App\\Models\\User', 6, 'user_token', 'b7358a5ad58d7e05ac20f12a36b509f272d42f3ada5ca908cc4bfa8a88f0bf50', '[\"*\"]', NULL, '2023-03-14 16:44:38', '2023-03-14 16:44:38'),
(5, 'App\\Models\\User', 6, 'user_token', '0121b28e01e93df1849fa59c3659717ff6b11b3f2a48fc66e76326cb7bc5a372', '[\"*\"]', NULL, '2023-03-14 16:45:52', '2023-03-14 16:45:52'),
(6, 'App\\Models\\User', 6, 'user_token', '612ff76750b0ab21fd1a88b39caa5f2ee9b9a1c7fe20cd9a26b0f98ca05116b2', '[\"*\"]', NULL, '2023-03-14 16:46:41', '2023-03-14 16:46:41'),
(7, 'App\\Models\\User', 6, 'user_token', '54dfa922351af7cedeaf9216eff78238ab49b64ca9fa5243240d59492be8dde3', '[\"*\"]', NULL, '2023-03-14 16:47:24', '2023-03-14 16:47:24'),
(8, 'App\\Models\\User', 6, 'user_token', '5e0e78378fcad9175564f445bac127c98bf89d31819b757d8030846a96ef48fb', '[\"*\"]', NULL, '2023-03-14 16:48:50', '2023-03-14 16:48:50'),
(9, 'App\\Models\\User', 6, 'user_token', '0dea59fcae45509616b35b5fe53b15d19d0b4262b3506b0e66d635d30172ac60', '[\"*\"]', NULL, '2023-03-14 16:49:28', '2023-03-14 16:49:28'),
(10, 'App\\Models\\User', 6, 'user_token', '58a363e937e47955159a05ed39d59fb924ac45a209fb6afb5e520b4d64496e72', '[\"*\"]', NULL, '2023-03-14 16:49:31', '2023-03-14 16:49:31'),
(11, 'App\\Models\\User', 6, 'user_token', '433817fe6745a6f9e1e7e426efe471aa8d6a04fff0c4d79c21132db145e85a67', '[\"*\"]', NULL, '2023-03-14 16:49:43', '2023-03-14 16:49:43'),
(12, 'App\\Models\\User', 6, 'user_token', '5efd5dd1a1e7027db4abf5f7a9d3d0831ae4f3109d2d108fca7f89d2beca9f24', '[\"*\"]', NULL, '2023-03-14 16:51:37', '2023-03-14 16:51:37'),
(13, 'App\\Models\\User', 6, 'user_token', '6c2e446571fbdfbfa24e76b75c76a89530b41102de80229c6787198a83f1f390', '[\"*\"]', NULL, '2023-03-14 16:52:01', '2023-03-14 16:52:01'),
(14, 'App\\Models\\User', 7, 'user_token', '4b0a87f35eb0bada38ab86432085ef28fc37fbc34d19019d4952be5f7f5b334a', '[\"*\"]', NULL, '2023-03-14 17:02:53', '2023-03-14 17:02:53'),
(15, 'App\\Models\\User', 7, 'user_token', '49077a1b9372e5164e2775247a9f2c17d621d8087a05b554a77aff936333bc30', '[\"*\"]', NULL, '2023-03-15 15:07:03', '2023-03-15 15:07:03'),
(16, 'App\\Models\\User', 7, 'user_token', '6adb1f0942cb43def72317a514c7c3032022be97b9e8cfcfd9e8732dfb22aa3a', '[\"*\"]', NULL, '2023-03-18 12:07:37', '2023-03-18 12:07:37'),
(17, 'App\\Models\\User', 7, 'user_token', 'dda1d7a2ba0968b98ad6afde504c20da44dc03ac4ff97c35213debc8ceff48e9', '[\"*\"]', '2023-03-29 15:03:04', '2023-03-20 04:34:48', '2023-03-29 15:03:04'),
(18, 'App\\Models\\User', 7, 'user_token', '9ec34a508ad94f23bc98beeae60f049d9f17408ca996977064cdb0e8ccc0300a', '[\"*\"]', NULL, '2023-03-29 16:27:37', '2023-03-29 16:27:37'),
(19, 'App\\Models\\User', 8, 'user_token', '907b004e895e22e28301e84c24009cafb5fae0ff4ae2da71373847ab4c75e4fd', '[\"*\"]', NULL, '2023-03-30 01:24:14', '2023-03-30 01:24:14'),
(20, 'App\\Models\\User', 7, 'user_token', '38436ac5d22d7a4f3e2b22e627250a26dfeb575188d47dea176b598c721450ce', '[\"*\"]', NULL, '2023-05-20 10:53:19', '2023-05-20 10:53:19'),
(21, 'App\\Models\\User', 7, 'user_token', '5c5086fa81f9a3c906c61257b636983597f1de2b64121b60b9a194d648b44423', '[\"*\"]', '2023-06-08 18:39:29', '2023-05-20 10:54:04', '2023-06-08 18:39:29'),
(22, 'App\\Models\\User', 7, 'user_token', 'cb7d9f62a8dc3209650a3ee6729d4760a670ff7b6854c548f4eb1e554e1f60a9', '[\"*\"]', NULL, '2023-05-20 10:56:13', '2023-05-20 10:56:13'),
(23, 'App\\Models\\User', 7, 'user_token', '726e9ce7570f29aeaae4777ac48c84b34751566d961d39a5c1cdf21625829d6b', '[\"*\"]', NULL, '2023-05-20 10:57:12', '2023-05-20 10:57:12'),
(24, 'App\\Models\\User', 7, 'user_token', 'd9cbfcc8c8327ad612f83cff59fe1ce0cdd0bafd621d888443cd99cfc6849d26', '[\"*\"]', NULL, '2023-05-20 15:24:58', '2023-05-20 15:24:58'),
(25, 'App\\Models\\User', 7, 'user_token', '034f2311ebd5f52521150a776c99a4d375e076ada7da537a22e50c04344f266c', '[\"*\"]', NULL, '2023-05-20 15:25:43', '2023-05-20 15:25:43'),
(26, 'App\\Models\\User', 7, 'user_token', '7c3cabc206413a6514149312a42a4c1da7186a82b1ea5c33eb084c45f32fd248', '[\"*\"]', NULL, '2023-05-20 15:26:23', '2023-05-20 15:26:23'),
(27, 'App\\Models\\User', 7, 'user_token', '9f4bb425f663592a68a6506358ca49684af512c9745950ece271ff29cc9af3df', '[\"*\"]', NULL, '2023-05-20 15:38:45', '2023-05-20 15:38:45'),
(28, 'App\\Models\\User', 7, 'user_token', '5ce198e37a033a92d01a33876fc373d4f570b2b14709102868999da39abe5e7f', '[\"*\"]', NULL, '2023-05-20 15:43:05', '2023-05-20 15:43:05'),
(29, 'App\\Models\\User', 7, 'user_token', '3c4e30357dee859c3031ca5d827d246684daa476f18205f84f17d61b867e18a7', '[\"*\"]', NULL, '2023-05-20 15:45:16', '2023-05-20 15:45:16'),
(30, 'App\\Models\\User', 7, 'user_token', '7aec82137c48bf6559f5277e64f32b4d1a96ae2062a913b768685c373f13bfc2', '[\"*\"]', NULL, '2023-05-20 15:48:59', '2023-05-20 15:48:59'),
(31, 'App\\Models\\User', 7, 'user_token', '6a7a062c0da89c52a44da0c7d691a56742cb4bee6dcb114bd93575a532fe9e71', '[\"*\"]', NULL, '2023-05-20 15:52:10', '2023-05-20 15:52:10'),
(32, 'App\\Models\\User', 7, 'user_token', '5dd22e68ea6883fe6f2d3b4b2927159accbeb43ec7c41afea88e49d346ab123e', '[\"*\"]', NULL, '2023-05-20 15:54:08', '2023-05-20 15:54:08'),
(33, 'App\\Models\\User', 7, 'user_token', 'b2080e1dfc789141b43f42f7fa5a78278638ba73a1d7bcfd3f79deafb1801e03', '[\"*\"]', NULL, '2023-06-01 03:16:50', '2023-06-01 03:16:50'),
(34, 'App\\Models\\User', 7, 'user_token', '40099735a5554f794fd6d43363bbb6662a87641f994c5dd40680209664550242', '[\"*\"]', '2023-06-02 06:10:24', '2023-06-01 03:17:49', '2023-06-02 06:10:24'),
(35, 'App\\Models\\User', 7, 'user_token', '83a7e543d9da0019f27d8308abba065a551b7270ae9a150ea4f4951fec22ff2a', '[\"*\"]', '2023-06-29 15:07:13', '2023-06-05 15:47:35', '2023-06-29 15:07:13'),
(36, 'App\\Models\\User', 7, 'user_token', 'ae47d8aed96a319373b58a4a34138d89f854bdeb7b09304df49b38de68f9f0cc', '[\"*\"]', NULL, '2023-06-09 05:42:14', '2023-06-09 05:42:14'),
(37, 'App\\Models\\User', 7, 'user_token', 'eace25ab8525ee582d0d31dc704581b48e51819269857cf401a9f1824a46a184', '[\"*\"]', NULL, '2023-06-09 05:46:47', '2023-06-09 05:46:47'),
(38, 'App\\Models\\User', 7, 'user_token', 'e6b846b2526657ba1b73c302d056e2fff54be2777d3e575093f8e09ef9d659a3', '[\"*\"]', NULL, '2023-06-09 05:50:25', '2023-06-09 05:50:25'),
(39, 'App\\Models\\User', 7, 'user_token', '5515f290b959e688952c24035db663c7efd74190fe6c6ddc190390dac0c31851', '[\"*\"]', NULL, '2023-06-09 05:52:01', '2023-06-09 05:52:01'),
(40, 'App\\Models\\User', 7, 'user_token', '063ad3832c5069410cda2553b7df29239df385b0345d49ab5c7ea53211b68e78', '[\"*\"]', NULL, '2023-06-09 05:59:49', '2023-06-09 05:59:49'),
(41, 'App\\Models\\User', 7, 'user_token', '77c5af7f4aaa987ea4722f9df8cb2f2b6d33b4d0c1728a2db3e04b77ac636bd1', '[\"*\"]', NULL, '2023-06-09 06:11:15', '2023-06-09 06:11:15'),
(42, 'App\\Models\\User', 7, 'user_token', '56a566beda6d9936d675b858ebe737bd3c2d0b7ae61ab94304553cd105777f42', '[\"*\"]', '2023-06-09 15:07:53', '2023-06-09 08:36:45', '2023-06-09 15:07:53'),
(43, 'App\\Models\\User', 7, 'user_token', '90f0609143326f45172f69653ab9ab464faccdc1194d213cd3d831bf0a5eeab5', '[\"*\"]', NULL, '2023-06-10 15:36:33', '2023-06-10 15:36:33'),
(44, 'App\\Models\\User', 7, 'user_token', '3a58ca79281095a3d92411cf673e24fc1ed8c1668475807c09415014d27c2270', '[\"*\"]', NULL, '2023-06-10 15:38:22', '2023-06-10 15:38:22'),
(45, 'App\\Models\\User', 7, 'user_token', '05a4756f31165adaf18d8da183b0f49d025a4a4ebedddb37e51c1767c4b73ab0', '[\"*\"]', NULL, '2023-06-10 15:41:44', '2023-06-10 15:41:44'),
(46, 'App\\Models\\User', 7, 'user_token', '79e366cae3bab6e0ee4809e72a68961faa028a9b5733057a6486683ffe37f145', '[\"*\"]', NULL, '2023-06-11 03:07:38', '2023-06-11 03:07:38'),
(47, 'App\\Models\\User', 7, 'user_token', '62f5401df38550f2a0d4401b729b6089b00214de5dad803699233ca689ef6cba', '[\"*\"]', NULL, '2023-06-11 03:07:38', '2023-06-11 03:07:38'),
(48, 'App\\Models\\User', 7, 'user_token', '730b38b46a14b1507834abe6dfb74d7aa3b0fecc70d264d3d4889f9f852316a7', '[\"*\"]', NULL, '2023-06-11 03:08:23', '2023-06-11 03:08:23'),
(49, 'App\\Models\\User', 7, 'user_token', 'e3b3195eb169968a7392c2aca9c98dfb631ed351668bd948d4b702f9790d0c71', '[\"*\"]', NULL, '2023-06-11 03:10:52', '2023-06-11 03:10:52'),
(50, 'App\\Models\\User', 7, 'user_token', '617c2c74569c8ebef9bc474bad33339367c216c3cbd8336fd8977fafc35cd33b', '[\"*\"]', NULL, '2023-06-11 03:24:37', '2023-06-11 03:24:37'),
(51, 'App\\Models\\User', 7, 'user_token', 'cf888b8e70304da1c137b0b5574e6cee1b78eed9c91e79128d1bc61a27809f8e', '[\"*\"]', NULL, '2023-06-11 03:27:33', '2023-06-11 03:27:33'),
(52, 'App\\Models\\User', 7, 'user_token', '2374c25169984f9dea1264bc21c38399fb785d1a97396b5f392be39976d03a05', '[\"*\"]', NULL, '2023-06-11 03:30:33', '2023-06-11 03:30:33'),
(53, 'App\\Models\\User', 7, 'user_token', 'f58fc7e531ec29878535f59c10337ea8239140268d33b9d2c20196e7fe292da0', '[\"*\"]', NULL, '2023-06-11 03:32:46', '2023-06-11 03:32:46'),
(54, 'App\\Models\\User', 7, 'user_token', '703fe10e26b4b34fe5d83a4879c1174b53ff0ca750921ab073b1eacbe562f83f', '[\"*\"]', NULL, '2023-06-11 03:36:41', '2023-06-11 03:36:41'),
(55, 'App\\Models\\User', 7, 'user_token', '6e64f14e9cd8dea1ea46975300bc490985ed86e44cd8879ab354ed6ba07b8c65', '[\"*\"]', NULL, '2023-06-11 03:48:14', '2023-06-11 03:48:14'),
(56, 'App\\Models\\User', 7, 'user_token', '5fd0200231d34ef7dc872e3dc851845c2b5389964ed0e8b2d026aa1e3095b073', '[\"*\"]', NULL, '2023-06-11 03:49:05', '2023-06-11 03:49:05'),
(57, 'App\\Models\\User', 7, 'user_token', '768cd3ef5e5c41e39c7e98f7d47e5dfb7cc00bd55c081a81d80a48c70f989666', '[\"*\"]', NULL, '2023-06-11 03:49:23', '2023-06-11 03:49:23'),
(58, 'App\\Models\\User', 7, 'user_token', 'bf292378f99509bd912049f8a3e1990998056a56baf641308bb06f52b99f121a', '[\"*\"]', NULL, '2023-06-11 03:51:08', '2023-06-11 03:51:08'),
(59, 'App\\Models\\User', 7, 'user_token', '4d3a167222967f1872fde5488f76c8fa9243dcaf583c57e36357dab60a2c1538', '[\"*\"]', NULL, '2023-06-11 03:51:50', '2023-06-11 03:51:50'),
(60, 'App\\Models\\User', 7, 'user_token', 'ec126a5e2ea2fd286e453198dd3d75ee0f5452010f4dd6e6b09f7c4c2a15dbd6', '[\"*\"]', NULL, '2023-06-11 03:52:33', '2023-06-11 03:52:33'),
(61, 'App\\Models\\User', 7, 'user_token', 'ac6d8698a4261281476a3d31a1204245ee5b47bace214b7fee6c3033b980626c', '[\"*\"]', NULL, '2023-06-11 03:55:19', '2023-06-11 03:55:19'),
(62, 'App\\Models\\User', 7, 'user_token', '3665a4e6fa9ec578d7b2ed36931aa1bac5cee946aa6c44e4907e34c5fa71e681', '[\"*\"]', NULL, '2023-06-11 03:57:26', '2023-06-11 03:57:26'),
(63, 'App\\Models\\User', 7, 'user_token', 'e1ac85e51675d7229a0c2a3a025481204e28993a6ce99011c0c69c9daeb3209f', '[\"*\"]', NULL, '2023-06-11 03:57:26', '2023-06-11 03:57:26'),
(64, 'App\\Models\\User', 7, 'user_token', '8f0add88052255400f37b0b67ed1c8e459bd675b7c68465d38cef40ca185a0d1', '[\"*\"]', NULL, '2023-06-11 03:57:26', '2023-06-11 03:57:26'),
(65, 'App\\Models\\User', 7, 'user_token', '8c75fa621fe242bfee39ed8c5741b56d940b6ee7a62470fc253f07edd8d7a556', '[\"*\"]', NULL, '2023-06-11 04:00:07', '2023-06-11 04:00:07'),
(66, 'App\\Models\\User', 7, 'user_token', 'e6b8830b6f39a6cd720fadad271b5119b0249b90f6e9441ef2d47852d029d27a', '[\"*\"]', NULL, '2023-06-11 04:04:04', '2023-06-11 04:04:04'),
(67, 'App\\Models\\User', 7, 'user_token', '54643ed69323bbe1f94d40470148b85a1ca2b593e4ce0a138266f04efa0cf8c1', '[\"*\"]', NULL, '2023-06-11 12:24:26', '2023-06-11 12:24:26'),
(68, 'App\\Models\\User', 7, 'user_token', '33e88dc20e46b94f351214c2cc835f025852d85dc1ae31522681ecee4623201f', '[\"*\"]', '2023-06-17 12:28:16', '2023-06-17 04:41:06', '2023-06-17 12:28:16'),
(69, 'App\\Models\\User', 2, 'user_token', '2afd3cc9b3de19bd6ee8c769a08c1828dcdfbd9e91cdf7758e502194e5dc6805', '[\"*\"]', NULL, '2023-06-29 15:08:03', '2023-06-29 15:08:03'),
(70, 'App\\Models\\User', 8, 'user_token', '6d7b8d496d5ebc8bc2d5e8a97fa0029149814975ddaea5563ed09fabf374c9b7', '[\"*\"]', '2023-07-13 13:41:37', '2023-07-12 06:16:59', '2023-07-13 13:41:37'),
(71, 'App\\Models\\User', 28, 'user_token', '320d94cb07316aa1809d3066b2226bc313b9339da10a1ff9962b873d6bccd8c6', '[\"*\"]', NULL, '2023-07-31 03:56:31', '2023-07-31 03:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `product_desc` text DEFAULT NULL,
  `actual_price` varchar(100) DEFAULT NULL,
  `sale_price` varchar(100) DEFAULT NULL,
  `no_of_service` int(5) DEFAULT NULL,
  `price_per_service` varchar(100) DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT 1,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `product_desc`, `actual_price`, `sale_price`, `no_of_service`, `price_per_service`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Pureit Max Water Saver 10 L RO + UV + MF Water Purifier with Eco Recovery Technology  (Black, White)', 'You can provide your family with safe and clean drinking water with the Pureit by HUL Advanced Max 6 L Water Purifier. It uses a mineral enhancer cartridge to provide RO-purified water that contains essential minerals, like calcium and magnesium, without any bypass. Additionally, this water purifier is capable of storing up to 6 L of fresh and purified RO water, making it an excellent choice for households with high water consumption needs. Furthermore, its purification process involves up to seven stages, ensuring that the water is thoroughly purified and safe for drinking.', '12000', '11500', NULL, NULL, 1, NULL, '2023-03-08 23:22:03', '2023-06-14 11:55:56'),
(2, 2, 'product2', NULL, '10', '9', NULL, NULL, 1, NULL, '2023-03-08 22:31:04', '2023-03-08 23:06:26'),
(3, 3, 'Best purifier', NULL, '10', '5', NULL, NULL, 1, NULL, '2023-03-08 22:34:07', '2023-05-23 18:28:21'),
(4, 3, 'HUL Pureit Eco Water Saver Mineral RO+UV+MF AS wall mounted/Counter top Black 10L Water Purifier', NULL, '12999', '12500', NULL, NULL, 1, NULL, '2023-03-14 20:59:11', '2023-03-14 20:59:11'),
(5, 2, 'Best purifier', NULL, '15', '10', NULL, NULL, 1, NULL, '2023-05-23 18:39:10', '2023-05-23 18:39:10'),
(6, 3, 'HUL Pureit Eco Water Saver Mineral RO+UV+MF AS wall mounted/Counter top Black 10L Water Purifier', NULL, '3000', '3000', NULL, NULL, 1, NULL, '2023-05-23 18:39:27', '2023-05-23 18:39:27'),
(7, 2, 'HUL Pureit Eco Water Saver Mineral RO+UV+MF AS wall mounted/Counter top Black 10L Water Purifier', NULL, '3000', '3000', NULL, NULL, 1, NULL, '2023-05-23 18:39:42', '2023-05-23 18:39:42'),
(10, 2, 'ddadad', 'addada sfsgsfgsgd sfsfsfsf sfsgsfgsg', '2000', '2000', NULL, NULL, 1, NULL, '2023-06-06 22:39:56', '2023-06-06 22:39:56'),
(11, 2, 'ddadad', 'addada sfsgsfgsgd sfsfsfsf sfsgsfgsg', '2000', '2000', NULL, NULL, 1, NULL, '2023-06-06 22:40:45', '2023-06-06 22:40:45'),
(12, 2, 'ddadad', 'addada sfsgsfgsgd sfsfsfsf sfsgsfgsg', '2000', '2000', NULL, NULL, 1, NULL, '2023-06-06 22:41:11', '2023-06-06 22:41:11'),
(13, 2, 'rfrwrwrwtwtg darwrwrw', 'ccsfsgdg sgghgrhyrjhur ghhhtrhujt', '3000', '2000', NULL, NULL, 1, '2023-06-14 11:32:56', '2023-06-06 22:46:10', '2023-06-14 11:32:56'),
(14, 2, 'Best purifier', 'kk igii', '3000', '2000', NULL, NULL, 1, NULL, '2023-06-08 18:13:04', '2023-06-08 18:13:04'),
(15, 5, 'AAAA', 'AAAA', '20000', '18000', 4, '400', 1, NULL, '2023-07-12 10:31:24', '2023-07-12 10:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `product_gallery`
--

CREATE TABLE `product_gallery` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` text DEFAULT NULL,
  `thumbimage` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_gallery`
--

INSERT INTO `product_gallery` (`id`, `product_id`, `image`, `thumbimage`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, '2023-06-14 11:55:56', '2023-06-14 11:35:27', '2023-06-14 11:55:56'),
(2, 1, NULL, NULL, '2023-06-14 11:55:56', '2023-06-14 11:35:27', '2023-06-14 11:55:56'),
(3, 1, NULL, NULL, '2023-06-14 11:55:56', '2023-06-14 11:35:27', '2023-06-14 11:55:56'),
(4, 1, NULL, NULL, '2023-06-14 11:55:56', '2023-06-14 11:35:27', '2023-06-14 11:55:56'),
(5, 1, NULL, NULL, '2023-06-14 11:55:56', '2023-06-14 11:35:27', '2023-06-14 11:55:56'),
(6, 1, NULL, NULL, '2023-06-14 12:02:00', '2023-06-14 11:55:56', '2023-06-14 12:02:00'),
(7, 1, NULL, NULL, '2023-06-14 12:02:00', '2023-06-14 11:55:56', '2023-06-14 12:02:00'),
(8, 1, NULL, NULL, '2023-06-14 12:02:00', '2023-06-14 11:55:56', '2023-06-14 12:02:00'),
(9, 1, NULL, NULL, '2023-06-14 12:02:00', '2023-06-14 11:55:56', '2023-06-14 12:02:00'),
(10, 1, NULL, NULL, '2023-06-14 12:02:00', '2023-06-14 11:55:56', '2023-06-14 12:02:00'),
(11, 1, '/product/YZv9ljf8F9.jpg', '/product/thumbnail/hk6TGnnSsm.jpg', NULL, '2023-06-14 12:02:01', '2023-06-14 12:02:01'),
(12, 1, '/product/CGZh7mAk9p.jpg', '/product/thumbnail/TNNQ15dKbt.jpg', NULL, '2023-06-14 12:02:01', '2023-06-14 12:02:01'),
(13, 1, '/product/FmoyO8mGQl.jpg', '/product/thumbnail/ShBHwoH0o9.jpg', NULL, '2023-06-14 12:02:01', '2023-06-14 12:02:01'),
(14, 1, NULL, NULL, NULL, '2023-06-14 12:02:01', '2023-06-14 12:02:01'),
(15, 1, NULL, NULL, NULL, '2023-06-14 12:02:01', '2023-06-14 12:02:01'),
(16, 14, '/product/HFxcHWKUHe.jpg', '/product/thumbnail/SIIBMEbsLm.jpg', NULL, '2023-06-14 12:31:43', '2023-06-14 12:31:43'),
(17, 14, NULL, NULL, NULL, '2023-06-14 12:31:43', '2023-06-14 12:31:43'),
(18, 14, NULL, NULL, NULL, '2023-06-14 12:31:43', '2023-06-14 12:31:43'),
(19, 14, NULL, NULL, NULL, '2023-06-14 12:31:43', '2023-06-14 12:31:43'),
(20, 14, NULL, NULL, NULL, '2023-06-14 12:31:43', '2023-06-14 12:31:43');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slots_setiings`
--

CREATE TABLE `slots_setiings` (
  `id` int(11) NOT NULL,
  `slot_name` varchar(100) NOT NULL,
  `slot_time` varchar(100) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slots_setiings`
--

INSERT INTO `slots_setiings` (`id`, `slot_name`, `slot_time`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Morning', '11:00 AM', '2023-04-29 11:48:14', '2023-04-29 11:41:44', '2023-04-29 11:48:14'),
(2, 'Slot 1', '10:00 AM', NULL, '2023-04-29 11:45:22', '2023-04-29 11:49:12'),
(3, 'Slot 2', '11:00 AM', NULL, '2023-04-29 11:49:21', '2023-04-29 11:49:21'),
(4, 'Slot 3', '12:00 AM', NULL, '2023-04-29 11:49:35', '2023-04-29 11:49:35'),
(5, 'Slot 4', '2:00 PM', NULL, '2023-04-29 11:49:54', '2023-04-29 11:49:54'),
(6, 'Slot 5', '3:00 PM', NULL, '2023-04-29 11:50:09', '2023-04-29 11:50:09'),
(7, 'Slot 6', '4:00 PM', NULL, '2023-04-29 11:50:24', '2023-04-29 11:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `slug`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'not-started', 'Not Started', '2023-06-05 23:29:14', '2023-06-05 19:58:21', NULL),
(2, 'in-progress', 'In Progress', '2023-06-05 23:29:14', '2023-06-05 19:58:21', NULL),
(3, 'completed', 'Completed', '2023-06-05 23:29:44', '2023-06-05 19:59:19', NULL),
(4, 'not-avaliable', 'Not Avaliable', '2023-06-05 23:29:44', '2023-06-05 19:59:19', NULL),
(5, 'not-resolved', 'Not Resolved', '2023-06-05 23:30:08', '2023-06-05 19:59:49', NULL),
(6, 'started', 'Started', '2023-06-06 00:03:32', '2023-06-05 20:33:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `technian_slot`
--

CREATE TABLE `technian_slot` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `work_order_id` int(11) DEFAULT NULL,
  `slot_id` int(11) NOT NULL,
  `status` enum('NOT_STARTED','STARTED','PENDING','COMPLETED','CUSTOMER_NOT_AVALIABLE') DEFAULT 'NOT_STARTED',
  `date` date DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `technian_slot`
--

INSERT INTO `technian_slot` (`id`, `user_id`, `work_order_id`, `slot_id`, `status`, `date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(14, 7, 15, 2, 'STARTED', '2023-06-05', NULL, '2023-06-05 21:20:23', '2023-06-09 00:09:30'),
(15, 5, 16, 2, 'STARTED', '2023-06-05', NULL, '2023-06-05 21:31:55', '2023-06-05 21:39:58'),
(16, 7, 17, 2, 'NOT_STARTED', '2023-06-06', NULL, '2023-06-06 21:25:39', '2023-06-06 21:25:39'),
(17, 6, 18, 5, 'NOT_STARTED', '2023-06-18', NULL, '2023-06-18 20:20:10', '2023-06-18 20:20:10'),
(18, 6, 19, 2, 'NOT_STARTED', '2023-06-20', NULL, '2023-06-20 20:41:19', '2023-06-20 20:41:19'),
(19, 7, 21, 2, 'NOT_STARTED', '2023-06-20', NULL, '2023-06-20 20:49:53', '2023-06-20 20:49:53'),
(20, 7, 22, 3, 'NOT_STARTED', '2023-06-20', NULL, '2023-06-20 20:50:34', '2023-06-20 20:50:34'),
(21, 7, 23, 4, '', '2023-06-20', NULL, '2023-06-20 20:51:32', '2023-06-25 10:50:20'),
(22, 7, 24, 2, 'NOT_STARTED', '2023-06-21', NULL, '2023-06-21 20:57:21', '2023-06-21 20:57:21'),
(23, 7, 25, 2, '', '2023-06-25', NULL, '2023-06-25 10:19:23', '2023-06-25 10:50:20'),
(24, 7, 26, 3, 'NOT_STARTED', '2023-06-25', NULL, '2023-06-25 10:21:32', '2023-06-25 10:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `ticket_no` varchar(30) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `image` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT 1,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_no`, `user_id`, `title`, `description`, `created_by`, `image`, `category_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(15, 'T2023062115', 8, 'wrwrwr', 'wrwrwr', 1, NULL, 3, 2, NULL, '2023-06-21 22:19:59', '2023-06-25 10:21:32'),
(16, 'T2023072116', 9, 'ettet', 'etete', 1, NULL, 2, 1, NULL, '2023-07-21 23:10:43', '2023-07-21 23:10:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` enum('admin','tele_caller','technician','user','normal_user','amc_user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` enum('active','deactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_new` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `device_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `mobile`, `user_type`, `status`, `address`, `lat`, `lng`, `email_verified_at`, `password`, `password_new`, `remember_token`, `deleted_at`, `created_at`, `updated_at`, `device_type`, `device_token`) VALUES
(1, 'admin', NULL, 'admin@admin.com', '511111111', 'admin', 'active', 'Chandamari, Kalyani, 741245, WB', NULL, NULL, NULL, '$2y$10$vRJ4ffmV20zktB6BCRRoxecBjthc7IltsY49iQpwSlEMNvVTm7mbC', NULL, NULL, NULL, '2023-03-08 07:20:41', '2023-03-08 07:20:41', NULL, NULL),
(2, 'rahul', 'rahul', 'rahul@gmail.com', '4234242456', 'tele_caller', 'active', 'Chandamari, Kalyani, 741245, WB', NULL, NULL, NULL, '$2y$10$L.EPHiyA4XTiMseyWvr28.pu.aoPpSlp.706JxKCtki6J4S0/idQy', NULL, NULL, '2023-07-31 15:41:05', '2023-03-08 07:20:42', '2023-07-31 15:41:05', NULL, NULL),
(3, 'anup bhakta', 'abp', 'anup-01@lms.com', '688019332', 'technician', 'active', 'Chandamari, Kalyani, 741245, WB', NULL, NULL, NULL, '$2y$10$OY7j1O.txDWE.BcwK699sOGkZvYFTMYV8aSkApmJc0rkoJyoH2wGC', NULL, NULL, '2023-06-01 03:17:14', '2023-03-11 12:50:32', '2023-06-01 03:17:14', NULL, NULL),
(4, 'tech-01', 'tech-01', 'tech-01@test.com', '7699999996', 'technician', 'active', 'Chandamari, Kalyani, 741245, WB', NULL, NULL, NULL, '', NULL, NULL, '2023-07-31 15:41:03', NULL, '2023-07-31 15:41:03', NULL, NULL),
(5, 'tech-02', 'tech-02', 'tech-02@test.cm', '4242456678', 'technician', 'active', 'Chandamari, Kalyani, 741245, WB', NULL, NULL, NULL, '', NULL, NULL, '2023-07-31 15:40:59', NULL, '2023-07-31 15:40:59', NULL, NULL),
(7, 'anup2', 'anup', 'anupdeveloper@gmail.com', '7688019332', 'technician', 'active', 'kalyani 761245, WB', NULL, NULL, NULL, '$2y$10$.gkUZQcQ7dOFRRhU6BsfIOt0h4haR3QWSE1VxxnHYMyYCUUd3rKpu', 'anup', NULL, '2023-07-31 15:40:59', '2023-03-14 17:02:53', '2023-07-31 15:40:59', NULL, NULL),
(8, 'pronab', 'pronab', 'pronab@test.com', '9523554661', 'user', 'active', 'Chandamari, Kalyani, 741245, WB', 22.98, 88.44, NULL, '$2y$10$1g7Qqdu6x5WZEPbkpLskpuiYihGeOwQbFASbWOREaynH5d8no5ZVG', NULL, NULL, '2023-07-31 15:40:58', '2023-03-30 01:24:14', '2023-07-31 15:40:58', NULL, NULL),
(9, 'Biswajit Sarkar', 'biswajit', 'biswajit@test.com', '7465778889', 'user', 'active', 'Chandamari, Kalyani, 741245, WB', 22.98, 88.44, NULL, '$2y$10$W1A9zxxLYdGJXFdS7YQ77u6gPwJg.rF.ZY5T9QM7Gl1jcm.zv21bu', NULL, NULL, '2023-07-31 15:40:58', '2023-06-05 15:49:07', '2023-07-31 15:40:58', NULL, NULL),
(10, 'Sudeshna Roy', 'Sudeshna', 'Sudeshnam@test.com', '4442242424', 'technician', 'active', 'Chandamari, Kalyani, 741245, WB', 22.98, 88.44, NULL, '', NULL, NULL, '2023-07-31 15:40:57', '2023-06-05 15:49:43', '2023-07-31 15:40:57', NULL, NULL),
(11, 'Ricky', 'jony', '54654464644', '4442242424', 'technician', 'active', NULL, NULL, NULL, NULL, '$2y$10$ux7qvFw8JIj03wW8nLAX9.MEWnc5eYNWjSklHGEqY./KI2b9k8I8W', NULL, NULL, '2023-07-31 15:40:57', '2023-06-20 15:23:59', '2023-07-31 15:40:57', NULL, NULL),
(15, 'Ricky', 'fhdgfhgd', 'abc!@jk.com', '4442242424', 'technician', 'active', NULL, NULL, NULL, NULL, '$2y$10$JK40mj.DvqqTh.h9FYxfLOqoG9KLh2wU3GvDkAnKMSBQE3WZiax36', NULL, NULL, '2023-07-31 15:40:56', '2023-06-20 15:25:37', '2023-07-31 15:40:56', NULL, NULL),
(18, 'richard', 'richard', 'abc@te.123', '1234567895', 'user', 'active', NULL, NULL, NULL, NULL, '$2y$10$FEuSZD1uBg8JOWt6H6iVNeNyHvkzvhHAGioGnhJ7YXc21.i0s489S', NULL, NULL, '2023-07-31 15:40:55', '2023-06-21 22:30:34', '2023-07-31 15:40:55', NULL, NULL),
(19, 'tom', 'tom1', 'tom@123', '1234567897', 'user', 'active', 'bandel road', NULL, NULL, NULL, '$2y$10$sLl99LE41Jqg5gzs7VqWEeUsrtLNeLle4q.5Zb3XQxdhSsXyITTu.', NULL, NULL, '2023-07-31 15:40:50', '2023-06-24 04:38:27', '2023-07-31 15:40:50', NULL, NULL),
(20, 'rony', 'tom12', 'rony@123.com', '2345678912', 'user', 'active', 'chnchurah', NULL, NULL, NULL, '$2y$10$zQoannABeOyRIPBGyXATheg1215x02Jb96rW4y58JmO5k5hakBuHC', NULL, NULL, '2023-07-31 15:40:48', '2023-06-24 04:43:10', '2023-07-31 15:40:48', NULL, NULL),
(22, 'x', 'test@1234', 'admin12@admin.com', '8240903631', 'tele_caller', 'active', '123456', NULL, NULL, NULL, '$2y$10$Ysemr9ZMgnKb2cwerk3DuOmaDt75XAwU/uyFtyRj4PquXImKV/gm.', NULL, NULL, '2023-07-31 15:40:45', '2023-07-01 17:54:13', '2023-07-31 15:40:45', NULL, NULL),
(23, 'akhsay', 'avfd', 'abc@text.com', '4567892223', 'normal_user', 'active', '4 linton st', NULL, NULL, NULL, '$2y$10$BjIkA0lO3tGDXpDXU5zgeOe4UdEuS22XHkCLNRiXB..GWMSGb9dEa', NULL, NULL, '2023-07-31 15:40:42', '2023-07-20 22:15:13', '2023-07-31 15:40:42', NULL, NULL),
(24, 'rahul', 'jhony', 'Jhony11@gmail.com', '1234567891', 'tele_caller', 'active', '12euiyyeuy', NULL, NULL, NULL, '$2y$10$.cde46Yifakbn54kdRJ8k.F0QLfKojYeaI6ot0jleej9rCOMuz27G', NULL, NULL, '2023-07-31 15:40:40', '2023-07-23 15:57:29', '2023-07-31 15:40:40', NULL, NULL),
(25, 'OFFICE-SAHA ENTERPRISE', 'OFFICE_1', NULL, '8240903631', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '$2y$10$hqikVjvpXseE9KjZValIn.w4kLXkBUkKfM4Bhxl/dcsu4czJqRISy', NULL, NULL, NULL, '2023-07-31 15:36:11', '2023-07-31 15:36:11', NULL, NULL),
(26, 'OFFICE-SAHA ENTERPRISE', 'OFFICE_2', NULL, '8240903631', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '$2y$10$.3NUHrqxCJ7uuuHhyEJbW.dSoH6Rp1RMD2tErapsgMYaBMNgPe3xa', NULL, NULL, NULL, '2023-07-31 15:40:03', '2023-07-31 15:40:03', NULL, NULL),
(27, 'OFFICE', 'OFFICE_3', NULL, '8240903631', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '$2y$10$G.M6sNvu/aThBBBJbPPDAumFSAmYZvHbk.C1f8s8cfvqdb6EIm8y6', NULL, NULL, NULL, '2023-07-31 15:43:40', '2023-07-31 15:43:40', NULL, NULL),
(28, 'SATABDI', 'test@12345', NULL, '8240903631', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '$2y$10$I5/ZPySHg/RjlHyvWtEJQuYRglAJjCHqYLcMAWfTrpT.7oz1e3o9G', NULL, NULL, NULL, '2023-07-31 15:47:00', '2023-07-31 03:56:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `pincode` varchar(8) DEFAULT NULL,
  `contact_number` varchar(11) DEFAULT NULL,
  `lat` varchar(50) DEFAULT NULL,
  `lng` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `address`, `pincode`, `contact_number`, `lat`, `lng`, `deleted_at`, `updated_at`, `created_at`) VALUES
(1, 7, 'Chandamari, Kalyani.', '741245', '7688093332', '22.98', '88.44', NULL, '2023-03-25 08:14:05', '2023-03-25 12:45:25'),
(2, 1, 'Birati, Vidyapit Road', '700123', '7636366778', '22.98', '88.44', NULL, '2023-03-25 08:14:05', '2023-03-25 12:45:25');

-- --------------------------------------------------------

--
-- Table structure for table `work_order`
--

CREATE TABLE `work_order` (
  `id` int(11) NOT NULL,
  `work_order_no` varchar(30) DEFAULT NULL,
  `work_order_type` enum('normal','complaint') DEFAULT 'normal',
  `ticket_id` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `technician_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `work_order`
--

INSERT INTO `work_order` (`id`, `work_order_no`, `work_order_type`, `ticket_id`, `category`, `title`, `description`, `technician_id`, `user_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(23, 'N2023062023', 'normal', NULL, 3, 'arrer', 'qrqrr', 7, 9, 'Not Resolved', NULL, '2023-06-24 20:51:32', '2023-06-25 10:50:20'),
(25, 'N2023062525', 'normal', NULL, 2, 'hi hi', 'hi hi', 7, 9, 'Not Resolved', NULL, '2023-06-24 10:19:23', '2023-06-25 10:50:20'),
(26, 'C2023062526', 'complaint', 15, 2, 'wrwrwr', 'wrwrwr', 7, 9, 'Not Started', NULL, '2023-06-25 10:21:32', '2023-06-25 10:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `work_order_report`
--

CREATE TABLE `work_order_report` (
  `id` int(11) NOT NULL,
  `technician_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `work_order_report`
--

INSERT INTO `work_order_report` (`id`, `technician_id`, `task_id`, `status`, `comment`, `created_at`, `deleted_at`, `updated_at`) VALUES
(7, 7, 14, 'Started', 'I just stared the job', '2023-06-05 21:35:34', NULL, '2023-06-05 21:35:34'),
(8, 7, 15, 'Started', 'I just stared the job', '2023-06-05 21:39:14', NULL, '2023-06-05 21:39:14'),
(9, 7, 15, 'Started', 'I just stared the job', '2023-06-05 21:39:58', NULL, '2023-06-05 21:39:58'),
(10, 7, 15, 'Started', 'I just stared the job', '2023-06-09 00:09:30', NULL, '2023-06-09 00:09:30');

-- --------------------------------------------------------

--
-- Table structure for table `work_order_report_pic`
--

CREATE TABLE `work_order_report_pic` (
  `id` int(11) NOT NULL,
  `wo_id` int(11) NOT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `work_order_report_pic`
--

INSERT INTO `work_order_report_pic` (`id`, `wo_id`, `pic`, `created_at`, `updated_at`) VALUES
(1, 14, '/uploads/work_order/wkBP55DXAJ.png', '2023-06-05 21:35:28', '2023-06-05 21:35:28'),
(2, 14, '/uploads/work_order/f5gkDVac4H.png', '2023-06-05 21:35:34', '2023-06-05 21:35:34'),
(3, 15, '/uploads/work_order/XK434UDKIn.png', '2023-06-05 21:39:07', '2023-06-05 21:39:07'),
(4, 15, '/uploads/work_order/f7egRcoe6h.png', '2023-06-05 21:39:14', '2023-06-05 21:39:14'),
(5, 15, '/uploads/work_order/D0lrHVphy5.png', '2023-06-05 21:39:50', '2023-06-05 21:39:50'),
(6, 15, '/uploads/work_order/to7xZNZqLa.png', '2023-06-05 21:39:58', '2023-06-05 21:39:58'),
(7, 15, '/uploads/work_order/gHCwBbuIuR.jpg', '2023-06-09 00:09:30', '2023-06-09 00:09:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_assignment`
--
ALTER TABLE `lead_assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_report`
--
ALTER TABLE `lead_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_popup_messages`
--
ALTER TABLE `master_popup_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_models`
--
ALTER TABLE `otp_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

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
-- Indexes for table `product_gallery`
--
ALTER TABLE `product_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `slots_setiings`
--
ALTER TABLE `slots_setiings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technian_slot`
--
ALTER TABLE `technian_slot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_order`
--
ALTER TABLE `work_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_order_report`
--
ALTER TABLE `work_order_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_order_report_pic`
--
ALTER TABLE `work_order_report_pic`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `lead_assignment`
--
ALTER TABLE `lead_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lead_report`
--
ALTER TABLE `lead_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_popup_messages`
--
ALTER TABLE `master_popup_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `otp_models`
--
ALTER TABLE `otp_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_gallery`
--
ALTER TABLE `product_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slots_setiings`
--
ALTER TABLE `slots_setiings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `technian_slot`
--
ALTER TABLE `technian_slot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_order`
--
ALTER TABLE `work_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `work_order_report`
--
ALTER TABLE `work_order_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `work_order_report_pic`
--
ALTER TABLE `work_order_report_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
