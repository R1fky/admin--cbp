-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table admin_cbp.beritas
DROP TABLE IF EXISTS `beritas`;
CREATE TABLE IF NOT EXISTS `beritas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `beritas_title_unique` (`title`),
  KEY `beritas_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `beritas_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_beritas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.beritas: ~1 rows (approximately)
INSERT INTO `beritas` (`id`, `title`, `excerpt`, `author`, `source`, `content`, `image`, `published_at`, `created_at`, `updated_at`, `kategori_id`) VALUES
	(12, 'Sosialisasi Cinta Bangga Paham Rupiah di Lhokseumawe', 'Cinta Rupiah merupakan perwujudan dari kemampuan Masyarakat untuk mengenal karakteristik dan desain Rupiah, memperlakukan Rupiah secara tepat, menjaga dirinya dari kejahatan uang palsu.\r\n3 Cinta dengan: Mengenali, Merawat, Menjaga.', 'Admin', 'Bank Indonesia', '<p><strong>Lhokseumawe</strong> — Kantor Perwakilan Bank Indonesia (KPw BI) Lhokseumawe terus berkomitmen meningkatkan pemahaman masyarakat terhadap uang Rupiah melalui sosialisasi intensif Cinta, Bangga, Paham (CBP) Rupiah.</p><p>Dalam kegiatan edukasi yang dilaksanakan sepanjang bulan ini, BI menyasar kalangan pelajar SMA/SMK dan mahasiswa perguruan tinggi di wilayah Lhokseumawe dan Aceh Utara. Edukasi ini menekankan aspek \'Cinta\' dengan merawat fisik uang agar tidak rusak, \'Bangga\' dengan menggunakannya sebagai satu-satunya alat pembayaran yang sah, serta \'Paham\' dalam membelanjakannya secara bijak untuk mendukung stabilitas ekonomi daerah.</p><p>Kepala KPw BI Lhokseumawe menyampaikan bahwa pemahaman literasi Rupiah sejak dini sangat penting untuk menekan peredaran uang palsu dan menjaga kualitas uang beredar di masyarakat.</p>', 'berita/4X69Nnj9O8QnEHDdS4njmiGwnlA2dTU5mSGdqTgj.png', '2026-06-24 17:00:00', '2026-07-01 02:24:30', '2026-07-01 02:24:30', 1),
	(13, 'Pengumuman Penerima Beasiswa Bank Indonesia Tahun 2026', 'Setelah melalui serangkaian tahapan seleksi administrasi dan wawancara yang ketat, Kantor Perwakilan Bank Indonesia (KPw BI) Lhokseumawe mengumumkan nama-nama', 'Admin', 'Bank Indonesia', '<p><strong>Lhokseumawe</strong> — Setelah melalui serangkaian tahapan seleksi administrasi dan wawancara yang ketat, Kantor Perwakilan Bank Indonesia (KPw BI) Lhokseumawe mengumumkan nama-nama mahasiswa yang terpilih sebagai penerima Beasiswa Bank Indonesia Tahun Buku 2026.</p><p>Beasiswa ini diberikan kepada mahasiswa aktif dari perguruan tinggi mitra BI di wilayah kerja KPw BI Lhokseumawe yang memiliki prestasi akademik unggul serta aktif dalam organisasi sosial. Selain menerima bantuan dana pendidikan bulanan, para penerima beasiswa (disebut GenBI - Generasi Baru Indonesia) juga akan mendapatkan berbagai pelatihan kepemimpinan, wawasan kebangsaan, dan program pemberdayaan masyarakat.</p><p>Daftar nama lengkap penerima beasiswa dapat diakses secara resmi melalui pengumuman yang didistribusikan ke masing-masing universitas mitra.</p>', 'berita/551hEvCzVtRcLs4OEueGQVzRSDdXI6UubgflZDxN.jpg', '2026-06-17 17:00:00', '2026-07-01 02:30:27', '2026-07-01 02:30:27', 5);

-- Dumping structure for table admin_cbp.cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.cache: ~0 rows (approximately)

-- Dumping structure for table admin_cbp.cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.cache_locks: ~0 rows (approximately)

-- Dumping structure for table admin_cbp.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table admin_cbp.jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.jobs: ~0 rows (approximately)

-- Dumping structure for table admin_cbp.job_batches
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.job_batches: ~0 rows (approximately)

-- Dumping structure for table admin_cbp.kategori_beritas
DROP TABLE IF EXISTS `kategori_beritas`;
CREATE TABLE IF NOT EXISTS `kategori_beritas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategori_beritas_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.kategori_beritas: ~11 rows (approximately)
INSERT INTO `kategori_beritas` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'CBP Rupiah', '2026-06-24 21:36:24', '2026-06-24 21:36:24'),
	(2, 'Edukasi', '2026-06-24 21:36:24', '2026-06-24 21:36:24'),
	(3, 'Lomba', '2026-06-24 21:36:24', '2026-06-24 21:36:24'),
	(4, 'Event', '2026-06-24 21:36:24', '2026-06-24 21:36:24'),
	(5, 'Pengumuman', '2026-06-24 21:36:24', '2026-06-24 21:36:24'),
	(6, 'Bank Indonesia', '2026-06-24 21:36:24', '2026-06-24 21:36:24'),
	(7, 'UMKM', '2026-06-24 21:36:24', '2026-06-24 21:36:24'),
	(8, 'Digitalisasi', '2026-06-24 21:36:24', '2026-06-24 21:36:24'),
	(9, 'QRIS', '2026-06-24 21:36:24', '2026-06-24 21:36:24'),
	(10, 'Literasi Keuangan', '2026-06-24 21:36:24', '2026-06-24 21:36:24');

