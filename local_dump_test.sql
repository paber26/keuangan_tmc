-- Warning: column statistics not supported by the server.
-- MySQL dump 10.13  Distrib 8.4.9, for macos26.4 (arm64)
--
-- Host: 127.0.0.1    Database: keuangan_tmc
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `absensis`
--

DROP TABLE IF EXISTS `absensis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `absensis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `karyawan_id` bigint(20) unsigned NOT NULL,
  `kebun_id` bigint(20) unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Sakit','Izin','Alpha') NOT NULL DEFAULT 'Hadir',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `absensis_karyawan_id_kebun_id_tanggal_unique` (`karyawan_id`,`kebun_id`,`tanggal`),
  KEY `absensis_kebun_id_foreign` (`kebun_id`),
  CONSTRAINT `absensis_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `absensis_kebun_id_foreign` FOREIGN KEY (`kebun_id`) REFERENCES `kebuns` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `absensis`
--

LOCK TABLES `absensis` WRITE;
/*!40000 ALTER TABLE `absensis` DISABLE KEYS */;
INSERT INTO `absensis` VALUES (1,1,4,'2026-06-15','Alpha','2026-06-17 07:51:05','2026-06-17 07:51:05'),(2,1,4,'2026-06-16','Hadir','2026-06-17 07:51:05','2026-06-17 07:51:12'),(3,1,4,'2026-06-17','Alpha','2026-06-17 07:51:05','2026-06-17 07:51:05'),(4,1,4,'2026-06-18','Alpha','2026-06-17 07:51:05','2026-06-17 07:51:05'),(5,1,4,'2026-06-19','Alpha','2026-06-17 07:51:05','2026-06-17 07:51:05'),(6,1,4,'2026-06-20','Alpha','2026-06-17 07:51:05','2026-06-17 07:51:05'),(7,1,1,'2026-06-15','Alpha','2026-06-17 07:51:41','2026-06-17 07:51:41'),(8,1,1,'2026-06-16','Alpha','2026-06-17 07:51:41','2026-06-17 07:51:41'),(9,1,1,'2026-06-17','Alpha','2026-06-17 07:51:41','2026-06-17 07:51:41'),(10,1,1,'2026-06-18','Alpha','2026-06-17 07:51:41','2026-06-17 07:51:41'),(11,1,1,'2026-06-19','Hadir','2026-06-17 07:51:41','2026-06-17 07:51:44'),(12,1,1,'2026-06-20','Alpha','2026-06-17 07:51:41','2026-06-17 07:51:41'),(13,2,1,'2026-06-15','Alpha','2026-06-17 07:56:19','2026-06-17 07:56:19'),(14,2,1,'2026-06-16','Alpha','2026-06-17 07:56:19','2026-06-17 07:56:19'),(15,2,1,'2026-06-17','Alpha','2026-06-17 07:56:19','2026-06-17 07:56:19'),(16,2,1,'2026-06-18','Alpha','2026-06-17 07:56:19','2026-06-17 07:56:19'),(17,2,1,'2026-06-19','Alpha','2026-06-17 07:56:19','2026-06-17 07:56:19'),(18,2,1,'2026-06-20','Alpha','2026-06-17 07:56:19','2026-06-17 07:56:19'),(19,23,1,'2026-06-15','Alpha','2026-06-17 07:56:24','2026-06-17 07:56:24'),(20,23,1,'2026-06-16','Alpha','2026-06-17 07:56:24','2026-06-17 07:56:24'),(21,23,1,'2026-06-17','Alpha','2026-06-17 07:56:24','2026-06-17 07:56:24'),(22,23,1,'2026-06-18','Alpha','2026-06-17 07:56:24','2026-06-17 07:56:24'),(23,23,1,'2026-06-19','Alpha','2026-06-17 07:56:24','2026-06-17 07:56:24'),(24,23,1,'2026-06-20','Alpha','2026-06-17 07:56:24','2026-06-17 07:56:24'),(25,11,1,'2026-06-15','Alpha','2026-06-17 07:56:41','2026-06-17 07:56:41'),(26,11,1,'2026-06-16','Alpha','2026-06-17 07:56:41','2026-06-17 07:56:41'),(27,11,1,'2026-06-17','Alpha','2026-06-17 07:56:41','2026-06-17 07:56:41'),(28,11,1,'2026-06-18','Alpha','2026-06-17 07:56:41','2026-06-17 07:56:41'),(29,11,1,'2026-06-19','Alpha','2026-06-17 07:56:41','2026-06-17 07:56:41'),(30,11,1,'2026-06-20','Alpha','2026-06-17 07:56:41','2026-06-17 07:56:41');
/*!40000 ALTER TABLE `absensis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `karyawans`
--

