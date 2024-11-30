-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 12:59 PM
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
-- Database: `bookberry`
--

-- --------------------------------------------------------

--
-- Table structure for table `books_read`
--

CREATE TABLE `books_read` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `read_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_stats`
--

CREATE TABLE `book_stats` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `click_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_id` int(11) DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `book_title`, `username`, `text`, `created_at`, `parent_id`, `likes`, `dislikes`) VALUES
(1, 'Future Shock', 'cobabeb', 'halo', '2024-11-29 04:57:00', NULL, 0, 0),
(2, 'Agamemnon\'s Daughter', 'cobabeb', 'hai', '2024-11-29 04:57:10', NULL, 1, 1),
(3, '[English] Issue #9 - BoBoiBoy Galaxy Season 2: ', 'cobabeb', 'keren banget', '2024-11-29 07:23:33', NULL, 0, 0),
(4, '[English] Issue #9 - BoBoiBoy Galaxy Season 2: ', 'cobabeb', 'iya ya keren', '2024-11-29 07:23:45', NULL, 0, 0),
(5, 'Agamemnon\'s Daughter', 'cobabeb', 'hoi', '2024-11-29 07:47:45', 2, 0, 0),
(6, 'Through the Looking Glass', 'cobabeb', 'hlo', '2024-11-29 07:53:34', NULL, 1, 0),
(7, 'Through the Looking Glass', 'cobacomment', 'halo', '2024-11-29 08:04:39', 6, 0, 0),
(8, 'Ready Player Two', 'cobacomment', 'ini buku apah?', '2024-11-29 08:22:24', NULL, 0, 0),
(9, 'The Discarded Image', 'cobacomment', 'kerenn banget, sangat informatif', '2024-11-29 09:44:45', NULL, 0, 0),
(10, 'Harry Potter and the Deathly Hallows', 'cobabeb', 'omg, my favorite book!!!!', '2024-11-29 13:32:38', NULL, 0, 0),
(11, 'Lives of the Eminent Philosophers', 'cobabeb', 'test', '2024-11-29 16:19:15', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `publish_date` date NOT NULL,
  `rate` decimal(2,1) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shelves`
--

CREATE TABLE `shelves` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `publish_date` date NOT NULL,
  `rate` decimal(2,1) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Image` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `last_login` date DEFAULT NULL,
  `streak_count` int(11) DEFAULT 0,
  `badges` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `name`, `email`, `password`, `Image`, `last_login`, `streak_count`, `badges`) VALUES
(1, 'cobabeb', 'cobabeb@gmail.com', '$2y$10$kjNnS3wwJUu3h1cBePoY3.0yie8P.I1ajv1dc5avOQt7DTIBqlL8C', 'Screenshot 2024-11-20 153047.png', '2024-11-30', 3, ''),
(2, 'cobacomment', 'cobacomment@gmail.com', '$2y$10$iZCcdD1KAWlWYQ8ipUIBAO9sbwzZjFpRIlNqn020wODNR43l7vbu6', '2023-09-16.png', '2024-11-29', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books_read`
--
ALTER TABLE `books_read`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `book_stats`
--
ALTER TABLE `book_stats`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `shelves`
--
ALTER TABLE `shelves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books_read`
--
ALTER TABLE `books_read`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shelves`
--
ALTER TABLE `shelves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books_read`
--
ALTER TABLE `books_read`
  ADD CONSTRAINT `books_read_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user_form` (`name`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
