<?php
include_once "../connections/connection.php"; // Adjust path if needed
header('Content-Type: application/json');

session_start();    

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$id = $_SESSION['id']; // Faculty ID from session

try {
    // Fetch department of the logged-in user
    $stmt = $pdo->prepare("SELECT department FROM users WHERE faculty_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $department = $stmt->fetchColumn();

    if (!$department) {
        echo json_encode(["error" => "Department not found"]);
        exit();
    }

    // Fetch faculty members in the same department with all required fields
    $stmt = $pdo->prepare("SELECT faculty_id, firstname, middlename, lastname, college, employment_status, address, phone_no, departmentID, department_title, subject, created_at, role, master_specialization FROM faculty WHERE departmentID = :department");
    $stmt->bindParam(':department', $department, PDO::PARAM_STR);
    $stmt->execute();
    $facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($facultyList);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
