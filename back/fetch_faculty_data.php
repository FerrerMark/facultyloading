<?php
include_once "../connections/connection.php"; // Adjust path if needed
header('Content-Type: application/json');

session_start();    

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$id = $_SESSION['id']; // Faculty ID from session

try {
    // Fetch department of the logged-in user (assuming the users table has faculty_id)
    $stmt = $pdo->prepare("SELECT departmentID FROM faculty WHERE faculty_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $department = $stmt->fetchColumn();

    if (!$department) {
        echo json_encode(["error" => "Department not found"]);
        exit();
    }

    // Fetch faculty members in the same department with all required fields
    $stmt = $pdo->prepare("SELECT faculty_id, firstname, middlename, lastname, college, departmentID, employment_status, address, phone_no, departmentID, role, master_specialization 
                           FROM faculty 
                           WHERE departmentID = :department");
    $stmt->bindParam(':department', $department, PDO::PARAM_STR);  // Use correct parameter type based on department data
    $stmt->execute();
    $facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as a JSON response
    echo json_encode($facultyList);
} catch (PDOException $e) {
    // Return an error message in case of an exception
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
