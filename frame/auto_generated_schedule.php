<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../connections/connection.php";

// Initialize variables
$message = '';
$schedules = [];

// Function to run scheduling process
function runScheduling($conn) {
    // Check if database connection is successful
    if (!$conn) {
        return "❌ Database connection failed: " . $conn->errorInfo()[2];
    }

    $output = "✅ Database connected successfully!<br>";

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

    $output .= "✅ Instructors fetched successfully!<br>";

    // Fetch all courses and their corresponding section_id
    $sql = "SELECT c.course_id, c.subject_code, c.course_title, s.section_id 
            FROM courses c
            JOIN sections s ON c.program_code = s.program_code";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output .= "✅ Courses with sections fetched successfully!<br>";

    // Fetch available rooms
    $sql = "SELECT room_id FROM rooms";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($rooms)) {
        return $output . "❌ No rooms available. Cannot proceed with scheduling.";
    }

    $output .= "✅ Rooms fetched successfully!<br>";

    // Custom time slots and days
    $time_slots = [
        1 => "6:00 AM - 7:00 AM",
        2 => "7:00 AM - 8:00 AM",
        3 => "8:00 AM - 9:00 AM",
        4 => "9:00 AM - 10:00 AM", // Fixed typo from "10:00 AM - 10:00 AM"
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
        6 => "Saturday"
    ];

    $assigned_slots = [];

    // Process courses and assign instructors
    foreach ($courses as $course) {  
        $output .= "📌 Processing course: " . $course['subject_code'] . " (" . $course['course_title'] . ")<br>";

        if (empty($course['section_id'])) {
            $output .= "⚠️ Skipping " . $course['subject_code'] . " (No section assigned)<br>";
            continue;
        }

        foreach ($instructors as $id => &$instructor) {  
            if ($instructor['assigned'] < $instructor['max_load']) {  
                foreach ($days_of_week as $day => $day_name) {
                    foreach ($time_slots as $slot) {  
                        if (!isset($assigned_slots[$id][$day][$slot])) {  
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
                                    'room_id' => $room_id,
                                    'day' => $day, 
                                    'time_slot' => $slot
                                ]);

                                $output .= "✅ Assigned " . $instructor['name'] . " to " . $course['subject_code'] . 
                                             " (Section " . $course['section_id'] . ", Room " . $room_id . ") at " . $day_name . " " . $slot . "<br>";

                                // Mark slot as used
                                $assigned_slots[$id][$day][$slot] = true;
                                $instructor['assigned']++;
                                break 3; // Move to next course
                            } catch (PDOException $e) {
                                return $output . "❌ SQL Error: " . $e->getMessage();
                            }
                        }
                    }
                }
            }
        }
    }

    return $output . "<br>✅ Scheduling completed successfully!";
}

// Function to fetch schedules
function fetchSchedules($conn) {
    $sql = "SELECT s.faculty_id, f.firstname AS instructor_name, s.subject_code, s.section_id, s.room_id, s.day_of_week, s.time_slot 
            FROM schedules s
            JOIN faculty f ON s.faculty_id = f.faculty_id
            ORDER BY s.faculty_id, s.day_of_week, s.time_slot";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert time slot to readable format
    foreach ($schedules as &$schedule) {
        $schedule['time_slot'] = formatTimeSlot($schedule['time_slot']);
        $schedule['day_of_week'] = formatDayOfWeek($schedule['day_of_week']);
    }

    return $schedules;
}

// Function to format the time slot
function formatTimeSlot($time_slot) {
    return $time_slot; // Since it's already in your desired format, no change needed
}

function formatDayOfWeek($day) {
    global $days_of_week;

    // If the day is already a string (e.g., "Monday"), no need to convert
    if (is_string($day)) {
        return $day;  // Return as it is (e.g., "Monday")
    }

    // If the day is a number (1-6), convert it using the array
    return isset($days_of_week[$day]) ? $days_of_week[$day] : 'Unknown';
}


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['run_scheduling'])) {
        $message = runScheduling($conn);
    }
}

// Fetch schedules
$schedules = fetchSchedules($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Scheduling System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #45a049;
        }
        #message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Course Scheduling System</h1>
        <form method="post">
            <input type="submit" name="run_scheduling" value="Run Scheduling" class="button">
        </form>
        <?php if (!empty($message)): ?>
            <div id="message" class="<?php echo strpos($message, '❌') !== false ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <h2>Current Schedule</h2>
    <table>
        <tr>
            <th>Instructor</th>
            <th>Course</th>
            <th>Section</th>
            <th>Room</th>
            <th>Day</th>
            <th>Time Slot</th>
        </tr>
        <?php foreach ($schedules as $schedule): ?>
            <tr>
                <td><?php echo htmlspecialchars($schedule['instructor_name']); ?></td>
                <td><?php echo htmlspecialchars($schedule['subject_code']); ?></td>
                <td><?php echo htmlspecialchars($schedule['section_id']); ?></td>
                <td><?php echo htmlspecialchars($schedule['room_id']); ?></td>
                <td><?php echo htmlspecialchars($schedule['day_of_week']); ?></td>
                <td><?php echo htmlspecialchars($schedule['time_slot']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
</body>
</html>
