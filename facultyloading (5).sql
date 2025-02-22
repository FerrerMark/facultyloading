-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2025 at 03:58 AM
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
(1, 'John', 'Doe', 'Smith', 'College of Computer Science', 'Full-Time', '123 Main St', '09171234567', 'BSIT', 'Dean', 'General Education', '2025-02-08 07:13:58', 40, 'Monday,Friday,Wednesday', '06:00:00', '17:00:00'),
(2, 'Alice', 'A.', 'Johnson', 'College of Computer Science', 'Full-Time', '456 Elm St', '09172345678', 'BSIT', 'Department Head', 'Dep_specific_course', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Friday, Wednesday, Friday', '06:00:00', '17:00:00'),
(3, 'Robert', 'B.', 'Brown', 'College of Computer Science', 'Full-Time', '789 Oak St', '09173456789', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-02-08 07:13:58', 40, 'Monday,Friday,Wednesday', '06:00:00', '12:00:00'),
(4, 'Emily', 'C.', 'Williams', 'College of Computer Science', 'Part-Time', '321 Pine St', '09174567890', 'BSIT', 'Instructor', 'General Education', '2025-02-08 07:13:58', 20, 'Monday,Friday,Wednesday', '06:00:00', '12:00:00'),
(5, 'Michael', 'D.', 'Jones', 'College of Computer Science', 'Full-Time', '654 Birch St', '09175678901', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-02-08 07:13:58', 40, 'Monday,Friday,Wednesday', '06:00:00', '17:00:00'),
(6, 'Sarah', 'E.', 'Garcia', 'College of Computer Science', 'Full-Time', '987 Cedar St', '09176789012', 'BSIT', 'Instructor', 'General Education', '2025-02-08 07:13:58', 40, 'Monday,Friday,Wednesday', '06:00:00', '17:00:00'),
(7, 'David', 'F.', 'Martinez', 'College of Computer Science', 'Full-Time', '543 Maple St', '09177890123', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Friday, Wednesday, Friday', '06:00:00', '17:00:00'),
(8, 'Jessica', 'G.', 'Hernandez', 'College of Computer Science', 'Part-Time', '765 Walnut St', '09178901234', 'BSIT', 'Instructor', 'General Education', '2025-02-08 07:13:58', 20, 'Monday,Tuesday,Friday, Wednesday, Friday', '06:00:00', '12:00:00'),
(9, 'James', 'H.', 'Lopez', 'College of Computer Science', 'Full-Time', '234 Fir St', '09179012345', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Friday, Wednesday, Friday', '06:00:00', '17:00:00'),
(10, 'Mary', 'I.', 'Gonzalez', 'College of Computer Science', 'Full-Time', '876 Ash St', '09180123456', 'BSIT', 'Instructor', 'General Education', '2025-02-08 07:13:58', 40, 'Monday,Tuesday,Friday, Wednesday, Friday', '06:00:00', '17:00:00'),
(49, 'johnmak', 'sibayan', 'Ferrer', 'test', 'Full-Time', 'test', '355555', 'BSIT', 'Instructor', 'test', '2025-02-10 07:32:30', 40, 'Monday,Tuesday,Friday, Wednesday, Friday', '06:00:00', '17:00:00');

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
(3, 'DM102'),
(3, 'FLD15'),
(4, 'GE1'),
(4, 'GE2'),
(4, 'GE3'),
(4, 'GE4'),
(5, 'CC101'),
(6, 'KOMFIL'),
(6, 'NSTP1'),
(7, 'PE1'),
(8, 'ge2');

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
  `room_type` enum('Lecture','Lab') NOT NULL,
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
(14, 'MV Campus', '310', 'Lecture', 50);

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
(132, 1, 'CC101', 1, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '06:00:00', '07:00:00'),
(133, 1, 'CC102', 1, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '06:00:00', '07:00:00'),
(134, 1, 'CC101', 3, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '09:00:00', '10:00:00'),
(135, 1, 'CC102', 3, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '09:00:00', '10:00:00'),
(136, 2, 'CC101', 2, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '06:00:00', '07:00:00'),
(137, 2, 'CC102', 2, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '06:00:00', '07:00:00'),
(138, 4, 'GE1', 1, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '07:00:00', '08:00:00'),
(139, 4, 'GE3', 1, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '07:00:00', '08:00:00'),
(140, 4, 'GE1', 3, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '10:00:00', '11:00:00'),
(141, 4, 'GE3', 3, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '10:00:00', '11:00:00'),
(142, 4, 'GE2', 2, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '08:00:00', '09:00:00'),
(143, 4, 'GE4', 2, 'Wednesday', '', 0, NULL, NULL, NULL, NULL, NULL, '08:00:00', '09:00:00'),
(144, 6, 'KOMFIL', 1, 'Friday', '', 0, NULL, NULL, NULL, NULL, NULL, '06:00:00', '07:00:00'),
(145, 6, 'KOMFIL', 3, 'Friday', '', 0, NULL, NULL, NULL, NULL, NULL, '09:00:00', '10:00:00'),
(146, 6, 'NSTP1', 2, 'Friday', '', 0, NULL, NULL, NULL, NULL, NULL, '07:00:00', '08:00:00'),
(147, 8, 'GE2', 1, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '08:00:00', '09:00:00'),
(148, 8, 'GE2', 3, 'Monday', '', 0, NULL, NULL, NULL, NULL, NULL, '11:00:00', '12:00:00');

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
(3, 'BSIT', 1, 'BSIT-1103', '1', '13:00:00', '12:00:00');

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
  `section_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section_schedules`
--

INSERT INTO `section_schedules` (`schedule_id`, `section_id`, `subject_code`, `day_of_week`, `start_time`, `end_time`, `semester`, `program_code`, `section_name`) VALUES
(1, '1', 'CC101', 'Monday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1101'),
(2, '1', 'GE1', 'Monday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1101'),
(3, '1', 'GE2', 'Monday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1101'),
(4, '1', 'CC102', 'Wednesday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1101'),
(5, '1', 'GE3', 'Wednesday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1101'),
(6, '1', 'GE4', 'Wednesday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1101'),
(7, '1', 'KOMFIL', 'Friday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1101'),
(8, '1', 'NSTP1', 'Friday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1101'),
(9, '1', 'PE1', 'Friday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1101'),
(19, '3', 'CC101', 'Monday', '09:00:00', '10:00:00', 'First', 'BSIT', 'BSIT-1103'),
(20, '3', 'GE1', 'Monday', '10:00:00', '11:00:00', 'First', 'BSIT', 'BSIT-1103'),
(21, '3', 'GE2', 'Monday', '11:00:00', '12:00:00', 'First', 'BSIT', 'BSIT-1103'),
(22, '3', 'CC102', 'Wednesday', '09:00:00', '10:00:00', 'First', 'BSIT', 'BSIT-1103'),
(23, '3', 'GE3', 'Wednesday', '10:00:00', '11:00:00', 'First', 'BSIT', 'BSIT-1103'),
(24, '3', 'GE4', 'Wednesday', '11:00:00', '12:00:00', 'First', 'BSIT', 'BSIT-1103'),
(25, '3', 'KOMFIL', 'Friday', '09:00:00', '10:00:00', 'First', 'BSIT', 'BSIT-1103'),
(26, '3', 'NSTP1', 'Friday', '10:00:00', '11:00:00', 'First', 'BSIT', 'BSIT-1103'),
(27, '3', 'PE1', 'Friday', '11:00:00', '12:00:00', 'First', 'BSIT', 'BSIT-1103'),
(28, '2', 'CC101', 'Monday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1102'),
(29, '2', 'GE1', 'Monday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1102'),
(30, '2', 'GE2', 'Monday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1102'),
(31, '2', 'CC102', 'Wednesday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1102'),
(32, '2', 'GE3', 'Wednesday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1102'),
(33, '2', 'GE4', 'Wednesday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1102'),
(34, '2', 'KOMFIL', 'Friday', '06:00:00', '07:00:00', 'First', 'BSIT', 'BSIT-1102'),
(35, '2', 'NSTP1', 'Friday', '07:00:00', '08:00:00', 'First', 'BSIT', 'BSIT-1102'),
(36, '2', 'PE1', 'Friday', '08:00:00', '09:00:00', 'First', 'BSIT', 'BSIT-1102');

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
(2, 'alice.johnson', '#Jo8080', 'Department Head'),
(7, 'david.martinez', '#Ma8080', 'Instructor'),
(4, 'emily.williams', '#Wi8080', 'Instructor'),
(9, 'james.lopez', '#Lo8080', 'Instructor'),
(8, 'jessica.hernandez', '#He8080', 'Instructor'),
(1, 'john.smith', '#Sm8080', 'Dean'),
(49, 'johnmak.ferrer', '#Fe8080', 'Instructor'),
(10, 'mary.gonzalez', '#Go8080', 'Instructor'),
(5, 'michael.jones', '#Jo8080', 'Instructor'),
(3, 'robert.brown', '#Br8080', 'Instructor'),
(6, 'sarah.garcia', '#Ga8080', 'Instructor');

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
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD UNIQUE KEY `no_conflicting_schedules` (`faculty_id`,`day_of_week`,`start_time`);

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
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `section_schedules`
--
ALTER TABLE `section_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

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
