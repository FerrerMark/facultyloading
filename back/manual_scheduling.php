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

$stmt = $pdo->query("SELECT * FROM schedules");
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Store checked schedules in an array for easy reference
foreach ($schedules as $schedule) {
    // Create a key based on time slot and day of the week to track scheduled time slots
    $schedule_data[$schedule['time_slot'] . '-' . $schedule['day_of_week']] = true;
}

// Now, handle form submission (check for duplicates and insert new records)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher = htmlspecialchars($_POST['teacher'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $course = htmlspecialchars($_POST['course'] ?? '');
    $room = htmlspecialchars($_POST['room'] ?? '');
    $remarks = htmlspecialchars($_POST['remarks'] ?? '');
    $schedule_data_from_form = $_POST['schedule_data'] ?? []; // schedule data from the form

    // Loop through selected schedule slots from the form submission
    foreach ($schedule_data_from_form as $key => $value) {
        list($time_slot, $day_of_week) = explode('-', $key);

        // Check if the record already exists in the database to prevent duplicates
        if (!isset($schedule_data[$key])) { // Only insert if the schedule isn't already taken
            // Prepare and execute the insert query
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

    // Redirect to prevent resubmission after form submission
    header("Location: manual_scheduling.php?success=true");
    exit();
}

function renderCheckbox($name, $checked = false) {
    if ($checked) {
        return '<input type="checkbox" name="schedule_data[' . htmlspecialchars($name) . ']" checked>';
    } else {
        return '<input type="checkbox" name="schedule_data[' . htmlspecialchars($name) . ']">';
    }
}


?>