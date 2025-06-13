-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Generation Time: Jun 13, 2025 at 03:39 PM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u651019293_gymbookingapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_message` varchar(100) NOT NULL,
  `activity` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `user_id`, `activity_message`, `activity`, `created_at`) VALUES
(1, 5, 'sarah1234@gmail.com has added a new service $servicename', 'add_service', '2025-06-07 12:41:44'),
(2, 5, 'Sarah has added a new service $servicename', 'add_service', '2025-06-07 15:51:57'),
(3, 5, 'Sarah has added a new service cricket', 'add_service', '2025-06-07 16:28:22'),
(4, 9, 'Aimee Glenn has added a new service Tennis', 'add_service', '2025-06-10 21:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `bookingdatetime` datetime NOT NULL,
  `additionalinformation` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `client_id`, `service_id`, `bookingdatetime`, `additionalinformation`, `created_at`) VALUES
(2, 8, 3, '2025-08-12 14:00:00', 'Not really', '2025-06-07 15:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notificationcontent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `notificationcontent`, `created_at`) VALUES
(1, 5, 'dgsg has been added', '2025-06-07 12:41:44'),
(2, 5, 'Football has been added', '2025-06-07 15:51:57'),
(3, 5, 'cricket has been added', '2025-06-07 16:28:22'),
(4, 9, 'Tennis has been added', '2025-06-10 21:35:14'),
(5, 9, 'Tennis has been updated', '2025-06-10 21:35:22'),
(6, 5, 'Rugby has been updated', '2025-06-10 21:38:40');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `servicename` varchar(100) NOT NULL,
  `servicedescription` text DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `supplier_id`, `servicename`, `servicedescription`, `duration`, `price`, `created_at`) VALUES
(2, 5, 'Rugby', 'A rugby session', 30, 80.00, '2025-06-07 12:41:44'),
(3, 5, 'Football', 'A session', 80, 60.00, '2025-06-07 15:51:57'),
(4, 5, 'cricket', 'podmhdpm', 60, 20.00, '2025-06-07 16:28:22'),
(5, 9, 'Tennis', ' A beginner tennis session ', 60, 80.00, '2025-06-10 21:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `types` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `location` varchar(200) NOT NULL,
  `profilepicture` varchar(255) NOT NULL,
  `profiledescription` text NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password_hash`, `types`, `created_at`, `location`, `profilepicture`, `profiledescription`, `role`) VALUES
(5, 'Sarah', 'sarah1234@gmail.com', '$2y$10$/Z465op3fIrKA1HcCUBreu9rBliA5Eopsj2.7YWa/d2f51.1KtUUm', 'Owner', '2025-06-06 18:58:41', 'Middlesbrough', '68433ad5abcf5.jpg', 'A ex footballer providing sessions for beginners', 'A footballer'),
(8, 'Theo', 'emmawilliamson1234@gmail.com', '$2y$10$I5jnJp5E0LL86O3GaxJ6COU86wzn/aNyQ0QW8jthfl0XdjMyaiFre', 'Customer', '2025-06-06 19:21:18', 'Newcastle', '6844610a94e7d.jpg', 'A user for sessions', ''),
(9, 'Aimee Glenn', 'aimeeglenn1234@gmail.com', '$2y$10$R5nfrhj5HftC2HHDE0ct5.G5zt0toD9qbCCs36ygElCeI7RiZAMja', 'Owner', '2025-06-10 21:34:31', '', '', '', ''),
(10, 'Emma', 'dbdkfnf1234@gmail.com', '$2y$10$0AkH7YYuk0XRdOdgu7M.8uAxgzYq2umnsxTkfR9Q/LU9l0nTrcWJG', 'Customer', '2025-06-10 21:36:30', '', '', '', ''),
(11, 'Dbskddbdn', 'theo393@gmail.com', '$2y$10$SAn8ylfbnIC5gY4lBf/NFu6yVdGcJirfjvpd023eE.U3GmFzcLfrK', 'Customer', '2025-06-10 21:37:06', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`);
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
