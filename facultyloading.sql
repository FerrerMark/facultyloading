SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `courses` (
  `program_code` varchar(50) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `year_level` int(11) NOT NULL,
  `semester` enum('First','Second','Summer') NOT NULL,
  `lecture_hours` int(11) NOT NULL,
  `lab_hours` int(11) NOT NULL,
  `credit_units` int(11) NOT NULL,
  `slots` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `courses` (`program_code`, `subject_code`, `course_title`, `year_level`, `semester`, `lecture_hours`, `lab_hours`, `credit_units`, `slots`) VALUES
('BSBA', 'ba101', 'test', 2, 'Second', 2, 2, 2, 2),
('BSCRIM', 'cc101', 'programmings', 2, 'Second', 2, 2, 2, 2),
('BSCRIM', 'cc102', 'programmings', 2, 'Second', 2, 2, 2, 2),
('BSIT', 'BPM101', 'Business Process Management in IT', 3, 'Second', 3, 0, 3, 40),
('BSIT', 'CC101', 'Introduction to Computing', 1, 'First', 3, 0, 3, 40),
('BSIT', 'CC102', 'Computer Programming 1', 1, 'First', 3, 0, 3, 40),
('BSIT', 'CC103', 'Computer Programming 2', 1, 'Second', 3, 0, 3, 40),
('BSIT', 'CC104', 'Data Structures and Algorithms', 2, 'First', 3, 0, 3, 40),
('BSIT', 'CC105', 'Information Management', 2, 'Second', 3, 0, 3, 40),
('BSIT', 'CC106', 'Application Development and Emerging Technologies', 3, 'First', 3, 0, 3, 40),
('BSIT', 'DM102', 'Financial Management', 2, 'Second', 3, 0, 3, 40),
('BSIT', 'FLD15', 'Filipino sa Iba’t-ibang Disiplina', 1, 'Second', 3, 0, 3, 40),
('BSIT', 'GE1', 'Understanding the Self', 1, 'First', 3, 0, 3, 40),
('BSIT', 'GE2', 'Readings in Philippine History', 1, 'First', 3, 0, 3, 40),
('BSIT', 'GE3', 'The Contemporary World', 1, 'First', 3, 0, 3, 40),
('BSIT', 'GE4', 'Mathematics in the Modern World', 1, 'First', 3, 0, 3, 40),
('BSIT', 'GE5', 'Purposive Communication', 1, 'Second', 3, 0, 3, 40),
('BSIT', 'GE6', 'Art Appreciation', 1, 'Second', 3, 0, 3, 40),
('BSIT', 'GE7', 'Science and Technology and Society', 1, 'Second', 3, 0, 3, 40),
('BSIT', 'GE8', 'Ethics', 1, 'Second', 3, 0, 3, 40),
('BSIT', 'GE9', 'The Life and Works of Jose Rizal', 2, 'Second', 3, 0, 3, 40),
('BSIT', 'HCI101', 'Introduction to Human-Computer Interaction', 2, 'First', 3, 0, 3, 40),
('BSIT', 'IAS101', 'Information Assurance and Security 1', 3, 'First', 3, 0, 3, 40),
('BSIT', 'IAS102', 'Information Assurance and Security 2', 3, 'Second', 3, 0, 3, 40),
('BSIT', 'IM101', 'Fundamentals of Database System', 3, 'First', 3, 0, 3, 40),
('BSIT', 'IPT101', 'Integrative Programming and Technologies 1', 2, 'First', 3, 0, 3, 40),
('BSIT', 'ITE1', 'IT ELECTIVE 1 (Web Fundamental)', 2, 'First', 3, 0, 3, 40),
('BSIT', 'ITE2', 'IT ELECTIVE 2', 2, 'Second', 3, 0, 3, 40),
('BSIT', 'ITE3', 'IT ELECTIVE 3 (Research)', 3, 'First', 3, 0, 3, 40),
('BSIT', 'ITSP1-A', 'ENTERPRISE SYSTEMS: CONCEPT AND PRACTICE', 3, 'First', 3, 0, 3, 40),
('BSIT', 'ITSP2A', 'Mobile Application and Development', 3, 'Second', 3, 0, 3, 40),
('BSIT', 'KOMFIL', 'Kontekstualisadong Komunikasyon sa Filipino', 1, 'First', 3, 0, 3, 40),
('BSIT', 'MIS101', 'Discrete Mathematics', 1, 'Second', 3, 0, 3, 40),
('BSIT', 'MS102', 'Quantitative Methods with Modelling Simulation', 2, 'First', 3, 0, 3, 40),
('BSIT', 'NET101', 'Networking 1', 2, 'First', 3, 0, 3, 40),
('BSIT', 'NET102', 'Networking 2', 2, 'Second', 3, 0, 3, 40),
('BSIT', 'NSTP1', 'National Service Training Program 1', 1, 'First', 3, 0, 3, 40),
('BSIT', 'NSTP2', 'National Service Training Program 2', 1, 'Second', 3, 0, 3, 40),
('BSIT', 'PE1', 'Physical Fitness', 1, 'First', 2, 0, 2, 40),
('BSIT', 'PE2', 'Folk Dance and Rhythmic Activities', 1, 'Second', 3, 0, 3, 40),
('BSIT', 'PE3', 'Individual and Dual Sports', 2, 'First', 2, 0, 2, 40),
('BSIT', 'PE4', 'Team Sports', 2, 'Second', 2, 0, 2, 40),
('BSIT', 'PM101', 'Project Management', 3, 'First', 3, 0, 3, 40),
('BSIT', 'SA101', 'System Administration and Maintenance', 3, 'Second', 3, 0, 3, 40),
('BSIT', 'SIA101', 'System Integration and Architecture 1', 2, 'Second', 3, 0, 3, 40),
('BSIT', 'SOSLIT', 'Sosyedad at Literatura', 2, 'First', 3, 0, 3, 40),
('BSIT', 'SP101', 'Social and Professional Issues', 3, 'Second', 3, 0, 3, 40),
('BSIT', 'TEC101', 'Technopreneurship', 3, 'Second', 3, 0, 3, 40),
('BSIT', 'WEB101', 'Web Development', 2, 'Second', 3, 0, 3, 40);

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `college` varchar(100) NOT NULL,
  `employment_status` enum('Full-time','Part-time','Contract') NOT NULL,
  `address` text DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `departmentID` varchar(50) DEFAULT NULL,
  `department_title` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `faculty` (`faculty_id`, `firstname`, `middlename`, `lastname`, `college`, `employment_status`, `address`, `phone_no`, `departmentID`, `department_title`, `subject`, `created_at`, `role`) VALUES
(1, 'Johnmark', 'M', 'Ferrer', 'College of Computing', 'Full-time', '', '0954564', 'BSIT', 'Bachelor of Science in Information Technology', 'ferrrrrrr', '2025-01-17 13:09:29', 'department head'),
(2, 'Marie', 'V', 'Curie', 'College of Engineering', 'Full-time', 'test', '35354', 'BSCPE', 'Bachelor of Science in Chemical Engineering', 'chem101', '2025-01-17 13:09:29', 'faculty'),
(3, 'Alden', 'U', 'Recharge', 'College of Engineering', 'Part-time', 'null', '802380', 'BSCPE', 'Bachelor of Science in Chemical Engineering', 'null', '2025-01-17 13:09:29', 'department head'),
(4, 'James', 'U', 'Read', 'College of Education', 'Full-time', 'test', '65434', 'BSED', 'Bachelor of Science in Education', 'null', '2025-01-17 13:09:29', 'department head'),
(5, 'Deniel', 'M', 'Padila', 'College of Criminal Justice', 'Contract', 'test', '895', 'BSCRIM', 'Bachelor of Science in Criminology', 'null', '2025-01-17 13:09:29', 'department head'),
(6, 'Uzumaki', 'A', 'Naruto', 'College of Computing', 'Full-time', 'test', '234634', 'BSIT', 'Bachelor of Science in Information Technology', 'null', '2025-01-17 13:09:29', 'dean'),
(153, 'isaac', 's', 'newton', 'College of Education', 'Full-time', 's', '7851', 'BSED', 'stsdrfsrf', 'null', '2025-01-17 15:24:32', 'Faculty'),
(154, 'isaac', 's', 'newton', 'College of Computing', 'Full-time', 'esa', '785682', 'BSITE', 'bache etc', 'null', '2025-01-17 15:25:43', 'Faculty'),
(159, 'isaac', 's', 'newton', 'College of Computing', 'Full-time', 'seffe', '743', 'BSCPE', 'bache etc', 'null', '2025-01-18 10:04:55', 'Faculty'),
(161, 'isaac', 'M', 'Curie', 'null', 'Full-time', 'erwef', '86653', 'BSIT', 'null', 'chem101', '2025-01-18 12:17:43', 'Department Head');

CREATE TABLE `programs` (
  `program_code` varchar(50) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `college` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `programs` (`program_code`, `program_name`, `college`) VALUES
('BSBA', 'Bachelors of Science in Business Administration', '	College of Business'),
('BSCRIM', 'bachelor of science in crim', 'college of bu;affd'),
('BSED', 'Bachelors of Science in Education', 'college of bu;affd'),
('BSIT', '	Bachelors of Science in Information Technology', 'College of Computer Science');

CREATE TABLE `rooms` (
  `building` varchar(255) NOT NULL,
  `room_no` varchar(50) NOT NULL,
  `room_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rooms` (`building`, `room_no`, `room_type`) VALUES
('MV Campus', '301', 'lec'),
('MV Campus', '302', 'lec'),
('MV Campus', '303', 'lec'),
('MV Campus', '304', 'lec'),
('MV Campus', '305', 'lec'),
('MV campus', '306', 'lec'),
('MV campus', '307', 'lec'),
('MV campus', '308', 'lec'),
('MV campus', '309', 'lec'),
('MV campus', '310', 'lec');

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `teacher` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `time_slot` varchar(255) DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `is_checked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `schedules` (`id`, `teacher`, `subject`, `course`, `room`, `remarks`, `time_slot`, `day_of_week`, `is_checked`) VALUES
(259, 'jose, rizal', 'chem101', 'sead', '301', 'null', '1', '1', 1),
(260, 'jose, rizal', 'chem101', 'sead', '301', 'null', '1', '3', 1),
(261, 'jose, rizal', 'chem101', 'sead', '301', 'null', '1', '5', 1),
(262, 'gojo saturo', 'chem102', 'sead', '301', 'null', '15', '1', 1),
(263, 'gojo saturo', 'chem102', 'sead', '301', 'null', '15', '3', 1),
(264, 'gojo saturo', 'chem102', 'sead', '301', 'null', '15', '5', 1);

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `program_code` varchar(10) NOT NULL,
  `year_section` varchar(10) NOT NULL,
  `section_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sections` (`id`, `program_code`, `year_section`, `section_status`) VALUES
(1, 'BSCRIM', '1-1', NULL),
(2, 'BSIT', '1-1', NULL),
(3, 'BSCRIM', '1-2', NULL),
(4, 'BSCRIM', '1-3', NULL),
(5, 'BSCRIM', '1-4', NULL),
(6, 'BSIT', '1-2', NULL),
(7, 'BSCRIM', '1-5', NULL),
(8, 'BSIT', '1-3', NULL),
(9, 'BSIT', '1-4', NULL),
(10, 'BSIT', '1-7', NULL),
(12, 'BSIT', '1-5', NULL),
(13, 'BSIT', '1-8', NULL),
(14, 'BSBA', '1-2', NULL),
(16, 'BSBA', '1-1', NULL);

CREATE TABLE `users` (
  `faculty_id` int(11) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `role` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`faculty_id`, `username`, `password`, `role`) VALUES
(1, 'ferrer@gmail.com', '#Fe8080', 'department head'),
(2, 'mariecurie26@gmail.com', '#ma8080', 'faculty'),
(3, 'alden@gmail.com', '#al8080', 'department head'),
(4, 'james@gmail.com

