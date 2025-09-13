-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th9 13, 2025 lúc 05:46 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tiktokshop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

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
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lich_su`
--

CREATE TABLE `lich_su` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `hanh_dong` tinyint(4) NOT NULL COMMENT '1: nạp tiền, 2: rút tiền, 3: hệ thống xử lý, 4: nhận hoa hồng',
  `so_tien` decimal(15,2) NOT NULL DEFAULT 0.00,
  `ghi_chu` text DEFAULT NULL,
  `trang_thai` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'trạng thái',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_09_014350_add_phone_and_referral_code_to_users_table', 1),
(5, '2025_09_09_035114_add_role_to_users_table', 1),
(6, '2025_09_09_050000_create_profiles_table', 1),
(7, '2025_09_09_060000_create_phan_thuong_table', 1),
(8, '2025_09_10_012829_add_timestamps_to_profiles_table', 1),
(9, '2025_09_10_070500_add_timestamps_to_phan_thuong_table', 1),
(10, '2025_09_10_080100_create_thong_bao_table', 1),
(11, '2025_09_11_043455_create_slide_show_table', 1),
(12, '2025_09_11_044756_update_slide_show_trang_thai_to_integer', 1),
(13, '2025_09_11_090000_create_lich_su_table', 1),
(14, '2025_09_11_100700_drop_unique_email_from_users_table', 1),
(15, '2025_09_12_015326_add_mat_khau_chuyen_tien_to_users_table', 1),
(16, '2025_09_12_060701_create_nhan_don_table', 1),
(17, '2025_09_12_060823_add_san_pham_id_to_nhan_don_table', 1),
(18, '2025_09_12_061710_fix_nhan_don_san_pham_id_foreign_key', 1),
(19, '2025_09_12_120000_add_hoa_hong_to_profiles_table', 1),
(20, '2025_09_12_223736_create_nap_rut_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nap_rut`
--

CREATE TABLE `nap_rut` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `loai_giao_dich` enum('nap','rut') NOT NULL,
  `so_tien` decimal(15,2) NOT NULL,
  `trang_thai` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `ghi_chu` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhan_don`
--

CREATE TABLE `nhan_don` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `san_pham_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ten_san_pham` varchar(255) NOT NULL,
  `gia_tri` decimal(15,2) NOT NULL,
  `hoa_hong` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phan_thuong`
--

CREATE TABLE `phan_thuong` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten` varchar(255) DEFAULT NULL,
  `gia` decimal(10,2) DEFAULT NULL,
  `hoa_hong` decimal(10,2) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `cap_do` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phan_thuong`
--

