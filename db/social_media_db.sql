-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2024 at 01:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_media_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `id` int(11) NOT NULL,
  `user_id1` int(11) NOT NULL,
  `user_id2` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender_id`, `receiver_id`, `status`, `created_at`) VALUES
(1, 4, 1, 'accepted', '2024-12-26 10:59:31'),
(3, 4, 3, 'rejected', '2024-12-26 10:59:34'),
(5, 1, 3, 'accepted', '2024-12-26 11:00:13'),
(6, 5, 1, 'rejected', '2024-12-26 11:09:40'),
(7, 5, 3, 'rejected', '2024-12-26 11:09:41'),
(9, 5, 4, 'accepted', '2024-12-26 11:09:42'),
(15, 7, 6, 'rejected', '2024-12-26 11:35:44'),
(32, 6, 1, 'rejected', '2024-12-26 12:14:31'),
(33, 6, 1, 'rejected', '2024-12-26 12:14:31'),
(34, 6, 5, 'pending', '2024-12-26 12:18:32'),
(37, 6, 3, 'rejected', '2024-12-26 12:19:06'),
(42, 3, 7, 'pending', '2024-12-26 12:27:16'),
(43, 7, 1, 'rejected', '2024-12-26 12:32:27'),
(44, 1, 2, 'rejected', '2024-12-26 12:41:29'),
(45, 8, 1, 'rejected', '2024-12-26 12:44:23'),
(48, 8, 2, 'accepted', '2024-12-26 12:47:54'),
(56, 2, 7, 'accepted', '2024-12-30 10:28:17'),
(57, 4, 7, 'accepted', '2024-12-30 10:33:07'),
(58, 4, 2, 'accepted', '2024-12-30 10:43:21'),
(59, 2, 5, 'pending', '2024-12-30 10:44:11'),
(60, 1, 9, 'accepted', '2024-12-30 12:23:52'),
(63, 4, 9, 'accepted', '2024-12-30 12:25:08'),
(69, 11, 4, 'accepted', '2024-12-30 13:08:48');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_id`, `created_at`) VALUES
(3, 9, 2, '2024-12-26 10:17:00'),
(4, 8, 2, '2024-12-26 10:17:02'),
(5, 6, 2, '2024-12-26 10:17:09'),
(6, 5, 2, '2024-12-26 10:17:10'),
(7, 3, 2, '2024-12-26 10:17:12'),
(8, 11, 2, '2024-12-26 10:17:28'),
(9, 2, 2, '2024-12-26 10:17:40'),
(10, 1, 2, '2024-12-26 10:17:41'),
(11, 4, 2, '2024-12-26 10:17:42'),
(19, 10, 2, '2024-12-26 10:25:51'),
(20, 7, 2, '2024-12-26 10:25:54'),
(21, 12, 2, '2024-12-26 10:26:25'),
(22, 13, 2, '2024-12-26 10:27:01'),
(23, 13, 1, '2024-12-26 10:36:23'),
(24, 12, 1, '2024-12-26 10:36:25'),
(25, 11, 1, '2024-12-26 10:36:26'),
(26, 10, 1, '2024-12-26 10:36:26'),
(27, 9, 1, '2024-12-26 10:36:27'),
(28, 8, 1, '2024-12-26 10:36:29'),
(29, 7, 1, '2024-12-26 10:36:30'),
(30, 6, 1, '2024-12-26 10:36:31'),
(31, 4, 1, '2024-12-26 10:36:32'),
(32, 5, 1, '2024-12-26 10:36:33'),
(33, 3, 1, '2024-12-26 10:36:34'),
(34, 2, 1, '2024-12-26 10:36:35'),
(35, 1, 1, '2024-12-26 10:36:36'),
(36, 14, 1, '2024-12-26 10:37:17'),
(37, 14, 4, '2024-12-26 10:45:44'),
(38, 13, 4, '2024-12-26 10:45:47'),
(39, 12, 4, '2024-12-26 10:45:48'),
(40, 11, 4, '2024-12-26 10:45:50'),
(41, 10, 4, '2024-12-26 10:45:51'),
(42, 9, 4, '2024-12-26 10:45:52'),
(43, 8, 4, '2024-12-26 10:45:53'),
(44, 4, 4, '2024-12-26 10:46:37'),
(45, 5, 4, '2024-12-26 10:46:38'),
(46, 3, 4, '2024-12-26 10:46:39'),
(47, 2, 4, '2024-12-26 10:46:40'),
(48, 1, 4, '2024-12-26 10:46:41'),
(49, 6, 4, '2024-12-26 10:56:44'),
(50, 7, 4, '2024-12-26 10:56:45'),
(51, 20, 5, '2024-12-26 11:12:43'),
(52, 19, 5, '2024-12-26 11:12:44'),
(53, 18, 5, '2024-12-26 11:12:45'),
(54, 17, 5, '2024-12-26 11:12:48'),
(55, 16, 5, '2024-12-26 11:12:49'),
(56, 19, 6, '2024-12-26 11:31:24'),
(57, 20, 6, '2024-12-26 11:31:26'),
(58, 18, 6, '2024-12-26 11:31:27'),
(59, 17, 6, '2024-12-26 11:31:28'),
(60, 16, 6, '2024-12-26 11:31:29'),
(61, 15, 6, '2024-12-26 11:31:30'),
(62, 14, 6, '2024-12-26 11:31:32'),
(63, 13, 6, '2024-12-26 11:31:34'),
(64, 12, 6, '2024-12-26 11:31:35'),
(65, 11, 6, '2024-12-26 11:31:36'),
(66, 10, 6, '2024-12-26 11:31:38'),
(67, 9, 6, '2024-12-26 11:31:39'),
(68, 8, 6, '2024-12-26 11:31:39'),
(69, 7, 6, '2024-12-26 11:31:40'),
(70, 6, 6, '2024-12-26 11:31:41'),
(71, 5, 6, '2024-12-26 11:31:42'),
(72, 3, 6, '2024-12-26 11:31:43'),
(73, 2, 6, '2024-12-26 11:31:44'),
(74, 1, 6, '2024-12-26 11:31:44'),
(77, 21, 6, '2024-12-26 11:33:01'),
(79, 20, 7, '2024-12-26 12:27:48'),
(80, 21, 7, '2024-12-26 12:27:50'),
(81, 13, 7, '2024-12-26 12:27:56'),
(82, 12, 7, '2024-12-26 12:27:59'),
(83, 11, 7, '2024-12-26 12:28:00'),
(84, 10, 7, '2024-12-26 12:28:01'),
(85, 8, 7, '2024-12-26 12:28:02'),
(86, 9, 7, '2024-12-26 12:28:03'),
(87, 5, 7, '2024-12-26 12:28:04'),
(88, 4, 7, '2024-12-26 12:28:05'),
(89, 20, 1, '2024-12-26 12:33:23'),
(90, 21, 1, '2024-12-26 12:33:24'),
(91, 19, 1, '2024-12-26 12:33:26'),
(93, 21, 2, '2024-12-26 13:08:54'),
(94, 24, 8, '2024-12-26 13:12:03'),
(95, 24, 2, '2024-12-30 10:27:23'),
(96, 20, 2, '2024-12-30 10:27:27'),
(97, 19, 2, '2024-12-30 10:27:28'),
(98, 25, 9, '2024-12-30 11:06:49'),
(99, 24, 9, '2024-12-30 11:08:01'),
(100, 23, 9, '2024-12-30 11:08:03'),
(101, 22, 9, '2024-12-30 11:08:04'),
(102, 21, 9, '2024-12-30 11:08:05'),
(103, 20, 9, '2024-12-30 11:08:06'),
(104, 19, 9, '2024-12-30 11:08:07'),
(105, 18, 9, '2024-12-30 11:08:09'),
(106, 17, 9, '2024-12-30 11:08:11'),
(107, 16, 9, '2024-12-30 11:08:12'),
(108, 15, 9, '2024-12-30 11:08:13'),
(109, 13, 9, '2024-12-30 11:08:20'),
(110, 12, 9, '2024-12-30 11:08:22'),
(111, 11, 9, '2024-12-30 11:08:23'),
(112, 10, 9, '2024-12-30 11:08:24'),
(113, 8, 9, '2024-12-30 11:08:26'),
(114, 9, 9, '2024-12-30 11:08:26'),
(115, 25, 1, '2024-12-30 11:56:37'),
(116, 26, 10, '2024-12-30 12:53:57'),
(117, 26, 11, '2024-12-30 13:16:14'),
(118, 25, 11, '2024-12-30 13:16:15'),
(119, 24, 11, '2024-12-30 13:16:16'),
(120, 23, 11, '2024-12-30 13:16:17'),
(121, 29, 4, '2024-12-31 08:03:54'),
(122, 30, 4, '2024-12-31 08:03:55'),
(123, 31, 4, '2024-12-31 08:03:58'),
(124, 32, 4, '2024-12-31 12:14:16'),
(125, 33, 4, '2024-12-31 12:14:20'),
(126, 27, 4, '2024-12-31 12:14:25'),
(127, 26, 4, '2024-12-31 12:14:27'),
(128, 25, 4, '2024-12-31 12:14:28');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('sent','delivered','read') DEFAULT 'sent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`, `status`) VALUES
(1, 1, 2, 'hello', '2024-12-24 12:28:55', 'sent'),
(2, 1, 2, 'bhai', '2024-12-24 12:29:09', 'sent'),
(3, 2, 1, 'theek bhai', '2024-12-24 12:32:44', 'sent'),
(4, 1, 2, 'aur suna sab', '2024-12-24 12:33:07', 'sent'),
(5, 1, 2, 'hello bha', '2024-12-24 13:12:06', 'sent'),
(6, 2, 1, 'aur suna sab', '2024-12-24 13:12:47', 'sent'),
(7, 2, 1, 'shukr Allah Ka', '2024-12-24 13:13:00', 'sent'),
(8, 2, 1, 'hello bha', '2024-12-26 05:33:06', 'sent'),
(9, 2, 1, 'kia kr raha hai', '2024-12-26 05:33:10', 'sent'),
(10, 1, 3, 'han bhai', '2024-12-26 07:52:08', 'sent'),
(11, 1, 4, 'hello', '2024-12-26 07:52:13', 'sent'),
(12, 1, 2, 'aur suna sab', '2024-12-26 10:37:04', 'sent'),
(13, 1, 4, 'haan meri jaan', '2024-12-26 11:00:05', 'sent'),
(14, 4, 5, 'haan bhai', '2024-12-26 11:13:31', 'sent'),
(15, 5, 4, 'kesa hai', '2024-12-26 11:14:07', 'sent'),
(16, 4, 7, 'hello', '2024-12-30 10:33:38', 'sent'),
(17, 4, 7, 'kese ho', '2024-12-30 10:33:53', 'sent'),
(18, 4, 7, 'asa', '2024-12-30 10:34:02', 'sent'),
(19, 4, 7, 'bha', '2024-12-30 10:34:18', 'sent'),
(20, 7, 4, 'g', '2024-12-30 10:34:41', 'sent'),
(21, 7, 4, 'asasasas', '2024-12-30 10:34:58', 'sent'),
(22, 4, 7, 'aur suna sab', '2024-12-30 10:34:59', 'sent'),
(23, 7, 4, 's', '2024-12-30 10:35:05', 'sent'),
(24, 4, 7, 's', '2024-12-30 10:35:08', 'sent'),
(25, 7, 1, 'asas', '2024-12-30 10:35:27', 'sent'),
(26, 4, 7, 'hello', '2024-12-30 10:36:34', 'sent'),
(27, 4, 7, 'kasjka', '2024-12-30 10:36:40', 'sent'),
(28, 4, 7, 'aska', '2024-12-30 10:37:02', 'sent'),
(29, 4, 7, 'siajs', '2024-12-30 10:37:25', 'sent'),
(30, 4, 7, 'aur suna sab', '2024-12-30 10:37:55', 'sent'),
(31, 10, 1, 'saad', '2024-12-30 12:51:37', 'sent');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sender_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `from_user_id`, `content`, `is_read`, `created_at`, `sender_id`) VALUES
(7, 1, 'friend_request', 6, 'uiux sent you a friend request', 0, '2024-12-26 12:14:31', NULL),
(8, 5, 'friend_request', 6, 'uiux sent you a friend request', 0, '2024-12-26 12:18:32', NULL),
(10, 2, 'friend_request', 6, 'uiux sent you a friend request', 0, '2024-12-26 12:18:50', NULL),
(11, 3, 'friend_request', 6, 'uiux sent you a friend request', 0, '2024-12-26 12:19:06', NULL),
(16, 7, 'friend_request', 3, 'ammar sent you a friend request', 0, '2024-12-26 12:27:16', NULL),
(17, 1, 'friend_request', 7, 'almirah sent you a friend request', 0, '2024-12-26 12:32:27', NULL),
(18, 2, 'friend_request_canceled', 1, 'fahad canceled their friend request', 0, '2024-12-26 12:41:14', NULL),
(19, 2, 'friend_request', 1, 'fahad sent you a friend request', 0, '2024-12-26 12:41:29', NULL),
(20, 1, 'friend_request', 8, 'hina sent you a friend request', 0, '2024-12-26 12:44:23', NULL),
(21, 2, 'friend_request', 8, 'hina sent you a friend request', 0, '2024-12-26 12:46:03', NULL),
(22, 8, 'friend_request_rejected', 2, 'adnan rejected your friend request', 0, '2024-12-26 12:46:31', NULL),
(23, 2, 'friend_request', 8, 'hina sent you a friend request', 0, '2024-12-26 12:46:39', NULL),
(24, 8, 'friend_request_rejected', 2, 'adnan rejected your friend request', 0, '2024-12-26 12:46:43', NULL),
(25, 2, 'friend_request', 8, 'hina sent you a friend request', 0, '2024-12-26 12:47:54', NULL),
(26, 8, 'friend_request_accepted', 2, 'adnan accepted your friend request', 0, '2024-12-26 12:48:02', NULL),
(27, 4, 'friend_request_rejected', 2, 'adnan rejected your friend request', 1, '2024-12-26 12:51:16', NULL),
(28, 5, 'friend_request_rejected', 2, 'adnan rejected your friend request', 0, '2024-12-26 12:51:18', NULL),
(29, 6, 'friend_request_rejected', 2, 'adnan rejected your friend request', 0, '2024-12-26 12:51:19', NULL),
(35, 3, 'friend_request_canceled', 2, 'adnan canceled their friend request', 0, '2024-12-26 13:07:22', NULL),
(36, 4, 'friend_request_canceled', 2, 'adnan canceled their friend request', 1, '2024-12-26 13:07:23', NULL),
(37, 5, 'friend_request_canceled', 2, 'adnan canceled their friend request', 0, '2024-12-26 13:07:23', NULL),
(38, 6, 'friend_request_canceled', 2, 'adnan canceled their friend request', 0, '2024-12-26 13:07:24', NULL),
(39, 7, 'friend_request_canceled', 2, 'adnan canceled their friend request', 0, '2024-12-26 13:07:24', NULL),
(41, 7, 'friend_request_canceled', 2, 'adnan canceled their friend request', 0, '2024-12-30 10:27:55', NULL),
(43, 7, 'friend_request', 2, 'adnan sent you a friend request', 0, '2024-12-30 10:28:17', NULL),
(44, 2, 'friend_request_accepted', 7, 'almirah accepted your friend request', 0, '2024-12-30 10:29:20', NULL),
(45, 7, 'friend_request', 4, 'adeel faisal sent you a friend request', 0, '2024-12-30 10:33:07', NULL),
(46, 4, 'friend_request_accepted', 7, 'almirah accepted your friend request', 1, '2024-12-30 10:33:15', NULL),
(47, 2, 'friend_request', 4, 'adeel faisal sent you a friend request', 0, '2024-12-30 10:43:21', NULL),
(48, 4, 'friend_request_accepted', 2, 'adnan accepted your friend request', 1, '2024-12-30 10:43:58', NULL),
(49, 5, 'friend_request_canceled', 2, 'adnan canceled their friend request', 0, '2024-12-30 10:44:10', NULL),
(50, 5, 'friend_request', 2, 'adnan sent you a friend request', 0, '2024-12-30 10:44:11', NULL),
(51, 9, 'friend_request', 1, 'saad sent you a friend request', 1, '2024-12-30 12:23:52', NULL),
(52, 1, 'friend_request_accepted', 9, 'Liaqat accepted your friend request', 0, '2024-12-30 12:24:23', NULL),
(55, 9, 'friend_request', 4, 'adeel faisal sent you a friend request', 1, '2024-12-30 12:25:08', NULL),
(57, 4, 'friend_request_accepted', 9, 'Liaqat accepted your friend request', 1, '2024-12-30 12:25:46', NULL),
(58, 6, 'friend_request_canceled', 4, 'adeel faisal canceled their friend request', 0, '2024-12-30 12:42:41', NULL),
(59, 8, 'friend_request_canceled', 4, 'adeel faisal canceled their friend request', 0, '2024-12-30 12:42:42', NULL),
(60, 10, 'friend_request_canceled', 4, 'adeel faisal canceled their friend request', 1, '2024-12-30 12:42:43', NULL),
(62, 10, 'friend_request_canceled', 4, 'adeel faisal canceled their friend request', 1, '2024-12-30 12:43:22', NULL),
(64, 10, 'friend_request_canceled', 4, 'adeel faisal canceled their friend request', 1, '2024-12-30 12:43:39', NULL),
(66, 10, 'friend_request_canceled', 4, 'adeel faisal canceled their friend request', 1, '2024-12-30 12:43:49', NULL),
(67, 10, 'friend_request', 4, 'adeel faisal sent you a friend request', 1, '2024-12-30 12:43:50', NULL),
(68, 4, 'friend_request_rejected', 10, 'samir rejected your friend request', 1, '2024-12-30 12:47:54', NULL),
(69, 4, 'friend_request', 11, 'buggati sent you a friend request', 1, '2024-12-30 13:08:48', NULL),
(70, 11, 'friend_request_accepted', 4, 'adeel faisal accepted your friend request', 1, '2024-12-30 13:09:02', NULL),
(72, 8, 'friend_request_canceled', 11, 'buggati canceled their friend request', 0, '2024-12-30 13:11:29', NULL),
(76, 1, 'friend_request_canceled', 11, 'buggati canceled their friend request', 0, '2024-12-30 13:15:38', NULL),
(77, 2, 'friend_request_canceled', 11, 'buggati canceled their friend request', 0, '2024-12-30 13:15:38', NULL),
(78, 3, 'friend_request_canceled', 11, 'buggati canceled their friend request', 0, '2024-12-30 13:15:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `likes_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `image`, `created_at`, `likes_count`) VALUES
(1, 1, 'hello', NULL, '2024-12-24 11:55:24', 0),
(2, 1, 'main hu doremon', NULL, '2024-12-24 11:55:36', 0),
(3, 1, 'ap log kia kr rahe hain?', NULL, '2024-12-24 11:55:50', 0),
(4, 1, 'kese hain ap log', NULL, '2024-12-24 11:58:48', 0),
(5, 1, 'han bhai', NULL, '2024-12-24 12:06:35', 0),
(6, 1, 'kesa hai bhai', NULL, '2024-12-24 12:25:46', 0),
(7, 1, 'hello\r\n', NULL, '2024-12-24 13:13:41', 0),
(8, 2, 'helo bhai\r\n', NULL, '2024-12-26 06:04:48', 0),
(9, 1, 'check this', '676d0de0d5620.png', '2024-12-26 08:03:44', 0),
(10, 1, 'behtreen yaar', '676d0df33a325.png', '2024-12-26 08:04:03', 0),
(11, 2, 'error ara hai', '676d2865db082.png', '2024-12-26 09:56:53', 0),
(12, 2, 'beeru log ', '676d2f4e082cf.png', '2024-12-26 10:26:22', 0),
(13, 2, 'testing New Fb Clone', '676d2f708ee9c.png', '2024-12-26 10:26:56', 0),
(14, 1, 'sasas', '676d31d948f58.png', '2024-12-26 10:37:13', 0),
(15, 1, 'My Database', '676d3763249f5.png', '2024-12-26 11:00:51', 0),
(16, 5, '', '676d383263e98.jpg', '2024-12-26 11:04:18', 0),
(17, 5, 'New', '676d383f05bd5.jpg', '2024-12-26 11:04:31', 0),
(18, 5, 'New', '676d384896cdf.jpg', '2024-12-26 11:04:40', 0),
(19, 5, '', '676d385913f49.jpg', '2024-12-26 11:04:57', 0),
(20, 5, '', '676d3863ccf5c.jpg', '2024-12-26 11:05:07', 0),
(21, 6, 'asasa', '676d3ebe808fb.jpg', '2024-12-26 11:32:14', 0),
(22, 7, 'haan', NULL, '2024-12-26 12:35:18', 0),
(23, 2, 'sss', '676d5589e982b.jpg', '2024-12-26 13:09:29', 0),
(24, 8, 's', '676d561945abb.jpg', '2024-12-26 13:11:53', 0),
(25, 4, 'New Update ', '677276514a27b.jpg', '2024-12-30 10:30:41', 0),
(26, 10, '', '6772979ad3b8e.png', '2024-12-30 12:52:42', 0),
(27, 11, 'gagas', NULL, '2024-12-30 13:01:44', 0),
(28, 11, '', '67729d28f37cf.png', '2024-12-30 13:16:24', 0),
(29, 4, 'sasa', NULL, '2024-12-31 07:06:15', 0),
(30, 4, '', NULL, '2024-12-31 07:07:03', 0),
(31, 4, '', '677398216b4f3.png', '2024-12-31 07:07:13', 0),
(32, 4, '', NULL, '2024-12-31 08:20:51', 0),
(33, 4, '', '6773a968bba51.jpg', '2024-12-31 08:20:56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT 'default.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `city` varchar(50) DEFAULT NULL,
  `post_privacy` enum('public','friends','private') DEFAULT 'public',
  `friend_privacy` enum('everyone','friends_of_friends','none') DEFAULT 'everyone',
  `cover_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_pic`, `created_at`, `city`, `post_privacy`, `friend_privacy`, `cover_pic`) VALUES
(1, 'saad', 'fahad@gmail.com', '$2y$10$uCiDVQN99SYYnCngK1lGLuu3CifvLXgpmAH0UbSL9Z6R0eEiotFDu', '676cfdc4a64c4.png', '2024-12-24 11:53:15', 'islamabad', 'private', 'everyone', NULL),
(2, 'adnan', 'adnan@gmail.com', '$2y$10$XoXzqitJphMIzobelcBIhuXHl3JvdogONW1S4vl27VA7IP9hI8acu', '677275e61056f.jpg', '2024-12-24 12:28:09', NULL, 'public', 'everyone', NULL),
(3, 'ammar', 'amamr@gmail.com', '$2y$10$IQldg8kh03OTXKK/nNjgrO7yfSLdkPPUPE10MX84IV1LpukuqH/r.', 'default.jpg', '2024-12-24 12:28:24', 'islamabad', 'public', 'everyone', NULL),
(4, 'adeel faisal', 'adeel@gmail.com', '$2y$10$anyEvHVDEDCFxH6JeUyrq.daY0MMXVWBR4HXW7iXWeX9msB.4dlfi', '6773a548b7440.png', '2024-12-24 12:28:35', 'karachi', 'public', 'everyone', '6773ded0ca79a.jpg'),
(5, 'zain', 'zain@gmail.com', '$2y$10$XJDJkAhTKn9rtkM7SNt1euL3gkFK9Z7ZEhKXwA4Ws1iP6spPd40B6', '676d38782732d.jpg', '2024-12-26 11:02:21', NULL, 'public', 'everyone', NULL),
(6, 'uiux', 'uiux@gmail.com', '$2y$10$DTKBlGo.wvV7M26Uv.njNuSXv/V8vUikaiNfaqrFrW1AI6ISOYrLq', '676d3f12054cb.jpg', '2024-12-26 11:26:56', NULL, 'public', 'everyone', NULL),
(7, 'almirah', 'almirah@gmail.com', '$2y$10$b41yEVr/zRyZ2P7VK/Jwout2EnHLMiqaImcU1MUVTm8SLY4uZji9m', '676d4cf22af59.jpg', '2024-12-26 11:35:20', NULL, 'public', 'everyone', NULL),
(8, 'hina', 'hina@gmail.com', '$2y$10$bDz0.YzRRw3Q1OG98XdHtuOY4rN/qcRxqmGFmXOI.sws5W8413E66', '676d51b406662.jpg', '2024-12-26 12:44:04', NULL, 'public', 'everyone', NULL),
(9, 'Liaqat', 'liaqat@gmail.com', '$2y$10$j6QL1brneJMKkzzpZTyDbOy45oxhrVeDYle1TZ6w1CL6yT0dyyfSm', 'default.jpg', '2024-12-30 10:44:59', 'islamabad', 'public', 'everyone', NULL),
(10, 'samir', 'samir@gmail.com', '$2y$10$6DocdZvgZW/5.Ot/uIC6juzH6KifCEuc2Io3Y.RkOWQNYF3MUttAO', 'default.jpg', '2024-12-30 11:46:07', 'Hyderabad', 'public', 'everyone', NULL),
(11, 'buggati', 'buggati@gmail.com', '$2y$10$Lzqw3dTTWafD9Y0bwS6HZObiNz0a2IYXg6a.f6OgIjF/f36iVyDgy', 'default.jpg', '2024-12-30 13:01:24', NULL, 'public', 'everyone', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `friend_id` (`friend_id`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id1` (`user_id1`),
  ADD KEY `user_id2` (`user_id2`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friendships`
--
ALTER TABLE `friendships`
  ADD CONSTRAINT `friendships_ibfk_1` FOREIGN KEY (`user_id1`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friendships_ibfk_2` FOREIGN KEY (`user_id2`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `friend_requests_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