-- Dumping structure for table admin_cbp.kategori_lombas
DROP TABLE IF EXISTS `kategori_lombas`;
CREATE TABLE IF NOT EXISTS `kategori_lombas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategori_lombas_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.kategori_lombas: ~10 rows (approximately)
INSERT INTO `kategori_lombas` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Lomba Edukasi', '2026-06-30 02:50:58', '2026-06-30 02:50:58'),
	(2, 'Lomba Kreativitas', '2026-06-30 02:50:59', '2026-06-30 02:50:59'),
	(3, 'Lomba Poster', '2026-06-30 02:50:59', '2026-06-30 02:50:59'),
	(4, 'Lomba Video', '2026-06-30 02:50:59', '2026-06-30 02:50:59'),
	(5, 'Lomba Fotografi', '2026-06-30 02:50:59', '2026-06-30 02:50:59'),
	(6, 'Lomba Esai', '2026-06-30 02:50:59', '2026-06-30 02:50:59'),
	(7, 'Lomba Debat', '2026-06-30 02:50:59', '2026-06-30 02:50:59'),
	(8, 'Lomba Desain Grafis', '2026-06-30 02:50:59', '2026-06-30 02:50:59'),
	(9, 'Lomba Karya Tulis', '2026-06-30 02:50:59', '2026-06-30 02:50:59'),
	(10, 'Lomba UMKM', '2026-06-30 02:50:59', '2026-06-30 02:50:59');

-- Dumping structure for table admin_cbp.lombas
DROP TABLE IF EXISTS `lombas`;
CREATE TABLE IF NOT EXISTS `lombas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `end_date` date NOT NULL,
  `location_type` enum('online','offline') COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lombas_title_unique` (`title`),
  KEY `lombas_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `lombas_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_lombas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.lombas: ~5 rows (approximately)
INSERT INTO `lombas` (`id`, `title`, `kategori_id`, `description`, `thumbnail`, `release_date`, `end_date`, `location_type`, `location`, `created_at`, `updated_at`) VALUES
	(16, 'Lomba Video Kreatif Cinta Rupiah', 4, 'Buat video kreatif tentang pentingnya mencintai dan menjaga keaslian Rupiah. Durasi video maksimal 3 menit dengan format MP4.', NULL, '2026-04-15', '2026-05-30', 'online', 'Seluruh Indonesia', '2026-06-30 02:52:31', '2026-06-30 02:52:31'),
	(17, 'Quiz Literasi Keuangan Nasional', 1, 'Uji pengetahuan Anda tentang literasi keuangan dan mata uang Rupiah. Tersedia hadiah menarik untuk 100 peserta terbaik.', NULL, '2026-06-30', '2026-07-11', 'online', 'https://example.com', '2026-06-30 02:54:33', '2026-06-30 03:22:47'),
	(18, 'Segera Dibuka Lomba Poster Digital', 8, 'Desain poster digital dengan tema \'Rupiah Kebanggaanku\'. Terbuka untuk pelajar SMA/SMK sederajat di seluruh Indonesia.', NULL, '2026-07-01', '2026-07-31', 'online', 'https://example.com', '2026-06-30 02:56:00', '2026-06-30 02:56:00'),
	(19, 'Kompetisi Essay Ekonomi', 6, 'Tulis essay tentang peran mata uang dalam pembangunan ekonomi Indonesia. Panjang essay 2.000-3.000 kata.', NULL, '2026-03-01', '2026-03-31', 'online', 'https://example.com', '2026-06-30 02:57:28', '2026-06-30 02:57:28'),
	(20, 'Lomba Karya Tulis Ilmiah', 9, 'Kompetisi karya tulis ilmiah tentang kebijakan moneter dan dampaknya terhadap ekonomi mikro.', NULL, '2026-07-15', '2026-07-28', 'online', 'https://example.com', '2026-06-30 02:59:03', '2026-06-30 02:59:03'),
	(21, 'Hackathon Fintech Edukasi', 2, 'Kembangkan aplikasi atau solusi teknologi untuk meningkatkan literasi keuangan masyarakat Indonesia.', NULL, '2026-06-30', '2026-07-10', 'offline', 'Jakarta Convention Center', '2026-06-30 02:59:59', '2026-06-30 03:01:08');

-- Dumping structure for table admin_cbp.lomba_registrations
DROP TABLE IF EXISTS `lomba_registrations`;
CREATE TABLE IF NOT EXISTS `lomba_registrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lomba_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lomba_registrations_lomba_id_email_unique` (`lomba_id`,`email`),
  CONSTRAINT `lomba_registrations_lomba_id_foreign` FOREIGN KEY (`lomba_id`) REFERENCES `lombas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.lomba_registrations: ~6 rows (approximately)
