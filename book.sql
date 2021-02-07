-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 07, 2021 at 12:55 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_cdl`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime(4) DEFAULT NULL,
  `category` int(11) NOT NULL,
  `author` int(11) DEFAULT NULL,
  `comments` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `date`, `category`, `author`, `comments`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Harry Potter à l\'école des sorciers', '1997-01-01 00:00:00.0000', 1, 1, NULL, '2021-02-05 23:15:31', 1, '2021-02-06 10:50:36', 1),
(2, 'Harry Potter et la chambre des secrets', '1998-01-01 00:00:00.0000', 1, 1, NULL, '2021-02-05 23:16:44', 1, '2021-02-05 23:16:44', 1),
(3, 'Harry Potter et le prisonnier d\'Azkaban', '1999-01-01 00:00:00.0000', 1, 1, NULL, '2021-02-05 23:17:11', 1, '2021-02-05 23:17:11', 1),
(4, 'Astérix le Gaulois', '1961-01-01 00:00:00.0000', 2, 2, NULL, '2021-02-05 23:17:56', 1, '2021-02-05 23:17:56', 1),
(5, 'La Serpe d\'or', NULL, 2, 2, NULL, '2021-02-05 23:31:09', 1, '2021-02-05 23:35:36', 1),
(6, 'Le fils d\'Astérix', NULL, 2, NULL, NULL, '2021-02-05 23:38:45', 1, '2021-02-05 23:38:45', 1),
(7, 'One-Punch Man', NULL, 3, NULL, NULL, '2021-02-05 23:39:36', 1, '2021-02-05 23:39:36', 1),
(8, 'Naruto Tome 1', '1995-01-01 00:00:00.0000', 3, 3, NULL, '2021-02-05 23:40:14', 1, '2021-02-05 23:40:14', 1),
(9, 'La jeune fille et la nuit', '2018-01-01 00:00:00.0000', 1, 4, NULL, '2021-02-05 23:40:41', 1, '2021-02-05 23:40:41', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
