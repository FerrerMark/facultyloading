SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8mb4;

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


CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `college` varchar(100) DEFAULT NULL,
  `employment_status` enum('Full-time','Part-time','Contract') NOT NULL,
  `address` text DEFAULT NULL,
  `phone_no` varchar(255) NOT NULL,
  `departmentID` varchar(50) DEFAULT NULL,
  `department_title` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(50) DEFAULT NULL,
  `master_specialization` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `programs` (
  `program_code` varchar(50) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `college` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `building` varchar(100) NOT NULL,
  `room_no` varchar(50) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `section` varchar(255) NOT NULL,
  `year_level` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `teacher` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `time_slot` varchar(255) DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `is_checked` tinyint(1) DEFAULT 0,
  `year_level` int(255) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `program_code` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `program_code` varchar(10) NOT NULL,
  `year_section` varchar(10) NOT NULL,
  `year_level` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `users` (
  `faculty_id` int(11) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `role` varchar(35) NOT NULL,
  `department` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `courses`
  ADD PRIMARY KEY (`program_code`,`subject_code`),
  ADD UNIQUE KEY `program_code_subject_code` (`program_code`,`subject_code`);

ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD UNIQUE KEY `phoneN_no` (`phone_no`);

ALTER TABLE `programs`
  ADD PRIMARY KEY (`program_code`);

ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_schedule` (`teacher`,`subject`,`course`,`room`,`time_slot`,`day_of_week`) USING HASH;

ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `program_code` (`program_code`,`year_section`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`faculty_id`);

ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;

ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

ALTER TABLE `users`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`program_code`) REFERENCES `programs` (`program_code`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`program_code`) REFERENCES `programs` (`program_code`);

