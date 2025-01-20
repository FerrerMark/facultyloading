<?php 

include_once "../connections/connection.php";

// Define mapping arrays for time slots and days
$time_slots = [
    1 => "7:30 AM - 9:00 AM",
    2 => "9:00 AM - 10:30 AM",
    3 => "10:30 AM - 12:00 PM",
    4 => "1:00 PM - 2:30 PM",
    5 => "2:30 PM - 4:00 PM",
    6 => "4:00 PM - 5:30 PM"
];

$days_of_week = [
    1 => "Monday",
    2 => "Tuesday",
    3 => "Wednesday",
    4 => "Thursday",
    5 => "Friday",
    6 => "Saturday",
];

// Initialize variables to prevent undefined errors
$schedule_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs to prevent SQL Injection
    $teacher = htmlspecialchars($_POST['teacher'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $course = htmlspecialchars($_POST['course'] ?? '');
    $room = htmlspecialchars($_POST['room'] ?? '');
    $remarks = htmlspecialchars($_POST['remarks'] ?? '');
    $schedule_data = $_POST['schedule_data'] ?? [];

    // Loop through selected schedule slots and insert them if not duplicate
    foreach ($schedule_data as $key => $value) {
        list($time_slot, $day_of_week) = explode('-', $key);

        // Check if the record already exists
        $checkStmt = $pdo->prepare("
            SELECT COUNT(*) FROM schedules 
            WHERE teacher = :teacher 
              AND subject = :subject 
              AND course = :course 
              AND room = :room 
              AND time_slot = :time_slot 
              AND day_of_week = :day_of_week
        ");
        $checkStmt->execute([
            ':teacher' => $teacher,
            ':subject' => $subject,
            ':course' => $course,
            ':room' => $room,
            ':time_slot' => $time_slot,
            ':day_of_week' => $day_of_week
        ]);

        if ($checkStmt->fetchColumn() == 0) { // Only insert if the schedule is new
            $stmt = $pdo->prepare("
                INSERT INTO schedules (teacher, subject, course, room, remarks, time_slot, day_of_week, is_checked) 
                VALUES (:teacher, :subject, :course, :room, :remarks, :time_slot, :day_of_week, 1)
            ");
            $stmt->execute([
                ':teacher' => $teacher,
                ':subject' => $subject,
                ':course' => $course,
                ':room' => $room,
                ':remarks' => $remarks,
                ':time_slot' => $time_slot,
                ':day_of_week' => $day_of_week
            ]);
        }
    }

    // Redirect after submission to prevent duplicate inserts from refresh
    header("Location: manual_scheduling.php?role=department%20head&department=BSIT");
    exit();
}

///*
// Retrieve schedules from the database
$stmt = $pdo->query("SELECT * FROM schedules");
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Store checked schedules in an array for easy reference
foreach ($schedules as $schedule) {
    $schedule_data[$schedule['time_slot'] . '-' . $schedule['day_of_week']] = true;
}
// */

// Function to render a checkbox
// function renderCheckbox($name, $checked = false) {
//     return '<input type="checkbox" name="schedule_data[' . htmlspecialchars($name) . ']"' . ($checked ? ' checked' : '') . '>';
// }

function renderCheckbox($name, $checked = false) {
    if ($checked) {
        return '<input type="checkbox" name="schedule_data[' . htmlspecialchars($name) . ']" checked>';
    } else {
        return '<input type="checkbox" name="schedule_data[' . htmlspecialchars($name) . ']">';
    }
}


?>