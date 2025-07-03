-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2025 at 03:51 PM
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
-- Database: `eventify`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `organizer` varchar(100) DEFAULT NULL,
  `location` varchar(100) NOT NULL,
  `event_datetime` datetime NOT NULL,
  `description` text NOT NULL,
  `available_spots` int(11) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `event_type` enum('Meetup','Conference','Workshop') NOT NULL,
  `deadline_days` int(11) NOT NULL,
  `deadline_hours` int(11) NOT NULL,
  `deadline_minutes` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `event_name`, `organizer`, `location`, `event_datetime`, `description`, `available_spots`, `contact_info`, `event_type`, `deadline_days`, `deadline_hours`, `deadline_minutes`, `photo`, `created_at`) VALUES
(2, 4, 'Tech Leaders Meetup', 'Abebe', 'Skylight hotel', '2025-07-18 18:44:53', 'lorem ipusm', 218, '0911223344', 'Meetup', 20, 21, 20, './assets/video-image 1 (1).png', '2025-07-02 15:48:24'),
(9, 4, 'Tech Leaders Meetup', 'ABC', 'Skylight Hotel', '2025-07-19 14:08:00', 'Join us for the Tech Leaders Meetup, an exclusive gathering of visionary developers, IT professionals, startup founders, and tech executives who are shaping the future of technology in Ethiopia and beyond.\r\n\r\nThis event offers a platform for meaningful dialogue around innovation, digital transformation, leadership challenges, and emerging tech trends. Attendees will gain insights through expert-led panel discussions, lightning talks from local entrepreneurs, and peer networking designed to foster long-term collaboration.', 48, '0911223344', 'Meetup', 0, 20, 0, 'assets/uploads/event_686664cbe8a909.20753725.png', '2025-07-03 11:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED NOT NULL,
  `reserved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT './assets/Group 16.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_picture`) VALUES
(4, 'ABC', 'dshjakj@gmail.com', '$2y$10$CGEO1KM5UIwTWTeU91JTGOq.W9sbhlpIgvKVLN/PJiYpOtwkUHMcy', './assets/Group 16.png'),
(5, 'xzc', 'sdsaddsa@gmail.com', '$2y$10$l5yTkR51LA42ch0dgjxbye1lhvWQ2n54hdd8vLOfBiOoq95wKrvvu', './assets/Group 16.png'),
(6, 'Abebe', 'abebe@gmail.com', '$2y$10$2ef.qH5SvaMYZP3Kw1wCcOCgrZGOWH8VDpK5mK7aikL6.0odM9CBC', './assets/Group 16.png'),
(7, 'kebede', 'kebedee@gmail.com', '$2y$10$8pTb72N0irhLJH0U3Abl5eNh4wfTwEbVi3VURW7F3UQWSNIxz1YAy', './assets/Group 16.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`event_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_unique` (`username`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