INSERT INTO `lomba_registrations` (`id`, `lomba_id`, `name`, `email`, `phone`, `address`, `file`, `status`, `created_at`, `updated_at`) VALUES
	(4, 21, 'Rifky Yudha Pratama', 'rifkiyuda11@gmail.com', '08232323223', 'Indonesia, Aceh\r\nBlang Poroh, Kecamatan Muara Dua', NULL, 'pending', '2026-06-30 07:45:18', '2026-06-30 07:45:18'),
	(5, 21, 'Rifky Yudha Pratama', 'rifkiyuda12@gmail.com', '09293922323', 'Indonesia, Aceh\r\nBlang Poroh, Kecamatan Muara Dua', NULL, 'approved', '2026-06-30 07:58:59', '2026-07-05 09:05:50'),
	(6, 17, 'Rizki Wahyu Aulia', 'rizkiwahyu@gmail.com', '082278885444', 'Indonesia, Aceh\r\nBlang Poroh, Kecamatan Muara Dua', 'lomba-files/YyXtSuzyR7H6RiJbVkGX1f2DAQnNkuYN1pCDGoOH.pdf', 'pending', '2026-06-30 08:06:23', '2026-06-30 08:06:23'),
	(7, 17, 'Alfi Syarin', 'alfi@gmail.com', '082278885444', 'takengon', 'lomba-files/gYHIv99vhjQ4uSdifzLNmtcP4uVZzRU5H7GO5cVT.pdf', 'pending', '2026-06-30 08:41:21', '2026-06-30 08:41:21'),
	(8, 18, 'Haikal Murtadha', 'haikal@gmail.com', '082265756744', 'Kodim, Kota Lhokseumawe', NULL, 'pending', '2026-07-04 07:11:27', '2026-07-04 07:16:08'),
	(9, 18, 'Muhammad Jacky', 'jaxky@gmail.com', '099922345678', 'Sigli, Aceh', NULL, 'pending', '2026-07-04 07:12:13', '2026-07-04 07:16:05'),
	(10, 18, 'Haikal Murtaza', 'haikal123@gmail.com', '092245678933', 'Bandung, Jakarta Selatan', NULL, 'pending', '2026-07-04 07:13:13', '2026-07-04 07:13:13');

