-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 24, 2017 at 01:02 AM
-- Server version: 5.5.48
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `danx`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `doc1_1` varchar(50) DEFAULT NULL,
  `doc1_2` varchar(50) DEFAULT NULL,
  `doc2_1` varchar(50) DEFAULT NULL,
  `doc2_2` varchar(50) DEFAULT NULL,
  `doc3` varchar(50) DEFAULT NULL,
  `deletedat` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `voen` varchar(11) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `company` varchar(200) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `date` varchar(12) DEFAULT NULL,
  `company_long` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vehicle` varchar(20) DEFAULT NULL,
  `driver` varchar(50) DEFAULT NULL,
  `number` varchar(12) DEFAULT NULL,
  `type` int(1) DEFAULT '1',
  `capacity` float DEFAULT NULL,
  `regiontype` int(11) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `toregion` varchar(50) DEFAULT NULL,
  `months` int(11) NOT NULL DEFAULT '1',
  `time` varchar(20) DEFAULT NULL,
  `expire` varchar(10) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1 -  gözlənilir ; 2 - baxılır  3 - dəyişiklik tələb olunur ; 4 - qəbul olunudu ; ',
  `message` text,
  `deletedat` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voen` (`voen`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
