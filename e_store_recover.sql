-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2025 at 08:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_store_recover`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `photo`, `parent_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'blogs', 'uploads/1752068930_686e734238e8d.jpg', -395414718, NULL, '2025-07-09 13:48:50', '1989-02-24 07:36:32'),
(2, 'blogs', 'uploads/1752068999_686e7387d4295.jpg', -395414649, NULL, '2025-07-09 13:49:59', '1980-09-15 22:32:32'),
(3, 'police', 'uploads/1752131363_686f6723b1bab.jpg', 1, 'about what they need', '2025-07-10 07:09:23', '2025-07-10 07:09:23'),
(4, 'Babies', 'uploads/1752136521_686f7b4984d71.jpg', -512988128, NULL, '2027-02-08 07:27:32', '2031-03-17 09:18:30'),
(5, 'Baby shoes', 'uploads/1752136581_686f7b859977c.jpg', 4, 'both girls and boys ', '2025-07-10 08:36:21', '2025-07-10 08:36:21'),
(7, 'swabrah', 'uploads/1752234432_6870f9c084638.jpg', 5, 'kkk', '2025-07-11 11:47:12', '2025-07-11 11:47:12');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` varchar(50) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `user_name`, `created_at`, `order_status`, `total_price`) VALUES
(1, 5, 'pending', '2018-07-29 08:30:26', '24', 0),
(2, 5, 'pending', '2018-07-29 08:30:26', '34', 0),
(3, 5, 'pending', '2035-06-19 07:46:49', 'rst_name\":\"swabrah\",\"last_name\":\"h\",\"email\":\"kyosaaze@gmail.com\",\"phone\":\"0748289546\",\"address\":\"Kiboga\"}{\"34', 0),
(4, 5, 'pending', '2035-06-19 07:46:49', 'rst_name\":\"swabrah\",\"last_name\":\"h\",\"email\":\"kyosaaze@gmail.com\",\"phone\":\"0748289546\",\"address\":\"Kiboga\"}{\"42', 0),
(5, 5, 'pending', '2035-06-19 07:46:49', 'rst_name\":\"swabrah\",\"last_name\":\"h\",\"email\":\"kyosaaze@gmail.com\",\"phone\":\"0748289546\",\"address\":\"gilu\"}{\"46', 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `buying_price` decimal(10,2) DEFAULT 0.00,
  `selling_price` decimal(10,2) DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `photos` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `buying_price`, `selling_price`, `description`, `photos`, `created_at`, `updated_at`) VALUES
(1, 'Trendy Shoes #1', 2, 42.00, 67.00, 'This is a demo description for Trendy Shoes #1', '[\"uploads\\/01.jpg\",\"uploads\\/07.jpg\",\"uploads\\/05.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(2, 'LED Lamp #2', 7, 75.00, 96.00, 'This is a demo description for LED Lamp #2', '[\"uploads\\/16.jpg\",\"uploads\\/06.jpg\",\"uploads\\/03.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(3, 'Stylish Jacket #3', 1, 100.00, 127.00, 'This is a demo description for Stylish Jacket #3', '[\"uploads\\/16.jpg\",\"uploads\\/05.jpg\",\"uploads\\/04.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(4, 'Stylish Jacket #4', 2, 18.00, 32.00, 'This is a demo description for Stylish Jacket #4', '[\"uploads\\/05.jpg\",\"uploads\\/11.jpg\",\"uploads\\/16.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(5, 'LED Lamp #5', 4, 27.00, 73.00, 'This is a demo description for LED Lamp #5', '[\"uploads\\/07.jpg\",\"uploads\\/15.jpg\",\"uploads\\/06.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(6, 'Modern Chair #6', 4, 25.00, 58.00, 'This is a demo description for Modern Chair #6', '[\"uploads\\/19.jpg\",\"uploads\\/06.jpg\",\"uploads\\/14.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(7, 'Electric Kettle #7', 3, 67.00, 99.00, 'This is a demo description for Electric Kettle #7', '[\"uploads\\/07.jpg\",\"uploads\\/01.jpg\",\"uploads\\/15.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(8, 'Smart Device #8', 7, 66.00, 110.00, 'This is a demo description for Smart Device #8', '[\"uploads\\/06.jpg\",\"uploads\\/18.jpg\",\"uploads\\/05.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(9, 'Gaming Keyboard #9', 5, 94.00, 134.00, 'This is a demo description for Gaming Keyboard #9', '[\"uploads\\/02.jpg\",\"uploads\\/10.jpg\",\"uploads\\/11.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(10, 'Luxury Watch #10', 3, 89.00, 109.00, 'This is a demo description for Luxury Watch #10', '[\"uploads\\/06.jpg\",\"uploads\\/19.jpg\",\"uploads\\/08.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(11, 'Fashion Bag #11', 2, 42.00, 65.00, 'This is a demo description for Fashion Bag #11', '[\"uploads\\/06.jpg\",\"uploads\\/16.jpg\",\"uploads\\/04.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(12, 'Wireless Headphones #12', 5, 78.00, 114.00, 'This is a demo description for Wireless Headphones #12', '[\"uploads\\/15.jpg\",\"uploads\\/06.jpg\",\"uploads\\/10.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(13, 'Smart Device #13', 3, 87.00, 126.00, 'This is a demo description for Smart Device #13', '[\"uploads\\/05.jpg\",\"uploads\\/18.jpg\",\"uploads\\/09.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(14, 'Bluetooth Speaker #14', 5, 30.00, 72.00, 'This is a demo description for Bluetooth Speaker #14', '[\"uploads\\/15.jpg\",\"uploads\\/19.jpg\",\"uploads\\/03.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(15, 'Bluetooth Speaker #15', 2, 34.00, 57.00, 'This is a demo description for Bluetooth Speaker #15', '[\"uploads\\/14.jpg\",\"uploads\\/10.jpg\",\"uploads\\/13.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(16, 'Casual Sneakers #16', 4, 49.00, 75.00, 'This is a demo description for Casual Sneakers #16', '[\"uploads\\/13.jpg\",\"uploads\\/01.jpg\",\"uploads\\/11.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(17, 'Wireless Headphones #17', 5, 16.00, 46.00, 'This is a demo description for Wireless Headphones #17', '[\"uploads\\/02.jpg\",\"uploads\\/12.jpg\",\"uploads\\/04.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(18, 'Portable Charger #18', 7, 73.00, 122.00, 'This is a demo description for Portable Charger #18', '[\"uploads\\/05.jpg\",\"uploads\\/04.jpg\",\"uploads\\/19.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(19, 'Trendy Shoes #19', 2, 38.00, 84.00, 'This is a demo description for Trendy Shoes #19', '[\"uploads\\/05.jpg\",\"uploads\\/18.jpg\",\"uploads\\/08.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(20, 'Sports Gear #20', 1, 18.00, 49.00, 'This is a demo description for Sports Gear #20', '[\"uploads\\/07.jpg\",\"uploads\\/11.jpg\",\"uploads\\/15.jpg\"]', '2025-09-04 05:38:44', '2025-09-04 05:38:44'),
(21, 'Electric Kettle #1', 5, 40.00, 72.00, 'This is a demo description for Electric Kettle #1', '[\"uploads\\/08.jpg\",\"uploads\\/16.jpg\",\"uploads\\/12.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(22, 'Stylish Jacket #2', 4, 74.00, 86.00, 'This is a demo description for Stylish Jacket #2', '[\"uploads\\/06.jpg\",\"uploads\\/01.jpg\",\"uploads\\/17.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(23, 'Casual Sneakers #3', 7, 23.00, 65.00, 'This is a demo description for Casual Sneakers #3', '[\"uploads\\/13.jpg\",\"uploads\\/05.jpg\",\"uploads\\/15.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(24, 'Smart Device #4', 5, 61.00, 92.00, 'This is a demo description for Smart Device #4', '[\"uploads\\/17.jpg\",\"uploads\\/13.jpg\",\"uploads\\/18.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(25, 'Coffee Maker #5', 5, 75.00, 96.00, 'This is a demo description for Coffee Maker #5', '[\"uploads\\/14.jpg\",\"uploads\\/09.jpg\",\"uploads\\/11.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(26, 'Bluetooth Speaker #6', 7, 57.00, 84.00, 'This is a demo description for Bluetooth Speaker #6', '[\"uploads\\/14.jpg\",\"uploads\\/13.jpg\",\"uploads\\/12.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(27, 'Premium Gadget #7', 3, 91.00, 139.00, 'This is a demo description for Premium Gadget #7', '[\"uploads\\/13.jpg\",\"uploads\\/06.jpg\",\"uploads\\/10.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(28, 'Premium Gadget #8', 7, 45.00, 74.00, 'This is a demo description for Premium Gadget #8', '[\"uploads\\/12.jpg\",\"uploads\\/11.jpg\",\"uploads\\/16.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(29, 'Portable Charger #9', 4, 95.00, 139.00, 'This is a demo description for Portable Charger #9', '[\"uploads\\/20.jpg\",\"uploads\\/07.jpg\",\"uploads\\/13.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(30, 'Office Desk #10', 4, 82.00, 93.00, 'This is a demo description for Office Desk #10', '[\"uploads\\/18.jpg\",\"uploads\\/11.jpg\",\"uploads\\/19.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(31, 'Deluxe Item #11', 4, 71.00, 89.00, 'This is a demo description for Deluxe Item #11', '[\"uploads\\/06.jpg\",\"uploads\\/20.jpg\",\"uploads\\/18.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(32, 'Gaming Keyboard #12', 5, 24.00, 59.00, 'This is a demo description for Gaming Keyboard #12', '[\"uploads\\/13.jpg\",\"uploads\\/06.jpg\",\"uploads\\/11.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(33, 'Casual Sneakers #13', 3, 92.00, 124.00, 'This is a demo description for Casual Sneakers #13', '[\"uploads\\/02.jpg\",\"uploads\\/05.jpg\",\"uploads\\/20.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(34, 'Stylish Jacket #14', 3, 32.00, 60.00, 'This is a demo description for Stylish Jacket #14', '[\"uploads\\/07.jpg\",\"uploads\\/05.jpg\",\"uploads\\/14.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(35, 'Casual Sneakers #15', 7, 21.00, 48.00, 'This is a demo description for Casual Sneakers #15', '[\"uploads\\/13.jpg\",\"uploads\\/14.jpg\",\"uploads\\/20.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(36, 'Premium Gadget #16', 4, 15.00, 47.00, 'This is a demo description for Premium Gadget #16', '[\"uploads\\/20.jpg\",\"uploads\\/14.jpg\",\"uploads\\/16.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(37, 'Smart Device #17', 1, 97.00, 145.00, 'This is a demo description for Smart Device #17', '[\"uploads\\/08.jpg\",\"uploads\\/10.jpg\",\"uploads\\/16.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(38, 'LED Lamp #18', 4, 10.00, 32.00, 'This is a demo description for LED Lamp #18', '[\"uploads\\/06.jpg\",\"uploads\\/03.jpg\",\"uploads\\/12.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(39, 'Gaming Keyboard #19', 5, 26.00, 41.00, 'This is a demo description for Gaming Keyboard #19', '[\"uploads\\/12.jpg\",\"uploads\\/01.jpg\",\"uploads\\/05.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(40, 'Portable Charger #20', 1, 98.00, 143.00, 'This is a demo description for Portable Charger #20', '[\"uploads\\/15.jpg\",\"uploads\\/03.jpg\",\"uploads\\/14.jpg\"]', '2025-09-04 05:41:40', '2025-09-04 05:41:40'),
(41, 'Fitness Tracker #1', 1, 50.00, 63.00, 'This is a demo description for Fitness Tracker #1', '[\"uploads\\/19.jpg\",\"uploads\\/18.jpg\",\"uploads\\/17.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(42, 'Electric Kettle #2', 4, 73.00, 94.00, 'This is a demo description for Electric Kettle #2', '[\"uploads\\/20.jpg\",\"uploads\\/04.jpg\",\"uploads\\/03.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(43, 'Modern Chair #3', 1, 97.00, 134.00, 'This is a demo description for Modern Chair #3', '[\"uploads\\/02.jpg\",\"uploads\\/20.jpg\",\"uploads\\/10.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(44, 'Modern Chair #4', 3, 30.00, 40.00, 'This is a demo description for Modern Chair #4', '[\"uploads\\/20.jpg\",\"uploads\\/18.jpg\",\"uploads\\/11.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(45, 'Deluxe Item #5', 3, 98.00, 137.00, 'This is a demo description for Deluxe Item #5', '[\"uploads\\/11.jpg\",\"uploads\\/10.jpg\",\"uploads\\/17.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(46, 'Casual Sneakers #6', 7, 67.00, 84.00, 'This is a demo description for Casual Sneakers #6', '[\"uploads\\/19.jpg\",\"uploads\\/16.jpg\",\"uploads\\/11.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(47, 'Casual Sneakers #7', 4, 85.00, 104.00, 'This is a demo description for Casual Sneakers #7', '[\"uploads\\/18.jpg\",\"uploads\\/03.jpg\",\"uploads\\/13.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(48, 'Modern Chair #8', 3, 11.00, 36.00, 'This is a demo description for Modern Chair #8', '[\"uploads\\/10.jpg\",\"uploads\\/03.jpg\",\"uploads\\/13.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(49, 'Casual Sneakers #9', 4, 76.00, 112.00, 'This is a demo description for Casual Sneakers #9', '[\"uploads\\/02.jpg\",\"uploads\\/15.jpg\",\"uploads\\/01.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(50, 'Smart Device #10', 2, 48.00, 84.00, 'This is a demo description for Smart Device #10', '[\"uploads\\/05.jpg\",\"uploads\\/17.jpg\",\"uploads\\/09.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(51, 'Gaming Keyboard #11', 4, 96.00, 113.00, 'This is a demo description for Gaming Keyboard #11', '[\"uploads\\/14.jpg\",\"uploads\\/16.jpg\",\"uploads\\/02.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(52, 'Wireless Headphones #12', 7, 86.00, 115.00, 'This is a demo description for Wireless Headphones #12', '[\"uploads\\/05.jpg\",\"uploads\\/09.jpg\",\"uploads\\/02.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(53, 'Deluxe Item #13', 4, 39.00, 78.00, 'This is a demo description for Deluxe Item #13', '[\"uploads\\/10.jpg\",\"uploads\\/07.jpg\",\"uploads\\/04.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(54, 'Modern Chair #14', 4, 22.00, 40.00, 'This is a demo description for Modern Chair #14', '[\"uploads\\/17.jpg\",\"uploads\\/03.jpg\",\"uploads\\/13.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(55, 'Electric Kettle #15', 5, 16.00, 40.00, 'This is a demo description for Electric Kettle #15', '[\"uploads\\/01.jpg\",\"uploads\\/13.jpg\",\"uploads\\/19.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(56, 'LED Lamp #16', 5, 100.00, 124.00, 'This is a demo description for LED Lamp #16', '[\"uploads\\/08.jpg\",\"uploads\\/14.jpg\",\"uploads\\/06.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(57, 'Portable Charger #17', 4, 100.00, 121.00, 'This is a demo description for Portable Charger #17', '[\"uploads\\/14.jpg\",\"uploads\\/06.jpg\",\"uploads\\/18.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(58, 'Office Desk #18', 3, 33.00, 81.00, 'This is a demo description for Office Desk #18', '[\"uploads\\/09.jpg\",\"uploads\\/08.jpg\",\"uploads\\/05.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(59, 'Fitness Tracker #19', 5, 92.00, 109.00, 'This is a demo description for Fitness Tracker #19', '[\"uploads\\/09.jpg\",\"uploads\\/20.jpg\",\"uploads\\/02.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06'),
(60, 'Sports Gear #20', 3, 75.00, 120.00, 'This is a demo description for Sports Gear #20', '[\"uploads\\/17.jpg\",\"uploads\\/03.jpg\",\"uploads\\/04.jpg\"]', '2025-09-04 05:55:06', '2025-09-04 05:55:06');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_data` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_accounts`
--

CREATE TABLE `social_accounts` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'Swabrah', 'Kyosaaze', 'kyosaaze@gmail.com', '48289546', '$2y$10$eW5x1G5yq7ZzV2Jk4Nl9FuJ8JzQ5e7xRjQGQm7p92fU0KvzM6DqAq', '2025-09-04 05:16:12'),
(2, 'swab', 'me', 'saaze@gmail.com', '0782020015', '$2y$10$UnJLRcVwzMTYKFDPtyGg/eNbvM6NHFD5EgkA87SF2uwyxaVoHuRiW', '2025-09-04 05:43:04'),
(5, 'Swabrah', 'Kyosaaze', 'osaaze@gmail.com', '48289546', '48289546$2', '2034-05-28 07:43:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_accounts`
--
ALTER TABLE `social_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
