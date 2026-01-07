-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 07, 2026 at 10:57 PM
-- Server version: 5.6.51
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brrauf`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_company`
--

CREATE TABLE `about_company` (
  `id` int(11) NOT NULL,
  `title_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (O''zbekcha)',
  `title_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (Ruscha)',
  `description_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Qisqacha tavsif (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Qisqacha tavsif (Ruscha)',
  `content_uz` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Asosiy kontent (O''zbekcha)',
  `content_ru` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Asosiy kontent (Ruscha)',
  `images` text COLLATE utf8mb4_unicode_ci COMMENT 'Rasmlar (JSON format)',
  `videos` text COLLATE utf8mb4_unicode_ci COMMENT 'Video linklar (JSON format)',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_company`
--

INSERT INTO `about_company` (`id`, `title_uz`, `title_ru`, `description_uz`, `description_ru`, `content_uz`, `content_ru`, `images`, `videos`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(6, 'Brrauf haqida', ' О Brrauf', 'sadsad', 'dsadasd', 'asdasd', 'asdasd', '[\"uploads\\/about\\/694c0a4ea7c0a_1766591054.png\",\"uploads\\/about\\/694c0b1ba8502_1766591259.jpg\"]', '[\"https:\\/\\/www.youtube.com\\/@Brrauf_mebel\"]', 1, 1, 1766591054, 1766591259);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nomi (O''zbekcha)',
  `name_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nomi (Ruscha)',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'URL slug',
  `description_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (Ruscha)',
  `image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rasm',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_uz`, `name_ru`, `slug`, `description_uz`, `description_ru`, `image`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'czxc', 'xczc', 'czxc', 'zxcz', 'xzczxc', 'backend/web/uploads/categories/694a1f8dce71b_1766465421.png', 1, 1, 1766465421, 1766465421);

-- --------------------------------------------------------

--
-- Table structure for table `company_history`
--

CREATE TABLE `company_history` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL COMMENT 'Yil',
  `title_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (O''zbekcha)',
  `title_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (Ruscha)',
  `description_uz` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tavsif (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tavsif (Ruscha)',
  `images` text COLLATE utf8mb4_unicode_ci COMMENT 'Rasmlar (JSON format)',
  `videos` text COLLATE utf8mb4_unicode_ci COMMENT 'Video linklar (JSON format)',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_history`
--

INSERT INTO `company_history` (`id`, `year`, `title_uz`, `title_ru`, `description_uz`, `description_ru`, `images`, `videos`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 2012, 'dksf', 'lkmlkdmgslkm', 'lkmldflkmq', 'klmlkgfdmlkm', '[\"uploads\\/history\\/694d6abd48c0e_1766681277.jpg\",\"uploads\\/history\\/694d6abd499d7_1766681277.jpg\",\"uploads\\/history\\/694d6abd49b5e_1766681277.jpg\",\"uploads\\/history\\/694d6abd49c3d_1766681277.jpg\"]', '[\"https:\\/\\/www.youtube.com\\/watch?v=Owvbl9UnJYk\"]', 1, 1, 1766681277, 1766681277);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `phone1` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Telefon raqam 1',
  `phone2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Telefon raqam 2',
  `address1_uz` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Manzil 1 (O''zbekcha)',
  `address1_ru` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Manzil 1 (Ruscha)',
  `address2_uz` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Manzil 2 (O''zbekcha)',
  `address2_ru` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Manzil 2 (Ruscha)',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Email',
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Instagram link',
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Facebook link',
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'LinkedIn link',
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'YouTube link',
  `telegram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Telegram link',
  `working_hours_uz` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ish vaqti (O''zbekcha)',
  `working_hours_ru` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ish vaqti (Ruscha)',
  `map_latitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Xarita - Latitude',
  `map_longitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Xarita - Longitude',
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `phone1`, `phone2`, `address1_uz`, `address1_ru`, `address2_uz`, `address2_ru`, `email`, `instagram`, `facebook`, `linkedin`, `youtube`, `telegram`, `working_hours_uz`, `working_hours_ru`, `map_latitude`, `map_longitude`, `updated_at`) VALUES
(2, '+998935030058', '+998935030058', 'Olxurizor', 'asdasd', 'sdasd', 'sadsa', 'dsa@gmail.com', 'https://chatgpt.com/', 'https://chatgpt.com/', 'https://chatgpt.com/', 'https://chatgpt.com/', 'https://chatgpt.com/', 'dsad', 'sadas', '41.351326410681494', ' 69.24888622009013', 1767685462);

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'To''liq ismi',
  `position_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Lavozimi (O''zbekcha)',
  `position_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Lavozimi (Ruscha)',
  `bio_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Biografiya (O''zbekcha)',
  `bio_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Biografiya (Ruscha)',
  `photo` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rasmi',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `full_name`, `position_uz`, `position_ru`, `bio_uz`, `bio_ru`, `photo`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'sadd', 'asdas', 'sadas', 'as', 'asd', 'uploads/managers/694c1fe77899f_1766596583.jpg', 1, 1, 1766465319, 1766596583);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1766427667),
('m130524_201442_init', 1766427669),
('m190124_110200_add_verification_token_column_to_user_table', 1766427669),
('m251222_190109_create_about_company_table', 1766430112),
('m251222_190537_create_company_history_table', 1766430356),
('m251222_190730_create_production_volume_table', 1766464059),
('m251223_042434_create_managers_table', 1766464059),
('m251223_042457_create_categories_table', 1766464309),
('m251223_042514_create_products_table', 1766464309),
('m251223_042527_create_product_items_table', 1766464309),
('m251223_052600_create_portfolio_table', 1766467871),
('m251223_052611_create_partners_table', 1766467871),
('m251223_052620_create_news_table', 1766467871),
('m251223_052634_create_contacts_table', 1766467872),
('m251223_052656_create_vacancies_table', 1766467872),
('m251223_052727_create_vacancy_applications_table', 1766467872),
('m251223_052759_create_promotions_table', 1766467872),
('m251223_052816_create_promotion_products_table', 1766467872),
('m251223_053022_create_why_us_table', 1766467872),
('m251224_162940_create_production_volume_table', 1766593794),
('m260107_072403_create_order_table', 1767771034);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (O''zbekcha)',
  `title_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (Ruscha)',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'URL slug',
  `description_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Qisqa tavsif (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Qisqa tavsif (Ruscha)',
  `content_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'To''liq matn (O''zbekcha)',
  `content_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'To''liq matn (Ruscha)',
  `images` text COLLATE utf8mb4_unicode_ci COMMENT 'Rasmlar (JSON format)',
  `videos` text COLLATE utf8mb4_unicode_ci COMMENT 'Videolar - YouTube linklar (JSON format)',
  `published_date` date DEFAULT NULL COMMENT 'E''lon qilingan sana',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title_uz`, `title_ru`, `slug`, `description_uz`, `description_ru`, `content_uz`, `content_ru`, `images`, `videos`, `published_date`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'dadas', 'sadad', 'dadas', 'sdaddsasad', 'sdas', 'sdad', 'asdasd', '[\"uploads\\/news\\/694c1adebf2b4_1766595294.jpg\"]', '[\"sadas\"]', '2025-12-24', 1, 1, 1766595294, 1766595294);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Buyurtma raqami',
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mijoz ismi',
  `customer_phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Telefon raqami',
  `customer_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Shahar',
  `customer_address` text COLLATE utf8mb4_unicode_ci COMMENT 'Manzil (ixtiyoriy)',
  `total_amount` decimal(10,2) NOT NULL COMMENT 'Jami summa',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new' COMMENT 'Status',
  `notes` text COLLATE utf8mb4_unicode_ci COMMENT 'Qo''shimcha izoh',
  `admin_notes` text COLLATE utf8mb4_unicode_ci COMMENT 'Admin izohlari',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL COMMENT 'Buyurtma ID',
  `product_item_id` int(11) NOT NULL COMMENT 'Mahsulot ID',
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mahsulot nomi',
  `product_sku` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SKU',
  `price` decimal(10,2) NOT NULL COMMENT 'Narxi',
  `quantity` int(11) NOT NULL COMMENT 'Miqdori',
  `subtotal` decimal(10,2) NOT NULL COMMENT 'Jami'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `brand_name_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Brend nomi (O''zbekcha)',
  `brand_name_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Brend nomi (Ruscha)',
  `logo` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Logo',
  `description_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Qisqa ma''lumot (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Qisqa ma''lumot (Ruscha)',
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Veb-sayt',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `brand_name_uz`, `brand_name_ru`, `logo`, `description_uz`, `description_ru`, `website`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'sa', 'das', 'backend/web/uploads/partners/694a392d34c94_1766471981.png', 'sada', 'dsa', 'https://fds.uz', 1, 0, 1766471981, 1766471981);

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `company_name_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kompaniya nomi (O''zbekcha)',
  `company_name_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kompaniya nomi (Ruscha)',
  `company_logo` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kompaniya logosi',
  `title_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (O''zbekcha)',
  `title_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (Ruscha)',
  `description_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Qisqa tavsif (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Qisqa tavsif (Ruscha)',
  `content_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Batafsil matn (O''zbekcha)',
  `content_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Batafsil matn (Ruscha)',
  `images` text COLLATE utf8mb4_unicode_ci COMMENT 'Rasmlar (JSON format)',
  `videos` text COLLATE utf8mb4_unicode_ci COMMENT 'Videolar - YouTube linklar (JSON format)',
  `project_date` date DEFAULT NULL COMMENT 'Loyiha sanasi',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`id`, `company_name_uz`, `company_name_ru`, `company_logo`, `title_uz`, `title_ru`, `description_uz`, `description_ru`, `content_uz`, `content_ru`, `images`, `videos`, `project_date`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'asS', 'cxzc', 'backend/web/uploads/portfolio/logos/694c11fb4f45c_1766593019.jpg', 'xzczxc', 'xzcc', 'xzcxzc', 'xzczxc', 'xzcxzc', 'xczc', '[\"uploads\\/portfolio\\/images\\/694c11fb4f80c_1766593019.jpg\"]', '[\"https:\\/\\/www.youtube.com\\/watch?v=vEzEoZQdDjs\"]', '2025-12-24', 1, 1, 1766593019, 1766726729),
(3, 'asS', 'asddsad', 'backend/web/uploads/portfolio/logos/694c12981143e_1766593176.png', 'asdsad', 'sadasd', 'sadas', 'sadas', 'sda', 'sadas', '[\"uploads\\/portfolio\\/images\\/694c1298118b3_1766593176.jpg\"]', '[\"sadsad\"]', '2025-12-25', 1, 2, 1766593176, 1766593176),
(4, 'aasdsadasdasdas', 'sadsadasdsad', 'backend/web/uploads/portfolio/logos/694c2b7563984_1766599541.png', 'asdasda', 'dfsdf', 'dfsdf', 'dfsdf', 'sdfsdf', 'dsfsd', '[\"uploads\\/portfolio\\/images\\/694c2b75647a0_1766599541.jpg\",\"uploads\\/portfolio\\/images\\/694c2b75648d7_1766599541.jpg\",\"uploads\\/portfolio\\/images\\/694c2b7564992_1766599541.jpg\",\"uploads\\/portfolio\\/images\\/694c2b7564a26_1766599541.jpg\"]', '[\"https:\\/\\/www.youtube.com\\/watch?v=wgsWR2dpPyg&list=RDxQ0fkRpcmHs&index=13\"]', '2025-12-25', 1, 4, 1766599541, 1766599541);

-- --------------------------------------------------------

--
-- Table structure for table `production_volume`
--

CREATE TABLE `production_volume` (
  `id` int(11) NOT NULL,
  `title_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (O''zbekcha)',
  `title_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (Ruscha)',
  `description_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (Ruscha)',
  `volume` decimal(15,2) NOT NULL COMMENT 'Hajm (miqdor)',
  `unit_uz` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'O''lchov birligi (O''zbekcha)',
  `unit_ru` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'O''lchov birligi (Ruscha)',
  `period_uz` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Davr (O''zbekcha)',
  `period_ru` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Davr (Ruscha)',
  `images` text COLLATE utf8mb4_unicode_ci COMMENT 'Rasmlar (JSON format)',
  `videos` text COLLATE utf8mb4_unicode_ci COMMENT 'Video linklar (JSON format)',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_volume`
--

INSERT INTO `production_volume` (`id`, `title_uz`, `title_ru`, `description_uz`, `description_ru`, `volume`, `unit_uz`, `unit_ru`, `period_uz`, `period_ru`, `images`, `videos`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(4, 'sadsad', 'sadasd', 'asdsa', 'sadsa', '15.00', '1dsad', 'sdas', 'dfas', 'sada', '[\"uploads\\/production\\/694c175a0486d_1766594394.jpg\"]', '[]', 1, 1, 1766594394, 1766594394),
(5, 'asdasdas', 'dsdaasd', 'asdasd', 'asdsad', '12.00', 'dasd', 'sdasd', 'sdas', 'sada', '[\"uploads\\/production\\/694c178ca98b4_1766594444.jpg\"]', '[\"https:\\/\\/www.youtube.com\\/@Brrauf_mebel\"]', 1, 2, 1766594444, 1766594444),
(6, 'dasdsadsadas', 'asdasdasdas', 'dasdasdasd', 'sadasdasdasdas', '1223.00', 'dasd', 'sdsad', 'sadsad', 'dsadas', '[\"uploads\\/production\\/694c184b07a96_1766594635.jpg\"]', '[\"https:\\/\\/www.youtube.com\\/@Brrauf_mebel\"]', 1, 3, 1766594635, 1766594635),
(7, 'sdfsdf', 'fgfdgfdg', 'fgdfgdf', 'gdfgdfgdf', '324.00', 'gfdgf', 'fdgdfg', 'fdgfdg', 'dfgdfg', '[\"uploads\\/production\\/694c18656f53f_1766594661.jpg\"]', '[\"https:\\/\\/www.youtube.com\\/@Brrauf_mebel\"]', 1, 4, 1766594661, 1766594661),
(8, 'dcxzc', 'xzcxz', 'xczxc', 'xzczxc', '1215.00', '1dsfsd', 'fdds', 'vsd16', 'fsdd', '[\"uploads\\/production\\/694e6c3d6a7fc_1766747197.png\"]', '[\"https:\\/\\/www.youtube.com\\/@Brrauf_mebel\"]', 1, 5, 1766747197, 1766747197);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL COMMENT 'Kategoriya ID',
  `name_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nomi (O''zbekcha)',
  `name_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nomi (Ruscha)',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'URL slug',
  `description_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (Ruscha)',
  `images` text COLLATE utf8mb4_unicode_ci COMMENT 'Rasmlar (JSON format)',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name_uz`, `name_ru`, `slug`, `description_uz`, `description_ru`, `images`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'dsad', 'asda', 'dsad', 'asda', 'sd', '[\"backend\\/web\\/uploads\\/products\\/694a2212921bb_1766466066.png\"]', 1, 0, 1766466066, 1766466066);

-- --------------------------------------------------------

--
-- Table structure for table `product_items`
--

CREATE TABLE `product_items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT 'Mahsulot ID',
  `name_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Variant nomi (O''zbekcha)',
  `name_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Variant nomi (Ruscha)',
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SKU kodi',
  `price` decimal(15,2) NOT NULL COMMENT 'Narxi',
  `description_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (Ruscha)',
  `images` text COLLATE utf8mb4_unicode_ci COMMENT 'Rasmlar (JSON format)',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_items`
--

INSERT INTO `product_items` (`id`, `product_id`, `name_uz`, `name_ru`, `sku`, `price`, `description_uz`, `description_ru`, `images`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'saAS', 'As', 'asa', '54151.00', 'ASA', 'as', '[\"backend\\/web\\/uploads\\/product-items\\/694a22429b1a3_1766466114.jpg\"]', 1, 1, 1766466114, 1766466114),
(2, 1, 'Qora stul ofis uchun', 'asasdas', '6544sd', '150500.00', 'sdad', 'asdasd', '[\"uploads\\/product-items\\/694c3457add9b_1766601815.jpg\"]', 1, 0, 1766601815, 1766601815),
(3, 1, 'asdsad', 'sad', 'sadasd', '874465.00', 'asdsa', 'sadasd', '[\"uploads\\/product-items\\/694c346ebf904_1766601838.jpg\"]', 1, 2, 1766601838, 1766601838),
(4, 1, 'asdasd', 'sadasd', 'asdsad', '644.00', 'sadd', 'sadasd', '[\"uploads\\/product-items\\/694c349a7d918_1766601882.jpg\"]', 1, 1, 1766601882, 1766601882);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `title_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (O''zbekcha)',
  `title_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (Ruscha)',
  `description_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (Ruscha)',
  `discount_percent` decimal(5,2) NOT NULL COMMENT 'Chegirma foizi',
  `image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Aksiya rasmi',
  `start_date` date NOT NULL COMMENT 'Boshlanish sanasi',
  `end_date` date NOT NULL COMMENT 'Tugash sanasi',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `title_uz`, `title_ru`, `description_uz`, `description_ru`, `discount_percent`, `image`, `start_date`, `end_date`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'sda', 'sad', 'asd', 'asd', '30.00', 'backend/web/uploads/promotions/694a3c087309a_1766472712.png', '2025-12-23', '2025-12-30', 1, 0, 1766472712, 1766472712),
(2, 'xvzxv', 'vxc', 'xcvx', 'xcv', '30.00', 'backend/web/uploads/promotions/694a3e8b9b4d6_1766473355.jpg', '2025-12-01', '2025-12-12', 1, 1, 1766473355, 1766473355);

-- --------------------------------------------------------

--
-- Table structure for table `promotion_products`
--

CREATE TABLE `promotion_products` (
  `id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL COMMENT 'Aksiya ID',
  `product_id` int(11) NOT NULL COMMENT 'Mahsulot ID',
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotion_products`
--

INSERT INTO `promotion_products` (`id`, `promotion_id`, `product_id`, `created_at`) VALUES
(1, 2, 1, 1766473355);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'admin', 'O7aW1ANCQU3u1YSkyrBHvuf9ccZeLbjb', '$2y$13$xPGp.nhe/fRP7myHlgLuBu5w8.CEZ18fFeIWYY14jFM4Zv4URSzKe', NULL, 'admin@gmail.com', 10, 1766427672, 1766427672, '097heQUyNaINIFUqBrYxIkEJSEK0Jz3N_1766427672');

-- --------------------------------------------------------

--
-- Table structure for table `vacancies`
--

CREATE TABLE `vacancies` (
  `id` int(11) NOT NULL,
  `title_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Lavozim nomi (O''zbekcha)',
  `title_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Lavozim nomi (Ruscha)',
  `description_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (Ruscha)',
  `requirements_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Talablar (O''zbekcha)',
  `requirements_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Talablar (Ruscha)',
  `benefits_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Taklif qilinadigan imkoniyatlar (O''zbekcha)',
  `benefits_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Taklif qilinadigan imkoniyatlar (Ruscha)',
  `image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rasm',
  `salary_from` decimal(15,2) DEFAULT NULL COMMENT 'Maosh (dan)',
  `salary_to` decimal(15,2) DEFAULT NULL COMMENT 'Maosh (gacha)',
  `employment_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ish turi (full-time, part-time, remote)',
  `deadline` date DEFAULT NULL COMMENT 'Arizalar qabul qilish muddati',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)',
  `sort_order` int(11) DEFAULT '0' COMMENT 'Tartiblash',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vacancies`
--

INSERT INTO `vacancies` (`id`, `title_uz`, `title_ru`, `description_uz`, `description_ru`, `requirements_uz`, `requirements_ru`, `benefits_uz`, `benefits_ru`, `image`, `salary_from`, `salary_to`, `employment_type`, `deadline`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Ishchi', 'Ishchji', 'dsadsad', 'dsad', 'sadas', 'dsadsad', 'sadsad', 'sadasd', 'uploads/vacancies/694d4c0075eb3_1766673408.png', '1000000.00', '1500000.00', 'full-time', '2025-12-12', 1, 1, 1766673408, 1766673408),
(2, 'dsf', 'fsdf', 'sdfsd', 'sdf', 'sdf', 'sdf', 'sdf', 'sdf', 'uploads/vacancies/694d4ff9c54a3_1766674425.jpg', '54541.00', '116515.00', 'part-time', '2025-12-26', 1, 2, 1766674425, 1766674425);

-- --------------------------------------------------------

--
-- Table structure for table `vacancy_applications`
--

CREATE TABLE `vacancy_applications` (
  `id` int(11) NOT NULL,
  `vacancy_id` int(11) NOT NULL COMMENT 'Vakansiya ID',
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'To''liq ismi',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Email',
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Telefon',
  `birth_date` date DEFAULT NULL COMMENT 'Tug''ilgan sana',
  `education` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ma''lumoti',
  `experience` text COLLATE utf8mb4_unicode_ci COMMENT 'Ish tajribasi',
  `cover_letter` text COLLATE utf8mb4_unicode_ci COMMENT 'Qo''shimcha ma''lumot / Cover letter',
  `resume_file` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Resume fayli (CV)',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new' COMMENT 'Status (new, viewed, accepted, rejected)',
  `admin_notes` text COLLATE utf8mb4_unicode_ci COMMENT 'Admin izohlar',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vacancy_applications`
--

INSERT INTO `vacancy_applications` (`id`, `vacancy_id`, `full_name`, `email`, `phone`, `birth_date`, `education`, `experience`, `cover_letter`, `resume_file`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jakhongir Ergashev', 'ergashev@gmail.com', '+998935030058', '2001-08-22', 'asdsa', 'dsa', 'sada', 'uploads/resumes/694d4e62e1f74_1766674018.pdf', 'accepted', NULL, 1766674018, 1766674073),
(2, 1, 'Jakhongir Ergashev', 'ergashev@gmail.com', '935030058', '2026-01-06', 'asdsa', 'jhv', 'jugj', 'uploads/resumes/695cdb4834f0e_1767693128.pdf', 'new', NULL, 1767693128, 1767693128),
(3, 1, 'Jakhongir Ergashev', 'ergashev@gmail.com', '935030058', '2026-01-14', 'sdf', 'sdaf', 'asdf', 'uploads/resumes/695cf885f0a6d_1767700613.pdf', 'new', NULL, 1767700614, 1767700614),
(4, 2, 'Jakhongir Ergashev', 'ergashev@gmail.com', '935030058', '2026-01-14', 'dfsaf', 'sdfsd', 'sdaf', 'uploads/resumes/695dfaabbcd3e_1767766699.pdf', 'new', NULL, 1767766699, 1767766699),
(5, 2, 'Jakhongir Ergashev', 'ergashev@gmail.com', '935030058', '2026-01-07', 'asdsa', 'luikhj', 'hjkhjk', 'uploads/resumes/695dfe6ed9d46_1767767662.pdf', 'new', NULL, 1767767662, 1767767662),
(6, 2, 'Shahriyor', 'ergashev@gmail.com', '935030058', '2026-01-07', 'O\'rta maxsus', 'adsasdf', 'afdssdafsdf', 'uploads/resumes/695dfeaa5b8a2_1767767722.pdf', 'new', NULL, 1767767722, 1767767722);

-- --------------------------------------------------------

--
-- Table structure for table `why_us`
--

CREATE TABLE `why_us` (
  `id` int(11) NOT NULL,
  `title_uz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (O''zbekcha)',
  `title_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sarlavha (Ruscha)',
  `description_uz` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (O''zbekcha)',
  `description_ru` text COLLATE utf8mb4_unicode_ci COMMENT 'Tavsif (Ruscha)',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Status (1-active, 0-inactive)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_company`
--
ALTER TABLE `about_company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-about_company-status` (`status`),
  ADD KEY `idx-about_company-sort_order` (`sort_order`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx-categories-slug` (`slug`),
  ADD KEY `idx-categories-status` (`status`),
  ADD KEY `idx-categories-sort_order` (`sort_order`);

--
-- Indexes for table `company_history`
--
ALTER TABLE `company_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-company_history-year` (`year`),
  ADD KEY `idx-company_history-status` (`status`),
  ADD KEY `idx-company_history-sort_order` (`sort_order`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-managers-status` (`status`),
  ADD KEY `idx-managers-sort_order` (`sort_order`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx-news-slug` (`slug`),
  ADD KEY `idx-news-status` (`status`),
  ADD KEY `idx-news-sort_order` (`sort_order`),
  ADD KEY `idx-news-published_date` (`published_date`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `idx-orders-order_number` (`order_number`),
  ADD KEY `idx-orders-status` (`status`),
  ADD KEY `idx-orders-created_at` (`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-order_items-order_id` (`order_id`),
  ADD KEY `idx-order_items-product_item_id` (`product_item_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-partners-status` (`status`),
  ADD KEY `idx-partners-sort_order` (`sort_order`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-portfolio-status` (`status`),
  ADD KEY `idx-portfolio-sort_order` (`sort_order`);

--
-- Indexes for table `production_volume`
--
ALTER TABLE `production_volume`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-production_volume-status` (`status`),
  ADD KEY `idx-production_volume-sort_order` (`sort_order`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx-products-slug` (`slug`),
  ADD KEY `idx-products-category_id` (`category_id`),
  ADD KEY `idx-products-status` (`status`),
  ADD KEY `idx-products-sort_order` (`sort_order`);

--
-- Indexes for table `product_items`
--
ALTER TABLE `product_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-product_items-product_id` (`product_id`),
  ADD KEY `idx-product_items-status` (`status`),
  ADD KEY `idx-product_items-sort_order` (`sort_order`),
  ADD KEY `idx-product_items-sku` (`sku`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-promotions-status` (`status`),
  ADD KEY `idx-promotions-sort_order` (`sort_order`),
  ADD KEY `idx-promotions-dates` (`start_date`,`end_date`);

--
-- Indexes for table `promotion_products`
--
ALTER TABLE `promotion_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx-promotion_products-unique` (`promotion_id`,`product_id`),
  ADD KEY `idx-promotion_products-promotion_id` (`promotion_id`),
  ADD KEY `idx-promotion_products-product_id` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `vacancies`
--
ALTER TABLE `vacancies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-vacancies-status` (`status`),
  ADD KEY `idx-vacancies-sort_order` (`sort_order`),
  ADD KEY `idx-vacancies-deadline` (`deadline`);

--
-- Indexes for table `vacancy_applications`
--
ALTER TABLE `vacancy_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-vacancy_applications-vacancy_id` (`vacancy_id`),
  ADD KEY `idx-vacancy_applications-status` (`status`),
  ADD KEY `idx-vacancy_applications-created_at` (`created_at`);

--
-- Indexes for table `why_us`
--
ALTER TABLE `why_us`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_company`
--
ALTER TABLE `about_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_history`
--
ALTER TABLE `company_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `production_volume`
--
ALTER TABLE `production_volume`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_items`
--
ALTER TABLE `product_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotion_products`
--
ALTER TABLE `promotion_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vacancies`
--
ALTER TABLE `vacancies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vacancy_applications`
--
ALTER TABLE `vacancy_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `why_us`
--
ALTER TABLE `why_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk-order_items-order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-order_items-product_item_id` FOREIGN KEY (`product_item_id`) REFERENCES `product_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk-products-category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_items`
--
ALTER TABLE `product_items`
  ADD CONSTRAINT `fk-product_items-product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promotion_products`
--
ALTER TABLE `promotion_products`
  ADD CONSTRAINT `fk-promotion_products-product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-promotion_products-promotion_id` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vacancy_applications`
--
ALTER TABLE `vacancy_applications`
  ADD CONSTRAINT `fk-vacancy_applications-vacancy_id` FOREIGN KEY (`vacancy_id`) REFERENCES `vacancies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
