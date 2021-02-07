-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 07, 2021 at 01:01 PM
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
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birth_date` datetime DEFAULT NULL,
  `comments` text,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`, `birth_date`, `comments`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'J. K. Rowling', '1965-07-31 00:00:00', NULL, '2021-02-05 22:38:41', 1, '2021-02-05 22:38:41', 1),
(2, 'Uderzo', '1927-04-25 00:00:00', NULL, '2021-02-05 22:42:49', 1, '2021-02-05 22:42:49', 1),
(3, 'Masashi Kishimoto', '1974-11-08 00:00:00', NULL, '2021-02-05 22:43:21', 1, '2021-02-05 22:43:21', 1),
(4, 'Guillaume Musso', '1974-06-06 00:00:00', NULL, '2021-02-05 22:43:39', 1, '2021-02-05 22:43:39', 1);

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

-- --------------------------------------------------------

--
-- Table structure for table `book_category`
--

CREATE TABLE `book_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comments` text,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_category`
--

INSERT INTO `book_category` (`id`, `name`, `comments`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Roman', NULL, '2021-02-05 22:30:33', 1, '2021-02-05 22:30:33', 1),
(2, 'BD', NULL, '2021-02-05 22:34:33', 1, '2021-02-05 22:34:33', 1),
(3, 'Manga', NULL, '2021-02-05 22:35:00', 1, '2021-02-05 22:35:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(1, 'test_cdl', '[]', '$argon2id$v=19$m=65536,t=4,p=1$ygwdS3PDl7u+5B8Qpp0myA$SIjn9BgeRzO/91uFANsk7mTNvqOUiELUi30Eke6dmnQ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_category`
--
ALTER TABLE `book_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `book_category`
--
ALTER TABLE `book_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
