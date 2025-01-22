<?php

include_once "../connections/connection.php";

$building = $_GET['building'];

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

$room_no = $_GET['room_no'] ?? null;

if (!$room_no) {
    die("Invalid request: No room selected.");
}

$stmt = $pdo->prepare("SELECT * FROM schedules WHERE room = :room");
$stmt->execute([':room' => $room_no]);
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

$schedule_data = [];
foreach ($schedules as $schedule) {
    $schedule_data[$schedule['time_slot'] . '-' . $schedule['day_of_week']] = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher = htmlspecialchars($_POST['teacher'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $course = htmlspecialchars($_POST['course'] ?? '');
    $remarks = htmlspecialchars($_POST['remarks'] ?? '');
    $schedule_data_from_form = $_POST['schedule_data'] ?? [];

    foreach ($schedule_data_from_form as $key => $value) {
        list($time_slot, $day_of_week) = explode('-', $key);

        if (!isset($schedule_data[$key])) {
            $stmt = $pdo->prepare("
                INSERT INTO schedules (teacher, subject, course, room, remarks, time_slot, day_of_week, is_checked) 
                VALUES (:teacher, :subject, :course, :room, :remarks, :time_slot, :day_of_week, 1)
            ");
            $stmt->execute([
                ':teacher' => $teacher,
                ':subject' => $subject,
                ':course' => $course,
                ':room' => $room_no,
                ':remarks' => $remarks,
                ':time_slot' => $time_slot,
                ':day_of_week' => $day_of_week
            ]);
        }
    }

    header("Location: ../frame/manual_scheduling.php?building=$building&room_no=$room_no&success=true"); 
    exit();
}

function renderCheckbox($name, $checked = false) {
    return '<input type="checkbox" name="schedule_data[' . htmlspecialchars($name) . ']" ' . ($checked ? 'checked' : '') . '>';
}

$department = $_GET['department'];

try {
    $stmt = $conn->prepare("SELECT * FROM faculty WHERE departmentID = :departmentID");
    $stmt->bindParam(':departmentID', $department, PDO::PARAM_STR);
    $stmt->execute();
    $facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

?>
