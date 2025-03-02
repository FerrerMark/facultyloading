<?php
include_once("../session/session.php");
$facultyApiUrl = 'http://localhost/Hr/HRfacultyAPI.php';
$sectionsApiUrl = 'http://localhost/registrar/sectionsApi.php';

$options = [
    "http" => [
        "header" => "Authorization: Bearer m\r\n"
    ]
];

$context = stream_context_create($options);

$response = file_get_contents($facultyApiUrl, false, $context);
$facultyData = json_decode($response, true);

if (!$facultyData || !isset($facultyData['faculty_count'])) {
    die(json_encode(["error" => "Failed to fetch faculty data. Check API authentication."]));
}

$faculty_count = $facultyData['faculty_count'];

$response = file_get_contents($sectionsApiUrl);
$sectionData = json_decode($response, true);

if (!$sectionData || !isset($sectionData['section_count'])) {
    die(json_encode(["error" => "Failed to fetch section data."]));
}

$section_count = $sectionData['section_count'];

include_once "../connections/connection.php";

$faculty_id = $_SESSION['id'] ?? 0;

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("
        SELECT SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time) / 60) AS total_teaching_hours
        FROM schedules
        WHERE faculty_id = :faculty_id
    ");
    $stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $faculty_teaching_hours = $result['total_teaching_hours'] ?? 0;

} catch (PDOException $e) {
    die(json_encode(["error" => "Database error: " . $e->getMessage()]));
}

// echo json_encode([
//     "faculty_count" => $faculty_count,
//     "section_count" => $section_count,
//     "faculty_teaching_hours" => $faculty_teaching_hours
// ]);

