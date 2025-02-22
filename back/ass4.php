<?php 
header("Content-Type: application/json");
include "../connections/connection.php"; 

$jsonInput = file_get_contents("php://input");
$data = json_decode($jsonInput, true);

$faculty_id = 8; // Example faculty ID for testing
error_log("Assigning schedule for Faculty ID: $faculty_id");

$facultyQuery = "SELECT max_weekly_hours, start_time, end_time, availability FROM faculty WHERE faculty_id = :faculty_id";
$stmt = $conn->prepare($facultyQuery);
$stmt->execute(["faculty_id" => $faculty_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$faculty) {
    error_log("Faculty ID $faculty_id not found.");
    echo json_encode(["success" => false, "message" => "Faculty not found"]);
    exit();
}

$availableDays = array_unique(array_map('trim', explode(',', $faculty['availability'])));
error_log("Faculty ID $faculty_id is available on: " . implode(", ", $availableDays));

$currentHoursQuery = "
    SELECT SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) 
    FROM schedules WHERE faculty_id = :faculty_id";
$stmt = $conn->prepare($currentHoursQuery);
$stmt->execute(["faculty_id" => $faculty_id]);
$currentHours = (int) $stmt->fetchColumn();

$coursesQuery = "SELECT subject_code FROM faculty_courses WHERE faculty_id = :faculty_id";
$stmt = $conn->prepare($coursesQuery);
$stmt->execute(["faculty_id" => $faculty_id]);
$facultyCourses = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($facultyCourses)) {
    error_log("Faculty ID $faculty_id has no assigned courses.");
    echo json_encode(["success" => false, "message" => "No assigned courses"]);
    exit();
}

$sectionsQuery = "
    SELECT s.section_id, s.year_level, s.semester, sc.subject_code, sc.start_time, sc.end_time, sc.day_of_week 
    FROM section_schedules sc
    JOIN sections s ON sc.section_id = s.section_id
    WHERE sc.subject_code IN (" . implode(",", array_fill(0, count($facultyCourses), "?")) . ")
";
$stmt = $conn->prepare($sectionsQuery);
$stmt->execute($facultyCourses);
$sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

$assignedSchedules = [];
foreach ($sections as $row) {
    if (!in_array($row["day_of_week"], $availableDays)) {
        error_log("Skipping: Faculty ID $faculty_id is NOT available on {$row["day_of_week"]}.");
        continue;
    }

    if (strtotime($row["start_time"]) < strtotime($faculty["start_time"]) || 
        strtotime($row["end_time"]) > strtotime($faculty["end_time"])) {
        error_log("Faculty ID $faculty_id: Conflict with availability for subject {$row["subject_code"]} at {$row["start_time"]} - {$row["end_time"]}");
        continue;
    }

    $facultyConflictQuery = "
        SELECT COUNT(*) FROM schedules 
        WHERE faculty_id = :faculty_id 
        AND day_of_week = :day_of_week 
        AND (
            (start_time < :end_time AND end_time > :start_time) -- Overlapping time check
        )";
    $stmt = $conn->prepare($facultyConflictQuery);
    $stmt->execute([
        "faculty_id"  => $faculty_id,
        "day_of_week" => $row["day_of_week"],
        "start_time"  => $row["start_time"],
        "end_time"    => $row["end_time"]
    ]);

    if ($stmt->fetchColumn() > 0) {
        error_log("Skipping: Faculty ID $faculty_id already has a schedule conflict on {$row["day_of_week"]}.");
        continue;
    }

    $facultySectionConflictQuery = "
        SELECT COUNT(*) FROM schedules 
        WHERE faculty_id = :faculty_id 
        AND section_id = :section_id 
        AND day_of_week = :day_of_week";
    $stmt = $conn->prepare($facultySectionConflictQuery);
    $stmt->execute([
        "faculty_id"  => $faculty_id,
        "section_id"  => $row["section_id"],
        "day_of_week" => $row["day_of_week"]
    ]);

    if ($stmt->fetchColumn() > 0) {
        error_log("Skipping: Faculty ID $faculty_id is already assigned to Section ID {$row["section_id"]} on {$row["day_of_week"]}.");
        continue;
    }

    $sectionConflictQuery = "
        SELECT COUNT(*) FROM schedules 
        WHERE section_id = :section_id 
        AND day_of_week = :day_of_week 
        AND (
            (start_time < :end_time AND end_time > :start_time) -- Overlapping time check
        )";
    $stmt = $conn->prepare($sectionConflictQuery);
    $stmt->execute([
        "section_id"  => $row["section_id"],
        "day_of_week" => $row["day_of_week"],
        "start_time"  => $row["start_time"],
        "end_time"    => $row["end_time"]
    ]);

    if ($stmt->fetchColumn() > 0) {
        error_log("Skipping: Section ID {$row["section_id"]} already has a faculty assigned on {$row["day_of_week"]} at {$row["start_time"]}.");
        continue;
    }

    $newHours = (int) $currentHours + (strtotime($row["end_time"]) - strtotime($row["start_time"])) / 3600;
    if ($newHours > $faculty["max_weekly_hours"]) {
        error_log("Faculty ID $faculty_id has exceeded max weekly hours ({$faculty["max_weekly_hours"]}). Skipping...");
        continue;
    }

    $insertQuery = "INSERT INTO schedules (faculty_id, subject_code, section_id, day_of_week, start_time, end_time) 
                    VALUES (:faculty_id, :subject_code, :section_id, :day_of_week, :start_time, :end_time)";
    $stmt = $conn->prepare($insertQuery);

    if ($stmt->execute([
        "faculty_id"   => $faculty_id,
        "subject_code" => $row["subject_code"],
        "section_id"   => $row["section_id"],
        "day_of_week"  => $row["day_of_week"],
        "start_time"   => $row["start_time"],
        "end_time"     => $row["end_time"]
    ])) {
        error_log("Successfully assigned Faculty ID: $faculty_id to Section ID: {$row["section_id"]} for Subject: {$row["subject_code"]}");
        $assignedSchedules[] = $row;
        $currentHours = $newHours; // Update assigned hours
    } else {
        error_log("Failed to insert schedule for Faculty ID $faculty_id, Course: {$row["subject_code"]}");
    }
}

if (empty($assignedSchedules)) {
    error_log("No valid schedules assigned for Faculty ID: $faculty_id.");
    echo json_encode(["success" => false, "message" => "No valid schedules assigned"]);
    exit();
}

echo json_encode(["success" => true, "assignedSchedules" => $assignedSchedules]);

