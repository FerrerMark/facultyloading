-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2025 at 12:26 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `facultyloading`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `program_code` varchar(50) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `course_type` enum('General Education','Department-Specific') NOT NULL,
  `year_level` int(11) NOT NULL,
  `semester` enum('First','Second','Summer') NOT NULL,
  `lecture_hours` int(11) NOT NULL,
  `lab_hours` int(11) NOT NULL,
  `credit_units` int(11) NOT NULL,
  `slots` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `program_code`, `subject_code`, `course_title`, `course_type`, `year_level`, `semester`, `lecture_hours`, `lab_hours`, `credit_units`, `slots`) VALUES
(57, 'BSIT', 'BPM101', 'Business Process Management in IT', 'Department-Specific', 3, 'Second', 3, 0, 3, 40),
(58, 'BSIT', 'CC101', 'Introduction to Computing', 'Department-Specific', 1, 'First', 3, 0, 3, 40),
(59, 'BSIT', 'CC102', 'Computer Programming 1', 'Department-Specific', 1, 'First', 3, 0, 3, 40),
(60, 'BSIT', 'CC103', 'Computer Programming 2', 'Department-Specific', 1, 'Second', 3, 0, 3, 40),
(61, 'BSIT', 'CC104', 'Data Structures and Algorithms', 'Department-Specific', 2, 'First', 3, 0, 3, 40),
(62, 'BSIT', 'CC105', 'Information Management', 'Department-Specific', 2, 'Second', 3, 0, 3, 40),
(63, 'BSIT', 'CC106', 'Application Development and Emerging Technologies', 'Department-Specific', 3, 'First', 3, 0, 3, 40),
(64, 'BSIT', 'DM102', 'Financial Management', 'Department-Specific', 2, 'Second', 3, 0, 3, 40),
(65, 'BSIT', 'FLD15', 'Filipino sa Iba’t-ibang Disiplina', 'General Education', 1, 'Second', 3, 0, 3, 40),
(66, 'BSIT', 'GE1', 'Understanding the Self', 'General Education', 1, 'First', 3, 0, 3, 40),
(67, 'BSIT', 'GE2', 'Readings in Philippine History', 'General Education', 1, 'First', 3, 0, 3, 40),
(68, 'BSIT', 'GE3', 'The Contemporary World', 'General Education', 1, 'First', 3, 0, 3, 40),
(69, 'BSIT', 'GE4', 'Mathematics in the Modern World', 'General Education', 1, 'First', 3, 0, 3, 40),
(70, 'BSIT', 'GE5', 'Purposive Communication', 'General Education', 1, 'Second', 3, 0, 3, 40),
(71, 'BSIT', 'GE6', 'Art Appreciation', 'General Education', 1, 'Second', 3, 0, 3, 40),
(72, 'BSIT', 'GE7', 'Science and Technology and Society', 'General Education', 1, 'Second', 3, 0, 3, 40),
(73, 'BSIT', 'GE8', 'Ethics', 'General Education', 1, 'Second', 3, 0, 3, 40),
(74, 'BSIT', 'GE9', 'The Life and Works of Jose Rizal', 'General Education', 2, 'Second', 3, 0, 3, 40),
(75, 'BSIT', 'HCI101', 'Introduction to Human-Computer Interaction', 'Department-Specific', 2, 'First', 3, 0, 3, 40),
(76, 'BSIT', 'IAS101', 'Information Assurance and Security 1', 'Department-Specific', 3, 'First', 3, 0, 3, 40),
(77, 'BSIT', 'IAS102', 'Information Assurance and Security 2', 'Department-Specific', 3, 'Second', 3, 0, 3, 40),
(78, 'BSIT', 'IM101', 'Fundamentals of Database System', 'Department-Specific', 3, 'First', 3, 0, 3, 40),
(79, 'BSIT', 'IPT101', 'Integrative Programming and Technologies 1', 'Department-Specific', 2, 'First', 3, 0, 3, 40),
(80, 'BSIT', 'ITE1', 'IT ELECTIVE 1 (Web Fundamental)', 'Department-Specific', 2, 'First', 3, 0, 3, 40),
(81, 'BSIT', 'ITE2', 'IT ELECTIVE 2', 'Department-Specific', 2, 'Second', 3, 0, 3, 40),
(82, 'BSIT', 'ITE3', 'IT ELECTIVE 3 (Research)', 'Department-Specific', 3, 'First', 3, 0, 3, 40),
(83, 'BSIT', 'ITSP1-A', 'ENTERPRISE SYSTEMS: CONCEPT AND PRACTICE', 'Department-Specific', 3, 'First', 3, 0, 3, 40),
(84, 'BSIT', 'ITSP2A', 'Mobile Application and Development', 'Department-Specific', 3, 'Second', 3, 0, 3, 40),
(85, 'BSIT', 'KOMFIL', 'Kontekstualisadong Komunikasyon sa Filipino', 'General Education', 1, 'First', 3, 0, 3, 40),
(86, 'BSIT', 'MIS101', 'Discrete Mathematics', 'General Education', 1, 'Second', 3, 0, 3, 40),
(87, 'BSIT', 'MS102', 'Quantitative Methods with Modelling Simulation', 'Department-Specific', 2, 'First', 3, 0, 3, 40),
(88, 'BSIT', 'NET101', 'Networking 1', 'Department-Specific', 2, 'First', 3, 0, 3, 40),
(89, 'BSIT', 'NET102', 'Networking 2', 'Department-Specific', 2, 'Second', 3, 0, 3, 40),
(90, 'BSIT', 'NSTP1', 'National Service Training Program 1', 'General Education', 1, 'First', 3, 0, 3, 40),
(91, 'BSIT', 'NSTP2', 'National Service Training Program 2', 'General Education', 1, 'Second', 3, 0, 3, 40),
(92, 'BSIT', 'PE1', 'Physical Fitness', 'General Education', 1, 'First', 2, 0, 2, 40),
(93, 'BSIT', 'PE2', 'Folk Dance and Rhythmic Activities', 'General Education', 1, 'Second', 3, 0, 3, 40),
(94, 'BSIT', 'PE3', 'Individual and Dual Sports', 'General Education', 2, 'First', 2, 0, 2, 40),
(95, 'BSIT', 'PE4', 'Team Sports', 'General Education', 2, 'Second', 2, 0, 2, 40),
(96, 'BSIT', 'PM101', 'Project Management', 'Department-Specific', 3, 'First', 3, 0, 3, 40),
(97, 'BSIT', 'SA101', 'System Administration and Maintenance', 'Department-Specific', 3, 'Second', 3, 0, 3, 40),
(98, 'BSIT', 'SIA101', 'System Integration and Architecture 1', 'Department-Specific', 2, 'Second', 3, 0, 3, 40),
(99, 'BSIT', 'SOSLIT', 'Sosyedad at Literatura', 'General Education', 2, 'First', 3, 0, 3, 40),
(100, 'BSIT', 'SP101', 'Social and Professional Issues', 'Department-Specific', 3, 'Second', 3, 0, 3, 40),
(101, 'BSIT', 'TEC101', 'Technopreneurship', 'Department-Specific', 3, 'Second', 3, 0, 3, 40),
(102, 'BSIT', 'WEB101', 'Web Development', 'Department-Specific', 2, 'Second', 3, 0, 3, 40);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `college` varchar(100) DEFAULT NULL,
  `employment_status` enum('Full-Time','Part-Time') DEFAULT 'Full-Time',
  `address` text DEFAULT NULL,
  `phone_no` varchar(20) NOT NULL,
  `departmentID` varchar(50) DEFAULT NULL,
  `role` enum('Dean','Department Head','Instructor') DEFAULT NULL,
  `master_specialization` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `max_weekly_hours` int(11) DEFAULT 18,
  `availability` text NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `firstname`, `middlename`, `lastname`, `college`, `employment_status`, `address`, `phone_no`, `departmentID`, `role`, `master_specialization`, `created_at`, `max_weekly_hours`, `availability`, `start_time`, `end_time`) VALUES
