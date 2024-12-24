-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2024 at 02:15 PM
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
(7, 2, 1, 'shukr Allah Ka', '2024-12-24 13:13:00', 'sent');

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
(7, 1, 'hello\r\n', NULL, '2024-12-24 13:13:41');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_pic`, `created_at`) VALUES
(1, 'fahad', 'fahadfaisal694@gmail.com', '$2y$10$BB8pFb4DGCIVUS7THipL0eHgGwbQee/b7EPlRVLE0gD4W5wPvw0m.', 'default.jpg', '2024-12-24 11:53:15'),
(2, 'adnan', 'adnan@gmail.com', '$2y$10$XoXzqitJphMIzobelcBIhuXHl3JvdogONW1S4vl27VA7IP9hI8acu', 'default.jpg', '2024-12-24 12:28:09'),
(3, 'ammar', 'amamr@gmail.com', '$2y$10$IQldg8kh03OTXKK/nNjgrO7yfSLdkPPUPE10MX84IV1LpukuqH/r.', 'default.jpg', '2024-12-24 12:28:24'),
(4, 'adeel faisal', 'adeel@gmail.com', '$2y$10$anyEvHVDEDCFxH6JeUyrq.daY0MMXVWBR4HXW7iXWeX9msB.4dlfi', 'default.jpg', '2024-12-24 12:28:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
