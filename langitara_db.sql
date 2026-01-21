-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 12, 2026 at 02:14 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `langitara_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `actor_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `actor_id` bigint UNSIGNED NOT NULL,
  `actor_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` bigint UNSIGNED DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `actor_type`, `actor_id`, `actor_name`, `action`, `entity_type`, `entity_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 'user', 1, NULL, 'Registered new account', NULL, NULL, NULL, NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(2, 'user', 1, NULL, 'Created invitation Draft', NULL, NULL, NULL, NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(3, 'admin', 1, NULL, 'Approved payment #ORD-001', NULL, NULL, NULL, NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(4, 'user', 2, NULL, 'Submitted RSVP', NULL, NULL, NULL, NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(5, 'system', 0, 'System', 'view', 'Rsvp', 5, 'Viewed details of RSVP #5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2026-01-06 23:02:05', '2026-01-06 23:02:05'),
(6, 'system', 0, 'System', 'view', 'Rsvp', 1, 'Viewed details of RSVP #1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2026-01-06 23:02:09', '2026-01-06 23:02:09'),
(7, 'admin', 6, 'RANDY FAUZI', 'change_package', 'User', 6, 'Changed user package to Super Exclusive', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2026-01-10 01:44:47', '2026-01-10 01:44:47'),
(8, 'admin', 6, 'RANDY FAUZI', 'update', 'User', 6, 'Changed user status to suspended', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2026-01-10 01:44:48', '2026-01-10 01:44:48'),
(9, 'admin', 6, 'RANDY FAUZI', 'update', 'User', 6, 'Changed user status to active', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2026-01-10 01:44:51', '2026-01-10 01:44:51');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin','support') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@langitara.com', '$2y$12$2CrLXJEjjO.wXGkH78zvmOMas5OpgHHsZ5QU.ayOBhEOAsMsxTAs.', 'super_admin', '2026-01-06 05:01:30', '2026-01-06 05:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint UNSIGNED NOT NULL,
  `invitation_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `invitation_id`, `name`, `phone`, `category`, `created_at`, `updated_at`) VALUES