(1, 'John', 'Doe', 'Smith', 'College of Computer Science', 'Full-Time', '123 Main St', '09171234567', 'BSIT', 'Dean', 'General Education', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Wednesday,Thursday,Friday', '06:00:00', '21:00:00'),
(2, 'Alice', 'A.', 'Johnson', 'College of Computer Science', 'Full-Time', '456 Elm St', '09172345678', 'BSIT', 'Department Head', 'Dep_specific_course', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Wednesday,Thursday,Friday', '06:00:00', '21:00:00'),
(3, 'Robert', 'B.', 'Brown', 'College of Computer Science', 'Full-Time', '789 Oak St', '09173456789', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Wednesday,Thursday,Friday', '06:00:00', '21:00:00'),
(4, 'Emily', 'C.', 'Williams', 'College of Computer Science', 'Part-Time', '321 Pine St', '09174567890', 'BSIT', 'Instructor', 'General Education', '2025-02-08 07:13:58', 20, 'Monday,Friday,Wednesday', '06:00:00', '12:00:00'),
(5, 'Michael', 'D.', 'Jones', 'College of Computer Science', 'Full-Time', '654 Birch St', '09175678901', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Wednesday,Thursday,Friday', '06:00:00', '21:00:00'),
(6, 'Sarah', 'E.', 'Garcia', 'College of Computer Science', 'Full-Time', '987 Cedar St', '09176789012', 'BSIT', 'Instructor', 'General Education', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Wednesday,Thursday,Friday', '06:00:00', '21:00:00'),
(7, 'David', 'F.', 'Martinez', 'College of Computer Science', 'Full-Time', '543 Maple St', '09177890123', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Wednesday,Thursday,Friday', '06:00:00', '21:00:00'),
(8, 'Jessica', 'G.', 'Hernandez', 'College of Computer Science', 'Part-Time', '765 Walnut St', '09178901234', 'BSIT', 'Instructor', 'General Education', '2025-02-08 07:13:58', 20, 'Monday,Tuesday,Friday, Wednesday, Friday', '06:00:00', '12:00:00'),
(9, 'James', 'H.', 'Lopez', 'College of Computer Science', 'Full-Time', '234 Fir St', '09179012345', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Wednesday,Thursday,Friday', '06:00:00', '21:00:00'),
(10, 'Mary', 'I.', 'Gonzalez', 'College of Computer Science', 'Full-Time', '876 Ash St', '09180123456', 'BSIT', 'Instructor', 'General Education', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Wednesday,Thursday,Friday', '06:00:00', '21:00:00'),
(49, 'johnmak', 'sibayan', 'Ferrer', 'test', 'Full-Time', 'test', '355555', 'BSIT', 'Instructor', 'test', '2025-02-10 07:32:30', 40, 'Monday,Tuesday,Wednesday,Thursday,Friday', '06:00:00', '21:00:00'),
(90, 'johnmak', 'Galilei', 'Tesla', 'test', 'Full-Time', 'test', '0909589', 'BSIT', 'Instructor', 'gsae', '2025-02-20 07:06:27', 40, 'Monday,Tuesday,Wednesday,Thursday,Friday', '06:00:00', '21:00:00'),
(91, 'asef', 'asaefsf', 'asfeasdf', 'fasefdsaf', 'Part-Time', 'afeasef', '0909234', 'BSIT', 'Instructor', 'erwqrawef', '2025-02-20 07:10:55', 40, 'wqetcfwera', '06:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_courses`
--

CREATE TABLE `faculty_courses` (
  `faculty_id` int(11) NOT NULL,
  `subject_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_courses`
--

INSERT INTO `faculty_courses` (`faculty_id`, `subject_code`) VALUES
(1, 'BPM101'),
(1, 'CC101'),
(1, 'CC102'),
(1, 'CC103'),
(1, 'CC104'),
(1, 'FLD15'),
(2, 'CC101'),
(2, 'CC102'),
(2, 'CC103'),
(2, 'CC104'),
(2, 'CC105'),
(2, 'CC106'),
(2, 'DM102'),
(3, 'BPM101'),
(3, 'CC101'),
(3, 'CC102'),
(3, 'CC103'),
(3, 'CC104'),
(3, 'CC105'),
(3, 'CC106'),
(3, 'DM102'),
(3, 'FLD15'),
(4, 'GE1'),
(4, 'GE2'),
(4, 'GE3'),
(4, 'GE4'),
(5, 'CC101'),
(6, 'KOMFIL'),
(6, 'NSTP1'),
(7, 'PE1');

-- --------------------------------------------------------

--
-- Table structure for table `pending_preferred_courses`
--

CREATE TABLE `pending_preferred_courses` (
  `pending_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `available_days` text DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_preferred_courses`
--

INSERT INTO `pending_preferred_courses` (`pending_id`, `faculty_id`, `subject_code`, `available_days`, `start_time`, `end_time`, `status`, `submission_date`) VALUES
(1, 3, 'CC101', NULL, NULL, NULL, 'Accepted', '2025-02-27 16:26:15'),
(2, 3, 'GE3', NULL, NULL, NULL, 'Accepted', '2025-02-27 16:26:15'),
(3, 3, 'NSTP1', NULL, NULL, NULL, 'Accepted', '2025-02-27 16:26:15'),
(4, 3, 'ITE2', NULL, NULL, NULL, 'Accepted', '2025-02-27 16:27:48'),
(5, 3, 'GE4', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:46:18'),
(6, 3, 'CC106', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:46:26'),
(7, 3, 'IAS102', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:46:26'),
(8, 3, 'GE4', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:48:08'),
(9, 3, 'KOMFIL', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:49:50'),
(13, 3, 'GE1', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:53:30'),
(14, 3, 'IAS102', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:54:28'),
(15, 3, 'CC103', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:54:50'),
(16, 3, 'CC103', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:55:19'),
(17, 3, 'CC104', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:55:24'),
(18, 3, 'GE1', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:55:40'),
(19, 3, 'CC105', NULL, NULL, NULL, 'Rejected', '2025-02-27 16:58:25'),
(20, 3, 'CC105', NULL, NULL, NULL, 'Accepted', '2025-02-27 16:58:46'),
(21, 3, 'CC106', NULL, NULL, NULL, 'Rejected', '2025-02-27 17:01:28'),
(22, 3, 'GE1', NULL, NULL, NULL, 'Rejected', '2025-02-27 17:01:31'),
(23, 3, 'CC104', NULL, NULL, NULL, 'Rejected', '2025-02-27 17:01:46'),
(24, 3, 'HCI101', NULL, NULL, NULL, 'Accepted', '2025-02-28 01:31:29'),
(25, 3, 'IAS101', NULL, NULL, NULL, 'Accepted', '2025-02-28 01:31:29'),
(26, 3, 'IAS102', NULL, NULL, NULL, 'Accepted', '2025-02-28 01:31:29'),
(27, 3, 'CC101', NULL, NULL, NULL, 'Accepted', '2025-02-28 01:51:17'),
(28, 3, 'CC101', NULL, NULL, NULL, 'Accepted', '2025-02-28 01:51:30'),
(29, 3, 'BPM101', NULL, NULL, NULL, 'Accepted', '2025-02-28 01:58:02'),
(30, 3, 'CC103', NULL, NULL, NULL, 'Accepted', '2025-02-28 01:58:15'),
(31, 3, 'CC103', NULL, NULL, NULL, '', '2025-02-28 02:06:38'),
(32, 3, 'SP101', NULL, NULL, NULL, 'Accepted', '2025-02-28 02:08:20'),
(33, 3, 'TEC101', NULL, NULL, NULL, 'Accepted', '2025-02-28 02:08:20'),
(34, 3, 'WEB101', NULL, NULL, NULL, 'Accepted', '2025-02-28 02:08:20'),
(36, 3, 'NET101', NULL, NULL, NULL, 'Rejected', '2025-02-28 02:12:41'),
(37, 3, 'NET102', NULL, NULL, NULL, 'Rejected', '2025-02-28 02:12:41'),
(38, 3, 'CC104', NULL, NULL, NULL, 'Accepted', '2025-02-28 02:18:36'),
(43, 3, 'CC103', NULL, NULL, NULL, 'Accepted', '2025-02-28 02:30:13'),
(44, 3, 'CC104', NULL, NULL, NULL, 'Accepted', '2025-02-28 02:30:13'),
(45, 3, 'ITE1', NULL, NULL, NULL, 'Rejected', '2025-02-28 02:31:58'),
(47, 3, 'IAS102', NULL, NULL, NULL, 'Accepted', '2025-02-28 04:29:13'),
(48, 3, 'ITE1', NULL, NULL, NULL, 'Accepted', '2025-02-28 04:29:29'),
(50, 3, 'FLD15', NULL, NULL, NULL, '', '2025-03-01 17:51:47'),
(51, 3, 'FLD15', NULL, NULL, NULL, '', '2025-03-01 17:53:38'),
(52, 3, 'FLD15', NULL, NULL, NULL, '', '2025-03-01 17:54:27'),
(53, 3, 'FLD15', NULL, NULL, NULL, '', '2025-03-01 17:54:49'),
(54, 3, 'FLD15', NULL, NULL, NULL, '', '2025-03-01 17:55:47'),
(55, 3, 'FLD15', NULL, NULL, NULL, '', '2025-03-01 17:55:53'),
(56, 3, 'FLD15', NULL, NULL, NULL, '', '2025-03-01 17:57:08'),
(57, 3, 'FLD15', NULL, NULL, NULL, '', '2025-03-01 17:57:13'),
(58, 3, 'IAS102', NULL, NULL, NULL, '', '2025-03-01 18:00:06'),
(59, 3, 'IAS102', NULL, NULL, NULL, '', '2025-03-01 18:00:15'),
(60, 3, 'IAS102', NULL, NULL, NULL, '', '2025-03-01 18:02:13'),
(61, 3, 'BPM101', NULL, NULL, NULL, '', '2025-03-01 18:02:18'),
(62, 3, 'BPM101', NULL, NULL, NULL, '', '2025-03-01 18:05:16'),
(63, 3, 'IAS102', NULL, NULL, NULL, '', '2025-03-01 18:06:36'),
(64, 3, 'GE1', NULL, NULL, NULL, 'Accepted', '2025-03-01 18:07:50'),
(65, 3, 'KOMFIL', NULL, NULL, NULL, 'Accepted', '2025-03-01 18:08:05'),
(67, 3, 'SP101', NULL, NULL, NULL, 'Rejected', '2025-03-01 18:08:30'),
(68, 3, 'WEB101', NULL, NULL, NULL, 'Rejected', '2025-03-01 18:08:30'),
(69, 3, 'PM101', NULL, NULL, NULL, 'Rejected', '2025-03-01 18:10:47'),
(70, 3, 'SA101', NULL, NULL, NULL, 'Rejected', '2025-03-01 18:10:47'),
(71, 3, 'MIS101', NULL, NULL, NULL, 'Rejected', '2025-03-01 18:10:53'),
(72, 3, 'ITE1', NULL, NULL, NULL, '', '2025-03-01 18:16:14'),
(74, 3, 'KOMFIL', NULL, NULL, NULL, '', '2025-03-01 18:21:05'),
(75, 3, 'KOMFIL', NULL, NULL, NULL, '', '2025-03-01 18:22:29'),
(76, 3, 'KOMFIL', NULL, NULL, NULL, '', '2025-03-01 18:26:49'),
(77, 3, 'TEC101', NULL, NULL, NULL, 'Rejected', '2025-03-01 18:31:37'),
(78, 3, 'KOMFIL', NULL, NULL, NULL, '', '2025-03-01 18:31:50'),
(80, 3, 'KOMFIL', NULL, NULL, NULL, '', '2025-03-01 18:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `program_code` varchar(50) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `college` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`program_code`, `program_name`, `college`) VALUES
('BSBA', 'Bachelor of Science in Business Administration', 'College of Business'),
('BSIT', 'Bachelor of Science in Information Technology', 'College of Computing');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `building` varchar(100) NOT NULL,
  `room_no` varchar(50) NOT NULL,
  `room_type` enum('Lecture','Computer Lab') NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `building`, `room_no`, `room_type`, `capacity`) VALUES
(4, 'MV campus', '301', 'Lecture', 50),
(5, 'MV Campus', '302', 'Lecture', 50),
(7, 'MV Campus', '303', 'Lecture', 50),
(8, 'MV Campus', '304', 'Lecture', 50),
(9, 'MV Campus', '305', 'Lecture', 50),
(10, 'MV Campus', '306', 'Lecture', 50),
(11, 'MV Campus', '307', 'Lecture', 50),
(12, 'MV Campus', '308', 'Lecture', 50),
(13, 'MV Campus', '309', 'Lecture', 50),
(14, 'MV Campus', '310', 'Lecture', 50),
(15, 'MV Campus', '311', 'Computer Lab', 50);

-- --------------------------------------------------------

--
-- Table structure for table `room_assignments`
--

CREATE TABLE `room_assignments` (
  `assignment_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_assignments`
--

INSERT INTO `room_assignments` (`assignment_id`, `section_id`, `subject_code`, `day_of_week`, `start_time`, `end_time`, `room_id`) VALUES
(529, 1, 'CC101', 'Monday', '06:00:00', '07:00:00', 15),
(530, 1, 'GE1', 'Monday', '07:00:00', '08:00:00', 4),
(531, 1, 'GE2', 'Monday', '08:00:00', '09:00:00', 4),
(532, 1, 'CC102', 'Wednesday', '06:00:00', '07:00:00', 15),
(533, 1, 'GE3', 'Wednesday', '07:00:00', '08:00:00', 4),
(534, 1, 'GE4', 'Wednesday', '08:00:00', '09:00:00', 4),
(535, 1, 'KOMFIL', 'Friday', '06:00:00', '07:00:00', 4),
(536, 1, 'NSTP1', 'Friday', '07:00:00', '08:00:00', 4),
(537, 1, 'PE1', 'Friday', '08:00:00', '09:00:00', 4),
(538, 3, 'CC101', 'Monday', '09:00:00', '10:00:00', 15),
(539, 3, 'GE1', 'Monday', '10:00:00', '11:00:00', 4),
(540, 3, 'GE2', 'Monday', '11:00:00', '12:00:00', 4),
(541, 3, 'CC102', 'Wednesday', '09:00:00', '10:00:00', 15),
(542, 3, 'GE3', 'Wednesday', '10:00:00', '11:00:00', 4),
(543, 3, 'GE4', 'Wednesday', '11:00:00', '12:00:00', 4),
(544, 3, 'KOMFIL', 'Friday', '09:00:00', '10:00:00', 4),
(545, 3, 'NSTP1', 'Friday', '10:00:00', '11:00:00', 4),
(546, 3, 'PE1', 'Friday', '11:00:00', '12:00:00', 4),
(547, 2, 'GE1', 'Monday', '07:00:00', '08:00:00', 5),
(548, 2, 'GE2', 'Monday', '08:00:00', '09:00:00', 5),
(549, 2, 'GE3', 'Wednesday', '07:00:00', '08:00:00', 5),
(550, 2, 'GE4', 'Wednesday', '08:00:00', '09:00:00', 5),
(551, 2, 'KOMFIL', 'Friday', '06:00:00', '07:00:00', 5),
(552, 2, 'NSTP1', 'Friday', '07:00:00', '08:00:00', 5),
(553, 2, 'PE1', 'Friday', '08:00:00', '09:00:00', 5),
(554, 4, 'CC101', 'Tuesday', '09:00:00', '10:00:00', 15),
(555, 4, 'GE1', 'Tuesday', '10:00:00', '11:00:00', 4),
(556, 4, 'GE2', 'Tuesday', '11:00:00', '12:00:00', 4),
(557, 4, 'CC102', 'Thursday', '09:00:00', '10:00:00', 15),
(558, 4, 'GE3', 'Thursday', '10:00:00', '11:00:00', 4),
(559, 4, 'GE4', 'Thursday', '11:00:00', '12:00:00', 4),
(560, 4, 'KOMFIL', 'Saturday', '09:00:00', '10:00:00', 4),
(561, 4, 'NSTP1', 'Saturday', '10:00:00', '11:00:00', 4),
(562, 4, 'PE1', 'Saturday', '11:00:00', '12:00:00', 4),
(563, 5, 'CC104', 'Monday', '12:00:00', '13:00:00', 15),
(564, 5, 'HCI101', 'Monday', '13:00:00', '14:00:00', 4),
(565, 5, 'IPT101', 'Monday', '14:00:00', '15:00:00', 4),
(566, 5, 'ITE1', 'Wednesday', '12:00:00', '13:00:00', 4),
(567, 5, 'MS102', 'Wednesday', '13:00:00', '14:00:00', 4),
(568, 5, 'NET101', 'Wednesday', '14:00:00', '15:00:00', 15),
(569, 5, 'SOSLIT', 'Friday', '12:00:00', '13:00:00', 4),
(570, 5, 'PE3', 'Friday', '13:00:00', '14:00:00', 4),
(571, 6, 'HCI101', 'Monday', '13:00:00', '14:00:00', 5),
(572, 6, 'IPT101', 'Monday', '14:00:00', '15:00:00', 5),
(573, 6, 'ITE1', 'Wednesday', '12:00:00', '13:00:00', 5),
(574, 6, 'MS102', 'Wednesday', '13:00:00', '14:00:00', 5),
(575, 6, 'SOSLIT', 'Friday', '12:00:00', '13:00:00', 5),
(576, 6, 'PE3', 'Friday', '13:00:00', '14:00:00', 5),
(577, 2, 'CC101', 'Monday', '06:00:00', '07:00:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `schedule_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `section_id` int(11) NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `time_slot` varchar(255) NOT NULL,
  `is_checked` tinyint(1) DEFAULT 0,
  `course_id` int(255) DEFAULT NULL,
  `room_id` varchar(255) DEFAULT NULL,
  `department` varchar(35) DEFAULT NULL,
  `year_level` varchar(35) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`schedule_id`, `faculty_id`, `subject_code`, `section_id`, `day_of_week`, `time_slot`, `is_checked`, `course_id`, `room_id`, `department`, `year_level`, `semester`, `start_time`, `end_time`) VALUES
(3410, 3, 'CC101', 1, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '06:00:00', '07:00:00'),
(3411, 6, 'KOMFIL', 1, 'Friday', '', 0, NULL, NULL, NULL, NULL, NULL, '06:00:00', '07:00:00'),
(3412, 2, 'CC102', 1, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '06:00:00', '07:00:00'),
(3413, 6, 'NSTP1', 1, 'Friday', '', 0, NULL, NULL, NULL, NULL, NULL, '07:00:00', '08:00:00'),
(3414, 1, 'CC101', 3, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '09:00:00', '10:00:00'),
(3415, 1, 'CC102', 3, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '09:00:00', '10:00:00'),
(3416, 1, 'CC102', 2, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '06:00:00', '07:00:00'),
(3417, 1, 'CC101', 4, 'Tuesday', '', 0, NULL, NULL, NULL, NULL, NULL, '09:00:00', '10:00:00'),
(3418, 1, 'CC102', 4, 'Thursday', '', 0, NULL, NULL, NULL, NULL, NULL, '09:00:00', '10:00:00'),
(3419, 1, 'CC104', 5, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '12:00:00', '13:00:00'),
(3420, 2, 'CC101', 2, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '06:00:00', '07:00:00'),
(3421, 2, 'CC104', 6, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '12:00:00', '13:00:00'),
(3422, 3, 'MS102', 5, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '13:00:00', '14:00:00'),
(3423, 4, 'GE1', 1, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '07:00:00', '08:00:00'),
(3424, 0, 'GE3', 1, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '07:00:00', '08:00:00'),
(3425, 4, 'GE1', 3, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '10:00:00', '11:00:00'),
(3426, 4, 'GE3', 3, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '10:00:00', '11:00:00'),
(3427, 4, 'GE2', 2, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '08:00:00', '09:00:00'),
(3428, 4, 'GE4', 2, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '08:00:00', '09:00:00'),
(3429, 5, 'NET101', 5, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '14:00:00', '15:00:00'),
(3430, 6, 'GE2', 1, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '08:00:00', '09:00:00'),
(3431, 6, 'GE2', 3, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '11:00:00', '12:00:00'),
(3432, 6, 'KOMFIL', 3, 'Friday', '', 0, NULL, NULL, NULL, NULL, NULL, '09:00:00', '10:00:00'),
(3433, 6, 'GE2', 4, 'Tuesday', '', 0, NULL, NULL, NULL, NULL, NULL, '11:00:00', '12:00:00'),
(3434, 7, 'PE1', 1, 'Friday', '', 0, NULL, NULL, NULL, NULL, NULL, '08:00:00', '09:00:00'),
(3435, 7, 'PE1', 3, 'Friday', '', 0, NULL, NULL, NULL, NULL, NULL, '11:00:00', '12:00:00'),
(3436, 8, 'GE1', 2, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '07:00:00', '08:00:00'),
(3437, 8, 'GE1', 4, 'Tuesday', '', 0, NULL, NULL, NULL, NULL, NULL, '10:00:00', '11:00:00'),
(3438, 49, 'HCI101', 5, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '13:00:00', '14:00:00'),
(3439, 49, 'IPT101', 6, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '14:00:00', '15:00:00'),
(3440, 6, 'NSTP1', 3, 'Friday', '', 0, NULL, NULL, NULL, NULL, NULL, '10:00:00', '11:00:00'),
(3441, 4, 'GE4', 3, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '11:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` int(11) NOT NULL,
  `program_code` varchar(50) NOT NULL,
  `year_level` int(11) NOT NULL,
  `section_name` varchar(10) NOT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `program_code`, `year_level`, `section_name`, `semester`, `start_time`, `end_time`) VALUES
(1, 'BSIT', 1, 'BSIT-1101', '1', '06:00:00', '12:00:00'),
(2, 'BSIT', 1, 'BSIT-1102', '1', '05:00:00', '12:00:00'),
(3, 'BSIT', 1, 'BSIT-1103', '1', '13:00:00', '12:00:00'),
(4, 'BSIT', 1, 'BSIT-1104', '1', '09:00:00', '12:00:00'),
(5, 'BSIT', 2, 'BSIT-1105', '1', '12:00:00', '15:00:00'),
(6, 'BSIT', 2, 'BSIT-1106', '1', '12:00:00', '15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `section_schedules`
--

CREATE TABLE `section_schedules` (
  `schedule_id` int(11) NOT NULL,
  `section_id` varchar(50) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `semester` enum('First','Second','Summer') NOT NULL,
  `program_code` varchar(20) NOT NULL,
  `section_name` varchar(50) DEFAULT NULL,
  `year_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section_schedules`
--

INSERT INTO `section_schedules` (`schedule_id`, `section_id`, `subject_code`, `day_of_week`, `start_time`, `end_time`, `semester`, `program_code`, `section_name`, `year_level`) VALUES
(1, '1', 'CC101', 'Monday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1101', 1),
(2, '1', 'GE1', 'Monday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1101', 1),
(3, '1', 'GE2', 'Monday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1101', 1),
(4, '1', 'CC102', 'Wednesday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1101', 1),
(5, '1', 'GE3', 'Wednesday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1101', 1),
(6, '1', 'GE4', 'Wednesday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1101', 1),
(7, '1', 'KOMFIL', 'Friday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1101', 1),
(8, '1', 'NSTP1', 'Friday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1101', 1),
(9, '1', 'PE1', 'Friday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1101', 1),
(19, '3', 'CC101', 'Monday', '09:00:00', '10:00:00', 'First', 'BSIT', 'BSIT-1103', 1),
(20, '3', 'GE1', 'Monday', '10:00:00', '11:00:00', 'First', 'BSIT', 'BSIT-1103', 1),
(21, '3', 'GE2', 'Monday', '11:00:00', '12:00:00', 'First', 'BSIT', 'BSIT-1103', 1),
(22, '3', 'CC102', 'Wednesday', '09:00:00', '10:00:00', 'First', 'BSIT', 'BSIT-1103', 1),
(23, '3', 'GE3', 'Wednesday', '10:00:00', '11:00:00', 'First', 'BSIT', 'BSIT-1103', 1),
(24, '3', 'GE4', 'Wednesday', '11:00:00', '12:00:00', 'First', 'BSIT', 'BSIT-1103', 1),
(25, '3', 'KOMFIL', 'Friday', '09:00:00', '10:00:00', 'First', 'BSIT', 'BSIT-1103', 1),
(26, '3', 'NSTP1', 'Friday', '10:00:00', '11:00:00', 'First', 'BSIT', 'BSIT-1103', 1),
(27, '3', 'PE1', 'Friday', '11:00:00', '12:00:00', 'First', 'BSIT', 'BSIT-1103', 1),
(28, '2', 'CC101', 'Monday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1102', 1),
(29, '2', 'GE1', 'Monday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1102', 1),
(30, '2', 'GE2', 'Monday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1102', 1),
(31, '2', 'CC102', 'Wednesday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1102', 1),
(32, '2', 'GE3', 'Wednesday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1102', 1),
(33, '2', 'GE4', 'Wednesday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1102', 1),
(34, '2', 'KOMFIL', 'Friday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1102', 1),
(35, '2', 'NSTP1', 'Friday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1102', 1),
(36, '2', 'PE1', 'Friday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1102', 1),
(37, '4', 'CC101', 'Tuesday', '09:00:00', '10:00:00', 'First', 'BSIT', 'BSIT-1104', 1),
(38, '4', 'GE1', 'Tuesday', '10:00:00', '11:00:00', 'First', 'BSIT', 'BSIT-1104', 1),
(39, '4', 'GE2', 'Tuesday', '11:00:00', '12:00:00', 'First', 'BSIT', 'BSIT-1104', 1),
(40, '4', 'CC102', 'Thursday', '09:00:00', '10:00:00', 'First', 'BSIT', 'BSIT-1104', 1),
(41, '4', 'GE3', 'Thursday', '10:00:00', '11:00:00', 'First', 'BSIT', 'BSIT-1104', 1),
(42, '4', 'GE4', 'Thursday', '11:00:00', '12:00:00', 'First', 'BSIT', 'BSIT-1104', 1),
(43, '4', 'KOMFIL', 'Saturday', '09:00:00', '10:00:00', 'First', 'BSIT', 'BSIT-1104', 1),
(44, '4', 'NSTP1', 'Saturday', '10:00:00', '11:00:00', 'First', 'BSIT', 'BSIT-1104', 1),
(45, '4', 'PE1', 'Saturday', '11:00:00', '12:00:00', 'First', 'BSIT', 'BSIT-1104', 1),
(46, '5', 'CC104', 'Monday', '12:00:00', '13:00:00', 'First', 'BSIT', 'BSIT-1105', 2),
(47, '5', 'HCI101', 'Monday', '13:00:00', '14:00:00', 'First', 'BSIT', 'BSIT-1105', 2),
(48, '5', 'IPT101', 'Monday', '14:00:00', '15:00:00', 'First', 'BSIT', 'BSIT-1105', 2),
(49, '5', 'ITE1', 'Wednesday', '12:00:00', '13:00:00', 'First', 'BSIT', 'BSIT-1105', 2),
(50, '5', 'MS102', 'Wednesday', '13:00:00', '14:00:00', 'First', 'BSIT', 'BSIT-1105', 2),
(51, '5', 'NET101', 'Wednesday', '14:00:00', '15:00:00', 'First', 'BSIT', 'BSIT-1105', 2),
(52, '5', 'SOSLIT', 'Friday', '12:00:00', '13:00:00', 'First', 'BSIT', 'BSIT-1105', 2),
(53, '5', 'PE3', 'Friday', '13:00:00', '14:00:00', 'First', 'BSIT', 'BSIT-1105', 2),
(54, '6', 'CC104', 'Monday', '12:00:00', '13:00:00', 'First', 'BSIT', 'BSIT-1106', 2),
(55, '6', 'HCI101', 'Monday', '13:00:00', '14:00:00', 'First', 'BSIT', 'BSIT-1106', 2),
(56, '6', 'IPT101', 'Monday', '14:00:00', '15:00:00', 'First', 'BSIT', 'BSIT-1106', 2),
(57, '6', 'ITE1', 'Wednesday', '12:00:00', '13:00:00', 'First', 'BSIT', 'BSIT-1106', 2),
(58, '6', 'MS102', 'Wednesday', '13:00:00', '14:00:00', 'First', 'BSIT', 'BSIT-1106', 2),
(59, '6', 'NET101', 'Wednesday', '14:00:00', '15:00:00', 'First', 'BSIT', 'BSIT-1106', 2),
(60, '6', 'SOSLIT', 'Friday', '12:00:00', '13:00:00', 'First', 'BSIT', 'BSIT-1106', 2),
(61, '6', 'PE3', 'Friday', '13:00:00', '14:00:00', 'First', 'BSIT', 'BSIT-1106', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `faculty_id` int(11) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Dean','Department Head','Instructor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`faculty_id`, `username`, `password`, `role`) VALUES
(2, 'alice.johnson@faculty', 'johnson8080', 'Department Head'),
(91, 'asef.asfeasdf@faculty', 'asfeasdf8080', 'Instructor'),
(7, 'david.martinez@faculty', 'martinez8080', 'Instructor'),
(4, 'emily.williams@faculty', 'williams8080', 'Instructor'),
(9, 'james.lopez@faculty', 'lopez8080', 'Instructor'),
(8, 'jessica.hernandez@faculty', 'hernandez8080', 'Instructor'),
(1, 'john.smith', 'smith8080', 'Dean'),
(1, 'john.smith@faculty', 'smith8080', 'Dean'),
(49, 'johnmak.ferrer@faculty', 'ferrer8080', 'Instructor'),
(90, 'johnmak.tesla@faculty', 'tesla8080', 'Instructor'),
(10, 'mary.gonzalez@faculty', 'gonzalez8080', 'Instructor'),
(5, 'michael.jones@faculty', 'jones8080', 'Instructor'),
(3, 'robert.brown@faculty', 'brown8080', 'Instructor'),
(6, 'sarah.garcia@faculty', 'garcia8080', 'Instructor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`),
  ADD KEY `program_code` (`program_code`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD UNIQUE KEY `phone_no` (`phone_no`);

--
-- Indexes for table `faculty_courses`
--
ALTER TABLE `faculty_courses`
  ADD PRIMARY KEY (`faculty_id`,`subject_code`);

--
-- Indexes for table `pending_preferred_courses`
--
ALTER TABLE `pending_preferred_courses`
  ADD PRIMARY KEY (`pending_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `subject_code` (`subject_code`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`program_code`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_no` (`room_no`);

--
-- Indexes for table `room_assignments`
--
ALTER TABLE `room_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD UNIQUE KEY `unique_schedule` (`section_id`,`day_of_week`,`start_time`,`end_time`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD UNIQUE KEY `no_conflicting_schedules` (`faculty_id`,`day_of_week`,`start_time`),
  ADD UNIQUE KEY `no_room_conflicts` (`room_id`,`day_of_week`,`start_time`,`end_time`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `program_code` (`program_code`);

--
-- Indexes for table `section_schedules`
--
ALTER TABLE `section_schedules`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12346;

--
-- AUTO_INCREMENT for table `pending_preferred_courses`
--
ALTER TABLE `pending_preferred_courses`
  MODIFY `pending_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `room_assignments`
--
ALTER TABLE `room_assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=578;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3442;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`program_code`) REFERENCES `programs` (`program_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faculty_courses`
--
ALTER TABLE `faculty_courses`
  ADD CONSTRAINT `faculty_courses_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `faculty_courses_ibfk_2` FOREIGN KEY (`subject_code`) REFERENCES `courses` (`subject_code`) ON DELETE CASCADE;

--
-- Constraints for table `pending_preferred_courses`
--
ALTER TABLE `pending_preferred_courses`
  ADD CONSTRAINT `pending_preferred_courses_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pending_preferred_courses_ibfk_2` FOREIGN KEY (`subject_code`) REFERENCES `courses` (`subject_code`) ON DELETE CASCADE;

--
-- Constraints for table `room_assignments`
--
ALTER TABLE `room_assignments`
  ADD CONSTRAINT `room_assignments_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `sections` (`section_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_assignments_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`program_code`) REFERENCES `programs` (`program_code`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