-- Dumping structure for table admin_cbp.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.migrations: ~12 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_06_20_120204_create_lombas_table', 1),
	(5, '2026_06_20_120526_create_beritas_table', 1),
	(6, '2026_06_20_151157_create_personal_access_tokens_table', 2),
	(7, '2026_06_20_153100_add_unique_title_to_lombas_table', 3),
	(8, '2026_06_21_091527_add_role_to_users_table', 4),
	(9, '2026_06_24_144009_add_unique_title_to_beritas_table', 5),
	(10, '2026_06_25_042059_create_kategori_beritas_table', 6),
	(11, '2026_06_25_042211_add_kategori_id_to_beritas_table', 6),
	(12, '2026_06_25_062141_add_news_fields_to_beritas_table', 7),
	(13, '2026_06_25_091337_create_kategori_lombas_table', 8),
	(14, '2026_06_25_091444_add_kategori_id_to_lombas_table', 8),
	(15, '2026_06_27_070852_add_end_date_and_location_to_lombas_table', 9),
	(16, '2026_06_27_071413_drop_status_from_lombas_table', 9),
	(17, '2026_06_29_143837_create_lomba_registrations_table', 10),
	(18, '2026_06_29_162325_add_unique_lomba_email_to_lomba_registrations_table', 11);

-- Dumping structure for table admin_cbp.password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table admin_cbp.personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.personal_access_tokens: ~2 rows (approximately)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 1, 'admin-token', 'd8192edd80191f8785bd9af0ed5d4cdbe7a92e8faab9bd25a4c66a35802d5978', '["*"]', NULL, NULL, '2026-06-20 10:19:24', '2026-06-20 10:19:24'),
	(2, 'App\\Models\\User', 1, 'admin-token', '562dc8d27d9e5a33b3d8278d06ea4666874926fa8766e7db0e418c9bba5eb512', '["*"]', NULL, NULL, '2026-06-20 10:28:51', '2026-06-20 10:28:51');

-- Dumping structure for table admin_cbp.sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('oB5LrYguTP6XPkjoYhsHp8upRKEiGTpO4mflplm9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiellMdldvcG9zOVNJV25pZnQ2OGx3elFiNmx0ZkE2bFJoU3dIWWpNUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb21iYS9jcmVhdGUiO3M6NToicm91dGUiO3M6MTI6ImxvbWJhLmNyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1783267750),
	('WKxbsUVQF1hYsjSEaVV0NdxhzFohpDBtd0VqIAcC', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibnZzVEdzaHE2YkRjUzFoVHdDeUFPZ1VlUkNXTERjQXV4N2RVSjVsNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW5kYWZ0YXJhbi1sb21iYSI7czo1OiJyb3V0ZSI7czoxODoicmVnaXN0cmF0aW9uLmxvbWJhIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1783176939);

-- Dumping structure for table admin_cbp.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_cbp.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'admin@gmail.com', 'admin', NULL, '$2y$12$owBA4Ncs9AgZ8o5HeNSZ4.HJVZtBZJ8cZ51vZIGUNM17v/SNIAm72', NULL, '2026-06-20 09:57:52', '2026-06-20 09:57:52'),
	(2, 'Test User', 'test@example.com', 'admin', '2026-06-25 02:24:20', '$2y$12$UxgP5MTznPSqYR/Q5jt4GuSdh6froYJolMQXR44Op6dDNud3rNGEK', 'ME7IuWPsSS', '2026-06-25 02:24:21', '2026-06-25 02:24:21');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
