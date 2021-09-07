-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2021 at 05:05 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpressdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_postal_code_data`
--

CREATE TABLE `db_postal_code_data` (
  `id` bigint(11) NOT NULL,
  `urban` varchar(100) NOT NULL,
  `sub_district` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province_code` int(2) NOT NULL,
  `postal_code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `db_province_data`
--

CREATE TABLE `db_province_data` (
  `province_name` varchar(100) NOT NULL,
  `province_name_en` varchar(100) NOT NULL,
  `province_code` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
(55, '2014_10_12_100000_create_password_resets_table', 1),
(56, '2019_08_19_000000_create_failed_jobs_table', 1),
(57, '2021_06_16_130350_add_phone_number_to_wp_users_table', 1),
(58, '2021_06_17_031241_create_wp_otps_table', 1),
(59, '2021_06_19_152858_create_wp_user_addresses_table', 1),
(60, '2021_06_19_161530_create_wp_user_extension_attributes_table', 1),
(61, '2021_06_22_133247_create_wp_cms_table', 1),
(62, '2021_06_23_001120_create_wp_projects_table', 1),
(63, '2021_06_27_151810_add_user_picture_to_wp_users_table', 1),
(64, '2021_07_01_023108_alter_wp_users_user_phone_number_unique', 1),
(65, '2021_07_01_024351_drop_wp_projects_table', 1),
(66, '2021_07_02_032359_alter_wp_cms_name_unique', 1),
(67, '2021_07_12_055311_create_wp_user_tokens_table', 1),
(68, '2021_07_14_065407_add_password_to_wp_users', 1),
(69, '2021_07_17_035027_create_wp_user_notifications_table', 1),
(70, '2021_08_08_032423_alter_wp_user_notifications_add_text', 1),
(71, '2021_08_24_065407_add_company_name_to_wp_users', 2),
(72, '2021_08_24_065407_add_soft_delete_to_wp_users', 3),
(74, '2021_08_24_065407_add_service_type_to_wp_projects', 4),
(75, '2021_08_24_065407_add_room_number_to_wp_projects', 5),
(79, '2021_08_25_065407_add_project_value_to_wp_projects', 6),
(80, '2021_08_25_065407_add_other_expanse_to_wp_projects', 7),
(81, '2021_08_08_032423_alter_wp_user_notifications_add_is_read', 8),
(82, '2021_08_25_065407_add_rating_to_wp_projects', 9);

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
-- Table structure for table `wp_cms`
--

CREATE TABLE `wp_cms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_otps`
--

CREATE TABLE `wp_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `otp` int(11) NOT NULL,
  `valid_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_otps`
--