INSERT INTO `phan_thuong` (`id`, `ten`, `gia`, `hoa_hong`, `mo_ta`, `hinh_anh`, `cap_do`, `created_at`, `updated_at`) VALUES
(16, 'iPhone 15 Pro Max', 1109.00, 18.30, 'iPhone 15 Pro Max với chip A17 Pro mạnh mẽ, camera 48MP chuyên nghiệp và thiết kế titan cao cấp.', 'products/iphone15.jpg', 5, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(17, 'Samsung Galaxy S24 Ultra', 2876.00, 33.36, 'Samsung Galaxy S24 Ultra với S Pen, camera 200MP và màn hình Dynamic AMOLED 2X 6.8 inch.', 'products/samsung-s24.jpg', 4, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(18, 'MacBook Pro M3', 4353.00, 58.77, 'MacBook Pro M3 với chip Apple M3 Pro, màn hình Liquid Retina XDR 14 inch và hiệu năng vượt trội.', 'products/macbook-pro.jpg', 5, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(19, 'AirPods Pro 2', 1038.00, 16.40, 'AirPods Pro 2 với chip H2, chống ồi chủ động và âm thanh không gian.', 'products/airpods-pro.jpg', 3, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(20, 'iPad Air M2', 1838.00, 33.82, 'iPad Air M2 với chip M2 mạnh mẽ, màn hình Liquid Retina 10.9 inch và hỗ trợ Apple Pencil.', 'products/ipad-air.jpg', 4, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(21, 'Sony WH-1000XM5', 1889.00, 24.56, 'Sony WH-1000XM5 với chống ồi hàng đầu, âm thanh chất lượng cao và pin 30 giờ.', 'products/sony-headphones.jpg', 3, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(22, 'Apple Watch Series 9', 158.00, 2.16, 'Apple Watch Series 9 với chip S9, màn hình Always-On Retina và theo dõi sức khỏe toàn diện.', 'products/apple-watch.jpg', 3, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(23, 'Dell XPS 13', 3949.00, 49.36, 'Dell XPS 13 với Intel Core i7, màn hình 13.4 inch 4K và thiết kế siêu mỏng.', 'products/dell-xps.jpg', 4, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(24, 'Nintendo Switch OLED', 249.00, 3.04, 'Nintendo Switch OLED với màn hình OLED 7 inch, Joy-Con và chơi game mọi lúc mọi nơi.', 'products/nintendo-switch.jpg', 2, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(25, 'Sony PlayStation 5', 1741.00, 13.06, 'Sony PlayStation 5 với SSD siêu nhanh, DualSense controller và trải nghiệm game 4K.', 'products/ps5.jpg', 4, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(26, 'Xiaomi 13 Pro', 2452.00, 37.03, 'Xiaomi 13 Pro với Snapdragon 8 Gen 2, camera Leica 50MP và sạc nhanh 120W.', 'products/xiaomi-13.jpg', 3, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(27, 'OnePlus 11', 4729.00, 66.68, 'OnePlus 11 với Snapdragon 8 Gen 2, màn hình AMOLED 120Hz và sạc nhanh 100W.', 'products/oneplus-11.jpg', 3, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(28, 'Google Pixel 8 Pro', 4636.00, 54.70, 'Google Pixel 8 Pro với Tensor G3, camera AI và Android thuần túy.', 'products/pixel-8.jpg', 4, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(29, 'Huawei Mate 60 Pro', 297.00, 4.13, 'Huawei Mate 60 Pro với chip Kirin 9000S, camera XMAGE và thiết kế cao cấp.', 'products/huawei-mate60.jpg', 4, '2025-09-12 20:44:57', '2025-09-12 20:44:57'),
(30, 'Oppo Find X6 Pro', 1854.00, 35.97, 'Oppo Find X6 Pro với Snapdragon 8 Gen 2, camera Hasselblad và sạc nhanh 100W.', 'products/oppo-findx6.jpg', 3, '2025-09-12 20:44:57', '2025-09-12 20:44:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `gioi_tinh` varchar(255) DEFAULT NULL,
  `ngay_sinh` varchar(255) DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `so_du` varchar(255) DEFAULT NULL,
  `anh_mat_truoc` varchar(255) DEFAULT NULL,
  `anh_mat_sau` varchar(255) DEFAULT NULL,
  `anh_chan_dung` varchar(255) DEFAULT NULL,
  `ngan_hang` varchar(255) DEFAULT NULL,
  `so_tai_khoan` varchar(255) DEFAULT NULL,
  `chu_tai_khoan` varchar(255) DEFAULT NULL,
  `cap_do` varchar(255) DEFAULT NULL,
  `giai_thuong_id` varchar(255) DEFAULT NULL,
  `luot_trung` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hoa_hong` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slide_show`
--

CREATE TABLE `slide_show` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `tieu_de` varchar(255) DEFAULT NULL,
  `vi_tri` int(11) NOT NULL DEFAULT 0,
  `trang_thai` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thong_bao`
--

CREATE TABLE `thong_bao` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `noi_dung` text NOT NULL,
  `trang_thai` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `phone` varchar(255) NOT NULL,
  `referral_code` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mat_khau_chuyen_tien` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `referral_code`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `mat_khau_chuyen_tien`) VALUES
(1, 'Admin', 'admin@tiktokshop.com', 'admin', '0123456789', 'ADMIN001', NULL, '$2y$12$s84uAhdZoys3LqrGGkNp1O0.r8Tj95fPI6vroeenn6VPlU7ZNf0nC', NULL, '2025-09-12 20:34:37', '2025-09-12 20:34:37', NULL),
(2, 'Super Admin', 'superadmin@tiktokshop.com', 'admin', '0987654321', 'SUPER001', NULL, '$2y$12$Wm36bcGRBOkdYi3qdH8jeOjgdZhxGGX.Tm4XO2ubLKsupnThAOxf2', NULL, '2025-09-12 20:34:37', '2025-09-12 20:34:37', NULL),
(3, 'Chú. Sơn Thống', 'luc.dau@example.net', 'user', '0984238271', 'QO8953', '2025-09-12 20:34:37', '$2y$12$ls2IoGQJJvykk8ijSHZpsuJK3X79EBvouUJRZFKqyAWtNGv.F0acK', NULL, '2025-09-12 20:34:37', '2025-09-12 20:34:37', NULL),
(4, 'Thịnh Dương Hoàn', 'nhien.ung@example.com', 'user', '0962538869', 'EU7257', '2025-09-12 20:34:37', '$2y$12$qYrFUsP643oQ2J673/YbFOYXd5pYBVTLpFgcmwykMbOVc2zCcOK6y', NULL, '2025-09-12 20:34:37', '2025-09-12 20:34:37', NULL),
(5, 'Mộc Bữu Tín', 'xbac@example.org', 'user', '0977012611', 'GG0193', '2025-09-12 20:34:38', '$2y$12$MRdo9OYikXCJyac0H7QLPOhgiB.TSUiD1OWC/vF3xDZcwXQNg/yNG', NULL, '2025-09-12 20:34:38', '2025-09-12 20:34:38', NULL),
(6, 'Trang Hữu Anh', 'ha.hoai@example.net', 'user', '0978023875', 'MN4692', '2025-09-12 20:34:38', '$2y$12$47W1iBxWgPtOeg5lomYd9u8oRo2Q6KO5duD5nLDxn4TBquIGaCeDS', NULL, '2025-09-12 20:34:38', '2025-09-12 20:34:38', NULL),
(7, 'Bác. Hán Diệu Nghi', 'canh39@example.com', 'user', '0956339740', 'VC2037', '2025-09-12 20:34:38', '$2y$12$togXQwRQhRioA2w4e7XG4erhu0zFReSTXiCeikIZ60m4ZzBleUZOC', NULL, '2025-09-12 20:34:38', '2025-09-12 20:34:38', NULL),
(8, 'Bạch Bào', 'chinh.danh@example.net', 'user', '0916017805', 'NE4765', '2025-09-12 20:34:38', '$2y$12$re8Fia8zV9fwzUdcn5XS4.ghDAVHy6IHnADRP0rKHLrU5AUyCjVaS', NULL, '2025-09-12 20:34:38', '2025-09-12 20:34:38', NULL),
(9, 'Chu Ý', 'hy.anh@example.com', 'user', '0964000183', 'QL9233', '2025-09-12 20:34:38', '$2y$12$GYnsNBcB4spSYAiXpUIz2eNLzP4pHFZDdIxdlXTJjWegiDe7ulG.a', NULL, '2025-09-12 20:34:38', '2025-09-12 20:34:38', NULL),
(10, 'Đái Nhạn', 'fphi@example.org', 'user', '0908244675', 'YU6808', '2025-09-12 20:34:39', '$2y$12$pi5xNUf0QLNBUjErwSVri.U.eut8e8meNAV/qMiCqScxkC.XSwM.O', NULL, '2025-09-12 20:34:39', '2025-09-12 20:34:39', NULL),
(11, 'Anh. Xa Khắc Đăng', 'uleu@example.net', 'user', '0948109712', 'JW6226', '2025-09-12 20:34:39', '$2y$12$vTDAl58YKuYuoFpcq181WeIbyJ1Kli0d/V2lEH9M1/NE20jnaxCmW', NULL, '2025-09-12 20:34:39', '2025-09-12 20:34:39', NULL),
(12, 'Thái Ninh', 'thi19@example.org', 'user', '0965732852', 'MQ2415', '2025-09-12 20:34:39', '$2y$12$JLV0orXsZXHEi2girZGXIu6QiRrnnVTKHr9x56UYRd9/ebIHoEcKC', NULL, '2025-09-12 20:34:39', '2025-09-12 20:34:39', NULL),
(13, 'Cụ. Hồ Ngôn', 'da.quyen@example.com', 'user', '0983815880', 'MO4300', '2025-09-12 20:34:39', '$2y$12$PCQo79Ewz2sTM3txAWHhXOxngxZrnz4MNIRI1H9FIUThstuknF3bO', NULL, '2025-09-12 20:34:39', '2025-09-12 20:34:39', NULL),
(14, 'Chú. Ấu Khuyến Kỷ', 'quoc36@example.org', 'user', '0960669087', 'DF1787', '2025-09-12 20:34:39', '$2y$12$3rcN2mt2oFMq7W8VyIWnLOhMnq8.YOnWLN1khTpD8YoJmBu6oqatS', NULL, '2025-09-12 20:34:39', '2025-09-12 20:34:39', NULL),
(15, 'Tạ An Tuyến', 'man.truong@example.com', 'user', '0948003912', 'YZ9492', '2025-09-12 20:34:40', '$2y$12$hJOPdSaGZ16hVGfLmxJUJuokZ8KzY6g2TarvI86fbMRR5AAtHdU4.', NULL, '2025-09-12 20:34:40', '2025-09-12 20:34:40', NULL),
(16, 'Cụ. Cái Vĩ', 'giao.kieu@example.org', 'user', '0974154055', 'OL9160', '2025-09-12 20:34:40', '$2y$12$pW3wu.Rrx.5aAAKMHTFrp.s93k1G5Sq85uCZXzfhAw.bb892KLDXW', NULL, '2025-09-12 20:34:40', '2025-09-12 20:34:40', NULL),
(17, 'Cấn Bảo Điệp', 'knghi@example.org', 'user', '0931042928', 'ZR9627', '2025-09-12 20:34:40', '$2y$12$VddGAcZg6N9kRFJmV1XjzuNdhhMlw/K8DBhyY6H/TW8UidX4C5GD.', NULL, '2025-09-12 20:34:40', '2025-09-12 20:34:40', NULL),
(18, 'Cụ. Bồ Nguyên', 'tue12@example.org', 'user', '0909397676', 'NS8938', '2025-09-12 20:34:40', '$2y$12$FqpI1ceG3yAn0yAW5kCuAeunpvg0GnP5gKrwtt2zBX7tvCVaV3oI2', NULL, '2025-09-12 20:34:40', '2025-09-12 20:34:40', NULL),
(19, 'Bác. Đoàn Nhân', 'que94@example.net', 'user', '0962459787', 'RU3691', '2025-09-12 20:34:41', '$2y$12$EWaJir2yGE5LOSSlE3gyQ.xTPmufh2JskaQSTOp/OweXusfZPPC.q', NULL, '2025-09-12 20:34:41', '2025-09-12 20:34:41', NULL),
(20, 'Diệp Khang', 'vy.doan@example.net', 'user', '0937022892', 'HE0890', '2025-09-12 20:34:41', '$2y$12$rAZt5jmGAFOhFCaTLDXBSOwxiVvFOf51K48r151cM7efVAJQaAvza', NULL, '2025-09-12 20:34:41', '2025-09-12 20:34:41', NULL),
(21, 'Bành Bằng Đình', 'bang.thoai@example.net', 'user', '0977242609', 'GQ2349', '2025-09-12 20:34:41', '$2y$12$iwGgwS4djCxkhbnCzMLSfusUPh/C7ODGrN8d0d.IOf1HGb/cWx0zS', NULL, '2025-09-12 20:34:41', '2025-09-12 20:34:41', NULL),
(22, 'Đào Thuận', 'moc.dai@example.org', 'user', '0933062856', 'MP3075', '2025-09-12 20:34:41', '$2y$12$l3L20nG/CY9.ChtBAlE7NOMNM0bHPkTrl1BBNA/i60nX0nOefzWaq', NULL, '2025-09-12 20:34:41', '2025-09-12 20:34:41', NULL),
(23, 'Nguyễn Thoại', 'moc.trieu@example.net', 'user', '0908749436', 'AF6688', '2025-09-12 20:34:41', '$2y$12$SuUlq9WsGdJ.h/z5/NqAW.r0HQyzaed/9nPtXXoDa5DM2ZbJU2fz.', NULL, '2025-09-12 20:34:41', '2025-09-12 20:34:41', NULL),
(24, 'Cụ. Thập Anh Thục', 'thinh56@example.org', 'user', '0988067704', 'MR1730', '2025-09-12 20:34:42', '$2y$12$dThV8c5h33u12mSFkg/w2.Hzq9pD2QnTXKKneVXukNtX.K45QYJC6', NULL, '2025-09-12 20:34:42', '2025-09-12 20:34:42', NULL),
(25, 'Anh. Ánh Khoát', 'to.mai@example.com', 'user', '0966566857', 'JQ1379', '2025-09-12 20:34:42', '$2y$12$6AJ5J1VLIi76GNP6gMiDle509EbD/YQkCCyr9Ejy.5UrCKO6TcbFO', NULL, '2025-09-12 20:34:42', '2025-09-12 20:34:42', NULL),
(26, 'Chú. Đường Chế Nghiệp', 'hoc16@example.net', 'user', '0909764075', 'ZK2269', '2025-09-12 20:34:42', '$2y$12$ufp/pl2crs5.TDwL6guVJOq3Do0C8EQyb92og5LYhodR7x5Lq0Bea', NULL, '2025-09-12 20:34:42', '2025-09-12 20:34:42', NULL),
(27, 'Em. Lỳ Khuê', 'xuan26@example.net', 'user', '0911307201', 'PT1318', '2025-09-12 20:34:42', '$2y$12$9bMWtHoFM8vTfpTqXFmxnO6wl0ugcQRlL68ee9NAxp5BfSufFOXqO', NULL, '2025-09-12 20:34:42', '2025-09-12 20:34:42', NULL),
(28, 'Cụ. Giả Hà', 'man.thoi@example.com', 'user', '0913319584', 'IV4447', '2025-09-12 20:34:42', '$2y$12$ILzoNhh.feJNsETz8AabSuO5Op8YVyYYSHirqHhy.YNrSEPZ23TaW', NULL, '2025-09-12 20:34:42', '2025-09-12 20:34:42', NULL),
(29, 'Bá Pháp', 'tho12@example.org', 'user', '0978202376', 'HI6747', '2025-09-12 20:34:43', '$2y$12$4XF2G29U2imdC5.YOT9xCuoKNxmnBtDP.5T2.CDlTO1irZ9wR8u..', NULL, '2025-09-12 20:34:43', '2025-09-12 20:34:43', NULL),
(30, 'Ông. Lư Niệm Quế', 'khuc.thuan@example.com', 'user', '0981221157', 'AH2841', '2025-09-12 20:34:43', '$2y$12$B4634pTqfqfnaFCTmUEEZeSJiOd1AIgzjbyscrltHQGz6ZGPlAu8e', NULL, '2025-09-12 20:34:43', '2025-09-12 20:34:43', NULL),
(31, 'Anh. Quách Đồng Nhu', 'phi.hang@example.com', 'user', '0986985738', 'EC3138', '2025-09-12 20:34:43', '$2y$12$vQ4eH/eV12BIy2hHgwqpFupCymQzkUQEodoS14a44mo9OlkNy8fRm', NULL, '2025-09-12 20:34:43', '2025-09-12 20:34:43', NULL),
(32, 'Bác. Nhiệm Yên', 'tuyen.luong@example.net', 'user', '0988652882', 'NX2661', '2025-09-12 20:34:43', '$2y$12$SB.qJlsPKWG5jRT4Thwu4ul/CE2XjMtgGtNEFjCJ7IkHUd7mtYNI6', NULL, '2025-09-12 20:34:43', '2025-09-12 20:34:43', NULL),
(33, 'Bà. Tiếp Thúy', 'khue79@example.com', 'user', '0909387269', 'EV9191', '2025-09-12 20:34:43', '$2y$12$7062aT3TL/UDMJrPHLva9O2ckCuGurSPHA9VO4mwRfzczSiAUAy7m', NULL, '2025-09-12 20:34:43', '2025-09-12 20:34:43', NULL),
(34, 'Em. Bạch Nam Từ', 'hai.trieu@example.net', 'user', '0983992843', 'KX2190', '2025-09-12 20:34:44', '$2y$12$c2aiOakNg9EA6jmll/sRO.Uz6hDpWToUz9GpqCaHfVnR6MP8dE8xm', NULL, '2025-09-12 20:34:44', '2025-09-12 20:34:44', NULL),
(35, 'Viên Tân', 'trinh.thuy@example.org', 'user', '0905414972', 'PW7012', '2025-09-12 20:34:44', '$2y$12$EKuPR76YWgaCV6oEJpMOk.om5yXHSFcgZDJ.amx/lHOnrnOa5xacu', NULL, '2025-09-12 20:34:44', '2025-09-12 20:34:44', NULL),
(36, 'Phan Đăng', 'trinh.nguyet@example.org', 'user', '0917176006', 'KR6245', '2025-09-12 20:34:44', '$2y$12$MDsG8CIOetFLan89tS407ONZOgNlp2jCaVK2zwTLajilJ1iy8e53S', NULL, '2025-09-12 20:34:44', '2025-09-12 20:34:44', NULL),
(37, 'Ánh Bình', 'tuyet.mach@example.net', 'user', '0982766417', 'YO3785', '2025-09-12 20:34:44', '$2y$12$2nlimvP3Ewic2sdmdHtKl.w7OY657gaXH4NAksdzR.WK7ztPe3mrq', NULL, '2025-09-12 20:34:44', '2025-09-12 20:34:44', NULL),
(38, 'Hoa Nghĩa Thời', 'thuan.khoa@example.org', 'user', '0983545251', 'PH7576', '2025-09-12 20:34:45', '$2y$12$B6JLRxQSL31tAoeb/.Vh.O46A527cfp0WPDEIEd5vkzORGccDWS5u', NULL, '2025-09-12 20:34:45', '2025-09-12 20:34:45', NULL),
(39, 'Em. Ngân Lập Phi', 'chieu.phi@example.org', 'user', '0962047545', 'HL4548', '2025-09-12 20:34:45', '$2y$12$kGOXLBa6E61oL7sNHfg5p.7RQbOnoyInnQDyswXOMlM.QztaIjmam', NULL, '2025-09-12 20:34:45', '2025-09-12 20:34:45', NULL),
(40, 'Bà. Âu Thùy', 'mau.ngoc@example.net', 'user', '0904707923', 'OJ5883', '2025-09-12 20:34:45', '$2y$12$XWHHKocUMTZiH9dVjv1.Au4HijU3tuxjzu9vOsKgh0mPEEfVbZYw6', NULL, '2025-09-12 20:34:45', '2025-09-12 20:34:45', NULL),
(41, 'Bác. Trịnh Tường', 'lac.minh@example.net', 'user', '0946270335', 'JK6416', '2025-09-12 20:34:45', '$2y$12$cd.s3XLp84rnN/3xC992ieKjl5A6opcHKd1POSa3OjT6zR5DWoybm', NULL, '2025-09-12 20:34:45', '2025-09-12 20:34:45', NULL),
(42, 'Yên Mai', 'vinh.han@example.net', 'user', '0902696841', 'PD9438', '2025-09-12 20:34:45', '$2y$12$63NQ6KOj70iz/oFNSXwFEOTvFOUbnAJRDBRGRXORpVH3YQwDNodRC', NULL, '2025-09-12 20:34:45', '2025-09-12 20:34:45', NULL),
(43, 'Em. Kim Thắm', 'ehong@example.org', 'user', '0919912966', 'SO2683', '2025-09-12 20:34:46', '$2y$12$FrM/Z3ViRVU7RoOU.YdY3uJA1BI.HJkDHLioxrmhYHbnk1G5a1YPy', NULL, '2025-09-12 20:34:46', '2025-09-12 20:34:46', NULL),
(44, 'Chị. Thôi Phong', 'di.don@example.org', 'user', '0998322336', 'TA6282', '2025-09-12 20:34:46', '$2y$12$tJngOzyuTB6kTe5mK1P1R.PeDJZQ.6578IgAXmT7Np4pDG.WJFVSm', NULL, '2025-09-12 20:34:46', '2025-09-12 20:34:46', NULL),
(45, 'Phùng Trầm', 'thai.tram@example.com', 'user', '0902547043', 'JA8214', '2025-09-12 20:34:46', '$2y$12$Eh2cT0E7N9RUISO7ffzEz.qgMXtE3iz856RA7CODUR49BkGrOPRKi', NULL, '2025-09-12 20:34:46', '2025-09-12 20:34:46', NULL),
(46, 'Đồng Khôi Thông', 'apham@example.net', 'user', '0925416572', 'LC1114', '2025-09-12 20:34:46', '$2y$12$b23SH8nwWYOAziIGduu/Mu05zCfZtpgjyC86AqvI/J5m/Q/W2uCoS', NULL, '2025-09-12 20:34:46', '2025-09-12 20:34:46', NULL),
(47, 'Bà. Chiêm Sinh', 'toan.banh@example.net', 'user', '0997657255', 'QW7973', '2025-09-12 20:34:46', '$2y$12$EliTBl1Zdnk2cyUXUS3A7Omnr7H/lrbEF9HGQ7Ab0zCkOZVw/bQSq', NULL, '2025-09-12 20:34:46', '2025-09-12 20:34:46', NULL),
(48, 'Ông. Mạch Phú', 'dai.trinh@example.org', 'user', '0953684700', 'HH7911', '2025-09-12 20:34:47', '$2y$12$YnwW888O1ItsT59H7DeXWeYbJGXyjkSFyA8oHm/POARiPvA17GmJa', NULL, '2025-09-12 20:34:47', '2025-09-12 20:34:47', NULL),
(49, 'Khưu Cương', 'thien00@example.com', 'user', '0933918775', 'IZ9441', '2025-09-12 20:34:47', '$2y$12$R/MxVJa8Zqjsz1pXbckJl.YSu3AcaR4tQ4pHjrJqaz0Zx0g01llBa', NULL, '2025-09-12 20:34:47', '2025-09-12 20:34:47', NULL),
(50, 'Âu Huấn', 'uyen.ninh@example.org', 'user', '0965193693', 'BE9152', '2025-09-12 20:34:47', '$2y$12$EEllGIzT.K0q.UIbtyWfTePquQWMpUD.DsIz1C.yG3j7tSCyZBasG', NULL, '2025-09-12 20:34:47', '2025-09-12 20:34:47', NULL),
(51, 'Khuất Việt', 'bang.tu@example.net', 'user', '0915818617', 'BL3615', '2025-09-12 20:34:47', '$2y$12$R5hdSJkPCN0OiFVnCBD9Huk2sObwVAZyJoQn42uWtsHUgU9crs7ny', NULL, '2025-09-12 20:34:47', '2025-09-12 20:34:47', NULL),
(52, 'Phương Tuyền', 'lu.lam@example.org', 'user', '0925782300', 'OZ4716', '2025-09-12 20:34:48', '$2y$12$TxcbLNhJHZF5lXKa5qDaFuwHuwCdIEQdSlIyYSLNsh7SWtt1Vzop6', NULL, '2025-09-12 20:34:48', '2025-09-12 20:34:48', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `lich_su`
--
ALTER TABLE `lich_su`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lich_su_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nap_rut`
--
ALTER TABLE `nap_rut`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nap_rut_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `nhan_don`
--
ALTER TABLE `nhan_don`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nhan_don_user_id_foreign` (`user_id`),
  ADD KEY `nhan_don_san_pham_id_foreign` (`san_pham_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `phan_thuong`
--
ALTER TABLE `phan_thuong`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `slide_show`
--
ALTER TABLE `slide_show`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `lich_su`
--
ALTER TABLE `lich_su`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `nap_rut`
--
ALTER TABLE `nap_rut`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nhan_don`
--
ALTER TABLE `nhan_don`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phan_thuong`
--
ALTER TABLE `phan_thuong`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `slide_show`
--
ALTER TABLE `slide_show`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `lich_su`
--
ALTER TABLE `lich_su`
  ADD CONSTRAINT `lich_su_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `nap_rut`
--
ALTER TABLE `nap_rut`
  ADD CONSTRAINT `nap_rut_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `nhan_don`
--
ALTER TABLE `nhan_don`
  ADD CONSTRAINT `nhan_don_san_pham_id_foreign` FOREIGN KEY (`san_pham_id`) REFERENCES `phan_thuong` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `nhan_don_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
