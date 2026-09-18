
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
DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yeni',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('aegea-reserve-cache-settings_all','a:16:{s:8:\"site_adi\";s:13:\"AEGEA RESERVE\";s:13:\"site_aciklama\";s:172:\"Ege’nin berrak sularından, vahşi kefal balığı yumurtasından; elde tuzlanıp güneşte kurutulan premium bottarga. Vahşi avlanmış, katkısız, ustaca kürlenmiş.\";s:7:\"telefon\";s:14:\"0232 000 00 00\";s:8:\"whatsapp\";s:12:\"905320000000\";s:6:\"eposta\";s:21:\"info@ornek-gurme.com\";s:5:\"adres\";s:32:\"Ege Kıyısı, İzmir / Türkiye\";s:9:\"instagram\";s:21:\"https://instagram.com\";s:8:\"facebook\";s:20:\"https://facebook.com\";s:12:\"kargo_ucreti\";s:5:\"89.90\";s:18:\"kargo_bedava_limit\";s:4:\"1500\";s:11:\"havale_iban\";s:32:\"TR00 0000 0000 0000 0000 0000 00\";s:16:\"havale_hesap_adi\";s:39:\"AEGEA RESERVE Gıda İhracat Ltd. Şti.\";s:12:\"havale_banka\";s:15:\"Örnek Bankası\";s:12:\"iyzico_aktif\";s:1:\"0\";s:12:\"kapida_aktif\";s:1:\"1\";s:3:\"yil\";s:2:\"10\";}',2099308653);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sira` int unsigned NOT NULL DEFAULT '0',
  `durum` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `icon`, `image`, `description`, `sira`, `durum`, `created_at`, `updated_at`) VALUES (1,NULL,'Rendelenmiş Bottarga','rendelenmis','bi-stars',NULL,NULL,1,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(2,NULL,'Mumlu Bütün Bottarga','mumlu-butun','bi-award',NULL,NULL,2,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(3,NULL,'Vakumlu Bottarga','vakumlu','bi-box-seam',NULL,NULL,3,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(4,NULL,'Hediye Kutusu','hediye-kutusu','bi-gift',NULL,NULL,4,1,'2026-07-13 10:07:37','2026-07-13 10:07:37');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_06_16_000001_create_shop_tables',1),(5,'2026_06_16_000002_create_content_tables',1),(6,'2026_06_16_000003_add_role_to_users',1),(7,'2026_06_17_000001_create_contact_messages_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `qty` int unsigned NOT NULL DEFAULT '1',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'havale',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yeni',
  `payment_meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_no_unique` (`order_no`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `tarih` date DEFAULT NULL,
  `durum` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `title`, `slug`, `category`, `image`, `summary`, `content`, `tarih`, `durum`, `created_at`, `updated_at`) VALUES (1,'Bottarga Nedir, Nasıl Tüketilir?','bottarga-nedir','Rehber','uploads/products/g01.jpg','Akdeniz’in “deniz havyarı”; bottarganın ne olduğunu, nasıl rendelenip servis edildiğini ve eşleştiği lezzetleri anlattık.','Akdeniz’in “deniz havyarı”; bottarganın ne olduğunu, nasıl rendelenip servis edildiğini ve eşleştiği lezzetleri anlattık.\n\nDaha fazlası ve mevsimlik önerilerimiz için bültenimize göz atın.','2026-07-13',1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(2,'Makarnada Bottarga: 3 Klasik Tarif','makarnada-bottarga-tarifleri','Tarif','uploads/products/g07.jpg','Zeytinyağı ve sarımsakla spaghetti alla bottarga’dan limonlu linguine’ye, üç kolay ve etkileyici tarif.','Zeytinyağı ve sarımsakla spaghetti alla bottarga’dan limonlu linguine’ye, üç kolay ve etkileyici tarif.\n\nDaha fazlası ve mevsimlik önerilerimiz için bültenimize göz atın.','2026-07-07',1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(3,'Bottarga Nasıl Saklanır?','bottarga-nasil-saklanir','Bilgi','uploads/products/g09.jpg','Mumlu ve vakumlu bottarganın tazeliğini korumak için ideal saklama koşulları ve raf ömrü.','Mumlu ve vakumlu bottarganın tazeliğini korumak için ideal saklama koşulları ve raf ömrü.\n\nDaha fazlası ve mevsimlik önerilerimiz için bültenimize göz atın.','2026-07-01',1,'2026-07-13 10:07:37','2026-07-13 10:07:37');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `short_desc` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int unsigned NOT NULL DEFAULT '0',
  `attributes` json DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `sira` int unsigned NOT NULL DEFAULT '0',
  `durum` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `sku`, `brand`, `cover`, `images`, `short_desc`, `description`, `price`, `sale_price`, `stock`, `attributes`, `featured`, `sira`, `durum`, `created_at`, `updated_at`) VALUES (1,1,'Rendelenmiş Bottarga 50g','rendelenmis-bottarga-50g','AR-0001','AEGEA RESERVE','uploads/products/g01.jpg','[\"uploads/products/g01.jpg\"]','Kullanıma hazır, ince rendelenmiş bottarga. Makarna, risotto veya salatanın üzerine anında umami dokunuşu.','Kullanıma hazır, ince rendelenmiş bottarga. Makarna, risotto veya salatanın üzerine anında umami dokunuşu.\n\nVahşi avlanmış Ege kefal yumurtasından; elde tuzlanır, güneşte kurutulur. Katkısızdır; taze ürünler soğuk zincirle özenle gönderilir.',890.00,NULL,40,'{\"form\": \"Rendelenmiş\", \"agirlik\": \"50 g\", \"kullanim\": \"Makarna / salata\"}',1,1,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(2,1,'Rendelenmiş Bottarga 100g','rendelenmis-bottarga-100g','AR-0002','AEGEA RESERVE','uploads/products/g02.jpg','[\"uploads/products/g02.jpg\"]','Sık kullananlar için 100 gramlık cam kavanoz. Taze aromasını koruyan ağzı sıkı kapak.','Sık kullananlar için 100 gramlık cam kavanoz. Taze aromasını koruyan ağzı sıkı kapak.\n\nVahşi avlanmış Ege kefal yumurtasından; elde tuzlanır, güneşte kurutulur. Katkısızdır; taze ürünler soğuk zincirle özenle gönderilir.',1650.00,NULL,30,'{\"form\": \"Rendelenmiş\", \"agirlik\": \"100 g\"}',0,2,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(3,2,'Mumlu Bütün Bottarga — Tek (Küçük)','mumlu-butun-bottarga-tek-kucuk','AR-0003','AEGEA RESERVE','uploads/products/g03.jpg','[\"uploads/products/g03.jpg\"]','Geleneksel yöntemle balmumuyla kaplanmış bütün yumurta. Servis anında rendeleyin.','Geleneksel yöntemle balmumuyla kaplanmış bütün yumurta. Servis anında rendeleyin.\n\nVahşi avlanmış Ege kefal yumurtasından; elde tuzlanır, güneşte kurutulur. Katkısızdır; taze ürünler soğuk zincirle özenle gönderilir.',1450.00,NULL,25,'{\"form\": \"Bütün · mumlu\", \"agirlik\": \"80–100 g\"}',1,3,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(4,2,'Mumlu Bütün Bottarga — Tek (Büyük)','mumlu-butun-bottarga-tek-buyuk','AR-0004','AEGEA RESERVE','uploads/products/g04.jpg','[\"uploads/products/g04.jpg\"]','İri boy bütün bottarga; mumlu kabuğu tazeliği kilitler. Şef sofraları için ideal.','İri boy bütün bottarga; mumlu kabuğu tazeliği kilitler. Şef sofraları için ideal.\n\nVahşi avlanmış Ege kefal yumurtasından; elde tuzlanır, güneşte kurutulur. Katkısızdır; taze ürünler soğuk zincirle özenle gönderilir.',2450.00,2190.00,18,'{\"form\": \"Bütün · mumlu\", \"agirlik\": \"140–160 g\"}',1,4,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(5,2,'Mumlu Bütün Bottarga — 5’li Paket','mumlu-butun-bottarga-5li-paket','AR-0005','AEGEA RESERVE','uploads/products/g05.jpg','[\"uploads/products/g05.jpg\"]','Beş adet mumlu bütün bottarga; restoran ve toptan kullanım için avantajlı paket.','Beş adet mumlu bütün bottarga; restoran ve toptan kullanım için avantajlı paket.\n\nVahşi avlanmış Ege kefal yumurtasından; elde tuzlanır, güneşte kurutulur. Katkısızdır; taze ürünler soğuk zincirle özenle gönderilir.',6900.00,NULL,10,'{\"adet\": \"5\", \"form\": \"Bütün · mumlu\"}',0,5,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(6,3,'Vakumlu Bottarga Dilim 100g','vakumlu-bottarga-dilim-100g','AR-0006','AEGEA RESERVE','uploads/products/g06.jpg','[\"uploads/products/g06.jpg\"]','Vakumlanmış, dilimlenmeye hazır saf bottarga. Katkısız, dokunulmamış lezzet.','Vakumlanmış, dilimlenmeye hazır saf bottarga. Katkısız, dokunulmamış lezzet.\n\nVahşi avlanmış Ege kefal yumurtasından; elde tuzlanır, güneşte kurutulur. Katkısızdır; taze ürünler soğuk zincirle özenle gönderilir.',1290.00,NULL,35,'{\"form\": \"Vakumlu dilim\", \"agirlik\": \"100 g\"}',0,6,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(7,3,'Vakumlu Bottarga 200g','vakumlu-bottarga-200g','AR-0007','AEGEA RESERVE','uploads/products/g07.jpg','[\"uploads/products/g07.jpg\"]','Mutfak formatında 200 gramlık vakumlu bottarga; dilimleyin, rendeleyin, paylaşın.','Mutfak formatında 200 gramlık vakumlu bottarga; dilimleyin, rendeleyin, paylaşın.\n\nVahşi avlanmış Ege kefal yumurtasından; elde tuzlanır, güneşte kurutulur. Katkısızdır; taze ürünler soğuk zincirle özenle gönderilir.',2350.00,2100.00,28,'{\"form\": \"Vakumlu\", \"agirlik\": \"200 g\"}',1,7,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(8,3,'Vakumlu Bottarga 10’lu Paket','vakumlu-bottarga-10lu-paket','AR-0008','AEGEA RESERVE','uploads/products/g08.jpg','[\"uploads/products/g08.jpg\"]','On adet küçük vakumlu bottarga; ikramlık ve porsiyonlu kullanım için.','On adet küçük vakumlu bottarga; ikramlık ve porsiyonlu kullanım için.\n\nVahşi avlanmış Ege kefal yumurtasından; elde tuzlanır, güneşte kurutulur. Katkısızdır; taze ürünler soğuk zincirle özenle gönderilir.',3600.00,NULL,12,'{\"adet\": \"10\", \"form\": \"Vakumlu\"}',0,8,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(9,4,'AEGEA Reserve Hediye Kutusu','aegea-reserve-hediye-kutusu','AR-0009','AEGEA RESERVE','uploads/products/g09.jpg','[\"uploads/products/g09.jpg\"]','Siyah-altın hediye kutusunda bir bütün mumlu bottarga ve iki seçki. Gurme hediyeler için.','Siyah-altın hediye kutusunda bir bütün mumlu bottarga ve iki seçki. Gurme hediyeler için.\n\nVahşi avlanmış Ege kefal yumurtasından; elde tuzlanır, güneşte kurutulur. Katkısızdır; taze ürünler soğuk zincirle özenle gönderilir.',3990.00,NULL,15,'{\"icerik\": \"1 bütün + 2 seçki\", \"ambalaj\": \"Hediye kutusu\"}',1,9,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(10,4,'AEGEA Mini Seçki Kutusu','aegea-mini-secki-kutusu','AR-0010','AEGEA RESERVE','uploads/products/g10.jpg','[\"uploads/products/g10.jpg\"]','Rendelenmiş ve vakumlu bottarganın bir arada sunulduğu zarif mini seçki.','Rendelenmiş ve vakumlu bottarganın bir arada sunulduğu zarif mini seçki.\n\nVahşi avlanmış Ege kefal yumurtasından; elde tuzlanır, güneşte kurutulur. Katkısızdır; taze ürünler soğuk zincirle özenle gönderilir.',1950.00,NULL,20,'{\"icerik\": \"Rendelenmiş + vakumlu\", \"ambalaj\": \"Mini kutu\"}',0,10,1,'2026-07-13 10:07:37','2026-07-13 10:07:37');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `sira` int unsigned NOT NULL DEFAULT '0',
  `durum` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` (`id`, `title`, `slug`, `icon`, `image`, `summary`, `content`, `sira`, `durum`, `created_at`, `updated_at`) VALUES (1,'Vahşi Avlanmış','vahsi-avlanmis','bi-water',NULL,'Ege’nin açık ve berrak sularından, mevsiminde avlanan kefal yumurtası.','Ege’nin açık ve berrak sularından, mevsiminde avlanan kefal yumurtası. AEGEA RESERVE olarak lezzeti ve geleneği bir arada, en saf haliyle sunuyoruz.',1,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(2,'Elde Kürlenmiş','elde-kurlenmis','bi-hand-index',NULL,'Yalnızca deniz tuzuyla, ustaların eliyle tuzlanır — katkı yok.','Yalnızca deniz tuzuyla, ustaların eliyle tuzlanır — katkı yok. AEGEA RESERVE olarak lezzeti ve geleneği bir arada, en saf haliyle sunuyoruz.',2,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(3,'Güneşte Kurutulmuş','gunes-te-kurutulmus','bi-brightness-high',NULL,'Ege güneşi ve rüzgârıyla, amber rengini alana dek yavaşça kurutulur.','Ege güneşi ve rüzgârıyla, amber rengini alana dek yavaşça kurutulur. AEGEA RESERVE olarak lezzeti ve geleneği bir arada, en saf haliyle sunuyoruz.',3,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(4,'Coğrafi Lezzet Mirası','cografi-lezzet','bi-award',NULL,'Yüzyıllara dayanan geleneksel yöntemle hazırlanan seçkin bir delikatese.','Yüzyıllara dayanan geleneksel yöntemle hazırlanan seçkin bir delikatese. AEGEA RESERVE olarak lezzeti ve geleneği bir arada, en saf haliyle sunuyoruz.',4,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(5,'Soğuk Zincir Kargo','soguk-zincir-kargo','bi-truck',NULL,'Taze ürünler soğuk zincirle, kırılganlar özel ambalajla gönderilir.','Taze ürünler soğuk zincirle, kırılganlar özel ambalajla gönderilir. AEGEA RESERVE olarak lezzeti ve geleneği bir arada, en saf haliyle sunuyoruz.',5,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(6,'Güvenli Ödeme','guvenli-odeme','bi-shield-check',NULL,'Havale/EFT, kapıda ödeme ve 3D Secure kartlı ödeme seçenekleri.','Havale/EFT, kapıda ödeme ve 3D Secure kartlı ödeme seçenekleri. AEGEA RESERVE olarak lezzeti ve geleneği bir arada, en saf haliyle sunuyoruz.',6,1,'2026-07-13 10:07:37','2026-07-13 10:07:37');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('1zdSMVfgQQ1rd5EUSTLe9C4o0jMK2cTxtUmMtBWA',NULL,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.7827.55 Safari/537.36','eyJfdG9rZW4iOiJMVm9JNXhxakZzalhrQ04xb0dmZWxLc000c21JMzRISkp5blg2Wlo1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwiY2FydCI6eyI0Ijp7ImlkIjo0LCJuYW1lIjoiTXVtbHUgQlx1MDBmY3RcdTAwZmNuIEJvdHRhcmdhIFx1MjAxNCBUZWsgKEJcdTAwZmN5XHUwMGZjaykiLCJzbHVnIjoibXVtbHUtYnV0dW4tYm90dGFyZ2EtdGVrLWJ1eXVrIiwicHJpY2UiOjIxOTAsInF0eSI6MSwiaW1hZ2UiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2d1cm1lLXNob3BcL3B1YmxpY1wvdXBsb2Fkc1wvcHJvZHVjdHNcL2cwNC5qcGciLCJza3UiOiJBUi0wMDA0In19fQ==',1784028954),('6GDYuKh1yk49YOW2gtZ5yDqcD2cuOG8KgBfid8WQ',NULL,'::1','curl/8.18.0','eyJfdG9rZW4iOiJ6UjU5NVZmNUJIMHh4MTBWQ3FuZG8zRGx6OWhKTkxRVDI1WFJJaGdaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljXC91cnVuXC92YWt1bWx1LWJvdHRhcmdhLTIwMGciLCJyb3V0ZSI6InByb2R1Y3QifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1783948423),('7hYw6ynd93r6fpO7FwpH542SNhFPlFPQbMIJP2Ho',NULL,'::1','curl/8.18.0','eyJfdG9rZW4iOiJHUGRTdDFTbUU0YlFoM3lHcTIwZnBNcWpvb0hPQ0QyUWRMWHJQNGhXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljXC9pbGV0aXNpbSIsInJvdXRlIjoiY29udGFjdCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1783948423),('aJJQG4juGkkdGXyVqHGyUWUIyAdrFdxHGbOr9lKP',NULL,'::1','curl/8.18.0','eyJfdG9rZW4iOiJaeUNQS3RKa3JoN3FMZkpETmN1Tm9qNFpFZmRaSnJwWjU3Y0ZxU1pDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783948423),('bZN155Ip24kdY64dvb7n4rHfSSGgaqi2pMCIaoXp',NULL,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJvZTdGOERUcFpJdnZCV0R5cDkybkYySFB1V1NXakF5aHpHRTZNcFlqIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljXC9pbGV0aXNpbSIsInJvdXRlIjoiY29udGFjdCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1783950696),('dGlVTkR7kCrPRfTGhQEupu1wM8AVPihavVcc5XVp',NULL,'::1','curl/8.18.0','eyJfdG9rZW4iOiJ0VmxCUXBtVjRMSTNSVHpFWWpyYUg0ME5xQ2p4bmFhdHE2MU9XYldyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljXC9ibG9nIiwicm91dGUiOiJibG9nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783948424),('ImACkBOiDIuE6H9eB080wLKeIMb0yfFCIVd62kBe',1,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiIzWGRuYzBVbmdZdlV6eFoyVW56dDVtV1NTa2VUTUEydmJraVQ2VDlZIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljXC95b25ldGltXC9zZXR0aW5ncyIsInJvdXRlIjoiYWRtaW4uc2V0dGluZ3MuZWRpdCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==',1783966430),('od58QCwjDXcjwzP6mOYpr5tSWYoEQbcqZe5Pe9mK',NULL,'::1','curl/8.18.0','eyJfdG9rZW4iOiJBa01oNEFualRjbmZiVVBrMU9vM2NFcklHMjBzQmJFMFZIYUdGVlY3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljXC9naXJpcyIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1783948424),('Po5tghTWjai8rkhaNNWRmXIMwKDRC5YHJIE0XDc8',NULL,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/1.21459.0 Chrome/148.0.7778.271 Electron/42.5.1 Safari/537.36 MSIX','eyJfdG9rZW4iOiJkYk8zdWJwN1pMV1lJUHlQVnFRZm5DcGI5eXZCREFTd2xkWHpzekcwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784103287),('RKANQRSzBz34MIOxidk4NCLZkztWzmvpjZB2078C',NULL,'::1','curl/8.18.0','eyJfdG9rZW4iOiI5Z1ZNQ2hFYlB2TWxXQVZadjVwWE5aRGlPaTFEZDg1aG5KQ2lyUTFNIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljXC9zZXBldCIsInJvdXRlIjoiY2FydCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1783948423),('rUwub10acxg3uJ4nB1cxljpmeOsXQT1b3oLPxItl',1,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/1.20186.0 Chrome/148.0.7778.271 Electron/42.5.1 Safari/537.36 MSIX','eyJfdG9rZW4iOiI1Nzhsb2t6Rm9WSXEzekdPVmh1ZlhuQUhyYkw0M3JFNUh5eHhIcjZrIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljXC95b25ldGltXC9wcm9kdWN0cyIsInJvdXRlIjoiYWRtaW4ucHJvZHVjdHMuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJjYXJ0Ijp7IjciOnsiaWQiOjcsIm5hbWUiOiJWYWt1bWx1IEJvdHRhcmdhIDIwMGciLCJzbHVnIjoidmFrdW1sdS1ib3R0YXJnYS0yMDBnIiwicHJpY2UiOjIxMDAsInF0eSI6MSwiaW1hZ2UiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2d1cm1lLXNob3BcL3B1YmxpY1wvdXBsb2Fkc1wvcHJvZHVjdHNcL2cwNy5qcGciLCJza3UiOiJBUi0wMDA3In19LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=',1783950809),('uGaaXVLZF8PVAjgafAcF6Da9udWSh7KygRRhYive',NULL,'::1','curl/8.18.0','eyJfdG9rZW4iOiJMdXJnYmlJUTZIYzdHRGZKWWhnbDFxTnJ5SDZYc3NGdkZ1aHlrTFlKIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljXC9oYWtraW1pemRhIiwicm91dGUiOiJhYm91dCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1783948423),('Z4FWGU0ialSiaoa4Gh5kJXGYqWoZ0yn2fvTR9ceV',NULL,'::1','curl/8.18.0','eyJfdG9rZW4iOiJCN3dXYWRBWkN4c2QxTGEwZ1B4cVQzcFJhN0pYYXJrdE5VWkpUTWZQIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3VybWUtc2hvcFwvcHVibGljXC9tYWdhemEiLCJyb3V0ZSI6InNob3AifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1783948423);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `anahtar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deger` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_anahtar_unique` (`anahtar`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `anahtar`, `deger`, `created_at`, `updated_at`) VALUES (1,'site_adi','AEGEA RESERVE','2026-07-13 10:07:37','2026-07-13 10:07:37'),(2,'site_aciklama','Ege’nin berrak sularından, vahşi kefal balığı yumurtasından; elde tuzlanıp güneşte kurutulan premium bottarga. Vahşi avlanmış, katkısız, ustaca kürlenmiş.','2026-07-13 10:07:37','2026-07-13 10:07:37'),(3,'telefon','0232 000 00 00','2026-07-13 10:07:37','2026-07-13 10:07:37'),(4,'whatsapp','905320000000','2026-07-13 10:07:37','2026-07-13 10:07:37'),(5,'eposta','info@ornek-gurme.com','2026-07-13 10:07:37','2026-07-13 10:07:37'),(6,'adres','Ege Kıyısı, İzmir / Türkiye','2026-07-13 10:07:37','2026-07-13 10:07:37'),(7,'instagram','https://instagram.com','2026-07-13 10:07:37','2026-07-13 10:07:37'),(8,'facebook','https://facebook.com','2026-07-13 10:07:37','2026-07-13 10:07:37'),(9,'kargo_ucreti','89.90','2026-07-13 10:07:37','2026-07-13 10:07:37'),(10,'kargo_bedava_limit','1500','2026-07-13 10:07:37','2026-07-13 10:07:37'),(11,'havale_iban','TR00 0000 0000 0000 0000 0000 00','2026-07-13 10:07:37','2026-07-13 10:07:37'),(12,'havale_hesap_adi','AEGEA RESERVE Gıda İhracat Ltd. Şti.','2026-07-13 10:07:37','2026-07-13 10:07:37'),(13,'havale_banka','Örnek Bankası','2026-07-13 10:07:37','2026-07-13 10:07:37'),(14,'iyzico_aktif','0','2026-07-13 10:07:37','2026-07-13 10:07:37'),(15,'kapida_aktif','1','2026-07-13 10:07:37','2026-07-13 10:07:37'),(16,'yil','10','2026-07-13 10:07:37','2026-07-13 10:07:37');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stars` tinyint unsigned NOT NULL DEFAULT '5',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `durum` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` (`id`, `name`, `title`, `comment`, `stars`, `photo`, `durum`, `created_at`, `updated_at`) VALUES (1,'Şef Murat A.','Restoran Sahibi','Menümüzde rendelenmiş bottarga kullanıyoruz; misafirler farkı hemen anlıyor. Sardinya’dan sonra tattığım en iyi bottarga.',5,NULL,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(2,'Elif D.','Gurme','Mumlu bütün bottarga tam anlatıldığı gibi. Rendelendiğinde inanılmaz bir umami veriyor, paketleme de çok özenliydi.',5,NULL,1,'2026-07-13 10:07:37','2026-07-13 10:07:37'),(3,'Chef Kaan Y.','Gastronomi Danışmanı','Tutarlı, temiz ve zarif ambalajlı. AEGEA RESERVE artık mutfağımızın vazgeçilmezi.',5,NULL,1,'2026-07-13 10:07:37','2026-07-13 10:07:37');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (1,'AEGEA RESERVE Yönetici','admin@ornek-gurme.com','admin','0232 000 00 00',NULL,'$2y$10$abcdefghijklmnopqrstuvOaBcDeFgHiJkLmNoPqRsTuVwXyZ01234',NULL,'2026-07-13 10:07:37','2026-07-13 10:07:37');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

