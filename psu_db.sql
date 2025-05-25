-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 05:03 AM
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
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `acctype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`id`, `username`, `password`, `acctype`) VALUES
(1, 'adminuser1', 'password123', 'superadmin'),
(2, 'adminuser2', 'password123', 'admin'),
(25, 'Nanao Chan', '123', 'Superadmin'),
(28, 'adminuser', '123', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `contact_feedback`
--

CREATE TABLE `contact_feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_feedback`
--

INSERT INTO `contact_feedback` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'maala', 'kiwiilemon13@gmail.com', 'd', 'aa', '2024-11-14 12:10:57'),
(2, 'maala', 'geezwizz64@gmail.com', 'e', 'ff', '2024-11-14 12:12:17'),
(3, 'd', 'kiwiilemon13@gmail.com', 'ww', 'a', '2024-11-14 12:16:50'),
(5, 'dadf', 'gegsg@gmail.com', 'qwr', 'qwrqr', '2024-11-15 02:38:39'),
(6, 'kiwii', 'kiwiilemon13@gmail.com', 'afwafsa', 'wqweqweqewq', '2024-11-30 05:34:23'),
(7, 'TestAi', 'kiwiilemon13@gmail.com', 'egsgs', 'dasgsfdg sgsdg ', '2025-05-24 00:22:08'),
(8, 'treyal', 'geezwizz64@gmail.com', 'eee', 'shgsrhshshs', '2025-05-24 00:32:56');

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

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(500) DEFAULT NULL,
  `message` text NOT NULL,
  `rating` int(11) DEFAULT 5,
  `status` enum('New','Reviewed','Resolved') DEFAULT 'New',
  `admin_response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `subject`, `message`, `rating`, `status`, `admin_response`, `created_at`, `updated_at`) VALUES
