<?php
session_start();
include "../connections/connection.php";
$faculty_id = $_SESSION['id'];

$query = "SELECT availability, start_time, end_time FROM faculty WHERE faculty_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();
$availability = $result->fetch_assoc() ?? ['available_days' => '', 'start_time' => '06:00', 'end_time' => '17:00'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $days = implode(',', $_POST['available_days'] ?? []);
    $start_time = $_POST['start_time'] . ':00';
    $end_time = $_POST['end_time'] . ':00';
    
    $update = "UPDATE faculty SET availability = ?, start_time = ?, end_time = ? WHERE faculty_id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("sssi", $days, $start_time, $end_time, $faculty_id);
    $stmt->execute();
    header("Location: availability.php");
    exit;
}
