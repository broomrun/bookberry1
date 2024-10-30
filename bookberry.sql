-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 04:56 PM
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
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `parent_comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_sender_nama` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'user',
  `Image` varchar(100) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `name`, `email`, `password`, `user_type`, `Image`) VALUES
(1, 'icha', 'chairunnisaq11@gmail.com', '663971bcf86c6dc79d7ca6afc63392c3', 'admin', ''),
(2, 'icha', 'rima11@gmail.com', '3526b962b520a2f893fd093ca673b030', 'user', ''),
(3, 'salwa', 'salwa11@gmail.com', '31a55dbf049616691309fb7ada746a01', 'user', ''),
(4, 'alissya', 'alissya11@gmail.com', '68f669ac00b5e8092d523a14efe939b0', 'user', ''),
(5, 'erun', 'erun11@gmail.com', '8c49d9f5e65f6435ad1aaf332957f71b', 'user', ''),
(6, 'leesya', 'leesya11@gmail.com', '$2y$10$By6uh5rWrWtoVu9cWaE65uXc5sifAmxOZIxTqZ8oGVcV6HBhYOBR.', 'user', 'Screenshot 2024-03-02 231840.png'),
(7, 'nadahai', 'nada11@gmail.com', '$2y$10$JiO3k5N4.4bEGLE4/NZK.ueyyAoKiROjYewecg0zhKZwXCF0/QETS', 'user', 'logo.jpg'),
(8, 'erunerun', 'erunerun11@gmail.com', '$2y$10$/dAnnSqE4hmWr3yIjko3h.vgLtQtIDSwM8mpTr2mY5cfLE9bFbqp.', 'user', 'logo.jpg'),
(9, 'fanin11', 'fanin11@gmail.com', '$2y$10$DEVQGCtmnHxAxkzPE1Xk6e.YNEl/zim5ydYmCTDcmJozSJq25wune', 'user', 'logo.jpg'),
(10, 'erunaja', 'erun13@gmail.com', '$2y$10$QZYZLWpFn1KFVUMH2JehEeHRKzz02i3KuwRy5qPgYkmHEzK/FYKHG', 'user', 'ipb.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
