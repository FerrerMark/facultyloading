-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2025 at 07:01 AM
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
  `max_weekly_hours` int(11) DEFAULT 18
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `firstname`, `middlename`, `lastname`, `college`, `employment_status`, `address`, `phone_no`, `departmentID`, `role`, `master_specialization`, `created_at`, `max_weekly_hours`) VALUES
(1, 'John', 'Doe', 'Smith', 'College of Computer Science', 'Full-Time', '123 Main St', '09171234567', 'BSIT', 'Dean', 'General Education', '2025-01-24 14:57:19', 18),
(2, 'Alice', 'A.', 'Johnson', 'College of Computer Science', 'Full-Time', '456 Elm St', '09172345678', 'BSIT', 'Department Head', 'Dep_specific_course', '2025-01-24 14:57:19', 18),
(3, 'Robert', 'B.', 'Brown', 'College of Computer Science', 'Full-Time', '789 Oak St', '09173456789', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-01-24 14:57:19', 18),
(4, 'Emily', 'C.', 'Williams', 'College of Computer Science', 'Part-Time', '321 Pine St', '09174567890', 'BSIT', 'Instructor', 'General Education', '2025-01-24 14:57:19', 12),
(5, 'Michael', 'D.', 'Jones', 'College of Computer Science', 'Full-Time', '654 Birch St', '09175678901', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-01-24 14:57:19', 18),
(6, 'Sarah', 'E.', 'Garcia', 'College of Computer Science', 'Full-Time', '987 Cedar St', '09176789012', 'BSIT', 'Instructor', 'General Education', '2025-01-24 14:57:19', 18),
(7, 'David', 'F.', 'Martinez', 'College of Computer Science', 'Full-Time', '543 Maple St', '09177890123', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-01-24 14:57:19', 18),
(8, 'Jessica', 'G.', 'Hernandez', 'College of Computer Science', 'Part-Time', '765 Walnut St', '09178901234', 'BSIT', 'Instructor', 'General Education', '2025-01-24 14:57:19', 12),
(9, 'James', 'H.', 'Lopez', 'College of Computer Science', 'Full-Time', '234 Fir St', '09179012345', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-01-24 14:57:19', 18),
(10, 'Mary', 'I.', 'Gonzalez', 'College of Computer Science', 'Full-Time', '876 Ash St', '09180123456', 'BSIT', 'Instructor', 'General Education', '2025-01-24 14:57:19', 18),
(11, 'William', 'J.', 'Perez', 'College of Computer Science', 'Full-Time', '543 Elm St', '09181234567', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-01-24 14:57:19', 18),
(12, 'Patricia', 'K.', 'Wilson', 'College of Computer Science', 'Part-Time', '876 Pine St', '09182345678', 'BSIT', 'Instructor', 'General Education', '2025-01-24 14:57:19', 12),
(13, 'Christopher', 'L.', 'Anderson', 'College of Computer Science', 'Full-Time', '123 Oak St', '09183456789', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-01-24 14:57:19', 18),
(14, 'Linda', 'M.', 'Thomas', 'College of Computer Science', 'Full-Time', '345 Cedar St', '09184567890', 'BSIT', 'Instructor', 'General Education', '2025-01-24 14:57:19', 18),
(15, 'Daniel', 'N.', 'Jackson', 'College of Computer Science', 'Full-Time', '678 Maple St', '09185678901', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-01-24 14:57:19', 18),
(16, 'Susan', 'O.', 'White', 'College of Computer Science', 'Part-Time', '987 Fir St', '09186789012', 'BSIT', 'Instructor', 'General Education', '2025-01-24 14:57:19', 12),
(17, 'Joseph', 'P.', 'Lee', 'College of Computer Science', 'Full-Time', '321 Walnut St', '09187890123', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-01-24 14:57:19', 18),
(18, 'Karen', 'Q.', 'Young', 'College of Computer Science', 'Full-Time', '654 Ash St', '09188901234', 'BSIT', 'Instructor', 'General Education', '2025-01-24 14:57:19', 18),
(19, 'Charles', 'R.', 'King', 'College of Computer Science', 'Full-Time', '876 Fir St', '09189012345', 'BSIT', 'Instructor', 'Dep_specific_course', '2025-01-24 14:57:19', 18),
(20, 'Nancy', 'S.', 'Scott', 'College of Computer Science', 'Full-Time', '234 Cedar St', '09190123456', 'BSIT', 'Instructor', 'General Education', '2025-01-24 14:57:19', 18);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_availability`
--

CREATE TABLE `faculty_availability` (
  `availability_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_availability`
--

INSERT INTO `faculty_availability` (`availability_id`, `faculty_id`, `day_of_week`, `start_time`, `end_time`) VALUES
(10, 15, 'Wednesday', '07:00:06', '15:00:00'),
(11, 13, 'Monday', '06:00:00', '12:00:00'),
(12, 18, 'Wednesday', '06:00:00', '12:00:00'),
(13, 20, 'Saturday', '10:00:00', '17:00:00');

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
(8, 'GE1'),
(9, 'GE2'),
(12, 'KOMFIL'),
(13, 'CC101'),
(13, 'CC102'),
(17, 'GE3'),
(20, 'GE4');

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
('BSCPE', 'Bachelors of Science in computer science', 'College of Computer'),
('BSCS', 'Bachelor of Science in Computer Science', 'College of Computing'),
('BSIT', 'Bachelor of Science in Information Technology', 'College of Computing'),
('BSMath', 'Bachelor of Science in Mathematics', 'College of Science'),
('BSPhysics', 'Bachelor of Science in Physics', 'College of Science');

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
(4, 'MV campus', '301', 'Lab', 50),
(5, 'MV Campus', '302', 'Lab', 50),
(7, 'MV Campus', '303', 'Lab', 50),
(8, 'MV Campus', '304', 'Lab', 50),
(9, 'MV Campus', '305', 'Lab', 50),
(10, 'MV Campus', '306', 'Lab', 50),
(11, 'MV Campus', '307', 'Lab', 50),
(12, 'MV Campus', '308', 'Lab', 50),
(13, 'MV Campus', '309', 'Lab', 50),
(14, 'MV Campus', '310', 'Lab', 50);

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
  `semester` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`schedule_id`, `faculty_id`, `subject_code`, `section_id`, `day_of_week`, `time_slot`, `is_checked`, `course_id`, `room_id`, `department`, `year_level`, `semester`) VALUES
(5413, 1, 'BPM101', 47, 'Monday', '1', 1, NULL, NULL, 'BSIT', '1', 'First'),
(5414, 1, 'BPM101', 47, 'Tuesday', '1', 1, NULL, NULL, 'BSIT', '1', 'First'),
(5415, 1, 'BPM101', 47, 'Tuesday', '2', 1, NULL, NULL, 'BSIT', '1', 'First'),
(5416, 1, 'BPM101', 47, 'Thursday', '5', 1, NULL, NULL, 'BSIT', '1', 'First'),
(5417, 6, 'PE1', 47, 'Thursday', '1', 1, NULL, NULL, 'BSIT', '1', 'First'),
(5418, 6, 'PE1', 47, 'Monday', '4', 1, NULL, NULL, 'BSIT', '1', 'First'),
(5419, 6, 'PE1', 47, 'Tuesday', '4', 1, NULL, NULL, 'BSIT', '1', 'First'),
(5420, 6, 'PE1', 47, 'Monday', '5', 1, NULL, NULL, 'BSIT', '1', 'First'),
(5421, 6, 'PE1', 47, 'Tuesday', '5', 1, NULL, NULL, 'BSIT', '1', 'First'),
(5422, 10, 'CC102', 47, 'Monday', '3', 1, NULL, NULL, 'BSIT', '1', 'First'),
(5423, 10, 'CC102', 47, 'Tuesday', '3', 1, NULL, NULL, 'BSIT', '1', 'First'),
(5424, 10, 'CC102', 47, 'Wednesday', '3', 1, NULL, NULL, 'BSIT', '1', 'First');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` int(11) NOT NULL,
  `program_code` varchar(50) NOT NULL,
  `year_level` int(11) NOT NULL,
  `section_name` varchar(10) NOT NULL,
  `semester` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `program_code`, `year_level`, `section_name`, `semester`) VALUES
(47, 'BSIT', 1, 'BSIT-1101', 'First'),
(48, 'BSIT', 1, 'BSIT-1102', 'First'),
(49, 'BSIT', 3, 'BSIT-3103', 'First'),
(50, 'BSIT', 1, 'BSIT-1104', 'First'),
(51, 'BSIT', 1, 'BSIT-1105', 'First'),
(52, 'BSIT', 1, 'BSIT-1106', 'First'),
(53, 'BSIT', 1, 'BSIT-1107', 'First'),
(54, 'BSIT', 1, 'BSIT-1108', 'First'),
(55, 'BSIT', 1, 'BSIT-1109', 'First'),
(56, 'BSIT', 1, 'BSIT-1110', 'First'),
(57, 'BSIT', 1, 'BSIT-1111', 'First'),
(58, 'BSIT', 1, 'BSIT-1112', 'First'),
(59, 'BSIT', 1, 'BSIT-1113', 'First'),
(60, 'BSIT', 1, 'BSIT-1114', 'First'),
(61, 'BSIT', 1, 'BSIT-1115', 'First'),
(62, 'BSIT', 1, 'BSIT-1116', 'First'),
(63, 'BSIT', 1, 'BSIT-1117', 'First'),
(64, 'BSIT', 1, 'BSIT-1118', 'First'),
(65, 'BSIT', 1, 'BSIT-1119', 'First'),
(66, 'BSIT', 1, 'BSIT-1120', 'First');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Dean','Department Head','Instructor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `faculty_id`, `username`, `password`, `role`) VALUES
(1, 1, 'John@gmail.com', 'jo8080', 'Dean'),
(2, 2, 'Alice@gmail.com', 'al8080', 'Department Head'),
(3, 3, 'Robert@gmail.com', 'ro8080', 'Instructor'),
(4, 4, 'Emily@gmail.com', 'em8080', 'Instructor'),
(5, 5, 'Michael@gmail.com', 'mi8080', 'Instructor'),
(6, 6, 'Sarah@gmail.com', 'sa8080', 'Instructor'),
(7, 7, 'David@gmail.com', 'da8080', 'Instructor'),
(8, 8, 'Jessica@gmail.com', 'je8080', 'Instructor'),
(9, 9, 'James@gmail.com', 'ja8080', 'Instructor'),
(10, 10, 'Mary@gmail.com', 'ma8080', 'Instructor'),
(11, 11, 'William@gmail.com', 'wi8080', 'Instructor'),
(12, 12, 'Patricia@gmail.com', 'pa8080', 'Instructor'),
(13, 13, 'Christopher@gmail.com', 'ch8080', 'Instructor'),
(14, 14, 'Linda@gmail.com', 'li8080', 'Instructor'),
(15, 15, 'Daniel@gmail.com', 'da8080', 'Instructor'),
(16, 16, 'Susan@gmail.com', 'su8080', 'Instructor'),
(17, 17, 'Joseph@gmail.com', 'jo8080', 'Instructor'),
(18, 18, 'Karen@gmail.com', 'ka8080', 'Instructor'),
(19, 19, 'Charles@gmail.com', 'ch8080', 'Instructor'),
(20, 20, 'Nancy@gmail.com', 'na8080', 'Instructor');

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
-- Indexes for table `faculty_availability`
--
ALTER TABLE `faculty_availability`
  ADD PRIMARY KEY (`availability_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `faculty_courses`
--
ALTER TABLE `faculty_courses`
  ADD PRIMARY KEY (`faculty_id`,`subject_code`),
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
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD UNIQUE KEY `no_conflicting_schedules` (`faculty_id`,`day_of_week`,`time_slot`),
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `fk_course` (`course_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `program_code` (`program_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `faculty_availability`
--
ALTER TABLE `faculty_availability`
  MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5425;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`program_code`) REFERENCES `programs` (`program_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faculty_availability`
--
ALTER TABLE `faculty_availability`
  ADD CONSTRAINT `faculty_availability_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE CASCADE;

--
-- Constraints for table `faculty_courses`
--
ALTER TABLE `faculty_courses`
  ADD CONSTRAINT `faculty_courses_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `faculty_courses_ibfk_2` FOREIGN KEY (`subject_code`) REFERENCES `courses` (`subject_code`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `fk_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`subject_code`) REFERENCES `courses` (`subject_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `sections` (`section_id`) ON DELETE CASCADE;

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
