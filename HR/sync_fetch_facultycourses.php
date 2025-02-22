<?php
include_once "../connections/connection.php";

$api_url = "http://localhost/hr/facultycoursesAPI.php";
$response = file_get_contents($api_url);
$facultyCoursesData = json_decode($response, true);

if ($facultyCoursesData['status'] === "success") {
    try {
        $pdo->beginTransaction();

        // **Step 1: Delete existing faculty courses**
        $pdo->exec("DELETE FROM faculty_courses");

        // **Step 2: Insert new faculty courses**
        $stmt = $pdo->prepare("INSERT INTO faculty_courses (faculty_id, subject_code) VALUES (:faculty_id, :subject_code)");
        foreach ($facultyCoursesData['faculty_courses'] as $facultyCourse) {
            $stmt->execute([
                ':faculty_id' => $facultyCourse['faculty_id'],
                ':subject_code' => $facultyCourse['subject_code']
            ]);
        }

        $pdo->commit();
        echo "✅ Faculty courses synced successfully!";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "❌ Sync failed: " . $e->getMessage();
    }
} else {
    echo "❌ Failed to fetch data from API.";
}