INSERT INTO `wp_otps` (`id`, `user_id`, `otp`, `valid_date`, `created_at`, `updated_at`) VALUES
(9, 320, 159048, '2021-08-24 15:06:25', '2021-08-24 07:06:25', '2021-08-24 07:06:25'),
(10, 321, 853156, '2021-08-24 15:12:22', '2021-08-24 07:12:22', '2021-08-24 07:12:22'),
(13, 324, 318008, '2021-08-24 18:45:07', '2021-08-24 10:45:07', '2021-08-24 10:45:07'),
(14, 325, 287179, '2021-08-24 18:46:02', '2021-08-24 10:46:02', '2021-08-24 10:46:02'),
(16, 327, 498040, '2021-08-25 04:31:28', '2021-08-24 20:31:28', '2021-08-24 20:31:28'),
(17, 328, 282912, '2021-08-25 04:34:16', '2021-08-24 20:34:16', '2021-08-24 20:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `wp_projects`
--

CREATE TABLE `wp_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `vendor_user_id` bigint(20) DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` json DEFAULT NULL,
  `estimated_budget` double DEFAULT NULL,
  `amount_spk_customer_gross` double DEFAULT NULL,
  `amount_spk_customer` double DEFAULT NULL,
  `amount_spk_vendor` double DEFAULT NULL,
  `material_buy` double DEFAULT NULL,
  `mitraruma_discount` double DEFAULT NULL,
  `applicator_discount` double DEFAULT NULL,
  `commision` double DEFAULT NULL,
  `total_expanse` double DEFAULT NULL,
  `expanse_note` text COLLATE utf8mb4_unicode_ci,
  `project_note` text COLLATE utf8mb4_unicode_ci,
  `term_payment_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_fee` double DEFAULT NULL,
  `termin_customer_1` double DEFAULT NULL,
  `termin_customer_1_date` date DEFAULT NULL,
  `termin_customer_2` double DEFAULT NULL,
  `termin_customer_2_date` date DEFAULT NULL,
  `termin_customer_3` double DEFAULT NULL,
  `termin_customer_3_date` date DEFAULT NULL,
  `termin_customer_4` double DEFAULT NULL,
  `termin_customer_4_date` date DEFAULT NULL,
  `termin_customer_5` double DEFAULT NULL,
  `termin_customer_5_date` date DEFAULT NULL,
  `term_payment_vendor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `termin_vendor_1` double DEFAULT NULL,
  `termin_vendor_1_date` date DEFAULT NULL,
  `termin_vendor_2` double DEFAULT NULL,
  `termin_vendor_2_date` date DEFAULT NULL,
  `termin_vendor_3` double DEFAULT NULL,
  `termin_vendor_3_date` date DEFAULT NULL,
  `termin_vendor_4` double DEFAULT NULL,
  `termin_vendor_4_date` date DEFAULT NULL,
  `termin_vendor_5` double DEFAULT NULL,
  `termin_vendor_5_date` date DEFAULT NULL,
  `payment_retention_date` date DEFAULT NULL,
  `vendor_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `service_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_user_id` bigint(20) DEFAULT NULL,
  `consultation_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_value` double DEFAULT NULL,
  `amount_spk_vendor_net` double DEFAULT NULL,
  `termin_customer_count` double DEFAULT NULL,
  `termin_vendor_count` double DEFAULT NULL,
  `other_expanse` double DEFAULT NULL,
  `rating_admin` double DEFAULT NULL,
  `rating_vendor` double DEFAULT NULL,
  `rating_customer` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_projects`
--

INSERT INTO `wp_projects` (`id`, `user_id`, `vendor_user_id`, `order_number`, `room_id`, `description`, `images`, `estimated_budget`, `amount_spk_customer_gross`, `amount_spk_customer`, `amount_spk_vendor`, `material_buy`, `mitraruma_discount`, `applicator_discount`, `commision`, `total_expanse`, `expanse_note`, `project_note`, `term_payment_customer`, `booking_fee`, `termin_customer_1`, `termin_customer_1_date`, `termin_customer_2`, `termin_customer_2_date`, `termin_customer_3`, `termin_customer_3_date`, `termin_customer_4`, `termin_customer_4_date`, `termin_customer_5`, `termin_customer_5_date`, `term_payment_vendor`, `termin_vendor_1`, `termin_vendor_1_date`, `termin_vendor_2`, `termin_vendor_2_date`, `termin_vendor_3`, `termin_vendor_3_date`, `termin_vendor_4`, `termin_vendor_4_date`, `termin_vendor_5`, `termin_vendor_5_date`, `payment_retention_date`, `vendor_name`, `vendor_contact`, `customer_name`, `customer_contact`, `province`, `city`, `district`, `sub_district`, `zipcode`, `street`, `status`, `sub_status`, `created_at`, `updated_at`, `deleted_at`, `service_type`, `admin_user_id`, `consultation_id`, `admin_name`, `room_number`, `project_value`, `amount_spk_vendor_net`, `termin_customer_count`, `termin_vendor_count`, `other_expanse`, `rating_admin`, `rating_vendor`, `rating_customer`) VALUES
(1, 307, 308, '21212', '23212', 'apa', NULL, 20000, 20000, 18000, 16000, 100, 100, NULL, 100, 100, 'sdsd', NULL, '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Applikator', '08928392112', 'Hendrik', '08372837821', NULL, NULL, NULL, NULL, NULL, 'Bogor', 'pre-purchase', '', '2021-08-22 17:00:00', '2021-08-23 05:44:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 307, 308, '21213', '23213', 'apa 2', NULL, 30000, 20000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Applikator', '08928392112', 'Hendra', '08232837825', NULL, NULL, NULL, NULL, NULL, 'Jakarta', 'pre-purchase', '', '2021-08-22 17:00:00', NULL, NULL, NULL, NULL, '79194c2c6c96465b9eaf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 323, NULL, '6053561', 'e2c96c4006424f56ac0c', 'Renovasi dapur', NULL, 12000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Hendrik', '+628569908866', NULL, NULL, NULL, NULL, NULL, 'Jalan jatiwaringin no 666, pondok gede', 'pre-purchase', 'pre-purchase', '2021-08-24 20:09:04', '2021-08-24 20:09:04', NULL, 'SERVICE', 324, 'b5388f9092614afc9dc9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 333, NULL, '6712529', '9b16eabbf80741dfb6fc', 'Renovasi dapur', NULL, 12000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ds sss', '+628569908866', NULL, NULL, NULL, NULL, NULL, 'Jalan jatiwaringin no 666, pondok gede', 'pre-purchase', 'pre-purchase', '2021-08-24 21:11:16', '2021-08-24 21:11:16', NULL, 'SERVICE', 324, '07ca71e3d2b749fdaa89', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 333, NULL, '7871827', 'f14f7dd90d244c64bdb2', 'Renovasi dapur', NULL, 12000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ds sss', '+628569908866', NULL, NULL, NULL, NULL, NULL, 'Jalan jatiwaringin no 666, pondok gede', 'pre-purchase', 'pre-purchase', '2021-08-24 22:49:15', '2021-08-24 22:49:15', NULL, 'SERVICE', 324, 'e9d9e4cc65544ef68abc', 'Admin', '8083317', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 528, NULL, '6300884', '689226f4ca72411e8710', 'Renovasi dapur', NULL, 12000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Hendrik', '+628569908866', NULL, NULL, NULL, NULL, NULL, 'Jalan jatiwaringin no 666, pondok gede', 'pre-purchase', 'pre-purchase', '2021-09-06 09:43:29', '2021-09-06 09:43:29', NULL, 'SERVICE', 324, '00659ef9aa4544bf9717', 'Admin', 'AC-3589117', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wp_users`
--

CREATE TABLE `wp_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL,
  `user_activation_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_picture_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`, `user_picture_url`, `user_type`, `user_phone_number`, `created_at`, `updated_at`, `password`, `company_name`, `deleted_at`) VALUES
(323, '+6288211982955@gmail.com', '', '', '+6288211982955@gmail.com', '', '2021-08-24 16:44:28', '', 1, 'Hendrik', 'images/img-customer.jpeg', 'customer', '+6288211982955', '2021-08-24 09:44:46', '2021-08-24 10:41:58', '$2y$10$FYnBoujG24ymGtvu78tyyutrMWggPu17rGyvUcP8IpOrwGrD/q432', NULL, NULL),
(324, '+6288211982922@gmail.com', '', '', '+6288211982922@gmail.com', '', '2021-08-24 17:45:07', '', 1, 'Admin', 'images/img-customer.jpeg', 'admin', '+6288211982922', '2021-08-24 10:45:07', '2021-08-24 10:45:07', '$2y$10$CuN.fx.ZcljXMyRC6Ari2eyAvkFx0L2miXZU/apMxY7HGP8zwXsx2', NULL, NULL),
(327, '+6288211984956@gmail.com', '', '388', '+6288211984956@gmail.com', '', '2021-08-25 03:31:28', '', 1, 'Hendrik', 'images/img-customer.jpeg', 'customer', '+6288211984956', '2021-08-24 20:31:28', '2021-08-24 20:31:28', '$2y$10$kZsvmytq9iV7XB1FORuWC.anUNtIr8isa3ipaITsmaGRzExOvszKK', NULL, NULL),
(328, '+6288211984944@gmail.com', '', '484', '+6288211984944@gmail.com', '', '2021-08-25 03:34:16', '', 1, 'Hendrik', 'images/img-customer.jpeg', 'customer', '+6288211984944', '2021-08-24 20:34:16', '2021-08-24 20:34:16', '$2y$10$HfQWDxom5L5K6w0GR.Dv5OPYyY.p7SMjRHghgR7r9KybpaZ.hMgga', NULL, NULL),
(333, '+62882119849552@gmail.com', '', '487', '+6288211984933@gmail.com', '', '2021-08-25 00:00:00', '', 1, 'Kevin', '/images/img-customer.jpeg', 'vendor', '+62882119849552', '2021-08-24 21:10:26', '2021-08-24 21:10:26', '$2y$10$R5Rh3VWEfa5uUsSTI1zMAuFPzXFvZQu8Bl0Kjl2qdLtMwUaiDNaOW', '', NULL),
(366, 'admin@mitraruma.com', '', '', 'admin@mitraruma.com', '', '2021-08-25 00:00:00', '', 1, 'Admin', '/images/img-customer.jpeg', 'admin', '+62895605113577', '2021-08-24 20:59:24', '2021-08-24 20:59:24', '$2y$10$Ozm5lLFDYNTLp0CvhEEO9OZsOwJ0hzH5IpNGxU0Pb8c...', '', NULL),
(530, '+6288211984966@gmail.com', '', '485', '+6288211984966@gmail.com', '', '2021-08-25 00:00:00', '', 1, 'Berkah Vendor', '/images/img-customer.jpeg', 'vendor', '+6288211984966', '2021-08-24 21:05:57', '2021-08-24 21:05:57', '$2y$10$Ozm5lLFDYNTLp0CvhEEO9OZsOwJ0hzH5IpNGxU0Pb8cIJCMpjQQ1K', '', NULL),
(976, '+6288211984933@gmail.com', '', '487', '+6288211984933@gmail.com', '', '2021-09-06 00:00:00', '', 1, 'ds sss', '/images/img-customer.jpeg', 'customer', '+6288211984933', '2021-09-06 09:35:30', '2021-09-06 09:35:30', '$2y$10$bKMOvSDzGe6j7l597KbGxeNHYksFGBqz9ne4nwLjlxde0Yztqb6dG', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wp_user_addresses`
--

CREATE TABLE `wp_user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_user_extension_attributes`
--

CREATE TABLE `wp_user_extension_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_user_extension_attributes`
--

INSERT INTO `wp_user_extension_attributes` (`id`, `user_id`, `name`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 320, 'SKILLSET', '[\"Renovasi Kamar Mandi\"]', '2021-08-24 07:06:26', '2021-08-24 07:06:26', NULL),
(2, 320, 'Coverage', '[\"Kota Banda Aceh\"]', '2021-08-24 07:06:26', '2021-08-24 07:06:26', NULL),
(3, 321, 'SKILLSET', '[\"Renovasi Kamar Mandi\"]', '2021-08-24 07:12:24', '2021-08-24 07:12:24', NULL),
(4, 321, 'Coverage', '[\"Kota Banda Aceh\"]', '2021-08-24 07:12:25', '2021-08-24 07:12:25', NULL),
(5, 322, 'SKILLSET', '[\"Renovasi Kamar Mandi\"]', '2021-08-24 07:15:20', '2021-08-24 07:15:20', NULL),
(6, 322, 'Coverage', '[\"Kota Banda Aceh\"]', '2021-08-24 07:15:20', '2021-08-24 07:15:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wp_user_notifications`
--

CREATE TABLE `wp_user_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chat_room_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_user_notifications`
--

INSERT INTO `wp_user_notifications` (`id`, `user_id`, `type`, `chat_room_id`, `created_at`, `updated_at`, `text`, `is_read`) VALUES
(1, 528, 'notification', '1c688797d3ed48dd8337', '2021-08-30 18:20:35', '2021-08-31 08:11:03', 'Selected Applicator join the conversation', 1),
(2, 528, 'notification', '1c688797d3ed48dd8337', '2021-08-29 18:20:36', '2021-08-31 08:12:39', 'Selected Applicator join the conversation', 1),
(3, 474, 'notification', '5108b3b978794a599ee9', '2021-09-06 05:22:55', '2021-09-06 05:22:55', 'Booking Fee Paid', 0),
(4, 366, 'notification', '5108b3b978794a599ee9', '2021-09-06 05:22:56', '2021-09-06 05:22:56', 'Booking Fee Paid', 0),
(5, 474, 'notification', '5108b3b978794a599ee9', '2021-09-06 05:27:23', '2021-09-06 05:27:23', 'Booking Fee Paid', 0),
(6, 366, 'notification', '5108b3b978794a599ee9', '2021-09-06 05:27:23', '2021-09-06 05:27:23', 'Booking Fee Paid', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_user_tokens`
--

CREATE TABLE `wp_user_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `device_token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_postal_code_data`
--
ALTER TABLE `db_postal_code_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_postal_code` (`postal_code`);

--
-- Indexes for table `db_province_data`
--
ALTER TABLE `db_province_data`
  ADD UNIQUE KEY `province_code` (`province_code`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `wp_cms`
--
ALTER TABLE `wp_cms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wp_cms_name_unique` (`name`);

--
-- Indexes for table `wp_otps`
--
ALTER TABLE `wp_otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_projects`
--
ALTER TABLE `wp_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_users`
--
ALTER TABLE `wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `wp_users_user_phone_number_unique` (`user_phone_number`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `wp_user_addresses`
--
ALTER TABLE `wp_user_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_user_extension_attributes`
--
ALTER TABLE `wp_user_extension_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_user_notifications`
--
ALTER TABLE `wp_user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_user_tokens`
--
ALTER TABLE `wp_user_tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `db_postal_code_data`
--
ALTER TABLE `db_postal_code_data`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81249;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `wp_cms`
--
ALTER TABLE `wp_cms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_otps`
--
ALTER TABLE `wp_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `wp_projects`
--
ALTER TABLE `wp_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wp_users`
--
ALTER TABLE `wp_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=977;

--
-- AUTO_INCREMENT for table `wp_user_addresses`
--
ALTER TABLE `wp_user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_user_extension_attributes`
--
ALTER TABLE `wp_user_extension_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wp_user_notifications`
--
ALTER TABLE `wp_user_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wp_user_tokens`
--
ALTER TABLE `wp_user_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