(1, 'Juan Cruz', 'juan.cruz@email.com', 'Great System!', 'The PSU system is working really well. I love the new interface and features.', 5, 'New', NULL, '2025-05-24 00:29:29', '2025-05-24 00:29:29'),
(2, 'Maria Santos', 'maria.santos@email.com', 'Suggestion for Improvement', 'The ticket system could use a notification feature when admin responds.', 4, 'Reviewed', 'Thank you for the suggestion! We are working on implementing email notifications.', '2025-05-24 00:29:29', '2025-05-24 00:29:29'),
(3, 'Roberto Garcia', 'roberto.garcia@email.com', 'Technical Issue', 'I had trouble uploading files initially, but it works now.', 3, 'Resolved', 'Issue was resolved by updating the file upload limits. Thank you for reporting!', '2025-05-24 00:29:29', '2025-05-24 00:29:29'),
(4, 'maala', 'aww@gmail.com', 'dhdthfdrs hrsdhsrhdrthsdrhdrs', 'hdhsgsh shshdsfh sfdhsfhsdhsdshs', 3, 'New', NULL, '2025-05-24 01:49:22', '2025-05-24 01:49:22');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `StudentID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `Birthdate` date NOT NULL,
  `Age` int(11) NOT NULL,
  `BachelorProgram` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`StudentID`, `FullName`, `EmailAddress`, `Gender`, `Birthdate`, `Age`, `BachelorProgram`, `Address`, `PhoneNumber`) VALUES
(3, 'Princess Windy G. Saavedra', 'riveraprincess157@gmali.com', 'Female', '2003-06-03', 21, 'Bachelor of Science in Information Technology (BSIT)', 'Sobol, Pangasinan', '094250555549'),
(4, 'John Kelvin Macadangdang', 'johnkelvinmacadangdang72@gmail.com', 'Male', '2003-06-02', 21, 'Bachelor of Science in Information Technology (BSIT)', 'Ariston West Asingan Pangasinan', '09127224234'),
(5, 'Jimber E. Senopera ', 'jimberevangelista@gmail.com', 'Male', '2003-06-05', 21, 'Bachelor of Science in Information Technology (BSIT)', 'San Manuel, Pangasinan', '09129322778'),
(6, 'Claudine R. Navarro', 'claudinenavarro231@gmail.com', 'Female', '2004-09-21', 20, 'Bachelor of Science in Business Administration (BSBA)', 'Asingan, Pangasinan', '09915453940'),
(7, 'Angelene T. Gabe ', 'gabeangelene9@gmail.com', 'Female', '2003-02-01', 22, 'Bachelor of Science in Business Administration (BSBA)', 'Asingan, Pangasinan', '09542836354'),
(8, 'Roxanne A. Omilla', 'roxanneomilla10@gmail.com', 'Female', '2003-09-05', 22, 'Bachelor of Science in Business Administration (BSBA)', 'Asingan, Pangasinan', '09776333078'),
(9, 'Katrina A. Elevazo', 'katrinaelevazo@gmail.com', 'Female', '2002-05-02', 21, 'Bachelor of Industrial Technology (BIT)', 'Piaz Villasis, Pangasinan', '09184771346'),
(10, 'Allyssa Joy A. Lopez', 'lopezallyssajoy@gmail.com', 'Female', '2003-07-09', 21, 'Bachelor of Industrial Technology (BIT)', 'Pob East Asingan, Pangasinan', '09567897654'),
(11, 'Kristine A. Daquer', 'kristinedaquer23@gmail.com', 'Female', '2004-09-09', 21, 'Bachelor of Industrial Technology (BIT)', 'Ariston West Asingan Pangasinan', '09765234134'),
(12, 'John Michael C. Bondadzo', 'johnmichael@gmail.com', 'Male', '2004-02-22', 20, 'Bachelor of Secondary Education (BSE)', 'Carosucan Asingan Pangasinan', '09700934283'),
(13, 'Erica Roxsiel S. Delmiguez', 'ericaroxsieldelmiguez@gmail.com', 'Female', '2005-07-09', 19, 'Bachelor of Secondary Education (BSE)', 'Villasis, Pangasinan', '09786545643'),
(14, 'Alyssa Mae D. Gamboa', 'alyssagamboa10@gmail.com', 'Female', '2005-08-05', 19, 'Bachelor of Secondary Education (BSE)', 'Ariston West Asingan Pangasinan', '09876567876'),
(15, 'Adrian Espiritu', 'espirituadrian32@gmail.com', 'Male', '2002-08-09', 22, 'Bachelor of Technology and Livelihood Education (BTLE)', 'La-Paz Umingan, Pangasinan', '09324678987'),
(16, 'Glen Sinddnum', 'glensinddnum10@gmail.com', 'Male', '2004-03-05', 220, 'Bachelor of Technology and Livelihood Education (BTLE)', 'San Vicente West Asingan, Pangasinan', '09657436789'),
(17, 'Elizabeth P. Agpoldo', 'elizabethagpoldo75@gmail.com', 'Female', '2004-08-05', 20, 'Bachelor of Technology and Livelihood Education (BTLE)', 'Ariston West Asingan Pangasinan', '09768546534'),
(18, 'Joshua Gudoy', 'JoshuaGudoy64@gmail.com', 'Male', '2002-02-09', 21, 'Bachelor of Elementary Education (BEE)', 'San Manuel, Pangasinan', '09454443675'),
(19, 'Axelle Clyde S. Pio', 'Pioaxelle08@gmail.com', 'Male', '2004-06-08', 20, 'Bachelor of Elementary Education (BEE)', 'Ariston Bantog Asingan, Pangasinan', '09876655543'),
(20, 'Henille Campos', 'camposhenielle@gmail.com', 'Male', '2002-02-09', 21, 'Bachelor of Elementary Education (BEE)', 'Bolaoen, Urdaneta Pangasinan', '09765433212'),
(35, 'Emerson A. Agapay', 'agapayemerson@gmail.com', 'Male', '2005-03-09', 18, 'Bachelor of Technology and Livelihood Education (BTLE)', 'Domanpot Asingan, Pangasinan', '09198002123'),
(36, 'Catherine Medina', 'catherine21@gmail.com', 'Female', '2003-05-10', 22, 'Bachelor of Elementary Education (BEE)', 'Sta. Maria Pangasinan', '09765676543'),
(52, 'Lara Jane Gaban', 'gabanlara2@gmail.com', 'Female', '2003-07-09', 21, 'Bachelor of Secondary Education (BSE)', 'Sta. Maria Pangasinan', '09876787656'),
(58, 'Alyssa G. Alonzo', 'alonzoalyssa3@gmail.com', 'Female', '2003-03-10', 21, 'Bachelor of Science in Business Administration (BSBA)', 'Sta. Maria Pangasinan', '09878987654');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `TeacherID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Department` varchar(100) DEFAULT NULL,
  `Designation` varchar(50) DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`TeacherID`, `FullName`, `Email`, `Department`, `Designation`, `Gender`, `PhoneNumber`) VALUES
(1, 'Mary Ann E. Soberano', 'maryann@psu.edu.ph', 'BSE', 'Department Chairperson', 'Female', '09683552617'),
(2, 'Laurence D.Agsalud', 'LaurenceAgsalud@psu.edu.ph', 'BSE', 'Faculty', 'Male', '09625513346'),
(73, 'Rodelio M. Garin', 'Rodelio@psu.edu.ph', 'BSE', 'Faculty', 'Male', '09684427436'),
(74, 'Mary Jane U. Quibilan', 'Maryjane@psu.edu.ph', 'BEE', 'Department Chairperson', 'Female', '09695122386'),
(75, 'Aaron Manasseh L. Agsalud', 'AgsaludAaron@psu.edu.ph', 'BEE', 'Faculty', 'Male', '09486675913'),
(76, 'Benjie S. Cansino', 'Benjiecansino@psu.edu.ph', 'BEE', 'Faculty', 'Male', '09375664718'),
(77, 'Carlos G. Castillo Jr.', 'CarlosCastillo@psu.edu.ph', 'BIT', 'Faculty', 'Male', '0967896543'),
(78, 'Christian Garret F. Aquino', 'ChristianGarret@psu.edu.ph', 'BIT', 'Faculty', 'Male', '09678543567'),
(79, 'Wennalyn D. Honrado', 'WennaHonrado@psu.edu.ph', 'BSIT', 'Faculty', 'Female', '09678543678'),
(80, 'Jb O. Doria', 'jbDoria@psu.edu.ph', 'BSIT', 'College Dean', 'Male', '09675434567'),
(81, 'Glenny M. Salazar', 'glennysalazar@psu.edu.ph', 'BSBA', 'Faculty', 'Female', '09786546578'),
(82, 'Janna D. Arce', 'jannaarce@psu.edu.ph', 'BSBA', 'Faculty', 'Female', '09678987654');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(500) NOT NULL DEFAULT 'Support Request',
  `description` text NOT NULL,
  `priority` enum('Low','Medium','High','Critical') DEFAULT 'Medium',
  `department` varchar(255) DEFAULT '',
  `status` enum('Open','In Progress','Resolved','Closed') DEFAULT 'Open',
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `admin_response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `name`, `email`, `subject`, `description`, `priority`, `department`, `status`, `attachments`, `admin_response`, `created_at`, `updated_at`, `resolved_at`, `assigned_to`) VALUES
(11, NULL, '', 'bundang@psu.edu.ph', 'Support Request', 'dsadsa', 'Medium', '', 'In Progress', NULL, 'hdhfgdsg', '2025-05-23 13:52:31', '2025-05-23 13:53:23', NULL, NULL),
(16, NULL, '', 'kiwiilemon13@gmail.com', 'Support Request', 'afafwarwrwr', 'Medium', '', 'Open', NULL, NULL, '2025-05-23 13:52:31', '2025-05-23 13:52:31', NULL, NULL),
(17, NULL, '', '123@psu.edu.ph', 'Support Request', 'adadsda', 'Medium', '', 'Open', NULL, NULL, '2025-05-23 13:52:31', '2025-05-23 13:52:31', NULL, NULL),
(18, NULL, '', 'aztro14000@gmail.com', 'Support Request', 'faa', 'Medium', '', 'Open', NULL, NULL, '2025-05-23 13:52:31', '2025-05-23 13:52:31', NULL, NULL),
(19, NULL, '', 'qwe@psu.edu.ph', 'Support Request', 'aasgg', 'Medium', '', 'Open', NULL, NULL, '2025-05-23 13:52:31', '2025-05-23 13:52:31', NULL, NULL),
(20, NULL, '', '123@psu.edu.ph', 'Support Request', 'gagdsaga', 'Medium', '', 'Open', NULL, NULL, '2025-05-23 13:52:31', '2025-05-23 13:52:31', NULL, NULL),
(21, NULL, '', 'aww@gmail.com', 'Support Request', 'ADSAGG', 'Medium', '', 'Resolved', NULL, '', '2025-05-23 13:52:31', '2025-05-23 14:01:23', '2025-05-23 14:01:23', NULL),
(23, 13, 'maala', 'maala@psu.edu.ph', 'Test Ticket - 2025-05-24 02:01:59', 'This is a test ticket created to verify the ticket system functionality. If you can see this ticket in your ticket list, the system is working correctly.', 'Low', '', 'Resolved', NULL, 'wait', '2025-05-24 00:01:59', '2025-05-24 00:03:09', '2025-05-24 00:03:09', NULL),
(24, 13, 'maala', 'maala@psu.edu.ph', 'test4', 'sgsgsdghjgd tjdjdjdjgj j djdfhsdgsdfsd fsgfsghshdhdhdh d hsgs', 'Medium', 'BSBA', 'Closed', '[{\"original_name\":\"4.PNG\",\"stored_name\":\"68310f01effa8_1748045569.png\",\"file_path\":\"uploads\\/tickets\\/68310f01effa8_1748045569.png\",\"file_size\":23001,\"file_type\":\"png\",\"uploaded_at\":\"2025-05-24 02:12:49\"}]', 'Congrats', '2025-05-24 00:12:49', '2025-05-24 00:14:05', '2025-05-24 00:14:05', NULL),
(25, 13, 'maala', 'maala@psu.edu.ph', 'drhtdhdtj td seessef', 'segsrdhgrd tsgsegsrhgshdsh srhsrhshshsr hshdshsrh sr ssr', 'Medium', 'BSIT', 'Resolved', NULL, 'hdtdh d', '2025-05-24 00:52:22', '2025-05-24 00:53:01', '2025-05-24 00:53:01', NULL),
(26, 13, 'maala', 'maala@psu.edu.ph', 'hghjgdygh fhdfh fhfhdfh', 'sdfhfdh dhdfh dfhdfhdfhdfh', 'Medium', 'Faculty', 'Open', NULL, NULL, '2025-05-24 02:22:25', '2025-05-24 02:22:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets_backup_2025_05_23_15_52_31`
--

CREATE TABLE `tickets_backup_2025_05_23_15_52_31` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `priority` enum('Low','Medium','High','Critical') DEFAULT 'Medium',
  `screenshot` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Active',
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `admin_response` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tickets_backup_2025_05_23_15_52_31`
--

INSERT INTO `tickets_backup_2025_05_23_15_52_31` (`id`, `user_id`, `first_name`, `last_name`, `email`, `subject`, `department`, `description`, `priority`, `screenshot`, `submitted_at`, `status`, `attachments`, `admin_response`) VALUES
(11, NULL, 'bundang', 'suman', 'bundang@psu.edu.ph', 'Support Request', 'Science ', 'dsadsa', 'Medium', '1.png', '2024-11-09 01:46:00', '1', NULL, NULL),
(12, NULL, 'ema', 'victolero', 'ema@gmail.com', 'Support Request', 'Math', 'sadsads', 'Medium', 'body.png', '2024-11-09 02:57:10', 'Active', NULL, NULL),
(13, NULL, 'binay', 'binay', 'sadsad@gmail.com', 'Support Request', 'dsadasd', 'dsadasd', 'Medium', 'parachute.png', '2024-11-12 02:14:34', 'Active', NULL, NULL),
(16, NULL, 'gg', 'aa', 'kiwiilemon13@gmail.com', 'Support Request', 'IT', 'afafwarwrwr', 'Medium', 'CASUPANG, GIO REQUEST FOR SPECIAL EXAMINATION.pdf', '2024-11-23 03:20:12', 'Active', NULL, NULL),
(17, NULL, 'adsafgg', 'aaaa', '123@psu.edu.ph', 'Support Request', 'BSIT', 'adadsda', 'Medium', '2018-01-30-product-3 - Copy.webp', '2024-11-29 07:49:58', 'Active', NULL, NULL),
(18, NULL, 'adsafgg', 'afsaf', 'aztro14000@gmail.com', 'Support Request', 'BSBA', 'faa', 'Medium', '11 - Copy.jpg', '2024-11-29 07:59:35', 'Active', NULL, NULL),
(19, NULL, 'sdgdgd', 'aaaa', 'qwe@psu.edu.ph', 'Support Request', 'BSIT', 'aasgg', 'Medium', 'ghostrunner-game-uhdpaper.com-hd-7.1293.jpg', '2024-11-29 08:01:25', 'Active', NULL, NULL),
(20, NULL, 'daxa', 'asafag', '123@psu.edu.ph', 'Support Request', 'BSBA', 'gagdsaga', 'Medium', '281036.jpg,625497.jpg,805783.jpg', '2024-11-29 08:05:52', 'Active', NULL, NULL),
(21, NULL, 'GSDHFHH', 'JTGJGJGJG', 'aww@gmail.com', 'Support Request', 'BSE', 'ADSAGG', 'Medium', 'h525 (1).png,jase-bloor-oCZHIa1D4EU-unsplash.jpg,LD0005669338_1.jpg', '2024-11-29 08:19:22', 'Active', NULL, NULL),
(22, NULL, 'jnnjg', 'gjhcbvcb', '21as0260_ms@psu.edu.ph', 'Support Request', 'BIT', 'hfdhhxchs', 'Medium', '[]', '2024-11-29 10:39:01', 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_logs`
--

CREATE TABLE `ticket_logs` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_logs`
--

INSERT INTO `ticket_logs` (`id`, `ticket_id`, `action`, `details`, `created_at`) VALUES
(1, 11, 'status_update', '{\"old_status\":\"Unknown\",\"new_status\":\"In Progress\",\"admin_response\":\"hdhfgdsg\"}', '2025-05-23 13:53:23'),
(2, 21, 'status_update', '{\"old_status\":\"Unknown\",\"new_status\":\"Closed\",\"admin_response\":\"gdsfg\"}', '2025-05-23 14:00:59'),
(3, 21, 'status_update', '{\"old_status\":\"Unknown\",\"new_status\":\"Resolved\",\"admin_response\":\"\"}', '2025-05-23 14:01:23'),
(4, 23, 'status_update', '{\"old_status\":\"Unknown\",\"new_status\":\"Resolved\",\"admin_response\":\"wait\"}', '2025-05-24 00:03:09'),
(5, 24, 'status_update', '{\"old_status\":\"Unknown\",\"new_status\":\"In Progress\",\"admin_response\":\"your ticket is on hold\"}', '2025-05-24 00:13:30'),
(6, 24, 'status_update', '{\"old_status\":\"Unknown\",\"new_status\":\"Closed\",\"admin_response\":\"Congrats\"}', '2025-05-24 00:14:05'),
(7, 25, 'status_update', '{\"old_status\":\"Unknown\",\"new_status\":\"Resolved\",\"admin_response\":\"hdtdh d\"}', '2025-05-24 00:53:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(5, 'bernabe', 'bernabe@psu.edu.ph', '$2y$10$6RXclQv0N99Wyw1TXcE.zOcmT9DKXf7E4daT5D/4HFDll.LJNTPou', '2024-10-30 05:37:10', '2024-10-30 05:37:10'),
(6, 'susi', 'susi@psu.edu.ph', '$2y$10$WNjHgiA7gdSYHBICr/fP5eBmxeQu.gKnw2feZsnTiwEdMoNh6fuBa', '2024-11-09 06:21:36', '2024-11-09 06:21:36'),
(7, 'Aizen Sosuke ', 'aizen@psu.edu.ph', '$2y$10$4JlN05er6QNawfUF8t6oHebU9cmO/FmYlqrVzrJNC7JTvC3xBQqgK', '2024-11-10 03:52:55', '2024-11-10 03:52:55'),
(8, 'kiwii', 'gami@psu.edu.ph', '$2y$10$1k45/D1ORqlJhiggVxlL5ep5/qwHkJAJaqxWct8ZwngpRfY1QU4kK', '2024-11-14 11:10:11', '2024-11-14 11:10:11'),
(9, 'user', 'user@psu.edu.ph', '$2y$10$gEJTF7u7n636OGQL0OYgUuOZUsw1/CAyhZlG30invljaljFqMaGgm', '2024-11-20 10:41:43', '2024-11-20 10:41:43'),
(10, '123', '123@psu.edu.ph', '$2y$10$OGp.liQTo6lnkHtDWQhy7O7L2LdazMlFGGEsvwZomzTaxZER3wzoG', '2024-11-22 08:53:11', '2024-11-22 08:53:11'),
(11, 'kiwii', 'qwe@psu.edu.ph', '$2y$10$gRJ4araxRzqTQxCEU1RyXuhAWs3owr1VAZadsq9hEbUlttxtZdOYi', '2024-11-29 07:58:06', '2024-11-29 07:58:06'),
(12, 'treyal', 'gio@psu.edu.ph', '$2y$10$E1huwAU7OB1sh77JcD2HTe0BuONrQs./hWaBSgqKffxbg6Mh2dOaO', '2024-11-30 05:34:48', '2024-11-30 05:34:48'),
(13, 'maala', 'maala@psu.edu.ph', '$2y$10$RXln3BaINhjv9rQP8kx12ebdGI4M24RBYt.APEbE0aXQuJJHZuQZe', '2025-05-23 11:57:37', '2025-05-23 11:57:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `contact_feedback`
--
ALTER TABLE `contact_feedback`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_rating` (`rating`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`StudentID`),
  ADD UNIQUE KEY `EmailAddress` (`EmailAddress`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`TeacherID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_email` (`email`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_priority` (`priority`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `tickets_backup_2025_05_23_15_52_31`
--
ALTER TABLE `tickets_backup_2025_05_23_15_52_31`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_email` (`email`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_priority` (`priority`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `ticket_logs`
--
ALTER TABLE `ticket_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ticket_id` (`ticket_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `contact_feedback`
--
ALTER TABLE `contact_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `course_instructors`
--
ALTER TABLE `course_instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `TeacherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tickets_backup_2025_05_23_15_52_31`
--
ALTER TABLE `tickets_backup_2025_05_23_15_52_31`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ticket_logs`
--
ALTER TABLE `ticket_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
