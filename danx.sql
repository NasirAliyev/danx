-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 29, 2017 at 03:36 PM
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
-- Table structure for table `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name`) VALUES
(1, 'Göygöl'),
(2, 'Masallı'),
(3, 'Zaqatala'),
(4, 'Balakən'),
(5, 'Lerik'),
(6, 'Astara'),
(7, 'Lənkəran'),
(8, 'Ağsu'),
(9, 'Gəncə'),
(10, 'Yardımlı'),
(11, 'Şəki'),
(12, 'Şamaxı'),
(13, 'Naftalan'),
(14, 'Xocalı'),
(15, 'Samux'),
(16, 'Daşkəsən'),
(17, 'Goranboy'),
(18, 'Kəlbəcər'),
(19, 'Qusar'),
(20, 'Bakı'),
(21, 'Hacıqabul'),
(22, 'Saatlı'),
(23, 'Sabirabad'),
(24, 'Şirvan'),
(25, 'Cəbrayıl'),
(26, 'Ağdaş'),
(27, 'Bərdə'),
(28, 'Tərtər'),
(29, 'Ağdam'),
(30, 'Qax'),
(31, 'Oğuz'),
(32, 'Qəbələ'),
(33, 'İsmayıllı'),
(34, 'Şuşa'),
(35, 'Abşeron'),
(36, 'Şabran'),
(37, 'Siyəzən'),
(38, 'Xızı'),
(39, 'Zəngilan'),
(40, 'Laçın'),
(41, 'Qubadlı'),
(42, 'Ucar'),
(43, 'Kürdəmir'),
(44, 'Zərdab'),
(45, 'Şəmkir'),
(46, 'Gədəbəy'),
(47, 'Tovuz'),
(48, 'Ağstafa'),
(49, 'Qazax'),
(50, 'Beyləqan'),
(51, 'Ağcabədi'),
(52, 'İmişli'),
(53, 'Füzuli'),
(54, 'Xocavənd'),
(55, 'Cəlilabad'),
(56, 'Biləsuvar'),
(57, 'Neftçala'),
(58, 'Salyan'),
(59, 'Qobustan'),
(60, 'Mingəçevir'),
(61, 'Quba'),
(62, 'Xaçmaz'),
(63, 'Yevlax'),
(64, 'Göyçay'),
(65, 'Sumqayıt');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `fromdate` varchar(10) DEFAULT NULL,
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
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD KEY `id` (`id`);

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
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=98;
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
