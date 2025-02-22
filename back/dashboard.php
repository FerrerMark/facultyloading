<?php
session_start(); 

$url = 'http://localhost/Hr/HRfacultyAPI.php';
$response = json_decode(file_get_contents($url), true);
$faculty_count = $response['faculty_count'];


$url = 'http://localhost/registrar/sectionsApi.php';
$response = json_decode(file_get_contents($url), true);
$section_count = $response['section_count'];


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
    echo "Error: " . $e->getMessage();
}