DROP TABLE IF EXISTS `karyawans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `karyawans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `tipe_gaji` enum('Tetap','Harian','Borongan') NOT NULL DEFAULT 'Harian',
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karyawans`
--

LOCK TABLES `karyawans` WRITE;
/*!40000 ALTER TABLE `karyawans` DISABLE KEYS */;
INSERT INTO `karyawans` VALUES (1,'Jhon Bantu','Harian Kumpul','Sapa',NULL,'Harian','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(2,'Juanda Durandt','Harian Kumpul','Sapa',NULL,'Harian','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(3,'Adriana Maligoge','Harian Kumpul','Sapa',NULL,'Harian','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(4,'Ivon Purnama','Harian Kumpul','Sapa',NULL,'Harian','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(5,'Maxi Tenda','Momaras Mesin','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(6,'Anton Ambalao','Momaras Mesin','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(7,'Maykel Martin','Momaras Mesin','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(8,'Frendy Bantu','Kupas Kelapa','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(9,'Noval Durandt','Kupas Kelapa','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(10,'Alfa Durandt','Kupas Kelapa','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(11,'Ruslan Latupo','Kupas Kelapa','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(12,'Freddy Ottay','Pemanjat Kelapa','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(13,'Jolly Engkol','Pemanjat Kelapa','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(14,'Simon Sasela','Pemanjat Kelapa','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(15,'Rinaldy Lohodandel','Pemanjat Kelapa','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(16,'Fanly Palit','Pemanjat Kelapa','Sapa',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(17,'Riski Panigoro','Harian Kumpul','Ranoketang',NULL,'Harian','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(18,'Niko Labulango','Harian Kumpul','Ranoketang',NULL,'Harian','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(19,'Flandi Rembet','Harian Kumpul','Ranoketang',NULL,'Harian','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(20,'Marlo Rembet','Harian Kumpul','Ranoketang',NULL,'Harian','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(21,'Juan Rembet','Harian Kumpul','Ranoketang',NULL,'Harian','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(22,'Yanto Runtuwene','Harian Kumpul','Ranoketang',NULL,'Harian','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(23,'Herman Nayoan','Momaras Mesin','Tombatu',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(24,'Freddy Runturambi','Momaras Mesin','Tombatu',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(25,'Fredi Lamia','Momaras Mesin','Tombatu',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(26,'Reince Mogogibung','Momaras Mesin','Tombatu',NULL,'Borongan','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38'),(27,'Marsel Suot','Harian Kumpul','Tombatu',NULL,'Harian','Aktif','2026-06-17 15:43:38','2026-06-17 15:43:38');
/*!40000 ALTER TABLE `karyawans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kebuns`
--

DROP TABLE IF EXISTS `kebuns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kebuns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `luas` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kebuns`
--

LOCK TABLES `kebuns` WRITE;
/*!40000 ALTER TABLE `kebuns` DISABLE KEYS */;
INSERT INTO `kebuns` VALUES (1,'RANOKETANG B','RANOKETANG TUA',3000.00,'Aktif','2026-06-17 07:48:15','2026-06-17 07:48:15'),(2,'RANOKETANG A','RANOKETANG TUA',4000.00,'Aktif','2026-06-17 07:48:15','2026-06-17 07:48:15'),(3,'LANSOT','SAPA',1000.00,'Aktif','2026-06-17 07:48:15','2026-06-17 07:48:15'),(4,'KAYU WOLO','SAPA',2400.00,'Aktif','2026-06-17 07:48:15','2026-06-17 07:48:15'),(5,'GUNUNG KAPAS','SAPA',1000.00,'Aktif','2026-06-17 07:48:15','2026-06-17 07:48:15'),(6,'BATU KAPAL','SAPA',2500.00,'Aktif','2026-06-17 07:48:15','2026-06-17 07:48:15');
/*!40000 ALTER TABLE `kebuns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_06_17_150930_create_kebuns_table',1),(5,'2026_06_17_152200_create_karyawans_table',1),(6,'2026_06_17_152600_remove_jumlah_blok_from_kebuns_table',1),(7,'2026_06_17_153100_add_lokasi_to_karyawans_table',1),(8,'2026_06_17_153720_create_absensis_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('srbbH3OxIYmIvxyKPYUXTZAkpqyzZxwhJ8rhsy0V',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMzZWRkowVE1WZmEzNFdQdU5VTEtyd0dxdmlGeGpFTFJMaFhoRVoxayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hYnNlbnNpIjtzOjU6InJvdXRlIjtzOjEzOiJhYnNlbnNpLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1781711875);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-18  0:01:48
