-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2023 at 08:40 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

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
(3, 'KITCHEN CHIMNEY', 1, NULL, '2023-03-08 20:00:26', '2023-07-31 08:52:31'),
(4, 'Modular kitchen', 1, NULL, '2023-06-20 08:07:56', '2023-07-31 08:50:08'),
(5, 'AMC - CHIMNEY', 1, NULL, '2023-07-01 11:42:42', '2023-07-31 08:51:09'),
(6, 'SPARE PARTS', 1, NULL, '2023-07-12 02:31:50', '2023-07-31 08:52:11'),
(7, 'WATER PURIFIER', 1, NULL, '2023-07-20 16:05:13', '2023-07-31 08:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `customer_detail`
--

CREATE TABLE `customer_detail` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `alt_mobile` varchar(12) DEFAULT NULL,
  `user_type` varchar(10) DEFAULT NULL,
  `product_type` varchar(25) DEFAULT NULL,
  `no_services` int(5) DEFAULT NULL,
  `amc_duration` int(5) DEFAULT NULL,
  `model_taken` varchar(200) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_detail`
--

INSERT INTO `customer_detail` (`id`, `user_id`, `alt_mobile`, `user_type`, `product_type`, `no_services`, `amc_duration`, `model_taken`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 39, '7444747777', 'amc_user', 'Water Purifier', 3, 2, '1245- Waterpurifier', NULL, '2023-09-03 21:05:08', '2023-09-03 21:26:52'),
(2, 38, '5777789909', 'paid_user', 'Chimney', NULL, NULL, '1245- Chimney', NULL, '2023-09-03 23:58:55', '2023-09-03 21:32:24');

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
  `assigned_to` int(11) DEFAULT NULL,
  `assign_date` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `phone`, `name`, `email`, `address`, `assigned_to`, `assign_date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '7980772350', 'DIP', NULL, NULL, NULL, NULL, '2023-07-31 10:05:17', '2023-07-27 13:56:06', '2023-07-31 10:05:17'),
