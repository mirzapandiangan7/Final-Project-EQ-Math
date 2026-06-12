-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 12, 2026 at 01:15 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eq_math`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_causer_id_foreign` (`causer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `log_name`, `description`, `event`, `causer_id`, `causer_type`, `subject_type`, `subject_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, NULL, 'created pengajar', NULL, 1, 'App\\Models\\User', 'App\\Models\\MasterPengajar', 1, '{\"attributes\": {\"id\": 1, \"created_at\": \"2026-06-03T13:11:17.000000Z\", \"updated_at\": \"2026-06-03T13:11:17.000000Z\", \"nama_pengajar\": \"Bambang\"}}', NULL, '2026-06-03 13:11:17', '2026-06-03 13:11:17'),
(2, NULL, 'created kelas', NULL, 1, 'App\\Models\\User', 'App\\Models\\MasterKelas', 1, '{\"attributes\": {\"id\": 1, \"harga\": \"150000\", \"jenjang\": \"SMA\", \"deskripsi\": \"JOSJIS\", \"created_at\": \"2026-06-04T07:33:23.000000Z\", \"nama_kelas\": \"Matematika lanjut\", \"updated_at\": \"2026-06-04T07:33:23.000000Z\"}}', NULL, '2026-06-04 07:33:23', '2026-06-04 07:33:23'),
(3, NULL, 'created jadwal', NULL, 1, 'App\\Models\\User', 'App\\Models\\JadwalKelas', 1, '{\"attributes\": {\"id\": 1, \"hari\": \"Senin\", \"status\": \"upcoming\", \"kelas_id\": \"1\", \"jam_mulai\": \"07:00\", \"created_at\": \"2026-06-04T07:33:41.000000Z\", \"updated_at\": \"2026-06-04T07:33:41.000000Z\", \"jam_selesai\": \"09:30\", \"pengajar_id\": \"1\", \"status_jadwal\": \"completed\"}}', NULL, '2026-06-04 07:33:41', '2026-06-04 07:33:41'),
(4, NULL, 'created jadwal', NULL, 1, 'App\\Models\\User', 'App\\Models\\JadwalKelas', 2, '{\"attributes\": {\"id\": 2, \"hari\": \"Selasa\", \"status\": \"upcoming\", \"kelas_id\": \"1\", \"jam_mulai\": \"07:00\", \"created_at\": \"2026-06-04T08:01:36.000000Z\", \"updated_at\": \"2026-06-04T08:01:36.000000Z\", \"jam_selesai\": \"09:30\", \"pengajar_id\": \"1\", \"status_jadwal\": \"completed\"}}', NULL, '2026-06-04 08:01:36', '2026-06-04 08:01:36'),
(5, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 09:29:26', '2026-06-04 09:29:26'),
(6, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 09:29:26', '2026-06-04 09:29:26'),
(7, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 09:30:05', '2026-06-04 09:30:05'),
(8, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 09:30:05', '2026-06-04 09:30:05'),
(9, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 09:30:14', '2026-06-04 09:30:14'),
(10, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 09:30:14', '2026-06-04 09:30:14'),
(11, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 09:30:22', '2026-06-04 09:30:22'),
(12, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 09:30:22', '2026-06-04 09:30:22'),
(13, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 09:50:05', '2026-06-04 09:50:05'),
(14, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 09:50:05', '2026-06-04 09:50:05'),
(15, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:05:07', '2026-06-04 10:05:07'),
(16, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:05:07', '2026-06-04 10:05:07'),
(17, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 10:05:08', '2026-06-04 10:05:08'),
(18, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 10:05:08', '2026-06-04 10:05:08'),
(19, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:05:29', '2026-06-04 10:05:29'),
(20, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:05:29', '2026-06-04 10:05:29'),
(21, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:09:46', '2026-06-04 10:09:46'),
(22, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:09:46', '2026-06-04 10:09:46'),
(23, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:09:55', '2026-06-04 10:09:55'),
(24, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:09:55', '2026-06-04 10:09:55'),
(25, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:11:13', '2026-06-04 10:11:13'),
(26, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:11:13', '2026-06-04 10:11:13'),
(27, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:11:23', '2026-06-04 10:11:23'),
(28, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:11:23', '2026-06-04 10:11:23'),
(29, NULL, 'created kelas', NULL, 1, NULL, 'App\\Models\\MasterKelas', 2, '{\"attributes\": {\"id\": 2, \"harga\": \"150000\", \"jenjang\": \"SD\", \"deskripsi\": \"yahaha\", \"created_at\": \"2026-06-04T10:11:39.000000Z\", \"nama_kelas\": \"Matematika Dasar\", \"updated_at\": \"2026-06-04T10:11:39.000000Z\"}}', NULL, '2026-06-04 10:11:39', '2026-06-04 10:11:39'),
(30, NULL, 'created jadwal', NULL, 1, NULL, 'App\\Models\\JadwalKelas', 3, '{\"attributes\": {\"id\": 3, \"hari\": \"Jumat\", \"status\": \"upcoming\", \"kelas_id\": \"2\", \"jam_mulai\": \"13:00\", \"created_at\": \"2026-06-04T10:12:12.000000Z\", \"updated_at\": \"2026-06-04T10:12:12.000000Z\", \"jam_selesai\": \"15:30\", \"pengajar_id\": \"1\", \"status_jadwal\": \"upcoming\"}}', NULL, '2026-06-04 10:12:12', '2026-06-04 10:12:12'),
(31, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:15:09', '2026-06-04 10:15:09'),
(32, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:15:09', '2026-06-04 10:15:09'),
(33, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:15:20', '2026-06-04 10:15:20'),
(34, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:15:20', '2026-06-04 10:15:20'),
(35, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:27:23', '2026-06-04 10:27:23'),
(36, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:27:23', '2026-06-04 10:27:23'),
(37, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:28:36', '2026-06-04 10:28:36'),
(38, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:28:36', '2026-06-04 10:28:36'),
(39, NULL, 'memulai proses pembayaran kelas', NULL, 2, NULL, 'App\\Models\\TransaksiPembayaran', 4, '{\"jumlah\": 152500, \"order_id\": \"EQ-1780568128-jLj18\", \"jadwal_id\": \"3\"}', NULL, '2026-06-04 10:28:40', '2026-06-04 10:28:40'),
(40, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:29:18', '2026-06-04 10:29:18'),
(41, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:29:18', '2026-06-04 10:29:18'),
(42, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:29:24', '2026-06-04 10:29:24'),
(43, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:29:24', '2026-06-04 10:29:24'),
(44, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:37:40', '2026-06-04 10:37:40'),
(45, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 10:37:40', '2026-06-04 10:37:40'),
(46, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 11:10:19', '2026-06-04 11:10:19'),
(47, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 11:10:19', '2026-06-04 11:10:19'),
(48, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 11:10:50', '2026-06-04 11:10:50'),
(49, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 11:10:50', '2026-06-04 11:10:50'),
(50, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 11:11:48', '2026-06-04 11:11:48'),
(51, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 11:11:48', '2026-06-04 11:11:48'),
(52, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 11:12:15', '2026-06-04 11:12:15'),
(53, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 11:12:15', '2026-06-04 11:12:15'),
(54, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 11:12:26', '2026-06-04 11:12:26'),
(55, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 11:12:26', '2026-06-04 11:12:26'),
(56, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 11:33:23', '2026-06-04 11:33:23'),
(57, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 11:33:23', '2026-06-04 11:33:23'),
(58, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 14:00:34', '2026-06-04 14:00:34'),
(59, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 14:00:34', '2026-06-04 14:00:34'),
(60, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 14:00:44', '2026-06-04 14:00:44'),
(61, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-04 14:00:44', '2026-06-04 14:00:44'),
(62, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 14:01:10', '2026-06-04 14:01:10'),
(63, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 14:01:10', '2026-06-04 14:01:10'),
(64, NULL, 'created jadwal', NULL, 1, NULL, 'App\\Models\\JadwalKelas', 4, '{\"attributes\": {\"id\": 4, \"hari\": \"Senin\", \"status\": \"upcoming\", \"kelas_id\": \"1\", \"jam_mulai\": \"13:00\", \"created_at\": \"2026-06-04T14:01:38.000000Z\", \"updated_at\": \"2026-06-04T14:01:38.000000Z\", \"jam_selesai\": \"15:30\", \"pengajar_id\": \"1\", \"status_jadwal\": \"completed\"}}', NULL, '2026-06-04 14:01:38', '2026-06-04 14:01:38'),
(65, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 14:01:40', '2026-06-04 14:01:40'),
(66, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 14:01:40', '2026-06-04 14:01:40'),
(67, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 14:01:47', '2026-06-04 14:01:47'),
(68, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-04 14:01:47', '2026-06-04 14:01:47'),
(69, NULL, 'memulai proses pembayaran kelas', NULL, 2, NULL, 'App\\Models\\TransaksiPembayaran', 5, '{\"jumlah\": 152500, \"order_id\": \"EQ-1780581721-H07Ge\", \"jadwal_id\": \"4\"}', NULL, '2026-06-04 14:02:03', '2026-06-04 14:02:03'),
(70, NULL, 'memulai proses pembayaran kelas', NULL, 2, NULL, 'App\\Models\\TransaksiPembayaran', 5, '{\"jumlah\": 152500, \"order_id\": \"EQ-1780581721-H07Ge\", \"jadwal_id\": \"4\"}', NULL, '2026-06-04 14:03:09', '2026-06-04 14:03:09'),
(71, NULL, 'memulai proses pembayaran kelas', NULL, 2, NULL, 'App\\Models\\TransaksiPembayaran', 5, '{\"jumlah\": 152500, \"order_id\": \"EQ-1780581721-H07Ge\", \"jadwal_id\": \"4\"}', NULL, '2026-06-04 14:03:15', '2026-06-04 14:03:15'),
(72, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-05 09:59:07', '2026-06-05 09:59:07'),
(73, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-05 09:59:07', '2026-06-05 09:59:07'),
(74, NULL, 'memulai proses pembayaran kelas', NULL, 2, NULL, 'App\\Models\\TransaksiPembayaran', 5, '{\"jumlah\": 152500, \"order_id\": \"EQ-1780581721-H07Ge\", \"jadwal_id\": \"4\"}', NULL, '2026-06-05 10:03:56', '2026-06-05 10:03:56'),
(75, NULL, 'memulai proses pembayaran kelas', NULL, 2, NULL, 'App\\Models\\TransaksiPembayaran', 5, '{\"jumlah\": 152500, \"order_id\": \"EQ-1780581721-H07Ge\", \"jadwal_id\": \"4\"}', NULL, '2026-06-05 10:04:33', '2026-06-05 10:04:33'),
(76, NULL, 'membatalkan pembayaran kelas', NULL, 2, NULL, 'App\\Models\\TransaksiPembayaran', 5, '{\"order_id\": \"EQ-1780581721-H07Ge\"}', NULL, '2026-06-05 10:04:39', '2026-06-05 10:04:39'),
(77, NULL, 'memulai proses pembayaran kelas', NULL, 2, NULL, 'App\\Models\\TransaksiPembayaran', 6, '{\"jumlah\": 152500, \"order_id\": \"EQ-1780653932-IfH3m\", \"jadwal_id\": \"4\"}', NULL, '2026-06-05 10:05:34', '2026-06-05 10:05:34'),
(78, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-05 10:26:09', '2026-06-05 10:26:09'),
(79, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-05 10:26:09', '2026-06-05 10:26:09'),
(80, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-06 07:18:07', '2026-06-06 07:18:07'),
(81, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-06 07:18:07', '2026-06-06 07:18:07'),
(82, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-06 07:20:32', '2026-06-06 07:20:32'),
(83, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-06 07:20:32', '2026-06-06 07:20:32'),
(84, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-06 07:20:43', '2026-06-06 07:20:43'),
(85, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-06 07:20:43', '2026-06-06 07:20:43'),
(86, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-06 07:26:23', '2026-06-06 07:26:23'),
(87, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-06 07:26:23', '2026-06-06 07:26:23'),
(88, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-06 07:29:17', '2026-06-06 07:29:17'),
(89, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-06 07:29:17', '2026-06-06 07:29:17'),
(90, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-06 07:29:24', '2026-06-06 07:29:24'),
(91, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0\"}', NULL, '2026-06-06 07:29:24', '2026-06-06 07:29:24'),
(92, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 07:07:41', '2026-06-11 07:07:41'),
(93, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 07:07:41', '2026-06-11 07:07:41'),
(94, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 09:39:17', '2026-06-11 09:39:17'),
(95, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 09:39:17', '2026-06-11 09:39:17'),
(96, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 11:47:27', '2026-06-11 11:47:27'),
(97, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 11:47:27', '2026-06-11 11:47:27'),
(98, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 12:04:24', '2026-06-11 12:04:24'),
(99, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 12:04:24', '2026-06-11 12:04:24'),
(100, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 12:04:38', '2026-06-11 12:04:38'),
(101, NULL, 'User logged in', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"role\": \"siswa\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 12:04:38', '2026-06-11 12:04:38'),
(102, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 12:11:01', '2026-06-11 12:11:01'),
(103, NULL, 'User logged out', NULL, 2, NULL, 'App\\Models\\User', 2, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 12:11:01', '2026-06-11 12:11:01'),
(104, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 12:12:28', '2026-06-11 12:12:28'),
(105, NULL, 'User logged in', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"role\": \"admin\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 12:12:28', '2026-06-11 12:12:28'),
(106, NULL, 'updated profile', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"old\": {\"email\": \"admin@eqmath.com\", \"no_wa\": \"12345678\", \"nama_lengkap\": \"admin\"}, \"attributes\": {\"email\": \"admin@eqmath.com\", \"no_wa\": \"12345678\", \"nama_lengkap\": \"admin\"}}', NULL, '2026-06-11 12:12:59', '2026-06-11 12:12:59'),
(107, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 12:13:12', '2026-06-11 12:13:12'),
(108, NULL, 'User logged out', NULL, 1, NULL, 'App\\Models\\User', 1, '{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36\"}', NULL, '2026-06-11 12:13:12', '2026-06-11 12:13:12');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kelas`
--

DROP TABLE IF EXISTS `jadwal_kelas`;
CREATE TABLE IF NOT EXISTS `jadwal_kelas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `pengajar_id` bigint UNSIGNED NOT NULL,
  `hari` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status` enum('active','upcoming','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_kelas_kelas_id_foreign` (`kelas_id`),
  KEY `jadwal_kelas_pengajar_id_foreign` (`pengajar_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_kelas`
--

INSERT INTO `jadwal_kelas` (`id`, `kelas_id`, `pengajar_id`, `hari`, `jam_mulai`, `jam_selesai`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Senin', '07:00:00', '09:30:00', 'upcoming', '2026-06-04 07:33:41', '2026-06-04 07:33:41'),
(2, 1, 1, 'Selasa', '07:00:00', '09:30:00', 'upcoming', '2026-06-04 08:01:36', '2026-06-04 08:01:36'),
(3, 2, 1, 'Jumat', '13:00:00', '15:30:00', 'upcoming', '2026-06-04 10:12:12', '2026-06-04 10:12:12'),
(4, 1, 1, 'Senin', '13:00:00', '15:30:00', 'upcoming', '2026-06-04 14:01:38', '2026-06-04 14:01:38');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_kelas`
--

DROP TABLE IF EXISTS `master_kelas`;
CREATE TABLE IF NOT EXISTS `master_kelas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenjang` enum('SD','SMP','SMA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_kelas`
--

INSERT INTO `master_kelas` (`id`, `nama_kelas`, `jenjang`, `harga`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Matematika lanjut', 'SMA', 150000.00, 'JOSJIS', '2026-06-04 07:33:23', '2026-06-04 07:33:23'),
(2, 'Matematika Dasar', 'SD', 150000.00, 'yahaha', '2026-06-04 10:11:39', '2026-06-04 10:11:39');

-- --------------------------------------------------------

--
-- Table structure for table `master_pengajar`
--

DROP TABLE IF EXISTS `master_pengajar`;
CREATE TABLE IF NOT EXISTS `master_pengajar` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_pengajar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_pengajar`
--

INSERT INTO `master_pengajar` (`id`, `nama_pengajar`, `created_at`, `updated_at`) VALUES
(1, 'Bambang', '2026-06-03 13:11:17', '2026-06-03 13:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_21_123644_create_master_pengajars_table', 1),
(5, '2026_05_21_123645_create_jadwal_kelas_table', 1),
(6, '2026_05_21_123645_create_master_kelas_table', 1),
(7, '2026_05_21_123646_create_transaksi_pembayarans_table', 1),
(8, '2026_05_22_184444_add_snap_token_to_transaksi_pembayaran_table', 1),
(9, '2026_06_03_000000_create_activity_logs_table', 1),
(10, '2026_06_04_152017_add_spatie_columns_to_activity_logs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('25KA3UJjrUfhjMkcLL8uynWJPW1YaAJIWdV7DTmO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36', 'eyJfdG9rZW4iOiJ5VEh0WFdISkt2U3hPZVNwV1FwM0pwU2RFSjF3ZGhjU2ljRUNPUHZpIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6bnVsbH19', 1781179994);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_pembayaran`
--

DROP TABLE IF EXISTS `transaksi_pembayaran`;
CREATE TABLE IF NOT EXISTS `transaksi_pembayaran` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jadwal_id` bigint UNSIGNED NOT NULL,
  `tanggal_bayar` datetime DEFAULT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `snap_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` enum('pending','settlement','expire','cancel') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaksi_pembayaran_order_id_unique` (`order_id`),
  KEY `transaksi_pembayaran_user_id_foreign` (`user_id`),
  KEY `transaksi_pembayaran_jadwal_id_foreign` (`jadwal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi_pembayaran`
--

INSERT INTO `transaksi_pembayaran` (`id`, `order_id`, `user_id`, `jadwal_id`, `tanggal_bayar`, `jumlah_bayar`, `snap_token`, `status_pembayaran`, `created_at`, `updated_at`) VALUES
(1, 'EQ-1780558472-gxDpD', 2, 1, NULL, 152500.00, '7ebdea6f-ec36-4a45-a5b8-b05abcf60115', 'cancel', '2026-06-04 07:34:34', '2026-06-04 07:59:57'),
(2, 'EQ-1780560004-hsMNO', 2, 1, '2026-06-04 15:00:17', 152500.00, '6cf48356-9af3-4671-8074-04b5911b92ae', 'settlement', '2026-06-04 08:00:04', '2026-06-04 08:00:17'),
(3, 'EQ-1780560122-nwRtL', 2, 2, '2026-06-04 18:42:27', 152500.00, 'b99a89df-66a3-481d-b5eb-b395e676acca', 'settlement', '2026-06-04 08:02:02', '2026-06-04 11:42:27'),
(4, 'EQ-1780568128-jLj18', 2, 3, '2026-06-04 17:28:58', 152500.00, '00897202-1ca0-4259-9fd6-19befeca3e67', 'settlement', '2026-06-04 10:15:28', '2026-06-04 10:28:58'),
(5, 'EQ-1780581721-H07Ge', 2, 4, NULL, 152500.00, '0852121f-f48d-4c4b-8057-6074f19e37bf', 'cancel', '2026-06-04 14:02:03', '2026-06-05 10:04:39'),
(6, 'EQ-1780653932-IfH3m', 2, 4, '2026-06-05 17:05:54', 152500.00, 'b0ff658a-d9ba-460b-a7f8-19985f3cc4dd', 'settlement', '2026-06-05 10:05:34', '2026-06-05 10:05:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','siswa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_wa` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `email`, `email_verified_at`, `password`, `role`, `no_wa`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@eqmath.com', NULL, '$2y$12$evuNI6PSUsAqp.ksrxWFfOResUCCrv7T5Uki7BWVUwWbFgkPfWvSW', 'admin', '12345678', 'NUBzZwfArpYAaSLFOslQdU8wFzjRlXTTK1xNUAyJkCdIV22iPptIY7gR7tsL', '2026-06-03 13:08:34', '2026-06-03 13:10:42'),
(2, 'Mahendra', 'mahendra@gmail.com', NULL, '$2y$12$WPNHh4ga4bmGvpBncKsylO3VVjEv7mCGpqjpygxZJyUO84yCFpl0a', 'siswa', '12345678', 'XILQIn4tYyTYGCuDznGodPkrSL3ZmT23othouRjDDgznnrEQQCBaYnh2en5r', '2026-06-04 07:34:19', '2026-06-04 07:34:19');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
