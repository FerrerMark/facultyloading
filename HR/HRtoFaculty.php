<?php
include_once("../connections/connection.php");

header('Content-Type: application/json');

$url = 'http://localhost/Hr/HRfacultyAPI.php';
$response = json_decode(file_get_contents($url), true);

try {
    $pdo->beginTransaction();

    $stmtFaculty = $pdo->prepare("
        INSERT INTO faculty (faculty_id, firstname, middlename, lastname, college, employment_status, address, phone_no, departmentID, role, master_specialization, created_at, max_weekly_hours, availability, start_time, end_time) 
        VALUES (:faculty_id, :firstname, :middlename, :lastname, :college, :employment_status, :address, :phone_no, :departmentID, :role, :master_specialization, :created_at, :max_weekly_hours, :availability, :start_time, :end_time)
        ON DUPLICATE KEY UPDATE 
        firstname = VALUES(firstname), 
        middlename = VALUES(middlename), 
        lastname = VALUES(lastname), 
        college = VALUES(college), 
        employment_status = VALUES(employment_status), 
        address = VALUES(address), 
        phone_no = VALUES(phone_no), 
        departmentID = VALUES(departmentID), 
        role = VALUES(role), 
        master_specialization = VALUES(master_specialization), 
        max_weekly_hours = VALUES(max_weekly_hours), 
        availability = VALUES(availability), 
        start_time = VALUES(start_time), 
        end_time = VALUES(end_time)
    ");

    $stmtUsers = $pdo->prepare("
        REPLACE INTO users (faculty_id, username, password, role) 
        VALUES (:faculty_id, :username, :password, :role)
    ");

    foreach ($response['faculty'] as $faculty) {
        $stmtFaculty->execute([
            ':faculty_id' => $faculty['faculty_id'],
            ':firstname' => $faculty['firstname'],
            ':middlename' => $faculty['middlename'],
            ':lastname' => $faculty['lastname'],
            ':college' => $faculty['college'],
            ':employment_status' => $faculty['employment_status'],
            ':address' => $faculty['address'],
            ':phone_no' => $faculty['phone_no'],
            ':departmentID' => $faculty['departmentID'],
            ':role' => $faculty['role'],
            ':master_specialization' => $faculty['master_specialization'],
            ':created_at' => $faculty['created_at'],
            ':max_weekly_hours' => $faculty['max_weekly_hours'],
            ':availability' => $faculty['availability'],
            ':start_time' => $faculty['start_time'],
            ':end_time' => $faculty['end_time'],
        ]);

        $username = strtolower($faculty['firstname']) . "." . strtolower($faculty['lastname']);
        $password = '#' . substr($faculty['lastname'], 0, 2) . '8080';

        $stmtUsers->execute([
            ':faculty_id' => $faculty['faculty_id'],
            ':username' => $username,
            ':password' => $password,
            ':role' => $faculty['role'],
        ]);
    }

    $pdo->commit();

    echo json_encode(["status" => "success", "message" => "Faculty and users successfully synced!"]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(["status" => "error", "message" => "Sync failed: " . $e->getMessage()]);
}

