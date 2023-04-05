-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2022 at 03:31 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hsantana_testdb`
--
CREATE DATABASE IF NOT EXISTS `hsantana_testdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `hsantana_testdb`;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `roomNum` varchar(10) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingID`, `username`, `roomNum`, `startTime`, `endTime`) VALUES
(6, 'fredbloggs', 'PER01.002', '2022-07-01 10:00:00', '2022-07-01 12:00:00'),
(7, 'johnsmith', 'PER01.001', '2022-09-08 22:00:00', '2022-09-08 23:00:00'),
(28, 'johnsmith', 'PER02.002', '2022-09-10 09:30:00', '2022-09-10 10:30:00'),
(61, 'johnsmith', 'PER02.002', '2022-09-10 12:04:00', '2022-09-10 12:30:00'),
(62, 'johnsmith', 'PER01.001', '2022-09-20 09:00:00', '2022-09-20 11:00:00'),
(66, 'jamesbond', 'PER02.001', '2022-09-26 10:00:00', '2022-09-26 11:00:00'),
(67, 'jamesbond', 'PER02.001', '2022-09-30 10:00:00', '2022-09-30 12:00:00'),
(68, 'jamesbond', 'PER02.002', '2022-10-18 13:00:00', '2022-10-18 14:00:00'),
(69, 'fredbloggs', 'PER01.001', '2022-10-18 13:00:00', '2022-10-18 16:00:00'),
(70, 'johnsmith', 'PER03.001', '2022-10-18 14:00:00', '2022-10-18 16:00:00'),
(71, 'johnsmith', 'PER03.001', '2022-10-20 08:00:00', '2022-10-20 11:30:00'),
(78, 'testacc1', 'PER03.001', '2022-10-31 10:46:00', '2022-10-31 11:46:00');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(11) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(100) NOT NULL,
  `event_type` varchar(100) NOT NULL,
  `event_details` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `log_date`, `ip_address`, `event_type`, `event_details`) VALUES
(3, '2022-10-24 13:27:23', '::1', 'Login', 'johnsmith logged in'),
(4, '2022-10-24 13:34:02', '::1', 'Login', 'fredbloggs logged in'),
(5, '2022-10-24 13:39:13', '::1', 'Login Attempt', 'Failed login with username fredbloggs'),
(6, '2022-10-24 13:55:24', '::1', 'Login', 'johnsmith logged in'),
(7, '2022-10-29 02:18:19', '::1', 'Login', 'johnsmith logged in'),
(8, '2022-10-29 02:23:52', '::1', 'Room Added', 'ts added by johnsmith'),
(9, '2022-10-29 02:24:17', '::1', 'Room Deleted', 'ts deleted by johnsmith'),
(10, '2022-10-30 02:13:22', '::1', 'Registration', 'testacc1 registered'),
(11, '2022-10-30 02:14:02', '::1', 'Login Attempt', 'Failed login with username testacc1'),
(12, '2022-10-30 02:14:22', '::1', 'Login', 'testacc1 logged in'),
(19, '2022-10-30 02:34:07', '::1', 'Booking Cancelled', 'testacc1 cancelled a booking for PER02.001 from 2022-10-31 10:29:00 until 2022-10-31 11:29:00'),
(21, '2022-10-30 02:43:08', '::1', 'Booking Cancelled', 'testacc1 cancelled a booking for PER02.002 from 2022-10-31 10:42:00 until 2022-10-31 11:42:00'),
(22, '2022-10-30 02:46:30', '::1', 'Booking Made', 'testacc1 booked PER03.001 from 2022-10-31T10:46 until 2022-10-31T11:46'),
(23, '2022-10-30 02:48:02', '::1', 'Login', 'johnsmith logged in');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomID` int(11) NOT NULL,
  `roomNum` varchar(30) NOT NULL,
  `capacity` smallint(6) NOT NULL,
  `whiteboard` tinyint(1) NOT NULL DEFAULT 0,
  `laptopConnection` tinyint(1) NOT NULL DEFAULT 0,
  `teleconference` tinyint(1) DEFAULT 0,
  `notes` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomID`, `roomNum`, `capacity`, `whiteboard`, `laptopConnection`, `teleconference`, `notes`) VALUES
(1, 'PER01.001', 50, 0, 1, 1, 'Books out quick!'),
(2, 'PER01.002', 50, 0, 0, 0, ''),
(3, 'PER02.001', 50, 1, 0, 0, ''),
(4, 'PER02.002', 25, 0, 1, 0, ''),
(11, 'PER03.001', 60, 0, 0, 0, ''),
(13, 'PER04.002', 50, 0, 0, 0, ''),
(20, 'Test', 20, 0, 1, 0, ''),
(21, 'test22', 22, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `extension` smallint(4) UNSIGNED NOT NULL,
  `password` varchar(100) NOT NULL,
  `accessLevel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `firstName`, `surname`, `extension`, `password`, `accessLevel`) VALUES
(1, 'johnsmith', 'John', 'Smith', 1, '$2y$10$VK1GEszKH8UsMzf3WpuVCenyIqGwK3/y6.feGlemSWNRKhmcCUre.', 'admin'),
(2, 'janesmith', 'Jane', 'Smith', 2, '$2y$10$VK1GEszKH8UsMzf3WpuVCenyIqGwK3/y6.feGlemSWNRKhmcCUre.', 'admin'),
(3, 'joebloggs', 'Joe', 'Bloggs', 3, '$2y$10$Pv90FSTBYwTnvAAL2ZElAOdhguVHh26hvx6.UvlGczS6ammogUzWC', 'staff'),
(4, 'fredbloggs', 'Fred', 'Bloggs', 4, '$2y$10$HUz8BdqWPpjOwRYz655MxuLVHBBsVvEVU7dPYJpUIPooklf7oRlKO', 'staff'),
(6, 'jamesbond', 'James', 'Bond', 7, '$2y$10$xHs60S0e4KF40jme.2zpxu2SAz1BsRxKDsgVyysKy4QuHrT8D3o0S', 'staff'),
(8, 'TestAcc', 'test', 'acc', 1111, '$2y$10$jwegf1bHYBVKL.1NySqPU.oPwE/XlBA2oEepkvYOXHm6Y80/ExutO', 'staff'),
(9, 'testacc1', 'test', 'test', 1111, '$2y$10$DvFsPLKebDDvPHVPt4RLN.zpTlT6yN64FtseM5G3z7YWgvS0aXrpG', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `usernameFK` (`username`),
  ADD KEY `roomnumFK` (`roomNum`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomID`),
  ADD UNIQUE KEY `roomNum` (`roomNum`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `roomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `roomnumFK` FOREIGN KEY (`roomNum`) REFERENCES `room` (`roomNum`),
  ADD CONSTRAINT `usernameFK` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
