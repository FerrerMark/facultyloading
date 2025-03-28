<?php
include_once "../session/session.php";
include_once "../connections/connection.php";

$api_url = "http://localhost/registrar/scheduleAPI.php";
$response = file_get_contents($api_url);
$scheduleData = json_decode($response, true);

if ($scheduleData['status'] === "success") {
    try {
        $pdo->exec("DELETE FROM section_schedules");

        $stmt = $pdo->prepare("
            INSERT INTO section_schedules 
                (schedule_id, section_id, section_name, subject_code, day_of_week, start_time, end_time, semester, program_code, year_level) 
            VALUES 
                (:schedule_id, :section_id, :section_name, :subject_code, :day_of_week, :start_time, :end_time, :semester, :program_code, :year_level)
        ");

        foreach ($scheduleData['data'] as $schedule) {
            $stmt->execute([
                ':schedule_id' => $schedule['schedule_id'],
                ':section_id' => $schedule['section_id'],
                ':section_name' => $schedule['section_name'],
                ':subject_code' => $schedule['subject_code'],
                ':day_of_week' => $schedule['day_of_week'],
                ':start_time' => $schedule['start_time'],
                ':end_time' => $schedule['end_time'],
                ':semester' => $schedule['semester'],
                ':program_code' => $schedule['program_code'],
                ':year_level' => $schedule['year_level']
            ]);
        }

        // echo json_encode([
        //     "status" => "success",
        //     "message" => "✅ Section schedules synced successfully!",
        // ]);
    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "❌ Sync failed: " . $e->getMessage(),
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "❌ Failed to fetch data from API.",
    ]);
}

