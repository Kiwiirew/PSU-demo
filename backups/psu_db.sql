-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2024 at 05:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psu_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_tag` varchar(50) NOT NULL,
  `course_image` varchar(255) NOT NULL,
  `course_video` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `career_opportunities` text NOT NULL,
  `skills_gained` text NOT NULL,
  `future_impact` text NOT NULL,
  `duration` varchar(50) NOT NULL DEFAULT '4 Years',
  `total_subjects` int(11) NOT NULL DEFAULT 60,
  `level` varchar(50) NOT NULL DEFAULT 'Secondary',
  `language` varchar(50) NOT NULL DEFAULT 'English',
  `certificate` varchar(10) NOT NULL DEFAULT 'Yes',
  `portal_link` varchar(255) NOT NULL DEFAULT 'https://psu362.campus-erp.com/portal/',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `course_tag`, `course_image`, `course_video`, `description`, `career_opportunities`, `skills_gained`, `future_impact`, `duration`, `total_subjects`, `level`, `language`, `certificate`, `portal_link`, `created_at`) VALUES
(9, 'wqrsgyer', 'Technology', 'assets/images/courses/course_1734328259.png', 'https://www.youtube.com/watch?app=desktop&v=OELOf_gETbw', 'erydfytstsdtgsd', 'tsdtsdtsdgsdg', 'sdsdfsdfsdg', 'sdgsgsgsdgsdgs', '4 Years', 20, 'Secondary', 'English', 'Yes', 'https://psu362.campus-erp.com/portal/', '2024-12-16 05:50:59');

-- --------------------------------------------------------

--
-- Table structure for table `course_instructors`
--

CREATE TABLE `course_instructors` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `instructor_name` varchar(255) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `instructor_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_instructors`
--

INSERT INTO `course_instructors` (`id`, `course_id`, `instructor_name`, `designation`, `instructor_image`) VALUES
(11, 9, 'gsgsdg', 'sdgsgsd', 'assets/images/courses/instructors/instructor_1734328259_0.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_instructors`
--
ALTER TABLE `course_instructors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `course_instructors`
--
ALTER TABLE `course_instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_instructors`
--
ALTER TABLE `course_instructors`
  ADD CONSTRAINT `course_instructors_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