(2, '1234567890', 'ANUP', NULL, NULL, 33, '2023-08-21 00:00:00', NULL, '2023-07-27 14:07:07', '2023-08-21 10:29:26'),
(3, '2548796201', 'Suman Dhara', 'suman@gmail.com', 'qewtrewt 101', 33, '2023-08-21 00:00:00', NULL, '2023-08-01 09:35:24', '2023-08-21 10:29:26'),
(4, '1234567801', 'Test', NULL, '15 Linton st.', 36, '2023-08-24 00:00:00', NULL, '2023-08-01 09:48:15', '2023-08-24 10:27:01'),
(5, '8802808771', 'Kapil', NULL, 'ro', 37, '2023-08-22 00:00:00', NULL, '2023-08-04 10:56:26', '2023-08-22 14:16:28'),
(6, '9474071941', 'ABHRA KAR', NULL, 'ro', 37, '2023-08-22 00:00:00', NULL, '2023-08-04 10:56:26', '2023-08-22 14:16:28'),
(7, '7980351815', 'User', NULL, 'Chimney', 36, '2023-08-19 00:00:00', NULL, '2023-08-04 10:56:26', '2023-08-19 21:16:20'),
(8, '9143225884', 'User', NULL, 'Chimney', 36, '2023-08-19 00:00:00', NULL, '2023-08-04 10:56:26', '2023-08-19 21:16:20'),
(9, '8017625641', 'S.Basu', NULL, 'Chimney', 36, '2023-08-19 00:00:00', NULL, '2023-08-04 10:56:26', '2023-08-19 21:13:16'),
(10, '7890767840', 'Piyali', NULL, 'water purifier', 37, '2023-09-25 00:00:00', NULL, '2023-08-04 10:56:26', '2023-09-25 19:51:27'),
(11, '9007090100', 'Gouranga', NULL, 'Chimney', 37, '2023-09-25 00:00:00', NULL, '2023-08-04 10:56:26', '2023-09-25 19:52:16'),
(12, '8274881937', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(13, '6291782228', 'Ravi', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(14, '7001574767', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(15, '9073129015', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(16, '9432350991', 'R K Halder', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(17, '6289667687', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(18, '7668680215', 'VINITI', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(19, '9231591230', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(20, '9681734964', 'Ananda+Chowdhury', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(21, '7001545071', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(22, '9330314479', 'Avideep Sadhukhan', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(23, '8777568950', 'Shiv', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(24, '8334919602', 'GITASHRI BHAKTA', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(25, '9555480666', 'Sunny', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(26, '9836669413', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(27, '9932658413', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(28, '8116115287', 'Ratan', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(29, '9432297363', 'Duranta Kumar', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(30, '8945840778', 'MD', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(31, '9831486570', 'Zahid Zoha', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(32, '6291262728', 'User', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(33, '7003166244', 'User', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(34, '8389877457', 'User', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(35, '8800752766', 'DEBJIT', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(36, '7011943787', 'RAJ', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(37, '6290176598', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(38, '9953553530', 'Karan', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(39, '9831077426', 'Sobha', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(40, '8334941141', 'Chiranjit Biswas', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(41, '8240651154', 'horrible way to talk who ever picked up the call for on', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(42, '9836550444', 'Biplab das', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(43, '9062694381', 'Debasish Sen', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(44, '8910007577', 'sourav', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(45, '8777096558', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(46, '7044969366', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(47, '9038009473', 'Saha', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(48, '9051271881', 'Robert', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(49, '9836785556', 'ANUPAM', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(50, '9831212898', 'S Sammader', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(51, '7449472585', 'pradip', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(52, '9062694381', 'debasish', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(53, '9835345081', 'kumar', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(54, '9437564903', 'Mandal', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(55, '9904805693', 'JD User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(56, '6290664145', 'SANDEEP', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(57, '8336061437', 'Sofia', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(58, '7797449299', 'Pinku Adhikari', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(59, '9875370693', 'Suman', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(60, '8100571788', 'Jayanti', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(61, '9835345081', 'kumar chandan', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(62, '9717176415', 'MUKIM', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(63, '9875490781', 'User', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(64, '9147141068', 'Siddhartha', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(65, '8617765793', 'Subhra', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(66, '8100647763', 'Choudhury', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(67, '7278623423', 'p.k.ghosh', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(68, '9748975805', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(69, '9836469458', 'BHASKAR', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(70, '7011322208', 'POOJA', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(71, '9477021855', 'Dipak%20Kumar%20Palit', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(72, '9163313818', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(73, '6290518214', 'User', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(74, '8617250343', 'JD User', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(75, '8820038808', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(76, '9830240164', 'pritam sarkar', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(77, '9831097388', 'Roy', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(78, '8334988459', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(79, '8050590961', 'Paul', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(80, '7686805956', 'Nidhudebanth', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(81, '9831137283', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(82, '9310754022', 'pradeep', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(83, '9674849593', 'Suchandra', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(84, '7980433076', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(85, '9038434861', 'Supriyo', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(86, '9820758978', 'Sumit', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(87, '8017772088', 'sankar roy', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(88, '6299031710', 'soumya', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(89, '9560164572', 'user', NULL, NULL, NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(90, '8334060567', 'Sudip', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(91, '7980421735', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(92, '7003368152', 'TYENT', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(93, '9830058751', 'Raghav', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(94, '7980763013', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(95, '8100079726', 'Sandeep', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(96, '8777816001', 'Chil Cool', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(97, '9921002836', 'Suman', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(98, '9880696049', 'Mithra', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(99, '7003986519', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(100, '8240756519', 'Arut', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(101, '8017020279', 'a Das', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(102, '9051042841', 'Savita', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(103, '9831459000', 'Madan', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(104, '9123712188', 'Samir Laskar', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(105, '8790113110', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(106, '8017239177', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(107, '7980467415', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(108, '9330572400', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(109, '8013900501', 'MD', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(110, '9903779680', 'Tamanna', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(111, '7827780656', 'Rupa', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(112, '9831064537', 'D P Mondal', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(113, '9038772807', 'wasim', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(114, '7980420229', 'Mouli', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(115, '8697401852', 'Poonam saha', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(116, '7980283378', 'Sudip', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(117, '7059374192', 'Agrawal', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(118, '9830191352', 'Ashok', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(119, '7980355094', 'Rimi', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(120, '8910479275', 'Aaradhya Sengupta', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(121, '6291625798', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(122, '8981250315', 'Prosenjit De', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(123, '9300977025', 'Abhishek+Sharma', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(124, '9830700405', 'ARUP', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(125, '6289885170', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(126, '9333112614', 'Partha Pratim Sakar', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(127, '9051572961', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(128, '8082617849', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(129, '7004249831', 'Amit+kumar', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(130, '7978412524', 'User', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(131, '7980985936', 'Das', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(132, '9800540305', 'sudin halder', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(133, '8447221844', 'raju', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(134, '8910923161', 'user', NULL, NULL, NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(135, '7407528639', 'pk enterprise', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(136, '8240572137', 'TULSIYAN', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(137, '8777085433', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(138, '9874090105', 'User', NULL, 'Chimney', 35, '2023-08-19 00:00:00', NULL, '2023-08-04 10:56:26', '2023-08-19 21:22:26'),
(139, '7003440559', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(140, '9051284857', 'Tanmoy', NULL, 'Modular Kitchen Chimney Repair & Services', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(141, '7596963817', 'Argho sen', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(142, '7980646141', 'User', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(143, '9830279072', 'Lundia', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(144, '7980061235', 'Raj Kumar Bajaj', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(145, '8617431182', 'REHAMAN', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(146, '8956033331', 'Vineet Saraogi', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(147, '9051459463', 'RAJU', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(148, '9874425970', 'AYUSH AGARWAL', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(149, '8777495550', 'Bikash', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(150, '9123311458', 'Javed', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(151, '9339206755', 'Prem kumar Singh', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(152, '8777628918', 'Bimal Chakraborty', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(153, '8500037954', 'Pranab', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(154, '9933509992', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(155, '8971797764', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(156, '9830285200', 'Sharma', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(157, '9903304296', 'SAURAV', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(158, '9392908476', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(159, '9289707754', 'Vikas', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(160, '9475838685', 'User', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(161, '8910947499', 'Amit', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(162, '8368599405', 'superb', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(163, '7031122658', 'Raju', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(164, '9330941217', 'Pradeep Kumar', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(165, '8240453607', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(166, '6291456957', 'sanchita sinha', NULL, NULL, NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(167, '9874733309', 'ANGSHUMAN', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(168, '9883610608', 'Pradip%20Bhowmick', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(169, '9831282071', 'Sunaina', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(170, '9874457604', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(171, '9667513566', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(172, '9818221821', 'Priya', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(173, '8017020279', 'A Banerjee', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(174, '8240981711', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(175, '9830043870', 'Sharma', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(176, '9910543380', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(177, '8670560071', 'tapas Roy', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(178, '9330730816', 'R Dey', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(179, '9830285200', 'Sk', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(180, '9000650266', 'DINESH', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(181, '8172847470', 'geeta', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(182, '7086032474', 'soumyadeep', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(183, '7003522452', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(184, '8172847470', 'User', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(185, '8800622903', 'Ak', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(186, '8100094940', 'Suvadip Dey', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(187, '8777671365', 'Saha', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(188, '8420555075', 'Sagarika', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(189, '6003687101', 'Subhradeep Kar Purkayastha', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(190, '7596004856', 'aniruddha ghosh', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(191, '9163663673', 'User', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(192, '8910938757', 'Rajib Saha', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(193, '8282817741', 'Anurag', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(194, '6201520063', 'Rajeev', NULL, 'ro', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(195, '6291787922', 'rahul ghosh dastidar', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(196, '9830863345', 'Abhisikta', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(197, '8017625641', 'S.Basu', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(198, '9830512718', 'User', NULL, 'Chimney', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(199, '9804262625', 'Akash', NULL, 'water purifier', NULL, NULL, NULL, '2023-08-04 10:56:26', '2023-08-04 10:56:26'),
(200, '1245789631', 'abcd', 'afgt@gmail.com', '1 cvghfyty', 33, '2023-08-19 00:00:00', NULL, '2023-08-19 21:14:31', '2023-08-19 21:28:13'),
(201, '1452687920', 'bron', 'ad@gmail.com', '1 mbn', 36, '2023-08-19 00:00:00', NULL, '2023-08-19 21:20:02', '2023-08-19 21:21:13');

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
(1, 1, 2, '2023-07-27', 'Not Interested', NULL, 2, NULL, NULL, '2023-07-27 13:56:26', '2023-07-27 13:57:48'),
(2, 2, 2, '2023-07-27', 'Interested', NULL, 35, 'Gigugh', NULL, '2023-07-27 14:07:21', '2023-08-19 12:08:50'),
(3, 14, 28, '2023-08-04', 'Busy', NULL, 28, 'Call later', NULL, '2023-08-04 11:04:37', '2023-08-04 11:19:52'),
(4, 38, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(5, 62, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(6, 86, 28, '2023-08-04', 'Interested', NULL, 28, 'Work on monday 12 pm, service charge 350, ro servuce', NULL, '2023-08-04 11:04:37', '2023-08-04 11:28:05'),
(7, 110, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(8, 134, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(9, 158, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(10, 182, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(11, 18, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(12, 42, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(13, 66, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(14, 90, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(15, 114, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(16, 138, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(17, 162, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(18, 186, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(19, 22, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(20, 46, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(21, 70, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(22, 94, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(23, 118, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(24, 142, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(25, 166, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(26, 190, 28, '2023-08-04', 'Interested', NULL, 32, 'Test anup', NULL, '2023-08-04 11:04:37', '2023-08-05 11:54:11'),
(27, 26, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(28, 50, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(29, 74, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(30, 98, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(31, 122, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(32, 146, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(33, 170, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(34, 194, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(35, 6, 28, '2023-08-04', 'Follow Up', NULL, 37, 'Do', NULL, '2023-08-04 11:04:37', '2023-08-22 14:34:44'),
(36, 30, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(37, 54, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(38, 78, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(39, 102, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(40, 126, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(41, 150, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(42, 174, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(43, 198, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(44, 10, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(45, 34, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(46, 58, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(47, 82, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(48, 106, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(49, 130, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(50, 154, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(51, 178, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(52, 133, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(53, 157, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(54, 181, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(55, 17, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(56, 41, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(57, 65, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(58, 89, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(59, 113, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(60, 137, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(61, 161, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(62, 185, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(63, 21, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(64, 45, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(65, 69, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(66, 93, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(67, 117, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(68, 141, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(69, 165, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(70, 189, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(71, 25, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(72, 49, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(73, 73, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(74, 97, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(75, 121, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(76, 145, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(77, 169, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(78, 193, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(79, 5, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(80, 29, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(81, 53, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(82, 77, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(83, 101, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(84, 125, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(85, 149, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(86, 173, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(87, 197, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(88, 9, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(89, 33, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(90, 57, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(91, 81, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(92, 105, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(93, 129, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(94, 153, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(95, 177, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(96, 13, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(97, 37, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(98, 61, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(99, 85, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(100, 109, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(101, 16, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(102, 40, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(103, 64, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(104, 88, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(105, 112, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(106, 136, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(107, 160, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(108, 184, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(109, 20, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(110, 44, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(111, 68, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(112, 92, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(113, 116, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(114, 140, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(115, 164, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(116, 188, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(117, 24, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(118, 48, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(119, 72, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(120, 96, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(121, 120, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(122, 144, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(123, 168, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(124, 192, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(125, 28, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(126, 52, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(127, 76, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(128, 100, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(129, 124, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(130, 148, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(131, 172, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(132, 196, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(133, 8, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(134, 32, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(135, 56, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(136, 80, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(137, 104, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(138, 128, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(139, 152, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(140, 176, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(141, 12, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(142, 36, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(143, 60, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(144, 84, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(145, 108, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(146, 132, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(147, 156, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(148, 180, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(149, 15, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(150, 39, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(151, 63, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(152, 87, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(153, 111, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(154, 135, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(155, 159, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(156, 183, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(157, 19, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(158, 43, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(159, 67, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(160, 91, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(161, 115, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(162, 139, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(163, 163, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(164, 187, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(165, 23, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(166, 47, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(167, 71, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(168, 95, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(169, 119, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(170, 143, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(171, 167, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(172, 191, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(173, 27, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(174, 51, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(175, 75, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(176, 99, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(177, 123, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(178, 147, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(179, 171, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(180, 195, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(181, 7, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(182, 31, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(183, 55, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(184, 79, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(185, 103, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(186, 127, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(187, 151, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(188, 175, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(189, 199, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(190, 11, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(191, 35, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(192, 59, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(193, 83, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(194, 107, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(195, 131, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(196, 155, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(197, 179, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(198, 4, 28, '2023-08-04', 'Interested', NULL, 36, 'After 1 week', NULL, '2023-08-04 11:04:37', '2023-08-24 10:51:30'),
(199, 3, 28, '2023-08-04', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-04 11:04:37', '2023-08-04 11:04:37'),
(200, 2, 28, '2023-08-04', 'Interested', NULL, 35, 'Gigugh', NULL, '2023-08-04 11:04:37', '2023-08-19 12:08:50'),
(201, 190, 32, '2023-08-05', 'Interested', NULL, 32, 'Test anup', NULL, '2023-08-05 10:58:25', '2023-08-05 11:54:11'),
(202, 154, 32, '2023-08-05', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-05 10:58:25', '2023-08-05 10:58:25'),
(203, 97, 32, '2023-08-05', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-05 10:58:25', '2023-08-05 10:58:25'),
(204, 2, 33, '2023-08-19', 'Interested', NULL, 35, 'Gigugh', NULL, '2023-08-19 10:23:48', '2023-08-19 12:08:50'),
(205, 2, 33, '2023-08-19', 'Interested', NULL, 35, 'Gigugh', NULL, '2023-08-19 11:53:19', '2023-08-19 12:08:50'),
(206, 3, 35, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 11:53:44', '2023-08-19 11:53:44'),
(207, 2, 35, '2023-08-19', 'Interested', NULL, 35, 'Gigugh', NULL, '2023-08-19 12:08:17', '2023-08-19 12:08:50'),
(208, 4, 36, '2023-08-19', 'Interested', NULL, 36, 'After 1 week', NULL, '2023-08-19 20:15:39', '2023-08-24 10:51:30'),
(209, 5, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 20:15:39', '2023-08-19 20:15:39'),
(210, 6, 36, '2023-08-19', 'Follow Up', NULL, 37, 'Do', NULL, '2023-08-19 20:15:39', '2023-08-22 14:34:44'),
(211, 8, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 20:17:10', '2023-08-19 20:17:10'),
(212, 9, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 20:17:10', '2023-08-19 20:17:10'),
(213, 4, 36, '2023-08-19', 'Interested', NULL, 36, 'After 1 week', NULL, '2023-08-19 20:17:19', '2023-08-24 10:51:30'),
(214, 5, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 20:17:19', '2023-08-19 20:17:19'),
(215, 4, 36, '2023-08-19', 'Interested', NULL, 36, 'After 1 week', NULL, '2023-08-19 20:18:30', '2023-08-24 10:51:30'),
(216, 5, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 20:18:30', '2023-08-19 20:18:30'),
(217, 7, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 20:19:23', '2023-08-19 20:19:23'),
(218, 4, 36, '2023-08-19', 'Interested', NULL, 36, 'After 1 week', NULL, '2023-08-19 21:11:25', '2023-08-24 10:51:30'),
(219, 5, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:11:25', '2023-08-19 21:11:25'),
(220, 4, 36, '2023-08-19', 'Interested', NULL, 36, 'After 1 week', NULL, '2023-08-19 21:11:49', '2023-08-24 10:51:30'),
(221, 5, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:11:49', '2023-08-19 21:11:49'),
(222, 4, 36, '2023-08-19', 'Interested', NULL, 36, 'After 1 week', NULL, '2023-08-19 21:11:59', '2023-08-24 10:51:30'),
(223, 5, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:11:59', '2023-08-19 21:11:59'),
(224, 9, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:13:16', '2023-08-19 21:13:16'),
(225, 4, 36, '2023-08-19', 'Interested', NULL, 36, 'After 1 week', NULL, '2023-08-19 21:15:56', '2023-08-24 10:51:30'),
(226, 5, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:15:56', '2023-08-19 21:15:56'),
(227, 6, 36, '2023-08-19', 'Follow Up', NULL, 37, 'Do', NULL, '2023-08-19 21:15:56', '2023-08-22 14:34:44'),
(228, 7, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:15:56', '2023-08-19 21:15:56'),
(229, 8, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:15:56', '2023-08-19 21:15:56'),
(230, 4, 36, '2023-08-19', 'Interested', NULL, 36, 'After 1 week', NULL, '2023-08-19 21:16:20', '2023-08-24 10:51:30'),
(231, 5, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:16:20', '2023-08-19 21:16:20'),
(232, 6, 36, '2023-08-19', 'Follow Up', NULL, 37, 'Do', NULL, '2023-08-19 21:16:20', '2023-08-22 14:34:44'),
(233, 7, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:16:20', '2023-08-19 21:16:20'),
(234, 8, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:16:20', '2023-08-19 21:16:20'),
(235, 201, 36, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:21:13', '2023-08-19 21:21:13'),
(236, 138, 35, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:22:26', '2023-08-19 21:22:26'),
(237, 200, 33, '2023-08-19', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-19 21:28:13', '2023-08-19 21:28:13'),
(238, 2, 33, '2023-08-21', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-21 10:29:26', '2023-08-21 10:29:26'),
(239, 3, 33, '2023-08-21', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-21 10:29:26', '2023-08-21 10:29:26'),
(240, 5, 37, '2023-08-22', 'Assigned', NULL, NULL, NULL, NULL, '2023-08-22 14:16:28', '2023-08-22 14:16:28'),
(241, 6, 37, '2023-08-22', 'Follow Up', NULL, 37, 'Do', NULL, '2023-08-22 14:16:28', '2023-08-22 14:34:44'),
(242, 4, 36, '2023-08-24', 'Interested', NULL, 36, 'After 1 week', NULL, '2023-08-24 10:26:17', '2023-08-24 10:51:30'),
(243, 4, 36, '2023-08-24', 'Interested', NULL, 36, 'After 1 week', NULL, '2023-08-24 10:27:01', '2023-08-24 10:51:30'),
(244, 10, 37, '2023-09-25', 'Assigned', NULL, NULL, NULL, NULL, '2023-09-25 19:51:27', '2023-09-25 19:51:27'),
(245, 11, 37, '2023-09-25', 'Assigned', NULL, NULL, NULL, NULL, '2023-09-25 19:52:16', '2023-09-25 19:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `lead_report`
--

CREATE TABLE `lead_report` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `product_type` int(11) DEFAULT NULL,
  `use_status` varchar(30) DEFAULT NULL,
  `amc_status` varchar(30) DEFAULT NULL,
  `paid_status` varchar(30) DEFAULT NULL,
  `comment` text DEFAULT NULL,
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

INSERT INTO `lead_report` (`id`, `lead_id`, `product_type`, `use_status`, `amc_status`, `paid_status`, `comment`, `has_water_purifier`, `in_use_water_purifier`, `has_chimney`, `in_use_chimney`, `chimney_status`, `waterpurifier_status`, `added_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'NOTINUSE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-25 22:20:37', '2023-09-25 18:49:56');

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
(7, '25032023-007', 7, '1900', 'dispatch', 'cod', NULL, '2023-03-25 08:56:04', '2023-03-25 11:28:06'),
(8, '24062023-008', 8, '12000', 'dispatch', 'cod', NULL, '2023-06-24 09:43:05', '2023-06-24 09:44:59'),
(9, '30062023-009', 8, '12010', 'pending', 'cod', NULL, '2023-06-30 21:44:17', '2023-06-30 21:44:17'),
(10, '30062023-010', 8, '5000', 'pending', 'cod', NULL, '2023-06-30 21:45:46', '2023-06-30 21:45:46'),
(11, '01072023-011', 8, '2000', 'pending', 'cod', NULL, '2023-07-01 11:24:59', '2023-07-01 11:24:59'),
(12, '07072023-012', 8, '25009', 'pending', 'cod', NULL, '2023-07-07 09:40:16', '2023-07-07 09:40:16'),
(13, '18072023-013', 8, '12000', 'pending', 'cod', NULL, '2023-07-18 11:20:52', '2023-07-18 11:20:52'),
(14, '10082023-014', 30, '2000', 'pending', 'cod', NULL, '2023-08-10 17:14:28', '2023-08-10 17:14:28'),
(15, '10082023-015', 30, '2000', 'pending', 'cod', NULL, '2023-08-10 17:14:30', '2023-08-10 17:14:30'),
(16, '17082023-016', 31, '12000', 'pending', 'cod', NULL, '2023-08-17 15:26:27', '2023-08-17 15:26:27');

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
(9, 7, 2, 1, '2023-03-25 11:26:04', NULL, '2023-03-25 08:56:04', '2023-03-25 08:56:04'),
(10, 8, 1, 1, '2023-06-23 23:43:05', NULL, '2023-06-24 09:43:05', '2023-06-24 09:43:05'),
(11, 9, 2, 1, '2023-06-30 11:44:17', NULL, '2023-06-30 21:44:17', '2023-06-30 21:44:17'),
(12, 9, 1, 1, '2023-06-30 11:44:17', NULL, '2023-06-30 21:44:17', '2023-06-30 21:44:17'),
(13, 10, 10, 1, '2023-06-30 11:45:46', NULL, '2023-06-30 21:45:46', '2023-06-30 21:45:46'),
(14, 10, 7, 1, '2023-06-30 11:45:46', NULL, '2023-06-30 21:45:46', '2023-06-30 21:45:46'),
(15, 11, 11, 1, '2023-07-01 01:24:59', NULL, '2023-07-01 11:24:59', '2023-07-01 11:24:59'),
(16, 12, 4, 1, '2023-07-06 23:40:16', NULL, '2023-07-07 09:40:16', '2023-07-07 09:40:16'),
(17, 12, 1, 1, '2023-07-06 23:40:16', NULL, '2023-07-07 09:40:16', '2023-07-07 09:40:16'),
(18, 12, 2, 1, '2023-07-06 23:40:16', NULL, '2023-07-07 09:40:16', '2023-07-07 09:40:16'),
(19, 13, 1, 1, '2023-07-18 01:20:52', NULL, '2023-07-18 11:20:52', '2023-07-18 11:20:52'),
(20, 14, 10, 1, '2023-08-10 07:14:28', NULL, '2023-08-10 17:14:28', '2023-08-10 17:14:28'),
(21, 15, 10, 1, '2023-08-10 07:14:30', NULL, '2023-08-10 17:14:30', '2023-08-10 17:14:30'),
(22, 16, 1, 1, '2023-08-17 05:26:27', NULL, '2023-08-17 15:26:27', '2023-08-17 15:26:27');

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
(1, 'About Us Edit', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,', 'Our small appliances make your kitchen time more interesting & enjoyable. All our products are designed and tested for a long time to facilitate our customers. Your valuable opinion & feedback have created our business platform for the upcoming, new & prosperous customers.  \r\n \r\n Our different categories include modular chimney Kitchen, water purifier with latest designs from kutchina. We are going forward with a satisfied list of customers. Hopefully you will be enjoying our services like other customers in future also.', '2023-06-07 01:42:17', '2023-06-22 16:36:53', NULL),
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
(35, 'App\\Models\\User', 7, 'user_token', '83a7e543d9da0019f27d8308abba065a551b7270ae9a150ea4f4951fec22ff2a', '[\"*\"]', '2023-06-09 14:44:43', '2023-06-05 15:47:35', '2023-06-09 14:44:43'),
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
(68, 'App\\Models\\User', 7, 'user_token', '33e88dc20e46b94f351214c2cc835f025852d85dc1ae31522681ecee4623201f', '[\"*\"]', NULL, '2023-06-17 04:41:06', '2023-06-17 04:41:06'),
(69, 'App\\Models\\User', 7, 'user_token', '0882327f261f8637035458577d82b9f30f2c487fb4f9a6384cc48f9377f78703', '[\"*\"]', '2023-06-25 18:12:10', '2023-06-17 19:28:44', '2023-06-25 18:12:10'),
(70, 'App\\Models\\User', 7, 'user_token', '6ad321931b253383bfaaefdc4556f624ddb2a8d6ed4e9e0c639f0c521b5bf97e', '[\"*\"]', NULL, '2023-06-18 02:10:06', '2023-06-18 02:10:06'),
(71, 'App\\Models\\User', 7, 'user_token', 'de2e3ef967f15522e7bd645619e5e09fdc173d18c7c8523cf5e41140a0649b68', '[\"*\"]', NULL, '2023-06-18 03:49:31', '2023-06-18 03:49:31'),
(72, 'App\\Models\\User', 8, 'user_token', '8c02b7d7f8235e2a177478e4a5236af01a10f450ff2004533f86709035f3b746', '[\"*\"]', NULL, '2023-06-18 05:24:38', '2023-06-18 05:24:38'),
(73, 'App\\Models\\User', 8, 'user_token', '579eb389a8b3e8f333e748b6b0b815b87cf8f499c5355a9418270c04fa1a19e1', '[\"*\"]', NULL, '2023-06-18 05:26:07', '2023-06-18 05:26:07'),
(74, 'App\\Models\\User', 8, 'user_token', 'fca7374c85c63cbba526e2f0b2ad69fa66d8cb694b11089d3862613782b5b0d4', '[\"*\"]', NULL, '2023-06-18 05:26:54', '2023-06-18 05:26:54'),
(75, 'App\\Models\\User', 8, 'user_token', '0876e887cb8914e9d3c54ff1795fb86a81c2fe6c314d274bcc257d0c39304e99', '[\"*\"]', NULL, '2023-06-18 05:28:52', '2023-06-18 05:28:52'),
(76, 'App\\Models\\User', 8, 'user_token', 'f44f34219bd6fd0e43948270c49aac9dfaf37d4c84b5eee3dde272836305d484', '[\"*\"]', NULL, '2023-06-18 05:30:49', '2023-06-18 05:30:49'),
(77, 'App\\Models\\User', 8, 'user_token', '27a36cc32a5141abc29f967c129ebb828997633a38a289775a34c8a158a690a5', '[\"*\"]', '2023-06-18 05:35:46', '2023-06-18 05:33:54', '2023-06-18 05:35:46'),
(78, 'App\\Models\\User', 8, 'user_token', 'b572b6183cca223f889e898745a38a4adc4a9e876e301ab251a0dd671f70cb89', '[\"*\"]', NULL, '2023-06-18 05:40:16', '2023-06-18 05:40:16'),
(79, 'App\\Models\\User', 8, 'user_token', 'addea48622393e21b5f400ca78d2336f0ec7441b5e034a5f78b30063f38b92fa', '[\"*\"]', NULL, '2023-06-18 05:44:06', '2023-06-18 05:44:06'),
(80, 'App\\Models\\User', 8, 'user_token', '8c57afce2fb210388ab598b1dbf39e9ea2af23e07e03d57c85afae837ed6109a', '[\"*\"]', NULL, '2023-06-18 05:47:16', '2023-06-18 05:47:16'),
(81, 'App\\Models\\User', 8, 'user_token', '5a53fc9e7d1e39ce0add2ffc842c9a6b17367e45cbcb9c1cde44c82c2e27c6ce', '[\"*\"]', '2023-06-19 03:23:19', '2023-06-18 05:50:53', '2023-06-19 03:23:19'),
(82, 'App\\Models\\User', 7, 'user_token', '14d38add7c8dff5c18d34a477eee954690a8cede721f58e72f8eb24172fd2560', '[\"*\"]', NULL, '2023-06-19 03:23:58', '2023-06-19 03:23:58'),
(83, 'App\\Models\\User', 7, 'user_token', 'b33003c9a510758abc810d4b0e1c69f6391c6c2ced7c63419c75aa6c2fda58b6', '[\"*\"]', '2023-06-19 18:53:46', '2023-06-19 03:50:37', '2023-06-19 18:53:46'),
(84, 'App\\Models\\User', 7, 'user_token', 'ab5158e8a4258c965f351d6274e5b2d413b9cc918fc5d6b6496ddce4c2f4365f', '[\"*\"]', NULL, '2023-06-19 19:17:24', '2023-06-19 19:17:24'),
(85, 'App\\Models\\User', 7, 'user_token', 'b9d86123b1836e563f02578c1367c802e8bd50939161d3ed9ca0a75ab3b10d26', '[\"*\"]', NULL, '2023-06-22 17:37:43', '2023-06-22 17:37:43'),
(86, 'App\\Models\\User', 7, 'user_token', 'd9b86390c7dde3c42762376a1da89c3b3eb182a2406f7d157aca9add2d9b5502', '[\"*\"]', NULL, '2023-06-22 18:12:24', '2023-06-22 18:12:24'),
(87, 'App\\Models\\User', 7, 'user_token', '36669b8477348d229bc3e7961e1527e6cd9c4c5ce540b8517cffc233e484b9e2', '[\"*\"]', NULL, '2023-06-22 18:25:56', '2023-06-22 18:25:56'),
(88, 'App\\Models\\User', 7, 'user_token', '7cd56809c77cb9dfa74926e55396671a2a3d7708e50c786f4693c5085a8a83df', '[\"*\"]', NULL, '2023-06-22 23:55:35', '2023-06-22 23:55:35'),
(89, 'App\\Models\\User', 7, 'user_token', '7a10266d9a94b7fd71274a216d663668be4042d963b919fa97ad84f63071aa6c', '[\"*\"]', NULL, '2023-06-23 02:26:56', '2023-06-23 02:26:56'),
(90, 'App\\Models\\User', 7, 'user_token', 'd90e095f706b865f8dfba11985afae1aeb535d3fea8ce1d9c46e347969710816', '[\"*\"]', NULL, '2023-06-23 02:52:31', '2023-06-23 02:52:31'),
(91, 'App\\Models\\User', 7, 'user_token', '6fc44e280222b50536bf89762a8a312118f2a7b8a519a3ad251a7397559d7204', '[\"*\"]', NULL, '2023-06-23 03:54:28', '2023-06-23 03:54:28'),
(92, 'App\\Models\\User', 7, 'user_token', '40b8b2274a676e6d16ac9005f928383bd8c2e52537839c90fb0d922953137f8a', '[\"*\"]', NULL, '2023-06-23 04:26:39', '2023-06-23 04:26:39'),
(93, 'App\\Models\\User', 8, 'user_token', '9af11323dce9146cdd71f0e9409990907621727a171602af7001e07ce9646162', '[\"*\"]', NULL, '2023-06-23 04:43:38', '2023-06-23 04:43:38'),
(94, 'App\\Models\\User', 8, 'user_token', 'f082de4d5ecc243624be55492ba819e832505faf0e989b03d3b769a07122b62b', '[\"*\"]', NULL, '2023-06-23 04:51:44', '2023-06-23 04:51:44'),
(95, 'App\\Models\\User', 7, 'user_token', 'f87bbbbbb3b73c6893f6cd3e4d55e21b48813cb0e197e1f6f8d21dbaaef93a7f', '[\"*\"]', '2023-06-24 05:09:28', '2023-06-23 05:22:35', '2023-06-24 05:09:28'),
(96, 'App\\Models\\User', 8, 'user_token', '69090ff80e39b015dbab5c35cf836f2bdddbb8264ee6c37e2e6ae74efb325193', '[\"*\"]', NULL, '2023-06-24 05:09:49', '2023-06-24 05:09:49'),
(97, 'App\\Models\\User', 8, 'user_token', '3db4b8253123b54737f2729fb431bb073fbf7be93ceb499eb5a74355997790a1', '[\"*\"]', NULL, '2023-06-24 05:33:09', '2023-06-24 05:33:09'),
(98, 'App\\Models\\User', 7, 'user_token', '8aff1068849ccffb8932ccbb44d3cb8e7bee7368bfe4155e7aa0fe96353cdd1f', '[\"*\"]', NULL, '2023-06-24 06:12:01', '2023-06-24 06:12:01'),
(99, 'App\\Models\\User', 8, 'user_token', '038d2a865878ff5ec69bf600d867d8ea4a189664b856ed6e452f17a45db79662', '[\"*\"]', NULL, '2023-06-24 06:12:28', '2023-06-24 06:12:28'),
(100, 'App\\Models\\User', 7, 'user_token', 'f16d26d9ef6510bfc11c6d5bb68bca3b0d89df069e6d550984e90c57c6fdd586', '[\"*\"]', NULL, '2023-06-24 14:14:24', '2023-06-24 14:14:24'),
(101, 'App\\Models\\User', 7, 'user_token', 'bbd47679a0dc8c2b896d158ee08fb2fa86685f072d5d96d2004a0288480f0946', '[\"*\"]', NULL, '2023-06-24 16:14:58', '2023-06-24 16:14:58'),
(102, 'App\\Models\\User', 7, 'user_token', '134868d937a21141f11f10d58753593729e9b7a3ef174b1b8d6b106b570b346c', '[\"*\"]', NULL, '2023-06-24 16:18:22', '2023-06-24 16:18:22'),
(103, 'App\\Models\\User', 7, 'user_token', 'f35c66527b04250d62691f8f6aec0a6ce9cdd24f83eb5301cd7598bdf9dae70a', '[\"*\"]', NULL, '2023-06-24 16:18:56', '2023-06-24 16:18:56'),
(104, 'App\\Models\\User', 7, 'user_token', 'e95502a432892021d2011f774b1524d482e7ff895f70f17f33f4fa3d16f7569f', '[\"*\"]', '2023-06-24 16:27:30', '2023-06-24 16:20:01', '2023-06-24 16:27:30'),
(105, 'App\\Models\\User', 7, 'user_token', 'f7f5ce01d1921d736e82e349ee91cf973ae67c4c0b364ea077c28b8fe67e4c96', '[\"*\"]', NULL, '2023-06-24 16:27:29', '2023-06-24 16:27:29'),
(106, 'App\\Models\\User', 7, 'user_token', '81427b2f9504040327f64e1dbcff7b434868a266aa8ecc6e76c9469155f40086', '[\"*\"]', NULL, '2023-06-24 16:27:29', '2023-06-24 16:27:29'),
(107, 'App\\Models\\User', 7, 'user_token', '5c051b13bb4cd436adc544238efdd99eef255edc2f1ffdd28b5e5c7ea3de0984', '[\"*\"]', NULL, '2023-06-24 16:27:30', '2023-06-24 16:27:30'),
(108, 'App\\Models\\User', 7, 'user_token', '5559d835f2c06ca22b5b09f43996e06105c7b8b570fd51ae691062d9e5e6b887', '[\"*\"]', NULL, '2023-06-24 16:27:30', '2023-06-24 16:27:30'),
(109, 'App\\Models\\User', 7, 'user_token', '1c77534df9ea0933a0b6a22619f0b0d06bfec16f91f6b8b07f27f2fc30e7afff', '[\"*\"]', NULL, '2023-06-24 16:27:31', '2023-06-24 16:27:31'),
(110, 'App\\Models\\User', 7, 'user_token', 'd7309715fd372f45d6cb9efbdbf4c679d1aa06a8a6e44d5273fd8d86821fcc0c', '[\"*\"]', NULL, '2023-06-24 16:27:31', '2023-06-24 16:27:31'),
(111, 'App\\Models\\User', 7, 'user_token', '4e04368107476472353d9913fa7739397987773e4b6cb40b0dffda45f6107f0c', '[\"*\"]', NULL, '2023-06-24 16:27:32', '2023-06-24 16:27:32'),
(112, 'App\\Models\\User', 8, 'user_token', '11c07bbeb876eacbfb19ce63bb951d1e3e4e8e3363c00b631b924edaf9e69da4', '[\"*\"]', NULL, '2023-06-24 16:29:59', '2023-06-24 16:29:59'),
(113, 'App\\Models\\User', 7, 'user_token', '775034bcbe495e0ab3fb185ccf01a6a558504f71c158cd465dba0e7d4084a907', '[\"*\"]', NULL, '2023-06-24 16:38:40', '2023-06-24 16:38:40'),
(114, 'App\\Models\\User', 8, 'user_token', 'cfcb2d390ab27dad3d76e8229d56659a211d23fef289fa8c1d2733c2dc4c9310', '[\"*\"]', NULL, '2023-06-24 16:41:59', '2023-06-24 16:41:59'),
(115, 'App\\Models\\User', 7, 'user_token', '354fb523eb88f7072970881d2f92e9bde122d1dfc0037e6bcc16523a96260255', '[\"*\"]', NULL, '2023-06-24 16:47:28', '2023-06-24 16:47:28'),
(116, 'App\\Models\\User', 7, 'user_token', 'bc6e1e12d2bf4d533bdd9dbb8b0e4b2e83b2a5903ead60540377d0b9b944fda4', '[\"*\"]', NULL, '2023-06-24 16:48:31', '2023-06-24 16:48:31'),
(117, 'App\\Models\\User', 8, 'user_token', '5e60afbfd67315bd2b17c5bbc0d92324b8d9e196bd08e31519f328cbae7036a2', '[\"*\"]', NULL, '2023-06-24 16:49:46', '2023-06-24 16:49:46'),
(118, 'App\\Models\\User', 8, 'user_token', '2876ad67516d89662f41b09d25c2f5f8dd70526640506c3c9e45502f49a3ca29', '[\"*\"]', NULL, '2023-06-24 16:52:36', '2023-06-24 16:52:36'),
(119, 'App\\Models\\User', 8, 'user_token', '2234d14ce9b9a79cd426151e4c29e3a93790812bc18ac865c77837c6e7b267a5', '[\"*\"]', '2023-06-27 15:35:18', '2023-06-25 01:28:55', '2023-06-27 15:35:18'),
(120, 'App\\Models\\User', 8, 'user_token', '266ed9de2ce41597ae9e9b1363fbf7ae3e73c6204c5ee9fdf808be6afc549e34', '[\"*\"]', NULL, '2023-06-25 02:13:41', '2023-06-25 02:13:41'),
(121, 'App\\Models\\User', 7, 'user_token', 'bb5e25aff1b80a964c79cebe4b1307d555c60af870ccd93e427a8743e37924e4', '[\"*\"]', NULL, '2023-06-25 02:15:37', '2023-06-25 02:15:37'),
(122, 'App\\Models\\User', 8, 'user_token', '5c99133a2fd7f753ce9dc6b71374489870513af919f5bfc90d9785d333c7bdb9', '[\"*\"]', '2023-06-30 23:45:07', '2023-06-25 02:18:46', '2023-06-30 23:45:07'),
(123, 'App\\Models\\User', 7, 'user_token', '328b35c1836c02aef63132a258f698a7d86e5c3c0c55ca7163eabc282484dd93', '[\"*\"]', '2023-06-25 20:52:55', '2023-06-25 18:02:42', '2023-06-25 20:52:55'),
(124, 'App\\Models\\User', 7, 'user_token', '19a27bb88262bd9cec3ddbf5a4cc6c62b797cc24a0cd4041ca2be4c4412fe1e8', '[\"*\"]', NULL, '2023-06-27 15:20:07', '2023-06-27 15:20:07'),
(125, 'App\\Models\\User', 7, 'user_token', '8320968ef099b0da187f1d0208f8fefbb9d5f80980210a89fdf999f447bda30c', '[\"*\"]', NULL, '2023-06-27 15:31:23', '2023-06-27 15:31:23'),
(126, 'App\\Models\\User', 8, 'user_token', '2db4fb296184848d1c485f8cbf32bbebecddc9292028f6d10e3b567d73fd101d', '[\"*\"]', NULL, '2023-06-27 15:41:21', '2023-06-27 15:41:21'),
(127, 'App\\Models\\User', 7, 'user_token', 'c229f01945004b9e72282f40432bb2597d4cc4cb39482e9dbe1bda7ff6367891', '[\"*\"]', NULL, '2023-06-27 15:58:02', '2023-06-27 15:58:02'),
(128, 'App\\Models\\User', 2, 'user_token', '1d0a99b7da78047f233fe00e0ebef0d4548faa7f270cf877824cbc7bda8998f8', '[\"*\"]', NULL, '2023-06-27 15:59:54', '2023-06-27 15:59:54'),
(129, 'App\\Models\\User', 7, 'user_token', 'da0eacaf755afb56b557c32a68f9f4b35612dc7987ef94e59a6c8de412cb8112', '[\"*\"]', NULL, '2023-06-27 16:20:29', '2023-06-27 16:20:29'),
(130, 'App\\Models\\User', 8, 'user_token', '0eb427199260c95879f000329b4998e43b0fa786a193c030249b6e7dfad4154f', '[\"*\"]', NULL, '2023-06-27 16:20:55', '2023-06-27 16:20:55'),
(131, 'App\\Models\\User', 7, 'user_token', '96a2ab29894bff863c9ca219dea57b3e5c06cd416390df896dce5b871937a2b5', '[\"*\"]', NULL, '2023-06-27 16:21:32', '2023-06-27 16:21:32'),
(132, 'App\\Models\\User', 2, 'user_token', '6fa1085ab36337baf64526a33b8adb7c6db7974d2901268f6f20b6e252f92b80', '[\"*\"]', '2023-07-02 00:16:39', '2023-06-27 16:21:58', '2023-07-02 00:16:39'),
(133, 'App\\Models\\User', 7, 'user_token', 'c10caefe0c37ebc393d81c4e2bdd00a9b913f60f688663f3e2074f0c9e384344', '[\"*\"]', NULL, '2023-06-27 16:45:19', '2023-06-27 16:45:19'),
(134, 'App\\Models\\User', 7, 'user_token', '364ecfe026085be6d4bdb80e685057e9331d9ab9de1d378ab96e6169e60d5c79', '[\"*\"]', NULL, '2023-06-28 22:07:21', '2023-06-28 22:07:21'),
(135, 'App\\Models\\User', 8, 'user_token', '6b7e97dc4878ca8a09e3fd6808967e43001e9fdc89b7960079c0714f130627c9', '[\"*\"]', NULL, '2023-06-28 22:08:11', '2023-06-28 22:08:11'),
(136, 'App\\Models\\User', 2, 'user_token', 'ba8636840cad2eeda48f9ca75e2428ff7a5a15f315fd6d570ee8ebb66aec4e15', '[\"*\"]', NULL, '2023-06-28 22:08:49', '2023-06-28 22:08:49'),
(137, 'App\\Models\\User', 7, 'user_token', '13ffa4b77ef3767b4a2a009ec8e84b3242aa8c6e34e50602fc405092341a6e40', '[\"*\"]', NULL, '2023-06-29 09:09:49', '2023-06-29 09:09:49'),
(138, 'App\\Models\\User', 8, 'user_token', '78d288498ae54277851d76abd7648484d82778f73290be1a834401c601e8d9f5', '[\"*\"]', NULL, '2023-06-29 18:42:18', '2023-06-29 18:42:18'),
(139, 'App\\Models\\User', 8, 'user_token', '6dbf6399821fc3d70dace1db87c47ebccbb984b28b91c5dd4dabc75c6601af22', '[\"*\"]', NULL, '2023-06-30 02:15:28', '2023-06-30 02:15:28'),
(140, 'App\\Models\\User', 7, 'user_token', 'a3a26b344ede0962889b42021493d088e8627cf80e33ba1b1356ea0ca801e2d3', '[\"*\"]', NULL, '2023-06-30 02:15:49', '2023-06-30 02:15:49'),
(141, 'App\\Models\\User', 2, 'user_token', '55bb6bf45d3566d95e99977bb4ec4b0c02a957c701aa48a8f7a3f6859d33be96', '[\"*\"]', NULL, '2023-06-30 02:16:10', '2023-06-30 02:16:10'),
(142, 'App\\Models\\User', 2, 'user_token', '119b8108fe7f1406f37fee2bc5702f614523c703cb4d95d965aeced9637351eb', '[\"*\"]', NULL, '2023-06-30 02:18:42', '2023-06-30 02:18:42'),
(143, 'App\\Models\\User', 2, 'user_token', '09892e5db2b6801572d21a20988c343577cd56c146a7b3b57db9577e408d3f5c', '[\"*\"]', NULL, '2023-06-30 02:20:03', '2023-06-30 02:20:03'),
(144, 'App\\Models\\User', 2, 'user_token', 'c8b42fcd2bef92f4004dc38150cdba4bd14300f677816e346aac9c6de41bc062', '[\"*\"]', NULL, '2023-06-30 02:25:41', '2023-06-30 02:25:41'),
(145, 'App\\Models\\User', 2, 'user_token', '00066db3b9e4b2e7c7bf5680d715a00c7012efd83a576e3ac76ea7eae034b84b', '[\"*\"]', NULL, '2023-06-30 02:27:52', '2023-06-30 02:27:52'),
(146, 'App\\Models\\User', 2, 'user_token', '3e9c41d0ec1a5a10017239a9afdac05f240961040b2f5f81db33d22348d7e9fd', '[\"*\"]', NULL, '2023-06-30 02:27:57', '2023-06-30 02:27:57'),
(147, 'App\\Models\\User', 2, 'user_token', 'd20d33083d27fccaeee6b3c4de611bb6d4ff118737a123d1513fbbc8cff3f01d', '[\"*\"]', NULL, '2023-06-30 02:28:40', '2023-06-30 02:28:40'),
(148, 'App\\Models\\User', 2, 'user_token', '346c64784ef0571e70b78df7487d53fe667f41099159b92c3790ad85c2a72e0e', '[\"*\"]', NULL, '2023-06-30 02:40:43', '2023-06-30 02:40:43'),
(149, 'App\\Models\\User', 2, 'user_token', '5be6b8fe69ced50b9704f3cfe9408bdfb88edc6a4b68e21e1f509ecdde989837', '[\"*\"]', NULL, '2023-06-30 05:56:20', '2023-06-30 05:56:20'),
(150, 'App\\Models\\User', 2, 'user_token', '10e5a066c425faf0641ba821b6c313cae960fdb76a3ac5020e158c438c6a0016', '[\"*\"]', NULL, '2023-06-30 16:52:45', '2023-06-30 16:52:45'),
(151, 'App\\Models\\User', 7, 'user_token', 'c4cfe32fa813fc6f2274e5b0bc99e0c9c566d162acfa7c38026c7684ef062d7f', '[\"*\"]', NULL, '2023-06-30 20:31:22', '2023-06-30 20:31:22'),
(152, 'App\\Models\\User', 2, 'user_token', '660390ae9bb717a5c930156ca4230fc9a97ea45dadb35a5eab1e7ad2d7804e1d', '[\"*\"]', NULL, '2023-06-30 21:22:39', '2023-06-30 21:22:39'),
(153, 'App\\Models\\User', 2, 'user_token', '5f18e00cdf9242c3006848f0f18b61f0cfcf6f778e9d991a0de3f78cf4ea09cf', '[\"*\"]', NULL, '2023-06-30 23:10:57', '2023-06-30 23:10:57'),
(154, 'App\\Models\\User', 8, 'user_token', '23880120cf3e07587e6b6b906fe866c3a0b2ca523a274da0ff9c16bdc3eb60cf', '[\"*\"]', NULL, '2023-06-30 23:39:39', '2023-06-30 23:39:39'),
(155, 'App\\Models\\User', 7, 'user_token', 'a5e58eda4b6eb9c979768e99c85a59583ad68b6dfef52896abd6f947cf940ff1', '[\"*\"]', NULL, '2023-07-01 00:20:27', '2023-07-01 00:20:27'),
(156, 'App\\Models\\User', 7, 'user_token', '61b08fb8185ec73ec33b3baa8025f72fc085d6244e4b3539845f8c84d2b96f45', '[\"*\"]', NULL, '2023-07-01 00:24:23', '2023-07-01 00:24:23'),
(157, 'App\\Models\\User', 7, 'user_token', '43397eb6df83b97b8a97c3e6d2e8c703562a275ba5dec30b0fb43f64f2245748', '[\"*\"]', NULL, '2023-07-01 00:37:10', '2023-07-01 00:37:10'),
(158, 'App\\Models\\User', 8, 'user_token', '4750d81349dc9df0e0aedefacc71128ff065d79adc4a9773589ea49bdec91846', '[\"*\"]', NULL, '2023-07-01 01:16:19', '2023-07-01 01:16:19'),
(159, 'App\\Models\\User', 2, 'user_token', '69e5ddad2b1c6fbe4f59253d0dedf9da4cac021294eab646f0fe0450b2645e87', '[\"*\"]', NULL, '2023-07-01 01:22:29', '2023-07-01 01:22:29'),
(160, 'App\\Models\\User', 8, 'user_token', 'e56d747392b7e5048cffbda71a2569ff95017f635f88d30432fd60371ff5038b', '[\"*\"]', NULL, '2023-07-01 03:04:07', '2023-07-01 03:04:07'),
(161, 'App\\Models\\User', 8, 'user_token', 'a7b1e364c391fcfcc19b5d95e04c4392f45bafd5cf5074d7b5f80d4c39b0d21b', '[\"*\"]', NULL, '2023-07-01 03:08:10', '2023-07-01 03:08:10'),
(162, 'App\\Models\\User', 7, 'user_token', '475d095ca4168c0973e76b57c3ec83e6685baf47eae1a5f2c781d4bad49bf736', '[\"*\"]', NULL, '2023-07-01 03:11:30', '2023-07-01 03:11:30'),
(163, 'App\\Models\\User', 2, 'user_token', 'd1fbfe493fb9a23abfc24b9f3440fff35cbd2ce2f7ab37e33f5597babba8ae35', '[\"*\"]', NULL, '2023-07-01 03:12:21', '2023-07-01 03:12:21'),
(164, 'App\\Models\\User', 7, 'user_token', '948e248dd7e5d6776678246065262270bc387db3a59082a00caafe7c036fffa7', '[\"*\"]', NULL, '2023-07-01 03:51:51', '2023-07-01 03:51:51'),
(165, 'App\\Models\\User', 2, 'user_token', '86636839a873287a5de89e70dc13af5c811184d47c386b4a7e13b70184badee4', '[\"*\"]', NULL, '2023-07-01 03:52:53', '2023-07-01 03:52:53'),
(166, 'App\\Models\\User', 2, 'user_token', '962e921736c0501e9dab5350ef6a9d8ed1f684c00fde082fd66a138639441ed1', '[\"*\"]', NULL, '2023-07-01 04:34:28', '2023-07-01 04:34:28'),
(167, 'App\\Models\\User', 7, 'user_token', '5e6330ffa598d48e62e50ff7edf9d879027d16d81ac2c860ee159ec1d00deff1', '[\"*\"]', NULL, '2023-07-01 04:38:06', '2023-07-01 04:38:06'),
(168, 'App\\Models\\User', 8, 'user_token', 'c46dfb0c0bccc836b95e5d89f799dfc150ca5ccd56a56b0c9adeea0adf1e3866', '[\"*\"]', NULL, '2023-07-01 04:43:32', '2023-07-01 04:43:32'),
(169, 'App\\Models\\User', 2, 'user_token', 'a29c9f02078a44411088b369ba21ae9474c98296395940638b61a8cec36412dc', '[\"*\"]', '2023-07-14 01:54:43', '2023-07-01 04:44:24', '2023-07-14 01:54:43'),
(170, 'App\\Models\\User', 7, 'user_token', 'b077991375ce76403fee7ceb8f39588fbb5b9c77fd17c7d58cb7718d50d8c68c', '[\"*\"]', NULL, '2023-07-01 12:43:59', '2023-07-01 12:43:59'),
(171, 'App\\Models\\User', 7, 'user_token', 'a3aa60e3d2ada089e3cd5a9bd68ac90ff5436886d5e6a9ad91658ab6bd55ef24', '[\"*\"]', '2023-07-07 16:36:29', '2023-07-01 14:47:55', '2023-07-07 16:36:29'),
(172, 'App\\Models\\User', 8, 'user_token', '3ad5e56ed2e717ea55973e5a28c9054d0ad08e457eba838a181b8e785c675553', '[\"*\"]', NULL, '2023-07-01 17:42:27', '2023-07-01 17:42:27'),
(173, 'App\\Models\\User', 2, 'user_token', '4424cfc09add9ad020e7c901454f94f1d472f460c1029efeaef8d1fe892c33d9', '[\"*\"]', NULL, '2023-07-01 17:43:06', '2023-07-01 17:43:06'),
(174, 'App\\Models\\User', 7, 'user_token', '0b0bdc78b1f98be5db3bf67dd17cee27a0b3a7d72346056c80d6e71162fbf056', '[\"*\"]', '2023-07-02 18:41:50', '2023-07-01 17:44:12', '2023-07-02 18:41:50'),
(175, 'App\\Models\\User', 7, 'user_token', '395a0706c0f544d2fd591b82040fdb36032febd815692e8fb819c4134b2da2e0', '[\"*\"]', '2023-07-01 22:28:28', '2023-07-01 17:47:34', '2023-07-01 22:28:28'),
(176, 'App\\Models\\User', 22, 'user_token', 'cab62546744509bbb925e5b43d77fd33dad9fa1e55311be1fc9996c4f40c8351', '[\"*\"]', NULL, '2023-07-01 18:06:01', '2023-07-01 18:06:01'),
(177, 'App\\Models\\User', 8, 'user_token', 'e9c7010490fb1aa7f17c1f7f937df5ae514ddec0a0ff315cefbaa379f5d9af05', '[\"*\"]', NULL, '2023-07-01 18:24:13', '2023-07-01 18:24:13'),
(178, 'App\\Models\\User', 8, 'user_token', '08fb72ce06bf54d5d95cb67fa2e0d6c29efcbb41f75e020b0805f4062c940be3', '[\"*\"]', '2023-07-07 16:35:56', '2023-07-02 18:42:28', '2023-07-07 16:35:56'),
(179, 'App\\Models\\User', 8, 'user_token', 'd7633907b4cd79ed46aa95f9196852f1eb4a198d7bdadbfd407fdb25a3059df4', '[\"*\"]', NULL, '2023-07-07 16:37:22', '2023-07-07 16:37:22'),
(180, 'App\\Models\\User', 8, 'user_token', 'fd13a64ef3a178ead007d4d1f6a671a4aa389a3b8ca073560f615a95817ac57e', '[\"*\"]', NULL, '2023-07-07 16:38:07', '2023-07-07 16:38:07'),
(181, 'App\\Models\\User', 8, 'user_token', '2dcb7749613e76de6e624c01c98df7ccb5807939d6de840878a3068f2bc86b62', '[\"*\"]', NULL, '2023-07-07 16:38:09', '2023-07-07 16:38:09'),
(182, 'App\\Models\\User', 8, 'user_token', 'a4110726de00851801efc2653ba247ab3c3414feb31410ea0aead3a2befc79a0', '[\"*\"]', NULL, '2023-07-07 16:39:31', '2023-07-07 16:39:31'),
(183, 'App\\Models\\User', 8, 'user_token', '5534968a4fab3e07ad64e1f6c357479e28d46bf7684d7b0c86628b15ac1eebec', '[\"*\"]', NULL, '2023-07-07 16:39:55', '2023-07-07 16:39:55'),
(184, 'App\\Models\\User', 7, 'user_token', 'ffb781adf7ce724450e787be17e157cd6f0dad1c59ceeee35059b2458e3cd53b', '[\"*\"]', NULL, '2023-07-07 16:43:53', '2023-07-07 16:43:53'),
(185, 'App\\Models\\User', 8, 'user_token', 'c77134271549e2b316806d735cab759282fcc333b1755658f6c0df0e2d792bd3', '[\"*\"]', NULL, '2023-07-07 18:25:23', '2023-07-07 18:25:23'),
(186, 'App\\Models\\User', 8, 'user_token', '792e339969e049a8bc34fafb0a16dd8fd6bc12d1d129a4427fa72f5eefc5b9a9', '[\"*\"]', NULL, '2023-07-10 17:49:25', '2023-07-10 17:49:25'),
(187, 'App\\Models\\User', 2, 'user_token', '765d44bb23963ba4bcc4bda383f712700bb37694c7c9647d40962a1d8b2c9033', '[\"*\"]', NULL, '2023-07-10 17:49:57', '2023-07-10 17:49:57'),
(188, 'App\\Models\\User', 2, 'user_token', 'bdc420f21310dd3f77ccd4c264a3e0f143f375f0b11156a67b3e6f91ca115c08', '[\"*\"]', NULL, '2023-07-10 17:51:57', '2023-07-10 17:51:57'),
(189, 'App\\Models\\User', 2, 'user_token', '8c11b3353d780aa9a805a477e77410d20bf0838c791de9f6251bb7648ce4f80d', '[\"*\"]', '2023-07-12 03:25:45', '2023-07-10 18:29:07', '2023-07-12 03:25:45'),
(190, 'App\\Models\\User', 2, 'user_token', '3201b367fa8c3639e5da5ce5b5ee20c6500c5db632f98a682f7f01f8d298ccc7', '[\"*\"]', NULL, '2023-07-12 03:27:14', '2023-07-12 03:27:14'),
(191, 'App\\Models\\User', 8, 'user_token', 'da8892aa3121f2c398449c4bce01e540044ac9ad98cc9283f89a4a04c7ce22b3', '[\"*\"]', NULL, '2023-07-12 03:41:37', '2023-07-12 03:41:37'),
(192, 'App\\Models\\User', 2, 'user_token', '34f9f47d67e45bbd7e83cc7e048d10f221fe243f070c3405ef2315853f4cb264', '[\"*\"]', NULL, '2023-07-12 03:44:12', '2023-07-12 03:44:12'),
(193, 'App\\Models\\User', 8, 'user_token', '8f9453e3a5e2e234cd53309a6222e26061c33f1639f170d6ccbe06187976e63b', '[\"*\"]', NULL, '2023-07-12 04:21:50', '2023-07-12 04:21:50'),
(194, 'App\\Models\\User', 8, 'user_token', 'd6219f40f42ded3643dba592cf3eca7eda7de9b2efdbf71324e04268691880b7', '[\"*\"]', NULL, '2023-07-12 04:51:22', '2023-07-12 04:51:22'),
(195, 'App\\Models\\User', 2, 'user_token', '446a554eca32762f91742d5f1229dfa0ac00aae64d38bee144c3da4f320e0dfb', '[\"*\"]', NULL, '2023-07-12 04:53:14', '2023-07-12 04:53:14'),
(196, 'App\\Models\\User', 8, 'user_token', 'ed6198e6f5d4dd3ad2479c36866ec6ff130dd168dc1c79c95d07013acb87f5db', '[\"*\"]', '2023-07-12 05:22:41', '2023-07-12 05:13:26', '2023-07-12 05:22:41'),
(197, 'App\\Models\\User', 8, 'user_token', '90810bc7eed2d60ac4ef7738a17c603e2440fac5e0a2b3694d1ae2882f36cdb9', '[\"*\"]', NULL, '2023-07-12 05:52:55', '2023-07-12 05:52:55'),
(198, 'App\\Models\\User', 2, 'user_token', 'fc6d6d30e1d7e85f711679a3b957604b868325cdb1aa2c912996380aaedf36a5', '[\"*\"]', '2023-07-12 15:28:26', '2023-07-12 06:28:06', '2023-07-12 15:28:26'),
(199, 'App\\Models\\User', 8, 'user_token', '9f3daaf703842201c37b01b9bd865ed6eec0e1c54970747204ce90099239cdbf', '[\"*\"]', NULL, '2023-07-12 16:44:38', '2023-07-12 16:44:38'),
(200, 'App\\Models\\User', 8, 'user_token', '69a40e20de9edf30c037cb4af08811fa18acdefb79c99f62a2fe2c86494bf6d1', '[\"*\"]', '2023-07-14 01:07:52', '2023-07-12 19:32:59', '2023-07-14 01:07:52'),
(201, 'App\\Models\\User', 8, 'user_token', 'e2a91e788b37331a0a8f376f1d3bebd4a2710a9ebe5e7f3b6344fb7cc4cd5a10', '[\"*\"]', NULL, '2023-07-12 22:57:39', '2023-07-12 22:57:39'),
(202, 'App\\Models\\User', 2, 'user_token', 'a948eded1e93c62d0f9f44c946c6422c06632e21ba4cff10c32e82d6769b6022', '[\"*\"]', NULL, '2023-07-12 22:59:26', '2023-07-12 22:59:26'),
(203, 'App\\Models\\User', 7, 'user_token', '1c1c95caa00bc3e84cadb699323d7c21898d49d5e991573c6ba1eabc9f2454c0', '[\"*\"]', NULL, '2023-07-12 23:00:12', '2023-07-12 23:00:12'),
(204, 'App\\Models\\User', 8, 'user_token', '09cf3f700206067b6def58e2d8cafc0de882d0785db476ae6af24334c8e2df1a', '[\"*\"]', NULL, '2023-07-12 23:02:36', '2023-07-12 23:02:36'),
(205, 'App\\Models\\User', 8, 'user_token', 'fdf3c52ac78a90bba6bd5635f8772e9e9620c96d3d9068a198a5bb91f65f10b2', '[\"*\"]', NULL, '2023-07-14 01:10:09', '2023-07-14 01:10:09'),
(206, 'App\\Models\\User', 2, 'user_token', 'c1dcc03e3824648ccb861daae1f598bf838f14e1324813485acb83941330bd6f', '[\"*\"]', NULL, '2023-07-14 01:11:40', '2023-07-14 01:11:40'),
(207, 'App\\Models\\User', 8, 'user_token', 'c1c088ff1d9653e83c0039da6db740a3e43257fb8365384d76038eef1e1c0b2b', '[\"*\"]', '2023-07-14 04:43:19', '2023-07-14 01:55:37', '2023-07-14 04:43:19'),
(208, 'App\\Models\\User', 8, 'user_token', 'f9701ab5d5e68604c087436d84420fedb1c6354696d363c581c1c94d3bc36180', '[\"*\"]', NULL, '2023-07-14 03:08:33', '2023-07-14 03:08:33'),
(209, 'App\\Models\\User', 8, 'user_token', '11dc24dd3b0f1dec02004ddbdf9a3e0196ef5a2de8454ebf2e4a2d049d837389', '[\"*\"]', NULL, '2023-07-14 03:27:00', '2023-07-14 03:27:00'),
(210, 'App\\Models\\User', 8, 'user_token', '7ca506698354314cac03ba02a949ed50b3390a33b7a5e3bf7831f9aa247efac7', '[\"*\"]', NULL, '2023-07-14 04:47:27', '2023-07-14 04:47:27'),
(211, 'App\\Models\\User', 2, 'user_token', '09028b3034aeca4f2e5241bebaef9393248cc6c6da8bd0437fb71168dd5a9499', '[\"*\"]', NULL, '2023-07-14 04:48:13', '2023-07-14 04:48:13'),
(212, 'App\\Models\\User', 7, 'user_token', '21bd2b8e27c8f456cb2c0a009ee7c429d871bd3833dee7f65603b782bd3071d0', '[\"*\"]', NULL, '2023-07-14 04:48:39', '2023-07-14 04:48:39'),
(213, 'App\\Models\\User', 8, 'user_token', '5df77d41433e6d2caa79679ea4c8220785d6a2be5e356482a52375ec9948c6e4', '[\"*\"]', NULL, '2023-07-14 04:58:23', '2023-07-14 04:58:23'),
(214, 'App\\Models\\User', 2, 'user_token', '66ca41e3979b38cdbabcadf24d0e420e85b08b6eb694f3ac6c9a4de1f8a11c94', '[\"*\"]', NULL, '2023-07-14 04:59:01', '2023-07-14 04:59:01'),
(215, 'App\\Models\\User', 7, 'user_token', '82f270c93855d484e961013daf0128d8f264cd2155e15e42947f55405cd73583', '[\"*\"]', NULL, '2023-07-14 04:59:37', '2023-07-14 04:59:37'),
(216, 'App\\Models\\User', 8, 'user_token', 'afe6a0923d439df765d1a3349a8eda86a0baa241bb9495d8c2ecb9f8bbac872b', '[\"*\"]', '2023-07-18 18:20:52', '2023-07-14 18:16:48', '2023-07-18 18:20:52'),
(217, 'App\\Models\\User', 2, 'user_token', '9e1fa77080d580d97de2227167d396d6437a85b1e39b7945ca8a45bd6e31e2b3', '[\"*\"]', NULL, '2023-07-17 15:13:32', '2023-07-17 15:13:32'),
(218, 'App\\Models\\User', 2, 'user_token', '2f50e889f578692c6116eb5c808d2acaca712759e165399cb9bca199c29e9e85', '[\"*\"]', NULL, '2023-07-17 15:13:56', '2023-07-17 15:13:56'),
(219, 'App\\Models\\User', 8, 'user_token', '7dd1ce742ae8c049e90de649872250b479a0a01d6e9743dc1ce7c346cc9bb3e2', '[\"*\"]', NULL, '2023-07-17 19:26:48', '2023-07-17 19:26:48'),
(220, 'App\\Models\\User', 2, 'user_token', '3b84ec82bbc97dfa31a525d0ec1289aba3e8362a9d063b81bf2cf79ba2868a1f', '[\"*\"]', NULL, '2023-07-18 18:21:16', '2023-07-18 18:21:16'),
(221, 'App\\Models\\User', 2, 'user_token', '03222500eb59de1e4055cb87d54e0755671258d10c2546bfaf7c7ad6ba9502f9', '[\"*\"]', '2023-07-24 02:11:02', '2023-07-23 23:55:22', '2023-07-24 02:11:02'),
(222, 'App\\Models\\User', 2, 'user_token', '6514837cf309269db994b88ee45678e75861058cc4fd00e8adc975ab2f1e3db4', '[\"*\"]', NULL, '2023-07-27 20:55:39', '2023-07-27 20:55:39'),
(223, 'App\\Models\\User', 2, 'user_token', '4ba60cd31f7d80c1533c1d99f5096dfda32e42eeac924ae487e2a83b390dd967', '[\"*\"]', NULL, '2023-07-27 20:55:40', '2023-07-27 20:55:40'),
(224, 'App\\Models\\User', 8, 'user_token', 'a9a5e6a23e5746d6cfb53cd79bbe89b9ac09c1192d1d4a603d2fd90895edb4bf', '[\"*\"]', NULL, '2023-07-27 21:43:01', '2023-07-27 21:43:01'),
(225, 'App\\Models\\User', 7, 'user_token', '5eb2d3d32dfa8c0b1d2a4b5f0db9df7a6a77e70d76d02633adb392e88cb50d04', '[\"*\"]', NULL, '2023-07-27 21:50:16', '2023-07-27 21:50:16'),
(226, 'App\\Models\\User', 28, 'user_token', '36e228392eb11b387b4842504e8a459a8262cbd73458acfcb1a634633fb091dd', '[\"*\"]', NULL, '2023-08-04 18:03:50', '2023-08-04 18:03:50'),
(227, 'App\\Models\\User', 28, 'user_token', '5501aba517c7759d34f194033ea60a202a71efe0e7f5877bad7985f5a28d20c7', '[\"*\"]', NULL, '2023-08-04 18:18:43', '2023-08-04 18:18:43'),
(228, 'App\\Models\\User', 31, 'user_token', '0fd3981627f04cf81e1f73471b3225ffacef6f1b4fc39519906af2fae9862b5a', '[\"*\"]', '2023-08-17 22:44:36', '2023-08-04 22:53:37', '2023-08-17 22:44:36'),
(229, 'App\\Models\\User', 32, 'user_token', 'efe200cb6516cdb9b31951929139cec45a3dccb07f89534b8f54f2482e8d950f', '[\"*\"]', NULL, '2023-08-05 17:59:46', '2023-08-05 17:59:46'),
(230, 'App\\Models\\User', 32, 'user_token', '33d7ea8aac82da020604df913f05c6571c7de4ef8616b6f0b980bab05698b31a', '[\"*\"]', '2023-08-17 19:58:44', '2023-08-05 19:25:03', '2023-08-17 19:58:44'),
(231, 'App\\Models\\User', 30, 'user_token', '29d1a1b93262e096a2cb9dfa99da0666a799f763cdd069931c02918482bd36c8', '[\"*\"]', NULL, '2023-08-11 00:09:58', '2023-08-11 00:09:58'),
(232, 'App\\Models\\User', 30, 'user_token', '458f3bac4a8dc7bd36171c941318ba70913b4b914f7211fe74d990ecc7d8405a', '[\"*\"]', NULL, '2023-08-11 00:12:22', '2023-08-11 00:12:22'),
(233, 'App\\Models\\User', 28, 'user_token', 'fc05ec23f46332cd40360a5048b71bdfdc018505409d84961ff50af029417477', '[\"*\"]', NULL, '2023-08-11 00:18:38', '2023-08-11 00:18:38'),
(234, 'App\\Models\\User', 28, 'user_token', '186eb8fe8c87d089a63d16ad48dc7fef4cca00dfe9ce33fa3ddb3f2c6f9bf793', '[\"*\"]', '2023-08-11 17:51:07', '2023-08-11 00:18:48', '2023-08-11 17:51:07'),
(235, 'App\\Models\\User', 33, 'user_token', 'd260f84859e2ce7cc078cb8768f6efdc28524c7737fd086fc204f1baf255c4e7', '[\"*\"]', '2023-08-19 18:54:35', '2023-08-19 17:24:56', '2023-08-19 18:54:35'),
(236, 'App\\Models\\User', 33, 'user_token', '30c915c9f31b1303c948c757ced53d5b7e50e4429eb4ed081f0cb59a8e0d21f7', '[\"*\"]', '2023-08-19 19:08:23', '2023-08-19 19:07:55', '2023-08-19 19:08:23'),
(237, 'App\\Models\\User', 35, 'user_token', '8d6d50b32b96b71b90958644b3148288b6fe4f85164194a39bda19d619de3651', '[\"*\"]', '2023-08-24 21:38:14', '2023-08-19 19:08:37', '2023-08-24 21:38:14'),
(238, 'App\\Models\\User', 33, 'user_token', '0509312663c94921e82463af747da0ccfe984d27ed72596e4f36938bcac28f12', '[\"*\"]', '2023-08-22 18:50:38', '2023-08-20 04:24:39', '2023-08-22 18:50:38'),
(239, 'App\\Models\\User', 36, 'user_token', '441a57585e8030fb80ceece8cdb8084a561b21099e93f3bde9bf7ea3367bc923', '[\"*\"]', '2023-08-22 18:51:30', '2023-08-22 18:51:06', '2023-08-22 18:51:30'),
(240, 'App\\Models\\User', 36, 'user_token', 'bd443eec739820deb3e91f8740d60d099d9f3c05722f66845c357559150c2858', '[\"*\"]', '2023-08-22 18:51:38', '2023-08-22 18:51:32', '2023-08-22 18:51:38'),
(241, 'App\\Models\\User', 37, 'user_token', '83c57dbbdf2fb16364602426eacf50ca5cdd5fe571ef3419f5f7d802e2a8d811', '[\"*\"]', '2023-08-22 21:16:55', '2023-08-22 21:08:26', '2023-08-22 21:16:55'),
(242, 'App\\Models\\User', 36, 'user_token', 'e331e19a24ab71dd9ed37c820c71f08618874ff7cfc428c13ae499a283299cac', '[\"*\"]', '2023-08-22 21:29:59', '2023-08-22 21:29:35', '2023-08-22 21:29:59'),
(243, 'App\\Models\\User', 36, 'user_token', '0ef2feee2172834fe3f5f0b831475df465924179bde7a6014133368fa201f22a', '[\"*\"]', '2023-08-24 17:25:56', '2023-08-22 21:30:01', '2023-08-24 17:25:56'),
(244, 'App\\Models\\User', 37, 'user_token', 'cf25b0bd3d4063868e01b38c16ce31bb5aac40be7414cfc51563f7d6615a7814', '[\"*\"]', '2023-08-24 20:30:28', '2023-08-22 21:34:03', '2023-08-24 20:30:28'),
(245, 'App\\Models\\User', 36, 'user_token', '02264882aab3ea9422b1d1ffd4d6ae43116dbb0df22fe3c4f0a82afcc5b5a274', '[\"*\"]', '2023-08-24 17:27:13', '2023-08-24 17:24:59', '2023-08-24 17:27:13'),
(246, 'App\\Models\\User', 36, 'user_token', 'b725b9d97a88cb70f4b9c226f840b7ee5a285304cbe0863b1c975d3bd1c07acf', '[\"*\"]', '2023-08-24 17:54:26', '2023-08-24 17:27:15', '2023-08-24 17:54:26'),
(247, 'App\\Models\\User', 33, 'user_token', 'c66c29842d456b74e389377762db04df7c309731d688a53bf30060c27dd8a930', '[\"*\"]', '2023-08-24 17:56:01', '2023-08-24 17:55:26', '2023-08-24 17:56:01'),
(248, 'App\\Models\\User', 33, 'user_token', '0a4f216502ff25b70857e062981ea0bdb07506b8f9c4e3f37d3a0541ae8e6059', '[\"*\"]', '2023-08-24 17:57:18', '2023-08-24 17:56:58', '2023-08-24 17:57:18'),
(249, 'App\\Models\\User', 33, 'user_token', '40aca421b1c7e0fefdb77c7a3a40ed56a0692c5abc27b0ee88993adb250c6dde', '[\"*\"]', '2023-08-24 17:59:13', '2023-08-24 17:57:20', '2023-08-24 17:59:13'),
(250, 'App\\Models\\User', 33, 'user_token', 'b315e237b361274bd3e7335f0f9865619be3410d7b5a93b3a9c8e08deced3a61', '[\"*\"]', '2023-08-24 17:58:24', '2023-08-24 17:57:48', '2023-08-24 17:58:24'),
(251, 'App\\Models\\User', 33, 'user_token', 'db58749bea59ecf1330c9c1394c5238e430e19833b1f9e32ddbab75163dec56c', '[\"*\"]', '2023-08-24 17:58:26', '2023-08-24 17:58:26', '2023-08-24 17:58:26'),
(252, 'App\\Models\\User', 33, 'user_token', 'b42a64b66560de005c22a35a6c9d4c787e759133a0add07b6041f99cdce654d2', '[\"*\"]', '2023-08-24 18:26:37', '2023-08-24 17:58:37', '2023-08-24 18:26:37'),
(253, 'App\\Models\\User', 36, 'user_token', 'd86c27f0877a4c4c9ac4defbb1291046165d63cd92c3ebcb9e34473af9374382', '[\"*\"]', '2023-08-24 18:31:02', '2023-08-24 18:27:34', '2023-08-24 18:31:02'),
(254, 'App\\Models\\User', 38, 'user_token', '9cc1014c16a03489b2940532f152073467aaab75f831c59f1957f5b0b7aac4bc', '[\"*\"]', '2023-08-24 18:39:30', '2023-08-24 18:31:33', '2023-08-24 18:39:30'),
(255, 'App\\Models\\User', 38, 'user_token', '6e33a75de9f8db459a2986cd73e92bd83824e5cd743e790d171847ed904d3a2d', '[\"*\"]', '2023-08-24 21:39:24', '2023-08-24 21:38:35', '2023-08-24 21:39:24'),
(256, 'App\\Models\\User', 38, 'user_token', '6b1c404ce9a51ab736cf7fba06bbdc1d37258476a5c1cc13d3c1460aee54723e', '[\"*\"]', '2023-08-24 22:18:41', '2023-08-24 22:17:59', '2023-08-24 22:18:41');

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
(12, 2, 'avfrty', 'addada sfsgsfgsgd sfsfsfsf sfsgsfgsg', '2000', '2000', NULL, NULL, 1, NULL, '2023-06-06 22:41:11', '2023-06-23 21:50:59'),
(13, 2, 'rfrwrwrwtwtg darwrwrw', 'ccsfsgdg sgghgrhyrjhur ghhhtrhujt', '3000', '2000', NULL, NULL, 1, '2023-06-14 11:32:56', '2023-06-06 22:46:10', '2023-06-14 11:32:56'),
(14, 2, 'Best purifier', 'kk igii', '3000', '2000', NULL, NULL, 1, NULL, '2023-06-08 18:13:04', '2023-06-08 18:13:04'),
(15, 4, 'MODERN CHIMNEY', 'k0254 transistor based', '18000', '16000', NULL, NULL, 1, NULL, '2023-06-20 08:11:17', '2023-06-23 21:50:26'),
(16, 4, 'modular chimney', 's24dfgh', '100000', '150000', NULL, NULL, 1, NULL, '2023-07-23 08:38:18', '2023-07-23 08:38:18'),
(17, 2, 'Modular', 'ag2145', '25000', '30000', NULL, NULL, 1, NULL, '2023-07-23 08:40:41', '2023-07-23 08:47:17');

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
(11, 1, '/product/YZv9ljf8F9.jpg', '/product/thumbnail/hk6TGnnSsm.jpg', '2023-06-30 18:25:01', '2023-06-14 12:02:01', '2023-06-30 18:25:01'),
(12, 1, '/product/CGZh7mAk9p.jpg', '/product/thumbnail/TNNQ15dKbt.jpg', '2023-06-30 18:25:01', '2023-06-14 12:02:01', '2023-06-30 18:25:01'),
(13, 1, '/product/FmoyO8mGQl.jpg', '/product/thumbnail/ShBHwoH0o9.jpg', '2023-06-30 18:25:01', '2023-06-14 12:02:01', '2023-06-30 18:25:01'),
(14, 1, NULL, NULL, '2023-06-30 18:25:01', '2023-06-14 12:02:01', '2023-06-30 18:25:01'),
(15, 1, NULL, NULL, '2023-06-30 18:25:01', '2023-06-14 12:02:01', '2023-06-30 18:25:01'),
(16, 14, '/product/HFxcHWKUHe.jpg', '/product/thumbnail/SIIBMEbsLm.jpg', '2023-06-30 18:23:00', '2023-06-14 12:31:43', '2023-06-30 18:23:00'),
(17, 14, NULL, NULL, '2023-06-30 18:23:00', '2023-06-14 12:31:43', '2023-06-30 18:23:00'),
(18, 14, NULL, NULL, '2023-06-30 18:23:00', '2023-06-14 12:31:43', '2023-06-30 18:23:00'),
(19, 14, NULL, NULL, '2023-06-30 18:23:00', '2023-06-14 12:31:43', '2023-06-30 18:23:00'),
(20, 14, NULL, NULL, '2023-06-30 18:23:00', '2023-06-14 12:31:43', '2023-06-30 18:23:00'),
(21, 15, NULL, NULL, '2023-06-30 18:22:49', '2023-06-23 21:50:26', '2023-06-30 18:22:49'),
(22, 15, NULL, NULL, '2023-06-30 18:22:49', '2023-06-23 21:50:26', '2023-06-30 18:22:49'),
(23, 15, NULL, NULL, '2023-06-30 18:22:49', '2023-06-23 21:50:26', '2023-06-30 18:22:49'),
(24, 15, NULL, NULL, '2023-06-30 18:22:49', '2023-06-23 21:50:26', '2023-06-30 18:22:49'),
(25, 15, NULL, NULL, '2023-06-30 18:22:49', '2023-06-23 21:50:26', '2023-06-30 18:22:49'),
(26, 12, NULL, NULL, '2023-06-30 18:23:11', '2023-06-23 21:50:59', '2023-06-30 18:23:11'),
(27, 12, NULL, NULL, '2023-06-30 18:23:11', '2023-06-23 21:50:59', '2023-06-30 18:23:11'),
(28, 12, NULL, NULL, '2023-06-30 18:23:11', '2023-06-23 21:50:59', '2023-06-30 18:23:11'),
(29, 12, NULL, NULL, '2023-06-30 18:23:11', '2023-06-23 21:50:59', '2023-06-30 18:23:11'),
(30, 12, NULL, NULL, '2023-06-30 18:23:11', '2023-06-23 21:50:59', '2023-06-30 18:23:11'),
(31, 15, '/product/t66KkUiwBI.jpg', '/product/thumbnail/frmSj2ZTcG.jpg', NULL, '2023-06-30 18:22:49', '2023-06-30 18:22:49'),
(32, 15, NULL, NULL, NULL, '2023-06-30 18:22:49', '2023-06-30 18:22:49'),
(33, 15, NULL, NULL, NULL, '2023-06-30 18:22:49', '2023-06-30 18:22:49'),
(34, 15, NULL, NULL, NULL, '2023-06-30 18:22:49', '2023-06-30 18:22:49'),
(35, 15, NULL, NULL, NULL, '2023-06-30 18:22:49', '2023-06-30 18:22:49'),
(36, 14, '/product/Fr8D6jyOcP.jpg', '/product/thumbnail/DQZ3ZDNxav.jpg', NULL, '2023-06-30 18:23:00', '2023-06-30 18:23:00'),
(37, 14, NULL, NULL, NULL, '2023-06-30 18:23:00', '2023-06-30 18:23:00'),
(38, 14, NULL, NULL, NULL, '2023-06-30 18:23:00', '2023-06-30 18:23:00'),
(39, 14, NULL, NULL, NULL, '2023-06-30 18:23:00', '2023-06-30 18:23:00'),
(40, 14, NULL, NULL, NULL, '2023-06-30 18:23:00', '2023-06-30 18:23:00'),
(41, 12, '/product/9L4NmjGjsJ.jpg', '/product/thumbnail/79QiN9ug4T.jpg', NULL, '2023-06-30 18:23:11', '2023-06-30 18:23:11'),
(42, 12, NULL, NULL, NULL, '2023-06-30 18:23:11', '2023-06-30 18:23:11'),
(43, 12, NULL, NULL, NULL, '2023-06-30 18:23:11', '2023-06-30 18:23:11'),
(44, 12, NULL, NULL, NULL, '2023-06-30 18:23:11', '2023-06-30 18:23:11'),
(45, 12, NULL, NULL, NULL, '2023-06-30 18:23:11', '2023-06-30 18:23:11'),
(46, 11, '/product/QJaZj2ksHJ.webp', '/product/thumbnail/AQwmgbjaMc.webp', NULL, '2023-06-30 18:23:21', '2023-06-30 18:23:21'),
(47, 11, NULL, NULL, NULL, '2023-06-30 18:23:21', '2023-06-30 18:23:21'),
(48, 11, NULL, NULL, NULL, '2023-06-30 18:23:21', '2023-06-30 18:23:21'),
(49, 11, NULL, NULL, NULL, '2023-06-30 18:23:21', '2023-06-30 18:23:21'),
(50, 11, NULL, NULL, NULL, '2023-06-30 18:23:21', '2023-06-30 18:23:21'),
(51, 10, '/product/6sMLm4Zppb.jpg', '/product/thumbnail/NfJ9c1GJqa.jpg', NULL, '2023-06-30 18:23:31', '2023-06-30 18:23:31'),
(52, 10, NULL, NULL, NULL, '2023-06-30 18:23:31', '2023-06-30 18:23:31'),
(53, 10, NULL, NULL, NULL, '2023-06-30 18:23:31', '2023-06-30 18:23:31'),
(54, 10, NULL, NULL, NULL, '2023-06-30 18:23:31', '2023-06-30 18:23:31'),
(55, 10, NULL, NULL, NULL, '2023-06-30 18:23:31', '2023-06-30 18:23:31'),
(56, 7, '/product/mCzpHhfFUT.jpg', '/product/thumbnail/GVZ7c3Ee5j.jpg', NULL, '2023-06-30 18:23:43', '2023-06-30 18:23:43'),
(57, 7, NULL, NULL, NULL, '2023-06-30 18:23:43', '2023-06-30 18:23:43'),
(58, 7, NULL, NULL, NULL, '2023-06-30 18:23:43', '2023-06-30 18:23:43'),
(59, 7, NULL, NULL, NULL, '2023-06-30 18:23:43', '2023-06-30 18:23:43'),
(60, 7, NULL, NULL, NULL, '2023-06-30 18:23:43', '2023-06-30 18:23:43'),
(61, 6, '/product/E354yhdyc2.webp', '/product/thumbnail/OOs5KLu1We.webp', NULL, '2023-06-30 18:23:54', '2023-06-30 18:23:54'),
(62, 6, NULL, NULL, NULL, '2023-06-30 18:23:54', '2023-06-30 18:23:54'),
(63, 6, NULL, NULL, NULL, '2023-06-30 18:23:54', '2023-06-30 18:23:54'),
(64, 6, NULL, NULL, NULL, '2023-06-30 18:23:54', '2023-06-30 18:23:54'),
(65, 6, NULL, NULL, NULL, '2023-06-30 18:23:54', '2023-06-30 18:23:54'),
(66, 5, '/product/mLu5oloOWC.webp', '/product/thumbnail/VKvhYYMear.webp', NULL, '2023-06-30 18:24:13', '2023-06-30 18:24:13'),
(67, 5, NULL, NULL, NULL, '2023-06-30 18:24:13', '2023-06-30 18:24:13'),
(68, 5, NULL, NULL, NULL, '2023-06-30 18:24:13', '2023-06-30 18:24:13'),
(69, 5, NULL, NULL, NULL, '2023-06-30 18:24:13', '2023-06-30 18:24:13'),
(70, 5, NULL, NULL, NULL, '2023-06-30 18:24:13', '2023-06-30 18:24:13'),
(71, 4, '/product/3ftjJ9rnQT.jpg', '/product/thumbnail/YU1NTJoG0E.jpg', NULL, '2023-06-30 18:24:22', '2023-06-30 18:24:22'),
(72, 4, NULL, NULL, NULL, '2023-06-30 18:24:22', '2023-06-30 18:24:22'),
(73, 4, NULL, NULL, NULL, '2023-06-30 18:24:22', '2023-06-30 18:24:22'),
(74, 4, NULL, NULL, NULL, '2023-06-30 18:24:22', '2023-06-30 18:24:22'),
(75, 4, NULL, NULL, NULL, '2023-06-30 18:24:22', '2023-06-30 18:24:22'),
(76, 3, '/product/cCvU5EHJCI.jpg', '/product/thumbnail/jK63mbWYBa.jpg', NULL, '2023-06-30 18:24:35', '2023-06-30 18:24:35'),
(77, 3, NULL, NULL, NULL, '2023-06-30 18:24:35', '2023-06-30 18:24:35'),
(78, 3, NULL, NULL, NULL, '2023-06-30 18:24:35', '2023-06-30 18:24:35'),
(79, 3, NULL, NULL, NULL, '2023-06-30 18:24:35', '2023-06-30 18:24:35'),
(80, 3, NULL, NULL, NULL, '2023-06-30 18:24:35', '2023-06-30 18:24:35'),
(81, 2, '/product/1FOKGeJ2Np.jpg', '/product/thumbnail/fnKpNguddc.jpg', NULL, '2023-06-30 18:24:49', '2023-06-30 18:24:49'),
(82, 2, NULL, NULL, NULL, '2023-06-30 18:24:49', '2023-06-30 18:24:49'),
(83, 2, NULL, NULL, NULL, '2023-06-30 18:24:49', '2023-06-30 18:24:49'),
(84, 2, NULL, NULL, NULL, '2023-06-30 18:24:49', '2023-06-30 18:24:49'),
(85, 2, NULL, NULL, NULL, '2023-06-30 18:24:49', '2023-06-30 18:24:49'),
(86, 1, '/product/DxY7ETWtl5.jpg', '/product/thumbnail/OBxCg5svsP.jpg', NULL, '2023-06-30 18:25:01', '2023-06-30 18:25:01'),
(87, 1, 'http://centurytechnologies.co.in/projects/ecom/public/product/CGZh7mAk9p.jpg', '/product/thumbnail/TNNQ15dKbt.jpg', NULL, '2023-06-30 18:25:01', '2023-06-30 18:25:01'),
(88, 1, NULL, NULL, NULL, '2023-06-30 18:25:01', '2023-06-30 18:25:01'),
(89, 1, NULL, NULL, NULL, '2023-06-30 18:25:01', '2023-06-30 18:25:01'),
(90, 1, NULL, NULL, NULL, '2023-06-30 18:25:01', '2023-06-30 18:25:01'),
(91, 17, NULL, NULL, '2023-07-23 09:01:58', '2023-07-23 08:47:17', '2023-07-23 09:01:58'),
(92, 17, NULL, NULL, '2023-07-23 09:01:58', '2023-07-23 08:47:17', '2023-07-23 09:01:58'),
(93, 17, NULL, NULL, '2023-07-23 09:01:58', '2023-07-23 08:47:17', '2023-07-23 09:01:58'),
(94, 17, NULL, NULL, '2023-07-23 09:01:58', '2023-07-23 08:47:17', '2023-07-23 09:01:58'),
(95, 17, NULL, NULL, '2023-07-23 09:01:58', '2023-07-23 08:47:17', '2023-07-23 09:01:58'),
(96, 17, '/product/MmFJ96Li7y.jpg', '/product/thumbnail/xI5POh6Qur.jpg', NULL, '2023-07-23 09:01:59', '2023-07-23 09:01:59'),
(97, 17, '/product/CcOVA5ZHd9.jpg', '/product/thumbnail/jtpajCmFP8.jpg', NULL, '2023-07-23 09:01:59', '2023-07-23 09:01:59'),
(98, 17, '/product/XQ45FNSoOQ.jpg', '/product/thumbnail/ZbmRItxv4Q.jpg', NULL, '2023-07-23 09:01:59', '2023-07-23 09:01:59'),
(99, 17, NULL, NULL, NULL, '2023-07-23 09:01:59', '2023-07-23 09:01:59'),
(100, 17, NULL, NULL, NULL, '2023-07-23 09:01:59', '2023-07-23 09:01:59');

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
  `status` varchar(30) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `technian_slot`
--

INSERT INTO `technian_slot` (`id`, `user_id`, `work_order_id`, `slot_id`, `status`, `date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(23, 7, 24, 2, 'Completed', '2023-06-22', NULL, '2023-06-22 16:59:50', '2023-06-22 17:05:19'),
(24, 7, 25, 3, 'Not Resolved', '2023-06-22', NULL, '2023-06-22 17:08:09', '2023-06-22 17:19:12'),
(25, 7, 26, 2, 'Not Resolved', '2023-06-23', NULL, '2023-06-23 08:24:35', '2023-06-23 08:25:01'),
(26, 7, 27, 3, 'Not Resolved', '2023-06-23', NULL, '2023-06-23 08:26:01', '2023-06-23 08:30:01'),
(27, 7, 28, 4, 'Not Resolved', '2023-06-23', NULL, '2023-06-23 08:27:41', '2023-06-23 08:30:01'),
(28, 7, 29, 5, 'Not Resolved', '2023-06-23', NULL, '2023-06-23 08:28:14', '2023-06-23 08:30:01'),
(29, 7, 30, 6, 'Not Resolved', '2023-06-23', NULL, '2023-06-23 08:28:43', '2023-06-23 08:30:01'),
(30, 7, 31, 7, 'Not Resolved', '2023-06-23', NULL, '2023-06-23 08:29:15', '2023-06-23 08:30:01'),
(31, 4, 32, 2, NULL, '2023-06-23', NULL, '2023-06-23 22:19:55', '2023-06-23 22:19:55'),
(32, 4, 33, 3, NULL, '2023-06-23', NULL, '2023-06-23 22:25:28', '2023-06-23 22:25:28'),
(33, 7, 34, 2, 'Completed', '2023-06-24', NULL, '2023-06-24 09:17:52', '2023-06-24 09:28:00'),
(34, 7, 35, 3, 'Not Resolved', '2023-06-24', NULL, '2023-06-24 09:34:03', '2023-06-24 09:35:02'),
(35, 7, 36, 5, 'Not Resolved', '2023-06-25', NULL, '2023-06-25 10:27:08', '2023-06-25 10:30:01'),
(36, 7, 37, 6, 'Not Resolved', '2023-06-25', NULL, '2023-06-25 10:27:43', '2023-06-25 10:30:01'),
(37, 7, 38, 7, 'Not Resolved', '2023-06-25', NULL, '2023-06-25 10:28:14', '2023-06-25 10:30:01'),
(38, 7, 39, 2, 'Not Started', '2023-06-25', '2023-06-25 13:48:57', '2023-06-25 11:01:07', '2023-06-25 11:01:07'),
(39, 7, 40, 3, 'Not Started', '2023-06-25', '2023-06-25 13:48:40', '2023-06-25 11:01:27', '2023-06-25 11:01:27'),
(40, 7, 41, 4, 'Not Started', '2023-06-25', '2023-06-25 13:48:36', '2023-06-25 11:01:49', '2023-06-25 11:01:49'),
(41, 7, 42, 2, 'Not Resolved', '2023-06-25', NULL, '2023-06-25 11:37:06', '2023-06-26 00:00:01'),
(42, 7, 43, 3, 'Not Resolved', '2023-06-25', NULL, '2023-06-25 11:39:06', '2023-06-26 00:00:01'),
(43, 7, 44, 2, 'Completed', '2023-06-30', NULL, '2023-06-30 17:25:11', '2023-06-30 21:39:56'),
(44, 7, 45, 3, 'Not Resolved', '2023-06-30', NULL, '2023-06-30 17:25:51', '2023-07-01 00:00:01'),
(45, 7, 46, 5, 'Not Resolved', '2023-07-07', NULL, '2023-07-07 09:48:26', '2023-07-08 00:00:01'),
(46, 4, 47, 2, 'In Progress', '2023-07-20', NULL, '2023-07-20 17:12:54', '2023-07-20 17:12:54'),
(47, 5, 48, 2, 'Not Resolved', '2023-07-23', NULL, '2023-07-23 09:10:02', '2023-07-24 00:00:02'),
(48, 7, 49, 2, 'Completed', '2023-07-27', NULL, '2023-07-27 14:48:20', '2023-07-27 14:59:16');

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
  `user_type` enum('admin','tele_caller','technician','user','normal_user','amc_user','paid_user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
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
(25, 'OFFICE-SAHA ENTERPRISE', 'OFFICE_1', NULL, '8240903631', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '$2y$10$hqikVjvpXseE9KjZValIn.w4kLXkBUkKfM4Bhxl/dcsu4czJqRISy', NULL, NULL, '2023-07-31 16:35:10', '2023-07-31 15:36:11', '2023-07-31 16:35:10', NULL, NULL),
(26, 'OFFICE-SAHA ENTERPRISE', 'OFFICE_2', NULL, '8240903631', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '$2y$10$.3NUHrqxCJ7uuuHhyEJbW.dSoH6Rp1RMD2tErapsgMYaBMNgPe3xa', NULL, NULL, '2023-07-31 16:35:05', '2023-07-31 15:40:03', '2023-07-31 16:35:05', NULL, NULL),
(27, 'OFFICE', 'OFFICE_3', NULL, '8240903631', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '$2y$10$G.M6sNvu/aThBBBJbPPDAumFSAmYZvHbk.C1f8s8cfvqdb6EIm8y6', NULL, NULL, '2023-07-31 16:35:02', '2023-07-31 15:43:40', '2023-07-31 16:35:02', NULL, NULL),
(28, 'SATABDI', 'test@12345', NULL, '8240903631', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '$2y$10$ghy4WEGjIDHmfAegS9g1rO6sFK27.n6Zsr9J6Q4PzE9lFBr.bP2Ja', NULL, NULL, '2023-08-19 17:17:11', '2023-07-31 15:47:00', '2023-08-19 17:17:11', NULL, NULL),
(29, 'OFFICE-SAHA ENTERPRISE', 'sujit', NULL, '8240903631', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '$2y$10$JdJc.oJ44tp7u0rwEdvaCeAWXBFiU1kT0wRxQzesowKK3Eib3Sha.', NULL, NULL, '2023-08-19 17:17:13', '2023-07-31 16:37:34', '2023-08-19 17:17:13', NULL, NULL),
(30, 'France', 'suman345', NULL, '7318874161', 'normal_user', 'active', 'qewqr', NULL, NULL, NULL, '$2y$10$BRIgfYKzQ72pulhPu/3/ku8/aEYCu5.AB64kFGU94C/e4oSJKWIuW', NULL, NULL, '2023-08-19 17:17:03', '2023-07-31 16:51:19', '2023-08-19 17:17:03', NULL, NULL),
(31, 'France', '14jkl', NULL, '7318874161', 'normal_user', 'active', '15 Linton st.', NULL, NULL, NULL, '$2y$10$dBqI1PzmNdXFjJzNqLDbA.cJzKj4R3rpJyBYX2aq5GkA1zCbwciVG', NULL, NULL, '2023-08-19 17:17:01', '2023-08-04 22:30:49', '2023-08-19 17:17:01', NULL, NULL),
(32, 'Anup', 'anup_dev', NULL, '7688019332', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '$2y$10$vHz2KakPeRbyHJ0XYuyjK.EqF3T/68Ivlf1D7wRLG6Xs48zJcjdmS', NULL, NULL, '2023-08-19 17:17:15', '2023-08-05 17:57:14', '2023-08-19 17:17:15', NULL, NULL),
(33, 'Office Boy', 'Office1', NULL, '5345556674', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '123456', NULL, NULL, NULL, '2023-08-19 17:18:07', '2023-08-24 17:58:37', NULL, NULL),
(34, 'Technician Boy', 'Technician', NULL, '2422444667', 'technician', 'active', NULL, NULL, NULL, NULL, '123456', NULL, NULL, NULL, '2023-08-19 17:18:46', '2023-08-19 17:23:20', NULL, NULL),
(35, 'Office2', 'Office2', NULL, '4242246678', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '123456', NULL, NULL, NULL, '2023-08-19 18:53:06', '2023-08-19 19:08:37', NULL, NULL),
(36, 'tel1', 'nick', 'asd@text.com', '2547896501', 'tele_caller', 'active', '2 b. b ganguly st.', NULL, NULL, NULL, '123456', NULL, NULL, NULL, '2023-08-20 03:05:23', '2023-08-24 18:27:34', NULL, NULL),
(37, 'OFFICE-SAHA ENTERPRISE', 'sujit@12345', NULL, '8240903631', 'tele_caller', 'active', NULL, NULL, NULL, NULL, '123456', NULL, NULL, NULL, '2023-08-22 21:08:02', '2023-08-22 21:34:03', NULL, NULL),
(38, 'France', 'test123', NULL, '7318874161', 'paid_user', 'active', 'Howrah', NULL, NULL, NULL, '123456', NULL, NULL, NULL, '2023-08-24 18:30:39', '2023-09-03 16:02:24', NULL, NULL),
(39, 'Pronab Pal', 'pronab1', 'pronab1@test.com', '8353366671', 'amc_user', 'active', NULL, NULL, NULL, NULL, 'pronab1', NULL, NULL, NULL, '2023-09-03 15:35:08', '2023-09-03 15:39:24', NULL, NULL);

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
  `work_order_no` varchar(50) DEFAULT NULL,
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
(24, 7, 23, 'Completed', 'dddd', '2023-06-22 17:00:24', NULL, '2023-06-22 17:00:24'),
(25, 7, 23, 'Completed', 'ggggg', '2023-06-22 17:02:33', NULL, '2023-06-22 17:02:33'),
(26, 7, 23, 'Completed', 'ggggg', '2023-06-22 17:04:39', NULL, '2023-06-22 17:04:39'),
(27, 7, 24, 'Completed', 'ggggg', '2023-06-22 17:05:19', NULL, '2023-06-22 17:05:19'),
(28, 7, 25, 'Completed', 'addadad', '2023-06-22 17:14:23', NULL, '2023-06-22 17:14:23'),
(29, 7, 25, 'Completed', 'adadad', '2023-06-22 17:19:12', NULL, '2023-06-22 17:19:12'),
(30, 7, 34, 'Completed', 'Fgfhg', '2023-06-24 09:25:28', NULL, '2023-06-24 09:25:28'),
(31, 7, 34, 'Completed', 'Fgfhg', '2023-06-24 09:25:57', NULL, '2023-06-24 09:25:57'),
(32, 7, 34, 'Completed', 'Fgfhg', '2023-06-24 09:27:39', NULL, '2023-06-24 09:27:39'),
(33, 7, 34, 'Completed', 'Fgfhg', '2023-06-24 09:27:54', NULL, '2023-06-24 09:27:54'),
(34, 7, 34, 'Completed', 'Fgfhg', '2023-06-24 09:28:00', NULL, '2023-06-24 09:28:00'),
(35, 7, 44, 'Completed', 'Ok', '2023-06-30 17:39:13', NULL, '2023-06-30 17:39:13'),
(36, 7, 44, 'In Progress', 'Ok', '2023-06-30 17:39:29', NULL, '2023-06-30 17:39:29'),
(37, 7, 44, 'Completed', NULL, '2023-06-30 21:39:15', NULL, '2023-06-30 21:39:15'),
(38, 7, 44, 'Completed', 'Ok', '2023-06-30 21:39:56', NULL, '2023-06-30 21:39:56'),
(39, 7, 49, 'Completed', 'Dfg', '2023-07-27 14:59:11', NULL, '2023-07-27 14:59:11'),
(40, 7, 49, 'Completed', 'Dfg', '2023-07-27 14:59:13', NULL, '2023-07-27 14:59:13'),
(41, 7, 49, 'Completed', 'Dfg', '2023-07-27 14:59:14', NULL, '2023-07-27 14:59:14'),
(42, 7, 49, 'Completed', 'Dfg', '2023-07-27 14:59:16', NULL, '2023-07-27 14:59:16'),
(43, 7, 49, 'Completed', 'Dfg', '2023-07-27 14:59:16', NULL, '2023-07-27 14:59:16');

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
(24, 23, '/uploads/work_order/3wi0pVaNtw.jpg', '2023-06-22 17:00:24', '2023-06-22 17:00:24'),
(25, 23, '/uploads/work_order/WwR7efNN44.jpg', '2023-06-22 17:02:33', '2023-06-22 17:02:33'),
(26, 23, '/uploads/work_order/KyinAHpbpR.jpg', '2023-06-22 17:04:39', '2023-06-22 17:04:39'),
(27, 24, '/uploads/work_order/T9oVDK2rTM.jpg', '2023-06-22 17:05:19', '2023-06-22 17:05:19'),
(28, 25, '/uploads/work_order/oEIJEYmfds.jpg', '2023-06-22 17:14:23', '2023-06-22 17:14:23'),
(29, 25, '/uploads/work_order/Cgq8W8Rn4Q.jpg', '2023-06-22 17:19:12', '2023-06-22 17:19:12'),
(30, 34, '/uploads/work_order/yeuOdJwQH4.jpg', '2023-06-24 09:25:28', '2023-06-24 09:25:28'),
(31, 34, '/uploads/work_order/50c9YdHjzc.jpg', '2023-06-24 09:25:57', '2023-06-24 09:25:57'),
(32, 34, '/uploads/work_order/AOO1MbsXWn.jpg', '2023-06-24 09:27:39', '2023-06-24 09:27:39'),
(33, 34, '/uploads/work_order/a5QqnD8h1V.jpg', '2023-06-24 09:27:39', '2023-06-24 09:27:39'),
(34, 34, '/uploads/work_order/iB6lauJ8mR.jpg', '2023-06-24 09:27:54', '2023-06-24 09:27:54'),
(35, 34, '/uploads/work_order/qRMY6OQ5sR.jpg', '2023-06-24 09:27:54', '2023-06-24 09:27:54'),
(36, 34, '/uploads/work_order/ef43Z06pVO.jpg', '2023-06-24 09:28:00', '2023-06-24 09:28:00'),
(37, 34, '/uploads/work_order/u8MKJYRyq9.jpg', '2023-06-24 09:28:00', '2023-06-24 09:28:00'),
(38, 44, '/uploads/work_order/SaZpRYc3Rm.jpg', '2023-06-30 17:39:13', '2023-06-30 17:39:13'),
(39, 44, '/uploads/work_order/FI9o1VXmbp.jpg', '2023-06-30 17:39:29', '2023-06-30 17:39:29'),
(40, 44, '/uploads/work_order/CIbgWNxkdv.jpg', '2023-06-30 21:39:15', '2023-06-30 21:39:15'),
(41, 44, '/uploads/work_order/xaCxUMQ0j6.jpg', '2023-06-30 21:39:55', '2023-06-30 21:39:55'),
(42, 44, '/uploads/work_order/FS8UpBJ6cj.jpg', '2023-06-30 21:39:56', '2023-06-30 21:39:56'),
(43, 49, '/uploads/work_order/4Up9Azvaaq.jpg', '2023-07-27 14:59:11', '2023-07-27 14:59:11'),
(44, 49, '/uploads/work_order/Lf3dwIHWqi.jpg', '2023-07-27 14:59:13', '2023-07-27 14:59:13'),
(45, 49, '/uploads/work_order/q8qMpFGM5s.jpg', '2023-07-27 14:59:14', '2023-07-27 14:59:14'),
(46, 49, '/uploads/work_order/7PcsLW8iVH.jpg', '2023-07-27 14:59:16', '2023-07-27 14:59:16'),
(47, 49, '/uploads/work_order/ThLJdTUl0R.jpg', '2023-07-27 14:59:16', '2023-07-27 14:59:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_detail`
--
ALTER TABLE `customer_detail`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer_detail`
--
ALTER TABLE `customer_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `lead_assignment`
--
ALTER TABLE `lead_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `lead_report`
--
ALTER TABLE `lead_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_gallery`
--
ALTER TABLE `product_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_order`
--
ALTER TABLE `work_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_order_report`
--
ALTER TABLE `work_order_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `work_order_report_pic`
--
ALTER TABLE `work_order_report_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
