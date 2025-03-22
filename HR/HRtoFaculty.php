<?php
include_once("./session/session.php");
include_once("../connections/connection.php");

header('Content-Type: application/json');

$api_url = 'http://localhost/Hr/HRfacultyAPI.php';
$api_key = 'm';


$options = [
    "http" => [
        "header" => "Authorization: Bearer $api_key"
    ]
];

$context = stream_context_create($options);
$response = @file_get_contents($api_url, false, $context);

if ($response === false) {
    echo json_encode(["status" => "error", "message" => "Failed to fetch faculty data. Check API key and endpoint."]);
    exit;
}

$data = json_decode($response, true);
if (!$data || !isset($data['faculty'])) {
    echo json_encode(["status" => "error", "message" => "Invalid API response."]);
    exit;
}

try {
    $pdo->beginTransaction();

    $stmtFaculty = $pdo->prepare("
        INSERT INTO faculty 
        (faculty_id, firstname, middlename, lastname, college, employment_status, address, phone_no, departmentID, role, master_specialization, created_at, max_weekly_hours, availability, start_time, end_time) 
        VALUES 
        (:faculty_id, :firstname, :middlename, :lastname, :college, :employment_status, :address, :phone_no, :departmentID, :role, :master_specialization, :created_at, :max_weekly_hours, :availability, :start_time, :end_time) 
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

    foreach ($data['faculty'] as $faculty) {
        $stmtFaculty->execute([
            ':faculty_id' => $faculty['faculty_id'] ?? null,
            ':firstname' => $faculty['firstname'] ?? null,
            ':middlename' => $faculty['middlename'] ?? null,
            ':lastname' => $faculty['lastname'] ?? null,
            ':college' => $faculty['college'] ?? null,
            ':employment_status' => $faculty['employment_status'] ?? null,
            ':address' => $faculty['address'] ?? null,
            ':phone_no' => $faculty['phone_no'] ?? null,
            ':departmentID' => $faculty['departmentID'] ?? null,
            ':role' => $faculty['role'] ?? null,
            ':master_specialization' => $faculty['master_specialization'] ?? null,
            ':created_at' => $faculty['created_at'] ?? null,
            ':max_weekly_hours' => $faculty['max_weekly_hours'] ?? null,
            ':availability' => $faculty['availability'] ?? null,
            ':start_time' => $faculty['start_time'] ?? null,
            ':end_time' => $faculty['end_time'] ?? null,
        ]);

        $username = strtolower($faculty['firstname'] ?? '') . "." . strtolower($faculty['lastname'] . "@faculty"?? '');
        $password = strtolower($faculty['lastname'] ?? '') . "8080";

        $stmtUsers->execute([
            ':faculty_id' => $faculty['faculty_id'] ?? null,
            ':username' => $username,
            ':password' => $password,
            ':role' => $faculty['role'] ?? null,    
        ]);
    }

    $pdo->commit();

    echo json_encode(["status" => "success", "message" => "Faculty and users successfully synced!"]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(["status" => "error", "message" => "Sync failed: " . $e->getMessage()]);
}