(1, 1, 'Guest 0 for Kristofer Greenholt', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(2, 1, 'Guest 1 for Kristofer Greenholt', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(3, 1, 'Guest 2 for Kristofer Greenholt', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(4, 1, 'Guest 3 for Kristofer Greenholt', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(5, 1, 'Guest 4 for Kristofer Greenholt', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(6, 2, 'Guest 0 for Zoey Carter', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(7, 2, 'Guest 1 for Zoey Carter', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(8, 2, 'Guest 2 for Zoey Carter', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(9, 2, 'Guest 3 for Zoey Carter', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(10, 2, 'Guest 4 for Zoey Carter', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(11, 3, 'Guest 0 for Avis Cruickshank', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(12, 3, 'Guest 1 for Avis Cruickshank', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(13, 3, 'Guest 2 for Avis Cruickshank', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(14, 3, 'Guest 3 for Avis Cruickshank', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(15, 3, 'Guest 4 for Avis Cruickshank', NULL, NULL, '2026-01-06 05:01:30', '2026-01-06 05:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

CREATE TABLE `invitations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `template_id` bigint UNSIGNED DEFAULT NULL,
  `package_id` bigint UNSIGNED DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `active_sections` json DEFAULT NULL,
  `groom_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groom_nickname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groom_father` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groom_mother` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groom_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bride_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bride_nickname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bride_father` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bride_mother` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bride_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `music_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quote_text` text COLLATE utf8mb4_unicode_ci,
  `quote_author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akad_date` datetime DEFAULT NULL,
  `akad_location` text COLLATE utf8mb4_unicode_ci,
  `akad_address` text COLLATE utf8mb4_unicode_ci,
  `akad_map_link` text COLLATE utf8mb4_unicode_ci,
  `resepsi_date` datetime DEFAULT NULL,
  `resepsi_location` text COLLATE utf8mb4_unicode_ci,
  `resepsi_address` text COLLATE utf8mb4_unicode_ci,
  `resepsi_map_link` text COLLATE utf8mb4_unicode_ci,
  `love_stories` json DEFAULT NULL,
  `gallery_photos` json DEFAULT NULL,
  `bank_accounts` json DEFAULT NULL,
  `gift_address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invitations`
--

INSERT INTO `invitations` (`id`, `user_id`, `template_id`, `package_id`, `slug`, `title`, `status`, `active_sections`, `groom_name`, `groom_nickname`, `groom_father`, `groom_mother`, `groom_photo`, `bride_name`, `bride_nickname`, `bride_father`, `bride_mother`, `bride_photo`, `cover_image`, `music_path`, `quote_text`, `quote_author`, `akad_date`, `akad_location`, `akad_address`, `akad_map_link`, `resepsi_date`, `resepsi_location`, `resepsi_address`, `resepsi_map_link`, `love_stories`, `gallery_photos`, `bank_accounts`, `gift_address`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 1, 'sasuke-hinata-5z2qe', 'Sasuke & Hinata', 'draft', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-11 01:51:12', '2026-01-11 01:51:12'),
(2, 6, 1, 1, 'sasuke-hinata-cwavp', 'Sasuke & Hinata', 'draft', '[\"cover\", \"couple\", \"events\", \"gallery\", \"wishes\", \"quote\", \"music\", \"story\"]', 'Uciha Sasuke', 'Sasuke', 'kabuto', 'karin', 'http://127.0.0.1:8000/uploads/invitations/2_randy-fauzi/1768122892_groom_photo_randy-fauzi.jpg', 'Hinata Haruno', 'Hinta', 'Minato', 'Kurinai', 'http://127.0.0.1:8000/uploads/invitations/2_randy-fauzi/1768122918_bride_photo_randy-fauzi.jpg', 'http://127.0.0.1:8000/uploads/invitations/2_randy-fauzi/1768122954_cover_image_randy-fauzi.jpg', 'assets/music/free/1767790957_romantic.mp3', 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya diantaramu rasa kasih dan sayang.', 'QS. Ar-Rum: 21', '2026-01-12 16:16:00', 'Gedung Hokage', 'Gedung utama Hokage desa konoha', 'https://maps.google.com/maps?sca_esv=21fd1ad54828f0e3&output=search&q=google+maps+rumah+randy+sungai+anda&source=lnms&fbs=ADc_l-bPe-8sZSFDp1q7-UZ4_rZodBf_CxTT0J87GnJdrGhbMZDkOPiZtwbuhspNjAk9xU_IIr0FXE3ySmjjhrPovBUTBTR3_96_cA71tgy-TfMQGvLNr6qtQnia-PTpVDCIEokZyjQPGnlxLl7iSiwn8jsk9bmEUjtHjRQDSRBtBKaX9YQZ8HwuRutHhDkcNvXomuOVjZxMBY8gdZ-m61_nN2E7oXLtnA&entry=mc&ved=1t:200715&ictx=111', '2026-01-11 16:27:00', 'Gedung Hokage', 'Gedung utama Hokage desa konoha', 'https://maps.google.com/maps?sca_esv=21fd1ad54828f0e3&output=search&q=google+maps+rumah+randy+sungai+anda&source=lnms&fbs=ADc_l-bPe-8sZSFDp1q7-UZ4_rZodBf_CxTT0J87GnJdrGhbMZDkOPiZtwbuhspNjAk9xU_IIr0FXE3ySmjjhrPovBUTBTR3_96_cA71tgy-TfMQGvLNr6qtQnia-PTpVDCIEokZyjQPGnlxLl7iSiwn8jsk9bmEUjtHjRQDSRBtBKaX9YQZ8HwuRutHhDkcNvXomuOVjZxMBY8gdZ-m61_nN2E7oXLtnA&entry=mc&ved=1t:200715&ictx=111', '[{\"year\": \"2020\", \"story\": \"Kami memutusakan bercerai dari pasangna kami sebelumnya dan menikah\", \"title\": \"Pasca Perang Ninja\"}, {\"year\": \"2021\", \"story\": \"kami bersyukur dan akhrinya segera menikah\", \"title\": \"Pengangkatan Naruto jadi Hokage\"}]', '[]', '[{\"bank_name\": \"BCA\", \"account_name\": \"SASKUKE\", \"account_number\": \"12345678\"}]', 'NO 1', '2026-01-11 01:56:00', '2026-01-11 02:37:27');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_100000_create_langitara_schema', 1),
(5, '2026_01_07_031716_create_promos_table', 2),
(6, '2026_01_07_063523_update_activity_logs_table', 3),
(7, '2026_01_07_082554_update_templates_and_create_assets_table', 4),
(8, '2026_01_07_120428_create_songs_table', 5),
(9, '2026_01_07_132559_add_role_to_users_table', 6),
(10, '2026_01_09_143000_create_editor_schema_tables', 7),
(11, '2026_01_09_131418_update_packages_table_add_features', 8),
(12, '2026_01_10_064509_create_user_packages_table', 9),
(13, '2026_01_11_022758_create_promos_table', 10),
(14, '2026_01_11_025726_add_message_to_rsvps_table', 11),
(15, '2026_01_11_032631_add_json_columns_to_invitation_details_table', 12),
(16, '2026_01_11_065755_consolidate_invitation_structure_to_single_json', 13),
(17, '2026_01_11_081440_add_hybrid_columns_to_invitations_table', 14),
(18, '2026_01_11_084541_rebuild_invitations_schema_and_create_rsvps', 15);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `invitation_id` bigint UNSIGNED DEFAULT NULL,
  `package_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','paid','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `invitation_id`, `package_id`, `amount`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 99000.00, 'paid', '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(2, 2, 2, 2, 99000.00, 'paid', '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(3, 3, 3, 2, 99000.00, 'paid', '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(4, 4, 4, 2, 99000.00, 'pending', '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(5, 5, 5, 2, 99000.00, 'pending', '2026-01-06 05:01:30', '2026-01-06 05:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(12,2) DEFAULT NULL,
  `duration_days` int NOT NULL,
  `max_invitations` int NOT NULL,
  `max_guests` int NOT NULL,
  `features` json DEFAULT NULL,
  `can_publish` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `slug`, `description`, `price`, `original_price`, `duration_days`, `max_invitations`, `max_guests`, `features`, `can_publish`, `is_featured`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Free', 'free', 'Coba gratis tanpa biaya', 0.00, NULL, 0, 1, 50, '[\"1 Undangan\", \"Akses Template Basic\", \"Tidak Bisa Publish\"]', 0, 0, 1, 'active', '2026-01-09 05:17:23', '2026-01-09 05:17:23'),
(2, 'Premium', 'premium', 'Paket terlaris untuk acara spesial', 49500.00, 80000.00, 14, 1, 999999, '[\"1 Undangan\", \"Unlimited Tamu\", \"Music Digital\", \"Amplop Digital\", \"Template Premium\", \"Durasi Aktivasi: 14 hari\"]', 1, 0, 2, 'active', '2026-01-09 05:17:23', '2026-01-09 21:51:09'),
(3, 'Exclusive', 'exclusive', 'Fitur lengkap untuk acara istimewa', 89000.00, 100000.00, 30, 1, 999999, '[\"1 Undangan\", \"Unlimited Tamu\", \"Music Digital\", \"Amplop Digital\", \"Template Premium + Exclusive\", \"Durasi Aktivasi: 30 hari\"]', 1, 1, 3, 'active', '2026-01-09 05:17:23', '2026-01-09 21:51:09'),
(4, 'Super Exclusive', 'super-exclusive', 'Paket super lengkap untuk multiple event', 199000.00, 220000.00, 60, 3, 999999, '[\"3 Undangan\", \"Unlimited Tamu\", \"Music Digital\", \"Amplop Digital\", \"Template Premium + Exclusive\", \"Durasi Aktivasi: 60 hari\", \"Selfie Check-in (coming soon)\"]', 1, 0, 4, 'active', '2026-01-09 05:17:23', '2026-01-09 05:17:23'),
(5, 'Partnership', 'partnership', 'Solusi untuk vendor & bisnis wedding', 4999000.00, NULL, 365, 999999, 999999, '[\"White Label: Branding Anda sendiri\", \"Undangan Digital Custom\", \"Unlimited Undangan\", \"Multiple Guests (500+ per event)\", \"Integrasi Tambahan (CRM)\", \"Selfie Check-in (coming soon)\", \"Pelaporan & Analitik\", \"Dedicated Support\"]', 1, 0, 5, 'active', '2026-01-09 05:17:23', '2026-01-09 05:21:03');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` enum('percentage','fixed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL,
  `target_packages` json DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`id`, `title`, `description`, `code`, `discount_type`, `discount_value`, `target_packages`, `start_date`, `end_date`, `status`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 'Opening Sale Special', 'Diskon spesial grand opening Langitara untuk semua paket.', 'OPENING50', 'percentage', 50.00, '[\"all\"]', '2026-01-06 03:31:10', '2026-02-06 03:31:10', 'active', NULL, '2026-01-06 19:31:10', '2026-01-06 19:31:10'),
(2, 'Potongan 20 Ribu', 'Potongan langsung untuk pengguna baru.', 'HEMAT20', 'fixed', 20000.00, '[\"all\"]', '2026-01-07 03:31:10', '2026-01-21 03:31:10', 'active', NULL, '2026-01-06 19:31:10', '2026-01-06 19:31:10'),
(3, 'Exclusive Wedding Season', 'Upgrade ke paket Exclusive lebih hemat.', 'LUXURYWED', 'percentage', 30.00, '[\"all\"]', '2026-01-07 03:31:10', '2026-02-07 03:31:10', 'inactive', NULL, '2026-01-06 19:31:10', '2026-01-06 19:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `rsvps`
--

CREATE TABLE `rsvps` (
  `id` bigint UNSIGNED NOT NULL,
  `invitation_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL DEFAULT '1',
  `status` enum('hadir','tidak_hadir','ragu') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hadir',
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8Mg4DvXeF2ozyjuLQWGpp5lh2iN9nVFsS5X0lA3c', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS1F4ZTBLRTZmc1FDU1FZdTJ6SXMzRU9lSzBzSVFWSERpZmZLUUsyayI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjY4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvaW52aXRhdGlvbi9zYXN1a2UtaGluYXRhLWN3YXZwP3Q9MTc2ODEyNDI0NzYzMSI7czo1OiJyb3V0ZSI7czoyMjoicHVibGljLmludml0YXRpb24uc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7fQ==', 1768124247);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `artist` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int DEFAULT NULL,
  `is_premium` tinyint(1) NOT NULL DEFAULT '0',
  `min_package_level` enum('free','basic','premium','exclusive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'free',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `category`, `file_path`, `duration`, `is_premium`, `min_package_level`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Beautifull in White', 'Shane Fillan', 'romantic', 'assets/music/free/1767790957_romantic.mp3', NULL, 0, 'free', 'active', '2026-01-07 05:02:37', '2026-01-07 05:03:22'),
(2, 'Randy - Tes Song', 'Rony', 'romantic', 'assets/music/free/1767949762_cac90b5c-c0a6-4097-b26b-c6ea0d954ac2.mp3', NULL, 0, 'free', 'active', '2026-01-09 01:09:22', '2026-01-09 01:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `style` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folder_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_premium` tinyint(1) NOT NULL DEFAULT '0',
  `package_access` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'free' COMMENT 'free, premium, exclusive, wo',
  `supported_features` json DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `slug`, `category`, `style`, `preview_image_path`, `folder_name`, `base_path`, `is_premium`, `package_access`, `supported_features`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Gardenia Love', 'gardenia-love', 'floral', NULL, NULL, 'gardenia-love', 'templates/gardenia-love', 1, 'exclusive', NULL, 'active', '2026-01-06 05:01:30', '2026-01-07 03:33:39'),
(2, 'Modern Ivory', NULL, 'Minimalist', NULL, NULL, 'ivory', NULL, 1, 'free', NULL, 'active', '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(3, 'Ocean Blue', NULL, 'Nature', NULL, NULL, 'ocean', NULL, 1, 'free', NULL, 'active', '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(5, 'Basic Theme', NULL, 'Free', NULL, NULL, 'basic', NULL, 0, 'free', NULL, 'active', '2026-01-10 22:52:04', '2026-01-10 22:52:04');

-- --------------------------------------------------------

--
-- Table structure for table `template_assets`
--

CREATE TABLE `template_assets` (
  `id` bigint UNSIGNED NOT NULL,
  `template_id` bigint UNSIGNED DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal',
  `license_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `allowed_usage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'template-only',
  `uploader_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','suspended') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `status`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Kristofer Greenholt', 'ygerlach@example.com', NULL, '2026-01-06 05:01:30', '$2y$12$4gaAKS8hUx8aINTAZPd8Ru5kkE812Ki6xe2VKBUTw1ToHOE9p8KyW', 'active', 'user', 'BJnnKr0N2g', '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(2, 'Zoey Carter', 'pearline.bogan@example.net', NULL, '2026-01-06 05:01:30', '$2y$12$4gaAKS8hUx8aINTAZPd8Ru5kkE812Ki6xe2VKBUTw1ToHOE9p8KyW', 'active', 'user', 'xJeE51PRXn', '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(3, 'Avis Cruickshank', 'senger.kenny@example.net', NULL, '2026-01-06 05:01:30', '$2y$12$4gaAKS8hUx8aINTAZPd8Ru5kkE812Ki6xe2VKBUTw1ToHOE9p8KyW', 'active', 'user', 'JJKZSDjtAu', '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(4, 'Mr. Aidan Berge II', 'kamron37@example.net', NULL, '2026-01-06 05:01:30', '$2y$12$4gaAKS8hUx8aINTAZPd8Ru5kkE812Ki6xe2VKBUTw1ToHOE9p8KyW', 'active', 'user', 'J3mtJkxbaJ', '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(5, 'Else Dibbert', 'ncartwright@example.org', NULL, '2026-01-06 05:01:30', '$2y$12$4gaAKS8hUx8aINTAZPd8Ru5kkE812Ki6xe2VKBUTw1ToHOE9p8KyW', 'active', 'user', 'rglPK2ipJi', '2026-01-06 05:01:30', '2026-01-06 05:01:30'),
(6, 'RANDY FAUZI', 'randyfauzi24@gmail.com', '0895366583095', NULL, '$2y$12$5b0fteYr7hk6DFxVYykhF.n7w2E8OpUpxgvcdmRqyf2QBzeAkgdOS', 'active', 'admin', NULL, '2026-01-07 05:31:39', '2026-01-10 19:42:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_packages`
--

CREATE TABLE `user_packages` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `package_id` bigint UNSIGNED NOT NULL,
  `order_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','active','expired','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `amount` decimal(12,2) NOT NULL,
  `payment_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `midtrans_response` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_packages`
--

INSERT INTO `user_packages` (`id`, `user_id`, `package_id`, `order_id`, `transaction_id`, `status`, `amount`, `payment_type`, `paid_at`, `expiry_date`, `midtrans_response`, `created_at`, `updated_at`) VALUES
(11, 6, 1, 'FREE-6-1768031260', NULL, 'cancelled', 0.00, 'free', '2026-01-09 23:47:40', NULL, NULL, '2026-01-09 23:47:40', '2026-01-10 01:42:15'),
(16, 6, 2, 'LGT-6-1768031612', NULL, 'cancelled', 49500.00, NULL, NULL, NULL, NULL, '2026-01-09 23:53:32', '2026-01-10 00:30:00'),
(17, 6, 2, 'LGT-6-1768031665', NULL, 'cancelled', 49500.00, NULL, NULL, NULL, NULL, '2026-01-09 23:54:25', '2026-01-10 00:25:42'),
(18, 6, 2, 'LGT-6-1768031722', NULL, 'cancelled', 49500.00, NULL, NULL, NULL, NULL, '2026-01-09 23:55:22', '2026-01-10 00:25:41'),
(19, 6, 4, 'LGT-6-1768032958', NULL, 'cancelled', 199000.00, NULL, NULL, NULL, NULL, '2026-01-10 00:15:58', '2026-01-10 00:25:40'),
(20, 6, 4, 'LGT-6-1768032965', NULL, 'cancelled', 199000.00, NULL, NULL, NULL, NULL, '2026-01-10 00:16:05', '2026-01-10 00:25:39'),
(21, 6, 4, 'LGT-6-1768033008', NULL, 'cancelled', 199000.00, NULL, NULL, NULL, NULL, '2026-01-10 00:16:48', '2026-01-10 00:25:37'),
(22, 6, 1, 'FREE-6-1768033031', NULL, 'cancelled', 0.00, 'free', '2026-01-10 00:17:11', NULL, NULL, '2026-01-10 00:17:11', '2026-01-10 01:42:15'),
(23, 6, 4, 'ADMIN-SSN5X64N-1768038287', NULL, 'active', 199000.00, NULL, '2026-01-10 01:44:47', '2026-03-11', NULL, '2026-01-10 01:44:47', '2026-01-10 01:44:47'),
(24, 6, 4, 'LGT-6-1768099333', NULL, 'pending', 199000.00, NULL, NULL, NULL, NULL, '2026-01-10 19:42:13', '2026-01-10 19:42:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guests_invitation_id_foreign` (`invitation_id`);

--
-- Indexes for table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invitations_slug_unique` (`slug`),
  ADD KEY `invitations_user_id_foreign` (`user_id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_invitation_id_foreign` (`invitation_id`),
  ADD KEY `orders_package_id_foreign` (`package_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rsvps`
--
ALTER TABLE `rsvps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rsvps_invitation_id_foreign` (`invitation_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `templates_slug_unique` (`slug`);

--
-- Indexes for table `template_assets`
--
ALTER TABLE `template_assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_assets_template_id_foreign` (`template_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_packages`
--
ALTER TABLE `user_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_packages_order_id_unique` (`order_id`),
  ADD KEY `user_packages_user_id_foreign` (`user_id`),
  ADD KEY `user_packages_package_id_foreign` (`package_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rsvps`
--
ALTER TABLE `rsvps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `template_assets`
--
ALTER TABLE `template_assets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_packages`
--
ALTER TABLE `user_packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guests`
--
ALTER TABLE `guests`
  ADD CONSTRAINT `guests_invitation_id_foreign` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invitations`
--
ALTER TABLE `invitations`
  ADD CONSTRAINT `invitations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_invitation_id_foreign` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`),
  ADD CONSTRAINT `orders_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`),
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `rsvps`
--
ALTER TABLE `rsvps`
  ADD CONSTRAINT `rsvps_invitation_id_foreign` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `template_assets`
--
ALTER TABLE `template_assets`
  ADD CONSTRAINT `template_assets_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_packages`
--
ALTER TABLE `user_packages`
  ADD CONSTRAINT `user_packages_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_packages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
