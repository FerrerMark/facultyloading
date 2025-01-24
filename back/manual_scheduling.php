<?php

include_once "../connections/connection.php";

$section_id = $_GET['section'];  
$department = $_GET['department'];
$room_no = $_GET['room_no'];
$building = $_GET['building'] ?? null;
$time_slots = [
    1 => "6:00 AM - 7:00 AM",
    2 => "7:00 AM - 8:00 AM",
    3 => "8:00 AM - 9:00 AM",
    4 => "10:00 AM - 10:00 AM",
    5 => "10:00 AM - 11:00 AM",
    6 => "11:00 AM - 12:00 PM",
    7 => "12:00 PM - 1:00 PM",
    8 => "1:00 PM - 2:00 PM",
    9 => "2:00 PM - 3:00 PM",
    10 => "3:00 PM - 4:00 PM",
    11 => "4:00 PM - 5:00 PM",
    12 => "5:00 PM - 6:00 PM",
    13 => "6:00 PM - 7:00 PM",
    14 => "7:00 PM - 8:00 PM",
    15 => "8:00 PM - 9:00 PM"
];

$days_of_week = [
    1 => "Monday",
    2 => "Tuesday",
    3 => "Wednesday",
    4 => "Thursday",
    5 => "Friday",
    6 => "Saturday",
];

    // if (!$section_id) {
    //     die("Invalid request: No section selected.");
    // }

// Fetch schedules for the selected section
$stmt = $pdo->prepare("SELECT * FROM schedules WHERE section = :section_id");
$stmt->execute([':section_id' => $section_id]);
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

$schedule_data = [];
foreach ($schedules as $schedule) {
    $schedule_data[$schedule['time_slot'] . '-' . $schedule['day_of_week']] = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher = htmlspecialchars($_POST['teacher'] ?? '');
    $course = htmlspecialchars($_POST['course'] ?? '');
    $schedule_data_from_form = $_POST['schedule_data'] ?? [];
    $department = $_POST['department'] ?? '';


    $section_id = $_GET['section'];
    $stmt = $pdo->prepare("SELECT year_level FROM sections WHERE year_section = :section");
    $stmt->execute([':section' => $section_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $year_level = $result['year_level'];



    foreach ($schedule_data_from_form as $key => $value) {
        list($time_slot, $day_of_week) = explode('-', $key);

        if (!isset($schedule_data[$key])) {
            $stmt = $pdo->prepare("
                INSERT INTO schedules (teacher, course, section, time_slot, day_of_week, is_checked, program_code, year_level, room) 
                VALUES (:teacher, :course, :section_id, :time_slot, :day_of_week, 1, :program_code, :year_level, :room)
            ");
            $stmt->execute([
                ':teacher' => $teacher,
                ':course' => $course,
                ':section_id' => $section_id,
                ':time_slot' => $time_slot,
                ':day_of_week' => $day_of_week,
                ':program_code' => $department,
                ':year_level' => $year_level,
                ':room' => $room_no
            ]);
        }
    }

    header("Location: ../frame/manual_scheduling.php?building=$building&department=$department&section=$section_id&success=true&section=$section_id&room_no=$room_no"); 

    exit();
}

// Fetch list of faculty for selection
try {
    $stmt = $conn->prepare("SELECT * FROM faculty WHERE departmentID = :departmentID");
    $stmt->bindParam(':departmentID', $department, PDO::PARAM_STR);
    $stmt->execute();
    $facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

try {
    $stmt = $conn->prepare("SELECT * FROM faculty WHERE departmentID = :departmentID");
    $stmt->bindParam(':departmentID', $department, PDO::PARAM_STR);
    $stmt->execute();
    $facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

?>
