-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2024 at 02:14 PM
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
(48, 8, 2, 'accepted', '2024-12-26 12:47:54');

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
(94, 24, 8, '2024-12-26 13:12:03');

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
(15, 5, 4, 'kesa hai', '2024-12-26 11:14:07', 'sent');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `from_user_id`, `content`, `is_read`, `created_at`) VALUES
(7, 1, 'friend_request', 6, 'uiux sent you a friend request', 0, '2024-12-26 12:14:31'),
(8, 5, 'friend_request', 6, 'uiux sent you a friend request', 0, '2024-12-26 12:18:32'),
(10, 2, 'friend_request', 6, 'uiux sent you a friend request', 0, '2024-12-26 12:18:50'),
(11, 3, 'friend_request', 6, 'uiux sent you a friend request', 0, '2024-12-26 12:19:06'),
(16, 7, 'friend_request', 3, 'ammar sent you a friend request', 0, '2024-12-26 12:27:16'),
(17, 1, 'friend_request', 7, 'almirah sent you a friend request', 0, '2024-12-26 12:32:27'),
(18, 2, 'friend_request_canceled', 1, 'fahad canceled their friend request', 0, '2024-12-26 12:41:14'),
(19, 2, 'friend_request', 1, 'fahad sent you a friend request', 0, '2024-12-26 12:41:29'),
(20, 1, 'friend_request', 8, 'hina sent you a friend request', 0, '2024-12-26 12:44:23'),
(21, 2, 'friend_request', 8, 'hina sent you a friend request', 0, '2024-12-26 12:46:03'),
(22, 8, 'friend_request_rejected', 2, 'adnan rejected your friend request', 0, '2024-12-26 12:46:31'),
(23, 2, 'friend_request', 8, 'hina sent you a friend request', 0, '2024-12-26 12:46:39'),
(24, 8, 'friend_request_rejected', 2, 'adnan rejected your friend request', 0, '2024-12-26 12:46:43'),
(25, 2, 'friend_request', 8, 'hina sent you a friend request', 0, '2024-12-26 12:47:54'),
(26, 8, 'friend_request_accepted', 2, 'adnan accepted your friend request', 0, '2024-12-26 12:48:02'),
(27, 4, 'friend_request_rejected', 2, 'adnan rejected your friend request', 0, '2024-12-26 12:51:16'),
(28, 5, 'friend_request_rejected', 2, 'adnan rejected your friend request', 0, '2024-12-26 12:51:18'),
(29, 6, 'friend_request_rejected', 2, 'adnan rejected your friend request', 0, '2024-12-26 12:51:19'),
(35, 3, 'friend_request_canceled', 2, 'adnan canceled their friend request', 0, '2024-12-26 13:07:22'),
(36, 4, 'friend_request_canceled', 2, 'adnan canceled their friend request', 0, '2024-12-26 13:07:23'),
(37, 5, 'friend_request_canceled', 2, 'adnan canceled their friend request', 0, '2024-12-26 13:07:23'),
(38, 6, 'friend_request_canceled', 2, 'adnan canceled their friend request', 0, '2024-12-26 13:07:24'),
(39, 7, 'friend_request_canceled', 2, 'adnan canceled their friend request', 0, '2024-12-26 13:07:24');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `image`, `created_at`) VALUES
(1, 1, 'hello', NULL, '2024-12-24 11:55:24'),
(2, 1, 'main hu doremon', NULL, '2024-12-24 11:55:36'),
(3, 1, 'ap log kia kr rahe hain?', NULL, '2024-12-24 11:55:50'),
(4, 1, 'kese hain ap log', NULL, '2024-12-24 11:58:48'),
(5, 1, 'han bhai', NULL, '2024-12-24 12:06:35'),
(6, 1, 'kesa hai bhai', NULL, '2024-12-24 12:25:46'),
(7, 1, 'hello\r\n', NULL, '2024-12-24 13:13:41'),
(8, 2, 'helo bhai\r\n', NULL, '2024-12-26 06:04:48'),
(9, 1, 'check this', '676d0de0d5620.png', '2024-12-26 08:03:44'),
(10, 1, 'behtreen yaar', '676d0df33a325.png', '2024-12-26 08:04:03'),
(11, 2, 'error ara hai', '676d2865db082.png', '2024-12-26 09:56:53'),
(12, 2, 'beeru log ', '676d2f4e082cf.png', '2024-12-26 10:26:22'),
(13, 2, 'testing New Fb Clone', '676d2f708ee9c.png', '2024-12-26 10:26:56'),
(14, 1, 'sasas', '676d31d948f58.png', '2024-12-26 10:37:13'),
(15, 1, 'My Database', '676d3763249f5.png', '2024-12-26 11:00:51'),
(16, 5, '', '676d383263e98.jpg', '2024-12-26 11:04:18'),
(17, 5, 'New', '676d383f05bd5.jpg', '2024-12-26 11:04:31'),
(18, 5, 'New', '676d384896cdf.jpg', '2024-12-26 11:04:40'),
(19, 5, '', '676d385913f49.jpg', '2024-12-26 11:04:57'),
(20, 5, '', '676d3863ccf5c.jpg', '2024-12-26 11:05:07'),
(21, 6, 'asasa', '676d3ebe808fb.jpg', '2024-12-26 11:32:14'),
(22, 7, 'haan', NULL, '2024-12-26 12:35:18'),
(23, 2, 'sss', '676d5589e982b.jpg', '2024-12-26 13:09:29'),
(24, 8, 's', '676d561945abb.jpg', '2024-12-26 13:11:53');

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
  `city` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_pic`, `created_at`, `city`) VALUES
(1, 'fahad', 'fahadfaisal694@gmail.com', '$2y$10$BB8pFb4DGCIVUS7THipL0eHgGwbQee/b7EPlRVLE0gD4W5wPvw0m.', '676cfdc4a64c4.png', '2024-12-24 11:53:15', 'karachi'),
(2, 'adnan', 'adnan@gmail.com', '$2y$10$XoXzqitJphMIzobelcBIhuXHl3JvdogONW1S4vl27VA7IP9hI8acu', 'default.jpg', '2024-12-24 12:28:09', NULL),
(3, 'ammar', 'amamr@gmail.com', '$2y$10$IQldg8kh03OTXKK/nNjgrO7yfSLdkPPUPE10MX84IV1LpukuqH/r.', 'default.jpg', '2024-12-24 12:28:24', 'islamabad'),
(4, 'adeel faisal', 'adeel@gmail.com', '$2y$10$anyEvHVDEDCFxH6JeUyrq.daY0MMXVWBR4HXW7iXWeX9msB.4dlfi', 'default.jpg', '2024-12-24 12:28:35', 'karachi'),
(5, 'zain', 'zain@gmail.com', '$2y$10$XJDJkAhTKn9rtkM7SNt1euL3gkFK9Z7ZEhKXwA4Ws1iP6spPd40B6', '676d38782732d.jpg', '2024-12-26 11:02:21', NULL),
(6, 'uiux', 'uiux@gmail.com', '$2y$10$DTKBlGo.wvV7M26Uv.njNuSXv/V8vUikaiNfaqrFrW1AI6ISOYrLq', '676d3f12054cb.jpg', '2024-12-26 11:26:56', NULL),
(7, 'almirah', 'almirah@gmail.com', '$2y$10$b41yEVr/zRyZ2P7VK/Jwout2EnHLMiqaImcU1MUVTm8SLY4uZji9m', '676d4cf22af59.jpg', '2024-12-26 11:35:20', NULL),
(8, 'hina', 'hina@gmail.com', '$2y$10$bDz0.YzRRw3Q1OG98XdHtuOY4rN/qcRxqmGFmXOI.sws5W8413E66', '676d51b406662.jpg', '2024-12-26 12:44:04', NULL);

--
-- Indexes for dumped tables
--

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
  ADD KEY `from_user_id` (`from_user_id`);

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
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
