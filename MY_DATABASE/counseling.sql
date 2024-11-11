-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 09:03 PM
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
-- Database: `counseling`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `discution_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `discution_id`, `user_id`, `answer`, `created_at`) VALUES
(3, 10, 2, 'First answer', '2024-11-11'),
(4, 10, 2, 'One more answer', '2024-11-11'),
(5, 11, 5, 'Answer', '2024-11-11'),
(6, 11, 5, 'One more answer', '2024-11-11');

-- --------------------------------------------------------

--
-- Table structure for table `discution`
--

CREATE TABLE `discution` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic` varchar(256) NOT NULL,
  `have_answer` tinyint(4) NOT NULL DEFAULT 0,
  `advisor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discution`
--

INSERT INTO `discution` (`id`, `user_id`, `topic`, `have_answer`, `advisor_id`) VALUES
(10, 1, 'Test discution', 1, 2),
(11, 1, 'Jos jedan topic', 1, 5),
(12, 4, 'Bela discution', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `discution_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `user_id`, `question`, `discution_id`, `created_at`) VALUES
(3, 1, 'Test discution question', 10, '2024-11-09'),
(4, 1, 'Jos jedno pitanje', 11, '2024-11-09'),
(5, 4, 'New question from bela', 12, '2024-11-09'),
(6, 1, 'New question from Test user', 10, '2024-11-11'),
(7, 1, 'One Another question from Test user', 10, '2024-11-11'),
(8, 1, 'Another test question', 10, '2024-11-11'),
(9, 1, 'Jos jedno pitanje Test korisnika', 11, '2024-11-11');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `profile_image` varchar(128) NOT NULL,
  `type` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `profile_image`, `type`) VALUES
(1, 'test', 'test@test.com', '$2y$10$z.X9FJRgjnzXw3L.b2Lhj.tDMSpCJxI8E2cUuyiwVjPqCaecxlCPO', 'uploads/cool.jpg_1.jpg', 'listener'),
(2, 'Niko123', 'niko@nikolic.com', '$2y$10$IwG0sflzJBRZojVaKhbrje9IzcNXGRBCk1.rta4Gfi1ar5q6kYA.q', 'uploads/coolImg.jpg_2.jpg', 'advisor'),
(4, 'bela123', 'bela@belic.com', '$2y$10$GiM44Fh1PxayAcI/Vd266uhCGe3LCRNInEbyg.OCRs8Rd0d86YvzG', '', 'listener'),
(5, 'nikobelic123', 'niko@belic.com', '$2y$10$3.HzzMboAnbBdSBEkOE9XO1ERnOYoz160cFYqaKDYCArFGjl1R46O', '', 'advisor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discution`
--
ALTER TABLE `discution`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `discution`
--
ALTER TABLE `discution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
