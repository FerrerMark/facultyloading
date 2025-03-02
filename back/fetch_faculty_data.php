<?php
include_once("../session/session.php");
include_once "../connections/connection.php";
header('Content-Type: application/json');


if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$id = $_SESSION['id'];

try {
    $stmt = $pdo->prepare("SELECT departmentID FROM faculty WHERE faculty_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $department = $stmt->fetchColumn();

    if (!$department) {
        echo json_encode(["error" => "Department not found"]);
        exit();
    }

    $stmt = $pdo->prepare("SELECT faculty_id, firstname, middlename, lastname, college, departmentID, employment_status, address, phone_no, departmentID, role, master_specialization 
                           FROM faculty 
                           WHERE departmentID = :department");
    $stmt->bindParam(':department', $department, PDO::PARAM_STR);
    $stmt->execute();
    $facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($facultyList);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>

