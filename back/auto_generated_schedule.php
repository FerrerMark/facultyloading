<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../connections/connection.php";

// Check if database connection is successful
if (!$conn) {
    die("❌ Database connection failed: " . $conn->errorInfo()[2]);
}

echo "✅ Database connected successfully!<br>";

// Fetch all instructors and their maximum load
$instructors = [];
$sql = "SELECT faculty_id, firstname, max_weekly_hours FROM faculty";
$stmt = $conn->prepare($sql);
$stmt->execute(); 

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  
    $instructors[$row['faculty_id']] = [
        'name' => $row['firstname'],
        'max_load' => $row['max_weekly_hours'],  
        'assigned' => 0  
    ];
}

echo "✅ Instructors fetched successfully!<br>";

// Fetch all courses and their corresponding section_id
$sql = "SELECT c.course_id, c.subject_code, c.course_title, s.section_id 
        FROM courses c
        JOIN sections s ON c.program_code = s.program_code";
$stmt = $conn->prepare($sql);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "✅ Courses with sections fetched successfully!<br>";

// Fetch available rooms
$sql = "SELECT room_id FROM rooms";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($rooms)) {
    die("❌ No rooms available. Cannot proceed with scheduling.");
}

echo "✅ Rooms fetched successfully!<br>";

// Available time slots (Monday-Friday, 8 AM - 5 PM)
$time_slots = [
    "Monday 8-10", "Monday 10-12", "Monday 1-3", "Monday 3-5",
    "Tuesday 8-10", "Tuesday 10-12", "Tuesday 1-3", "Tuesday 3-5",
    "Wednesday 8-10", "Wednesday 10-12", "Wednesday 1-3", "Wednesday 3-5",
    "Thursday 8-10", "Thursday 10-12", "Thursday 1-3", "Thursday 3-5",
    "Friday 8-10", "Friday 10-12", "Friday 1-3", "Friday 3-5"
];

$assigned_slots = []; 

foreach ($courses as $course) {  
    echo "📌 Processing course: " . $course['subject_code'] . " (" . $course['course_title'] . ")<br>";

    if (empty($course['section_id'])) {
        echo "⚠️ Skipping " . $course['subject_code'] . " (No section assigned)<br>";
        continue;
    }

    foreach ($instructors as $id => &$instructor) {  
        if ($instructor['assigned'] < $instructor['max_load']) {  
            foreach ($time_slots as $slot) {  
                if (!isset($assigned_slots[$id][$slot])) {  
                    try {
                        // Assign the first available room
                        $room_id = $rooms[array_rand($rooms)];

                        // Assign instructor to course with section_id and room_id
                        $sql = "INSERT INTO schedules (faculty_id, subject_code, section_id, room_id, day_of_week, time_slot) 
                                VALUES (:faculty_id, :subject_code, :section_id, :room_id, :day, :time_slot)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([
                            'faculty_id' => $id,
                            'subject_code' => $course['subject_code'],
                            'section_id' => $course['section_id'],
                            'room_id' => $room_id, // Now correctly included
                            'day' => explode(" ", $slot)[0], 
                            'time_slot' => $slot
                        ]);

                        echo "✅ Assigned " . $instructor['name'] . " to " . $course['subject_code'] . 
                             " (Section " . $course['section_id'] . ", Room " . $room_id . ") at " . $slot . "<br>";

                        // Mark slot as used
                        $assigned_slots[$id][$slot] = true;
                        $instructor['assigned']++;
                        break 2; // Move to next course
                    } catch (PDOException $e) {
                        die("❌ SQL Error: " . $e->getMessage());
                    }
                }
            }
        }
    }
}

echo "<br>✅ Scheduling completed successfully!";
?>
