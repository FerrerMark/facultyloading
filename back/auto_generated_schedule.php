<?php
require 'vendor/autoload.php'; // Include PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['faculty_file'])) {
    $file = $_FILES['faculty_file']['tmp_name'];
    $schedules = []; // To hold the final schedule
    $conflicts = []; // To hold conflicts

    // Load the uploaded XLSX file
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    // Process the data
    foreach ($rows as $index => $row) {
        if ($index === 0) continue; // Skip header row

        // Assuming the columns are in the order specified
        $facultyID = $row[0];
        $firstName = $row[1];
        $middleName = $row[2];
        $lastName = $row[3];
        $college = $row[4];
        $employmentStatus = $row[5];
        $address = $row[6];
        $phoneNo = $row[7];
        $departmentID = $row[8];
        $departmentTitle = $row[9];
        $subject = $row[10];
        $role = $row[11];
        $specialization = $row[12];

        // Check for conflicts (this is a placeholder logic)
        if (!isset($schedules[$facultyID])) {
            $schedules[$facultyID] = [];
        }

        // Example time slot (this should be replaced with actual scheduling logic)
        $requestedTime = "9:00 AM - 10:00 AM"; // Placeholder for requested time
        if (in_array($requestedTime, array_column($schedules[$facultyID], 'time'))) {
            // Find the next available time slot (simple example)
            $nextAvailableTime = findNextAvailableTime($requestedTime, $schedules[$facultyID]);
            if ($nextAvailableTime) {
                $schedules[$facultyID][] = [
                    'name' => "$firstName $lastName",
                    'subject' => $subject,
                    'time' => $nextAvailableTime,
                    'room' => 'Room 101' // Placeholder for room
                ];
            } else {
                $conflicts[] = "Conflict for $firstName $lastName: $subject at $requestedTime";
            }
        } else {
            $schedules[$facultyID][] = [
                'name' => "$firstName $lastName",
                'subject' => $subject,
                'time' => $requestedTime,
                'room' => 'Room 101' // Placeholder for room
            ];
        }
    }

    // Function to find the next available time slot
    function findNextAvailableTime($requestedTime, $scheduledTimes) {
        // Logic to find the next available time slot
        // This is a placeholder; implement your own logic based on your scheduling needs
        return null; // Return the next available time or null if none found
    }

    // Output the generated schedule
    foreach ($schedules as $faculty => $schedule) {
        echo "<h2>Schedule for $faculty</h2>";
        echo "<table><tr><th>Name</th><th>Subject</th><th>Time</th><th>Room</th></tr>";
        foreach ($schedule as $entry) {
            echo "<tr><td>{$entry['name']}</td><td>{$entry['subject']}</td><td>{$entry['time']}</td><td>{$entry['room']}</td></tr>";
        }
        echo "</table>";
    }

    // Display conflicts if any
    if (!empty($conflicts)) {
        echo "<h3>Conflicts:</h3><ul>";
        foreach ($conflicts as $conflict) {
            echo "<li>$conflict</li>";
        }
        echo "</ul>";
    }
}
?>